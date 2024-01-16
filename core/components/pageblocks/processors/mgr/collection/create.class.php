<?php

class blockCollectionCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockCollection';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'create';

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
            $this->modx->error->addField('name', $this->modx->lexicon('pb_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            $this->modx->error->addField('name', $this->modx->lexicon('pb_err_ae'));
        }

        return parent::beforeSet();
    }

    /**
     * @return bool
     */
    public function beforeSave()
    {
        $this->object->fromArray(array(
            'rank' => $this->modx->getCount($this->classKey),
        ));

        return parent::beforeSave();
    }

    public function afterSave()
    {

        $columns = $this->modx->getCollection('pbTableColumn', ['table_id' => 0, 'collection_id' => 0]);
        foreach ($columns as $column) {
            $column->set('collection_id', $this->object->id);
            $column->save();
        }

        return parent::afterSave();
    }

}

return 'blockCollectionCreateProcessor';