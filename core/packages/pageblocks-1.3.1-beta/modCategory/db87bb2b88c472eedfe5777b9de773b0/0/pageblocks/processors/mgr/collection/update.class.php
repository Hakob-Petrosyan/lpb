<?php

class blockCollectionUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockCollection';
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
        $name = trim($this->properties['name']);
        if (empty($id)) {
            return $this->modx->lexicon('pb_err_ns');
        }

        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('pb_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name, 'id:!=' => $id])) {
            $this->modx->error->addField('name', $this->modx->lexicon('pb_err_ae'));
        }

        return parent::beforeSet();
    }
}

return 'blockCollectionUpdateProcessor';
