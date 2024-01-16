<?php

class PageBlockItem
{
    /** @var modX $modx */
    public $modx;
    /** @var PageBlocks $pp */
    public $pb;

    public $classKey = 'pageBlock';

    /**
     * PageBlockFiles constructor.
     * @param modX $modx
     * @param $pageblocks
     */
    public function __construct(modX $modx, $pageblocks)
    {
        $this->modx = $modx;
        $this->pb = $pageblocks;
    }


    /**
     * @param $values
     * @return array
     */
    public function filterValues($values)
    {
        $values = array_filter($values, function ($name) {

            if (stripos($name, 'ext-comp') !== false) {
                return false;
            }

            return !in_array($name, ['id', 'action', 'resource_id', 'context_key', 'cultureKey', 'chunk',
                'constructor_id', 'collection_id', 'baseblock', 'table_id', 'object_id', 'unique', 'active']);

        }, ARRAY_FILTER_USE_KEY);

        return $values;
    }


    /**
     * @param pageBlock $block
     */
    public function createValues(pageBlock $block)
    {
        $fields = $block->getOne('Constructor')->getMany('Fields', ['xtype:IN' => [
            'pb-grid-table',
            'pb-image-gallery',
            'pb-video-gallery',
            'pb-panel-video',
        ]]);
        foreach ($fields as $field) {
            $where = [
                'block_id' => 0,
                'resource_id' => $block->resource_id,
                'context_key' => $block->context_key,
                'cultureKey' => $block->cultureKey,
                'field_id' => $field->id,
                'grid_id' => 0,
                'active' => 1,
            ];

            if ($field->xtype == 'pb-grid-table') {
                $rows = $this->pb->table->getRows($where);
                // Обновляем вложенные таблицы
                foreach ($rows as $row) {
                    $this->updateTable($row, $block->id);
                }
            }

            if ($field->xtype == 'pb-image-gallery') {
                $rows = $this->pb->files->getRows($where);
            }

            if ($field->xtype == 'pb-panel-video') {
                $rows = $this->pb->video->getRows($where);
            }

            if ($field->xtype == 'pb-video-gallery') {
                $rows = $this->pb->video->getRows($where);
            }

            foreach ($rows as $row) {
                $row->set('block_id', $block->id);
                $row->save();
            }

        }

        $this->updateValues($block);
    }


    /**
     * @param pageBlock $block
     */
    public function updateValues(pageBlock $block)
    {
        $values = json_decode($block->values, 1);
//        $block->_relatedObjects['Constructor'] = [];
        $fields = $block->getOne('Constructor')->getMany('Fields', ['xtype:IN' => [
            'pb-grid-table',
            'pb-image-gallery',
            'pb-video-gallery',
            'pb-panel-video',
        ]]);
        foreach ($fields as $field) {
            $where = [
                'block_id' => $block->id,
                'resource_id' => $block->resource_id,
                'context_key' => $block->context_key,
                'cultureKey' => $block->cultureKey,
                'field_id' => $field->id,
                'grid_id' => 0,
                'active' => 1,
            ];

            if ($field->xtype == 'pb-grid-table') {
                $values[$field->name] = $this->pb->table->getValues($where);
            }

            if ($field->xtype == 'pb-image-gallery') {
                $values[$field->name] = $this->pb->files->getValues($where);
            }

            if ($field->xtype == 'pb-video-gallery') {
                $values[$field->name] = $this->pb->video->getValues($where);
            }

            if ($field->xtype == 'pb-panel-video') {
                if (empty($values[$field->name])) {
                    $this->pb->video->remove($where);
                } else {
                    $values[$field->name] = $this->pb->video->getValues($where);
                }
            }
        }

        $block->set('values', json_encode($values, JSON_UNESCAPED_UNICODE));
        $block->save();
    }


    /**
     * @param blockTableValue $table
     * @param int $block_id
     */
    public function updateTable(blockTableValue $table, int $block_id)
    {
        $table->_relatedObjects['Fields'] = [];
        $fields = $table->getMany('Fields', ['xtype:IN' => [
            'pb-grid-table',
            'pb-image-gallery',
            'pb-video-gallery',
            'pb-panel-video',
        ]]);
        foreach ($fields as $field) {
            $where = [
                'block_id' => 0,
                'resource_id' => $table->resource_id,
                'context_key' => $table->context_key,
                'cultureKey' => $table->cultureKey,
                'field_id' => $field->id,
                'grid_id' => $table->id,
                'active' => 1,
            ];

            if ($field->xtype == 'pb-grid-table') {
                $rows = $this->modx->getCollection('blockTableValue', $where);
                // Обновляем вложенные таблицы
                foreach ($rows as $row) {
                    $this->updateTable($row, $block_id);
                }
            }

            if ($field->xtype == 'pb-image-gallery') {
                $rows = $this->modx->getCollection('blockFile', $where);
            }

            if ($field->xtype == 'pb-video-gallery') {
                $rows = $this->modx->getCollection('blockVideo', $where);
            }

            if ($field->xtype == 'pb-panel-video') {
                $rows = $this->modx->getCollection('blockVideo', $where);
            }

            foreach ($rows as $row) {
                $row->set('block_id', $block_id);
                $row->save();
            }
        }

    }


    /**
     * @param modResource $oldResource
     * @param modResource $newResource
     */
    public function copyBlockResource(modResource $oldResource, modResource $newResource)
    {
        $blocks = $this->pb->getCollection($this->classKey, ['resource_id' => $oldResource->id]);
        foreach($blocks as $block) {
            $this->pb->runProcessor('mgr/block/copy', [
                'id' => $block->id,
                'resource_id' => $newResource->id,
            ]);
        }
    }


    /**
     * @param pageBlock $old_block
     * @param array $properties
     * @return bool
     */
    public function copy(pageBlock $old_block, array $properties = [])
    {
        $data = $old_block->toArray();
        $params = array_merge($data, $properties, [
            'rank' => $this->getRank([
                'resource_id' => $properties['resource_id'],
                'context_key' => $properties['context_key'],
                'cultureKey' => $properties['cultureKey'],
                'collection_id' => $properties['collection_id'],
            ]),
        ]);
        $new_block = $this->modx->newObject($this->classKey);
        $new_block->fromArray($params, '', false, true);
        if (!$new_block->save()) return false;

        // Копируем файлы
        $this->pb->files->copy([
            'block_id' => $old_block->id,
            'grid_id' => 0,
        ], [
            'block_id' => $new_block->id,
            'resource_id' => $properties['resource_id'],
            'context_key' => $properties['context_key'],
            'cultureKey' => $properties['cultureKey'],
        ]);

        // Копируем видео
        $this->pb->video->copy([
            'block_id' => $old_block->id,
            'grid_id' => 0,
        ], [
            'block_id' => $new_block->id,
            'resource_id' => $properties['resource_id'],
            'context_key' => $properties['context_key'],
            'cultureKey' => $properties['cultureKey'],
        ]);

        // Копируем вложенные таблицы
        $rows = $this->pb->table->getRows([
            'block_id' => $old_block->id,
            'grid_id' => 0
        ]);
        foreach ($rows as $row) {
            $this->pb->table->copy($row, [
                'block_id' => $new_block->id,
                'resource_id' => $properties['resource_id'],
                'context_key' => $properties['context_key'],
                'cultureKey' => $properties['cultureKey'],
            ]);
        }

        return true;
    }


    /**
     * @param pageBlock $block
     * @return bool
     */
    public function removeFiles(pageBlock $block)
    {
        $block->_relatedObjects['Constructor'] = [];
        $fields = $block->getOne('Constructor')->getMany('Fields');
        $values = json_decode($block->values, 1);
        foreach ($fields as $field) {
            if ($field->xtype == 'pb-image-gallery') {
                $this->pb->files->removeFiles($field->source, [
                    'block_id' => $block->id,
                    'field_id' => $field->id,
                    'grid_id' => 0,
                ]);
            }

            if ($field->xtype == 'pb-panel-image') {
                if (!empty($values[$field->name])) {
                    $this->pb->files->removeFile($field->source, $values[$field->name]);
                }
            }

            if ($field->xtype == 'pb-grid-table') {
                $rows = $this->pb->table->getRows([
                    'block_id' => $block->id,
                    'grid_id' => 0
                ]);
                foreach ($rows as $row) {
                    $this->pb->table->removeFiles($row);
                }
            }
        }

        return true;
    }


    /**
     * @param pageBlock $block
     */
    public function updateBaseBlocks(pageBlock $block)
    {
        $childrens = $block->getMany('Childrens');
        foreach($childrens as $children) {
            $this->updateBaseBlock($children, $block->id);
        }
    }


    /**
     * @param pageBlock $block
     * @param int $baseblock
     */
    public function updateBaseBlock(pageBlock $block, int $baseblock)
    {

        $values = $this->getValues(['id' => $baseblock]);
        $block->set('values', json_encode($values[0], JSON_UNESCAPED_UNICODE));
        $block->save();

        // Удаляем старые записи картинок
        $this->pb->files->remove(['block_id' => $block->id]);
        // Удаляем старые таблицы
        $this->pb->table->remove(['block_id' => $block->id]);

        // Копируем файлы
        $this->pb->files->copy([
            'block_id' => $baseblock,
            'grid_id' => 0,
        ], [
            'block_id' => $block->id,
            'resource_id' => $block->resource_id,
            'context_key' => $block->context_key,
            'cultureKey' => $block->cultureKey,
        ]);

        // Копируем видео
        $this->pb->video->copy([
            'block_id' => $baseblock,
            'grid_id' => 0,
        ], [
            'block_id' => $block->id,
            'resource_id' => $block->resource_id,
            'context_key' => $block->context_key,
            'cultureKey' => $block->cultureKey,
        ]);

        // Копируем вложенные таблицы
        $rows = $this->pb->table->getRows([
            'block_id' => $baseblock,
            'grid_id' => 0
        ]);
        foreach ($rows as $row) {
            $this->pb->table->copy($row, [
                'block_id' => $block->id,
                'resource_id' => $block->resource_id,
                'context_key' => $block->context_key,
                'cultureKey' => $block->cultureKey,
            ]);
        }
    }


    public function createVersion(pageBlock $block, $mode = 'new')
    {
        $version = $this->modx->newObject('pbVersion');
        $version->fromArray([
            'block_id' => $block->id,
            'constructor_id' => $block->constructor_id,
            'values' => json_encode($block->toArray(), JSON_UNESCAPED_UNICODE),
            'user' => $this->modx->user->id,
            'mode' => $mode,
        ], '', false, true);

        return $version->save();
    }


    /**
     * @param modResource $resource
     */
    public function syncValues(modResource $resource)
    {
        if ($block = $this->modx->getObject($this->classKey, ['object_id' => $resource->id])) {
            $res_arr = $resource->toArray();
            $values = json_decode($block->values,1);
            $fields = $block->getOne('Constructor')->getMany('Fields', ['active' => 1]);
            foreach ($fields as $field) {
                if (isset($res_arr[$field->name])) {
                    $values[$field->name] = $res_arr[$field->name];
                }
            }
            $block->set('values', json_encode($values,JSON_UNESCAPED_UNICODE));
            // Синхронизация pusblished
            $block->set('active', $resource->published);
            // Сохраняем блок
            $block->save();
        }
    }


    /**
     * @param array $where
     * @return mixed
     */
    public function getValues(array $where)
    {
        return $this->pb->getValues($this->classKey, $where);
    }


    /**
     * @param array $where
     * @return int|mixed
     */
    public function getRank(array $where)
    {
        return $this->pb->getRank($this->classKey, $where);
    }
}