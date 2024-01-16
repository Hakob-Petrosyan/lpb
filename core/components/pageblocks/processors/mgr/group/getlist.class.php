<?php

class blockFieldGroupGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockFieldGroup';
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
            'table_id' => $this->properties['table_id'] ?: 0,
        ));

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

        $array = $object->toArray();
        $array['actions'] = [];

        if ($this->properties['combo']) {
            return array(
                'id' => $object->id,
                'name' => $object->name,
            );
        }

        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('block_group_update'),
            'action' => 'updateGroup',
            'button' => true,
            'menu' => true,
        ];

        if (!$array['active']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('block_group_enable'),
                'action' => 'enableGroup',
                'button' => true,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('block_group_disable'),
//                'multiple' => $this->modx->lexicon('block_tabs_disable'),
                'action' => 'disableGroup',
                'button' => true,
                'menu' => true,
            ];
        }

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('block_group_remove'),
//            'multiple' => $this->modx->lexicon('pageblocks_remove'),
            'action' => 'removeGroup',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }


    /**
     * @param array $array
     * @param bool $count
     *
     * @return string
     */
    public function outputArray(array $array, $count = false)
    {
        if ($this->properties['combo']) {
            $array = array_merge_recursive(array(
                array(
                    'id' => 0,
                    'name' => $this->modx->lexicon('block_group_empty'),
                ),
            ), $array);
        }

        return parent::outputArray($array, $count);
    }

}

return 'blockFieldGroupGetListProcessor';