<?php

class pbTableColumnRemoveProcessor extends modObjectRemoveProcessor
{
    public $objectType = 'pb';
    public $classKey = 'pbTableColumn';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'remove';


    /**
     * @return array|string
     */
    public function initialize()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        return parent::initialize();
    }
    
    /**
     * @return bool|string
     */
    public function beforeRemove()
    {
        return parent::beforeRemove();
    }

}

return 'pbTableColumnRemoveProcessor';