<?php

class blockCollectionRemoveProcessor extends modObjectRemoveProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockCollection';
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

}

return 'blockCollectionRemoveProcessor';