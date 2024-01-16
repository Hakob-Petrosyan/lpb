<?php

class blockTableValueCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockTableValue';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'create';

    /** @var PageBlocks $pb */
    public $pb;

    /**
     * {@inheritDoc}
     * @return boolean
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
        $values = $this->pb->block->filterValues($this->properties);
        $this->properties['values'] = json_encode($values, JSON_UNESCAPED_UNICODE);


        return parent::beforeSet();
    }

    public function beforeSave()
    {
        $this->object->set('rank', $this->pb->table->getRank([
            'block_id' => $this->properties['block_id'],
            'field_id' => $this->properties['field_id'],
            'resource_id' => $this->properties['resource_id'],
            'context_key' => $this->properties['context_key'],
            'cultureKey' => $this->properties['cultureKey'],
            'grid_id' => $this->properties['grid_id'],
        ]));

        return parent::beforeSave();
    }

    public function afterSave()
    {
        // Обновляем значения
        $this->pb->table->createValues($this->object);

        return parent::afterSave();
    }

}

return 'blockTableValueCreateProcessor';