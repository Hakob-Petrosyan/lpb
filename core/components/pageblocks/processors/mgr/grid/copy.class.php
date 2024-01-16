<?php

class blockTableValueCopyProcessor extends modObjectGetProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockTableValue';
    public $languageTopics = ['pageblocks:default'];
    //public $permission = 'view';

    /** @var PageBlocks $pb */
    public $pb;


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


    public function cleanup()
    {
        $array = $this->object->toArray();
        if (!$this->pb->table->copy($this->object, $array)) {
            return $this->failure('', $array);
        }

        return $this->success('', $array);
    }

}

return 'blockTableValueCopyProcessor';