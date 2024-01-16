<?php

class blockConstructorGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockConstructor';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';

    /** @var PageBlocks $pb */
    public $pb;


    public function initialize()
    {
        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');
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
     * Can be used to insert a row before iteration
     * @param array $list
     * @return array
     */
    public function afterIteration(array $list)
    {
        if($this->properties['resource_id'] && $resource = $this->modx->getObject('modResource', $this->properties['resource_id'])) {
            $list = $this->pb->getFilteredBlocks($list, $resource->toArray());
        }
        return $list;
    }


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        if($this->properties['resource_id']) {
            return $object->toArray();
        }

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
            'title' => $this->modx->lexicon('pb_update'),
            'action' => 'changeBlock',
            'button' => true,
            'menu' => true,
        ];

        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-copy',
            'title' => $this->modx->lexicon('pb_copy'),
            'action' => 'copyBlock',
            'button' => true,
            'menu' => true,
        ];

        if (!$array['active']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('pb_enable'),
                'action' => 'enableBlock',
                'button' => true,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('pb_disable'),
//                'multiple' => $this->modx->lexicon('pageblocks_disable'),
                'action' => 'disableBlock',
                'button' => true,
                'menu' => true,
            ];
        }

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('pb_remove'),
//            'multiple' => $this->modx->lexicon('pageblocks_remove'),
            'action' => 'removeBlock',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}

return 'blockConstructorGetListProcessor';