<?php

class pageBlockRemoveProcessor extends modObjectRemoveProcessor
{
    public $objectType = 'pb';
    public $classKey = 'pageBlock';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'remove';

    /** @var PageBlocks $pb */
    public $pb;

    public $beforeRemoveEvent = 'pbBeforeRemoveBlock';
    public $afterRemoveEvent  = 'pbAfterRemoveBlock';


    /**
     * @return mixed
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
     * @return mixed
     */
    public function beforeRemove()
    {
        // Удаляем файлы
        if ($this->modx->getOption('pageblocks_remove_image')) {
            $this->pb->block->removeFiles($this->object);
        }

        return parent::beforeRemove();
    }

    /**
     * @return mixed
     */
    public function afterRemove()
    {
        // Удаляем ресурс
        if ($this->object->object_id) {
            $this->pb->resource->remove($this->object->object_id);
        }

        // Помечаем версию блока как удалено
        $this->pb->version->remove($this->object);

        return parent::afterRemove();
    }

}

return 'pageBlockRemoveProcessor';