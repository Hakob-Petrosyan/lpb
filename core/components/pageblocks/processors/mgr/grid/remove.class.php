<?php

class blockTableValueRemoveProcessor extends modObjectRemoveProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockTableValue';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'remove';

    /** @var PageBlocks $pb */
    public $pb;


    /**
     * @return array|string
     */
    public function initialize()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }
        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        return parent::initialize();
    }
    
    /**
     * @return bool|string
     */
    public function beforeRemove()
    {
        // Удаляем файлы
        if($this->modx->getOption('pageblocks_remove_image')) {
            $this->pb->table->removeFiles($this->object);
        }

        return parent::beforeRemove();
    }

}

return 'blockTableValueRemoveProcessor';