<?php

class pbResourceColumnRemoveProcessor extends modObjectRemoveProcessor
{
    public $objectType = 'pb';
    public $classKey = 'pbResourceColumn';
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

    public function afterRemove()
    {
        // Удаляем поле с таблицы ресурсов
        $this->pb->resource->removeTableColumn($this->object);

        return true;
    }

}

return 'pbResourceColumnRemoveProcessor';