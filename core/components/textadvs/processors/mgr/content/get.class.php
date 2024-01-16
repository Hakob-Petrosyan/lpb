<?php

class txaContentGetProcessor extends modObjectGetProcessor
{
    public $objectType = 'txaContent';
    public $classKey = 'txaContent';
    public $languageTopics = array('textadvs:default');
    public $permission = 'view';

    /**
     * @return mixed
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        return parent::process();
    }
}

return 'txaContentGetProcessor';