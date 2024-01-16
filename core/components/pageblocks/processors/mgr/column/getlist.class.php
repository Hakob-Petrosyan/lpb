<?php

class pbTableColumnGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'pb';
    public $classKey = 'pbTableColumn';
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
            'table_id' => $this->properties['table_id'] ?: 0,
            'collection_id' => $this->properties['collection_id'] ?: 0,
        ));

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

        // Получаем поле
        if($field = $object->getOne('Field')) {
            $array['name'] = $field->name;
            $array['caption'] = $field->caption;
        }

        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('block_field_update'),
            'action' => 'updateColumn',
            'button' => true,
            'menu' => true,
        ];

        if (!$array['active']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('block_field_enable'),
                'action' => 'enableColumn',
                'button' => true,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('block_field_disable'),
//                'multiple' => $this->modx->lexicon('block_fields_disable'),
                'action' => 'disableColumn',
                'button' => true,
                'menu' => true,
            ];
        }

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('block_field_remove'),
//            'multiple' => $this->modx->lexicon('pageblocks_remove'),
            'action' => 'removeColumn',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}

return 'pbTableColumnGetListProcessor';