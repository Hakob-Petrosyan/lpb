<?php

class PageBlocksFileRemoveProcessor extends modObjectRemoveProcessor
{
    public $classKey = 'blockFile';
    public $languageTopics = array('default');
//    public $permission = 'pageblocksfile_save';
    /** @var PageBlocks $pb */
    public $pb;

    public $beforeRemoveEvent = 'pbBeforeRemoveImage';
    public $afterRemoveEvent  = 'pbAfterRemoveImage';


    /**
     * @return bool|null|string
     */
    public function initialize()
    {
        if (!$this->modx->hasPermission($this->permission)) {
            return $this->modx->lexicon('access_denied');
        }
        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        return parent::initialize();
    }


    public function beforeRemove()
    {
        if ($this->modx->getOption('pageblocks_remove_image')) {
            $field = $this->object->getOne('Field');
            $this->pb->files->removeFile($field->source, $this->object->path . $this->object->filename);
        }

        return true;
    }

}

return 'PageBlocksFileRemoveProcessor';