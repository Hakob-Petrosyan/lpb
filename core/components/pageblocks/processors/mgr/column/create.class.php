<?php

class pbTableColumnCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'pbTableColumn';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {

        $field_id = trim($this->properties['field_id']);
        $table_id = trim($this->properties['table_id']);
        $collection_id = trim($this->properties['collection_id']);
        if (empty($field_id)) {
            $this->modx->error->addField('field_id', $this->modx->lexicon('block_field_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['field_id' => $field_id, 'table_id' => $table_id, 'collection_id' => $collection_id])) {
            $this->modx->error->addField('field_id', $this->modx->lexicon('block_field_err_ae'));
        }

        return parent::beforeSet();
    }

    public function beforeSave()
    {
        $this->object->fromArray(array(
            'rank' => $this->modx->getCount($this->classKey, [
                'table_id' => $this->properties['table_id'],
                'collection_id' => $this->properties['collection_id'],
            ]),
        ));

        return parent::beforeSave();
    }

}

return 'pbTableColumnCreateProcessor';