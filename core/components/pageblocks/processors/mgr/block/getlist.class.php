<?php

class pageBlockGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'pb';
    public $classKey = 'pageBlock';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
    //public $permission = 'list';


    /**
     * We do a special check of permissions
     * because our objects is not an instances of modAccessibleObject
     *
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $query = trim($this->properties['query']);
        if ($query) {
            $c->select($this->modx->getSelectColumns($this->classKey, $this->classKey));
            $c->leftJoin('blockConstructor', 'Constructor', 'pageBlock.constructor_id = Constructor.id');
            $c->select($this->modx->getSelectColumns('blockConstructor', 'Constructor', 'pageblock_', ['name']));

            $this->modx->invokeEvent('OnSearchBlock',array(
                'object' => &$c,
                'properties' => $this->properties,
                'query' => $query,
            ));
            $c->where([
                'OR:Constructor.name:LIKE' => "%{$query}%"
            ]);
        }

        $c->where([
            'resource_id' => (int)($this->properties['resource_id']),
            'context_key' => trim($this->properties['context']),
            'cultureKey' => trim($this->properties['language']) ?: $this->modx->getOption('cultureKey'),
            'collection_id' => $this->properties['collection_id'] ?: 0,
        ]);

        return $c;
    }


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {

        $array = $object->toArray();
        $array['values'] = json_decode($array['values'],1);
        $array['actions'] = [];

        if ($array['collection_id']) {
            // Получаем колонки для сетки
            $columns = $object->getOne('Collection')->getMany('Columns');
            foreach ($columns as $column) {
                $field = $column->getOne('Field');
                $name = $field->name;
                if (isset($array['values'][$name])) {
                    $array[$name] = $array['values'][$name];
                }
            }
        } else {
            // Получаем имя блока
            $array['block_name'] = '';
            if ($block = $object->getOne('Constructor')) {
                $array['block_name'] = $block->name;
            }
        }

        // Добавить переход на страницу
        if ($array['object_id'] && $res = $this->modx->getObject('modResource', $array['object_id'])) {
            $array['resource_url'] = $this->modx->makeUrl($array['object_id'], $res->context_key);
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-eye action-green',
                'title' => $this->modx->lexicon('pb_block_page_view'),
                'action' => 'viewResource',
                'button' => false,
                'menu' => true,
            ];
        }


        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('pb_block_update'),
            'action' => 'updateBlock',
            'button' => true,
            'menu' => true,
        ];

        if (!$array['active']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('pb_block_enable'),
                'multiple' => $this->modx->lexicon('pb_block_enable'),
                'action' => 'enableBlock',
                'button' => true,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('pb_block_disable'),
                'multiple' => $this->modx->lexicon('pb_blocks_disable'),
                'action' => 'disableBlock',
                'button' => true,
                'menu' => true,
            ];
        }

        // Edit chunk
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-th-large',
            'title' => $this->modx->lexicon('pb_block_update_chunk'),
            'action' => 'updateChunk',
            'button' => !$array['object_id'],
            'menu' => true,
        ];

        // Copy
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-copy',
            'title' => $this->modx->lexicon('pb_block_copy'),
            'action' => 'copyBlock',
            'button' => !$array['object_id'],
            'menu' => true,
        ];

        // Добавить переход на ресурс
        if ($array['object_id']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-eye action-green',
                'title' => $this->modx->lexicon('pb_block_resource_view'),
                'action' => 'openResource',
                'button' => true,
                'menu' => true,
            ];
        }

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('pb_block_remove'),
            'multiple' => $this->modx->lexicon('pb_blocks_remove'),
            'action' => 'removeBlock',
            'button' => !$array['object_id'],
            'menu' => true,
        ];

        // Menu
        if ($array['object_id']) {

            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-cog actions-menu',
                'menu' => false,
                'button' => true,
                'action' => 'showMenu',
                'type' => 'menu',
            );
        }

        // Для столбца values
        $values = '';
        $fields = $object->getOne('Constructor')->getMany('Fields');
        $fields_lexicon = [];
        foreach ($fields as $field) {
            $fields_lexicon[$field->name] = $field->caption;
        }
        foreach ($array['values'] as $title => $value) {
            if (!empty($value) && !is_array($value)) {
                $values .= "<b>{$fields_lexicon[$title]}:</b> $value <br>";
            }
        }
        $array['values'] = $values;

        return $array;
    }

}

return 'pageBlockGetListProcessor';