<?php

class pbVersionGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'pb';
    public $classKey = 'pbVersion';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';

    public $languageTopics = ['pageblocks:version'];
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

            if (is_numeric($query)) {
                $c->where(['block_id' => $query]);
            } else {
                if ($block = $this->modx->getObject('blockConstructor', ['name:LIKE' => "%$query%"])) {
                    $c->where(['constructor_id' => $block->id]);
                }
            }
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
        $array['admin'] = 0;

        $array['user'] = $object->getOne('User')->username;
        $array['block_name'] = $object->getOne('Constructor')->name;

        $array['actions'] = [];

        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-eye',
            'title' => $this->modx->lexicon('pb_version_view'),
            'action' => 'viewVersion',
            'button' => true,
            'menu' => true,
        ];

        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-history',
            'title' => $this->modx->lexicon('pb_version_restore'),
            'action' => 'restoreVersion',
            'button' => true,
            'menu' => true,
        ];

        if ($this->modx->user->isMember('Administrator')) {
            $array['admin'] = 1;

            // Remove
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-trash-o action-red',
                'title' => $this->modx->lexicon('pb_remove'),
                'multiple' => $this->modx->lexicon('pb_select_remove'),
                'action' => 'removeVersion',
                'button' => true,
                'menu' => true,
            ];
        }

        return $array;
    }

}

return 'pbVersionGetListProcessor';