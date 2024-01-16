<?php

class PageBlockTable
{
    /** @var modX $modx */
    public $modx;

    /** @var PageBlocks $pp */
    public $pb;

    public $classKey = 'blockTableValue';

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

            return !in_array($name, ['id', 'resource_id', 'context_key', 'cultureKey',
                'field_id', 'grid_id', 'action', 'block_id', 'table_id', 'active']);

        }, ARRAY_FILTER_USE_KEY);

        return $values;
    }


    /**
     * @param blockTableValue $table
     */
    public function createValues(blockTableValue $table)
    {
        $fields = $table->getMany('Fields', ['xtype:IN' => [
            'pb-grid-table',
            'pb-image-gallery',
            'pb-video-gallery',
            'pb-panel-video',
        ]]);
        foreach ($fields as $field) {
            $where = [
                'block_id' => $table->block_id,
                'resource_id' => $table->resource_id,
                'context_key' => $table->context_key,
                'cultureKey' => $table->cultureKey,
                'field_id' => $field->id,
                'grid_id' => 0,
                'active' => 1,
            ];

            if ($field->xtype == 'pb-grid-table') {
                $rows = $this->getRows($where);
            }

            if ($field->xtype == 'pb-image-gallery') {
                $rows = $this->pb->files->getRows($where);
            }

            if ($field->xtype == 'pb-video-gallery') {
                $rows = $this->pb->video->getRows($where);
            }

            if ($field->xtype == 'pb-panel-video') {
                $rows = $this->pb->video->getRows($where);
            }

            foreach ($rows as $row) {
                $row->set('grid_id', $table->id);
                $row->save();
            }
        }

        $this->updateValues($table);
    }

    /**
     * @param blockTableValue $table
     */
    public function updateValues(blockTableValue $table)
    {
        $values = json_decode($table->values,1);
        $table->_relatedObjects['Fields'] = [];
        $fields = $table->getMany('Fields', ['xtype:IN' => [
            'pb-grid-table',
            'pb-image-gallery',
            'pb-video-gallery',
            'pb-panel-video',
        ]]);
        foreach ($fields as $field) {
            $where = [
                'resource_id' => $table->resource_id,
                'context_key' => $table->context_key,
                'cultureKey' => $table->cultureKey,
                'block_id' => $table->block_id,
                'field_id' => $field->id,
                'grid_id' => $table->id,
                'active' => 1,
            ];

            if ($field->xtype == 'pb-grid-table') {
                $values[$field->name] = $this->getValues($where);
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

        $table->set('values', json_encode($values, JSON_UNESCAPED_UNICODE));
        $table->save();
    }


    /**
     * @param blockTableValue $object
     * @param array $properties
     * @return bool
     */
    public function copy(blockTableValue $old_table, array $properties = [])
    {
        $data = $old_table->toArray();
        $params = array_merge($data, $properties, [
            'rank' => $this->getRank([
                'block_id' => $properties['block_id'],
                'resource_id' => $properties['resource_id'],
                'context_key' => $properties['context_key'],
                'cultureKey' => $properties['cultureKey'],
                'field_id' => $data['field_id'],
                'grid_id' => $data['grid_id'],
            ]),
        ]);
        $new_table = $this->modx->newObject($this->classKey);
        $new_table->fromArray($params, '', false, true);
        if (!$new_table->save()) return false;

        // Копируем файлы
        $this->pb->files->copy([
            'grid_id' => $old_table->id,
        ], [
            'grid_id' => $new_table->id,
            'block_id' => $properties['block_id'],
            'resource_id' => $properties['resource_id'],
            'context_key' => $properties['context_key'],
            'cultureKey' => $properties['cultureKey'],
        ]);

        // Копируем видео
        $this->pb->video->copy([
            'grid_id' => $old_table->id,
        ], [
            'grid_id' => $new_table->id,
            'block_id' => $properties['block_id'],
            'resource_id' => $properties['resource_id'],
            'context_key' => $properties['context_key'],
            'cultureKey' => $properties['cultureKey'],
        ]);

        // Копируем вложенные таблицы
        $grids = $this->getRows(['grid_id' => $data['id']]);
        foreach ($grids as $grid) {
            $this->copy($grid, array_merge($grid->toArray(), [
                'block_id' => $new_table->block_id,
                'grid_id' => $new_table->id,
                'resource_id' => $properties['resource_id'],
                'context_key' => $properties['context_key'],
                'cultureKey' => $properties['cultureKey'],
            ]));
        }

        return true;
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function remove(array $where = [])
    {
        return $this->modx->removeCollection($this->classKey, $where);
    }

    /**
     * @param blockTableValue $table
     * @return bool
     */
    public function removeFiles(blockTableValue $table)
    {
        $table->_relatedObjects['Fields'] = [];
        $fields = $table->getMany('Fields');
        $values = json_decode($table->values,1);
        foreach ($fields as $field) {
            if ($field->xtype == 'pb-image-gallery') {
                $this->pb->files->removeFiles($field->source, [
                    'field_id' => $field->id,
                    'grid_id' => $table->id,
                ]);
            }

            if ($field->xtype == 'pb-panel-image') {
                if (!empty($values[$field->name])) {
                    $this->pb->files->removeFile($field->source, $values[$field->name]);
                }
            }

            if ($field->xtype == 'pb-grid-table') {
                $rows = $this->getRows(['grid_id' => $table->id]);
                foreach ($rows as $row) {
                    $this->removeFiles($row);
                }
            }
        }

        return true;
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function getRows(array $where = [])
    {
        $rows = $this->pb->getCollection($this->classKey, $where);

        return $rows;
    }

    /**
     * @param array $where
     * @return array
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