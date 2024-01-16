<?php

class pbResourceColumnUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'pbResourceColumn';
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
        $name = trim($this->properties['name']);
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('block_field_err_name'));
        } elseif ($this->modx->getCount($this->classKey, [
            'name' => $name,
            'id:!=' => $this->properties['id'],
        ])) {
            $this->modx->error->addField('name', $this->modx->lexicon('block_field_err_ae'));
        }
        if (!preg_match("/^[a-z]/", $name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('block_field_validation_name'));
        }

        $this->properties['name'] = $name;

        return parent::beforeSet();
    }

    /**
     * @return mixed
     */
    public function afterSave()
    {
        // Обновляем колонку
        $this->pb->resource->updateTableColumn($this->object);

        return parent::afterSave();
    }
}

return 'pbResourceColumnUpdateProcessor';