<?php

class blockTableGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockTable';
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
            $c->where([
                'name:LIKE' => "%{$query}%",
            ]);
        }

        if ($this->properties['combo']) {
            $c->select('id,name');
            $c->where([
                'active' => 1,
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
        if ($this->properties['combo']) {
            return array(
                'id' => $object->id,
                'name' => $object->name,
            );
        }

        $array = $object->toArray();
        $array['actions'] = [];

        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('block_table_update'),
            'action' => 'updateTable',
            'button' => true,
            'menu' => true,
        ];

        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-copy',
            'title' => $this->modx->lexicon('block_table_copy'),
            'action' => 'copyTable',
            'button' => true,
            'menu' => true,
        ];

        if (!$array['active']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('block_table_enable'),
                'action' => 'enableTable',
                'button' => true,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('block_table_disable'),
//                'multiple' => $this->modx->lexicon('block_tables_disable'),
                'action' => 'disableTable',
                'button' => true,
                'menu' => true,
            ];
        }

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('block_table_remove'),
//            'multiple' => $this->modx->lexicon('block_tables_remove'),
            'action' => 'removeTable',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}

return 'blockTableGetListProcessor';