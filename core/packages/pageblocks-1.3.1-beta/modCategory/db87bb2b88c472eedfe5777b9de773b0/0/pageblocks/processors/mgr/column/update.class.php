<?php

class pbTableColumnUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'pbTableColumn';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'save';


    /**
     * @return bool|null|string
     */
    public function initialize()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return parent::initialize();
    }


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $id = (int) $this->properties['id'];
        $table_id = (int) $this->properties['table_id'];
        $collection_id = (int) $this->properties['collection_id'];
        $field_id = (int)($this->properties['field_id']);

        if (empty($field_id)) {
            $this->modx->error->addField('field_id', $this->modx->lexicon('block_field_err_field'));
        } elseif ($this->modx->getCount($this->classKey, [
            'id:!=' => $id,
            'field_id' => $field_id,
            'table_id' => $table_id,
            'collection_id' => $collection_id
        ])) {
            $this->modx->error->addField('field_id', $this->modx->lexicon('block_field_err_ae'));
        }

        return parent::beforeSet();
    }
}

return 'pbTableColumnUpdateProcessor';
