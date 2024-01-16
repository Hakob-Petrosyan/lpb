<?php

class blockTableValueUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockTableValue';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'save';

    /** @var PageBlocks $pb */
    public $pb;

    /**
     * @return bool|null|string
     */
    public function initialize()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }
        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        return parent::initialize();
    }


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $id = (int) $this->properties['id'];
        if (empty($id)) {
            return $this->modx->lexicon('pb_grid_err_ns');
        }

        $values = $this->pb->block->filterValues($this->properties);
        $this->properties['values'] = json_encode($values, JSON_UNESCAPED_UNICODE);

        return parent::beforeSet();
    }

    public function afterSave()
    {
        // Обновляем значения
        $this->pb->table->updateValues($this->object);

        return parent::afterSave();
    }
}

return 'blockTableValueUpdateProcessor';
