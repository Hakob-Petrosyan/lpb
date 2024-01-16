<?php

class pbResourceColumnGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'pb';
    public $classKey = 'pbResourceColumn';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'asc';
    //public $permission = 'list';


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {

        $array = $object->toArray();
        $array['actions'] = [];

        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('block_field_update'),
            'action' => 'updateField',
            'button' => true,
            'menu' => true,
        ];
        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('block_field_remove'),
//            'multiple' => $this->modx->lexicon('block_fields_remove'),
            'action' => 'removeField',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}

return 'pbResourceColumnGetListProcessor';