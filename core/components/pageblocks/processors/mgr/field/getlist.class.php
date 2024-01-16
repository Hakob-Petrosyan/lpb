<?php

class blockFieldGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockField';
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
        $c->where(array(
            'block_id' => $this->properties['block_id'] ?: 0,
            'table_id' => $this->properties['table_id'] ?: 0
        ));

        if(!isset($this->properties['all'])) {
            $c->where([
                'group_id' => $this->properties['group_id'] ?: 0
            ]);
        }

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
        $array['actions'] = [];

        if($group = $object->getOne('Group')) {
            $array['group'] = $group->name;
        }


        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('block_field_update'),
            'action' => 'updateField',
            'button' => true,
            'menu' => true,
        ];

        if (!$array['active']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('block_field_enable'),
                'action' => 'enableField',
                'button' => true,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('block_field_disable'),
//                'multiple' => $this->modx->lexicon('block_fields_disable'),
                'action' => 'disableField',
                'button' => true,
                'menu' => true,
            ];
        }

        // Copy
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-copy',
            'title' => $this->modx->lexicon('block_field_copy'),
            'action' => 'copyField',
            'button' => true,
            'menu' => true,
        ];

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('block_field_remove'),
//            'multiple' => $this->modx->lexicon('pageblocks_remove'),
            'action' => 'removeField',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}

return 'blockFieldGetListProcessor';