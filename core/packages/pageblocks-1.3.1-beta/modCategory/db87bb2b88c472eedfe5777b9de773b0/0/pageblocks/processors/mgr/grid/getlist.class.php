<?php

class blockTableValueGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockTableValue';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
    //public $permission = 'list';

    /** @var PageBlocks $pb */
    public $pb;

    public function initialize()
    {
        if (!$this->modx->hasPermission($this->permission)) {
            return $this->modx->lexicon('access_denied');
        }

        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        if ($this->properties['version_id']) {
            $this->classKey = 'pbVersionTableValue';
        } else {
            $this->properties['unique'] = 0;
            $this->properties['baseblock'] = 0;

            if ($block = $this->modx->getObject('pageBlock', [
                'id' => $this->properties['block_id'],
                'unique' => 0
            ])) {
                $this->properties['unique'] = $block->unique;
                if ($block->baseblock) {
                    $this->properties['baseblock'] = $block->baseblock;
                }
                if (!$block->resource_id) {
                    $this->properties['baseblock'] = $block->id;
                }
            }
        }

        return parent::initialize();
    }


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
        $data = $this->properties;

        $where = [
            'block_id' => $data['block_id'],
            'field_id' => $data['field_id'],
            'table_id' => $data['table_id'],
            'resource_id' => $data['resource_id'],
            'context_key' => $data['context_key'],
            'cultureKey' => $data['cultureKey'],
        ];
        if ($data['grid_id'] != '') {
            $where['grid_id'] = $data['grid_id'];
        }
        if ($this->properties['version_id']) {
            $where['version_id'] = $data['version_id'];
        }

        $c->where($where);

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
        $values = json_decode($array['values'],1);

        // Получаем колонки для сетки
        $columns = $object->getMany('Columns');
        foreach ($columns as $column) {
            $field = $column->getOne('Field');
            $name = $field->name;
            if (isset($values[$name])) {
                $array[$name] = $values[$name];
                if ($column->render == 'renderResource') {
                    if ($res = $this->modx->getObject('modResource', ['id' => $values[$name]])) {
                        $array[$name] = $res->pagetitle;
                    }
                }
            }
        }

        $array['actions'] = [];

        if ($this->properties['version_id']) {
            $array['id'] = $array['version_table_id'];
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-eye',
                'title' => $this->modx->lexicon('pb_version_view'),
                'action' => 'viewItem',
                'button' => true,
                'menu' => true,
            );

            return $array;
        }

        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('pb_update'),
            'action' => 'updateItem',
            'button' => true,
            'menu' => true,
        ];

        if (
            $this->properties['baseblock'] &&
            !$this->properties['unique'] &&
            $this->properties['resource_id']
        ) {
            return $array;
        }

        if (!$array['active']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('pb_enable'),
                'multiple' => $this->modx->lexicon('pb_select_enable'),
                'action' => 'enableItem',
                'button' => true,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('pb_disable'),
                'multiple' => $this->modx->lexicon('pb_select_disable'),
                'action' => 'disableItem',
                'button' => true,
                'menu' => true,
            ];
        }

        // Copy
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-copy',
            'title' => $this->modx->lexicon('pb_copy'),
            'action' => 'copyItem',
            'button' => true,
            'menu' => true,
        ];

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('pb_remove'),
            'multiple' => $this->modx->lexicon('pb_select_remove'),
            'action' => 'removeItem',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}

return 'blockTableValueGetListProcessor';