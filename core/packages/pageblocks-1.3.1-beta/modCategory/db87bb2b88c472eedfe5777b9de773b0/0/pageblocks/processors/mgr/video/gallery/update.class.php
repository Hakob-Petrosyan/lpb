<?php

class PageBlocksVideoUpdateProcessor extends modObjectUpdateProcessor
{
    public $classKey = 'blockVideo';
    public $languageTopics = array('default');
//    public $permission = 'pageblocksfile_save';



    /**
     * @return bool|null|string
     */
    public function initialize()
    {
        if (!$this->modx->hasPermission($this->permission)) {
            return $this->modx->lexicon('access_denied');
        }

        return parent::initialize();
    }

    public function beforeSet()
    {
        if (!empty($this->properties['thumbnail'])) {
            $this->properties['thumbnail'] = trim($this->properties['thumbnail'], '/');
        }

        return parent::beforeSet();
    }

}

return 'PageBlocksVideoUpdateProcessor';