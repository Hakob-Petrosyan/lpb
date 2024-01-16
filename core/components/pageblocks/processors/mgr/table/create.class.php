<?php

class blockTableCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockTable';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->properties['name']);
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('block_table_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            $this->modx->error->addField('name', $this->modx->lexicon('block_table_err_ae'));
        }

        return parent::beforeSet();
    }

    public function beforeSave()
    {
        $this->object->fromArray(array(
            'rank' => $this->modx->getCount($this->classKey),
        ));

        return parent::beforeSave();
    }

    public function afterSave()
    {

        if($fields = $this->modx->getCollection('blockField', ['table_id' => 0, 'block_id' => 0])) {
            foreach ($fields as $field) {
                $field->set('table_id', $this->object->id);
                $field->save();
            }
        }

        if($groups = $this->modx->getCollection('blockFieldGroup', ['table_id' => 0, 'block_id' => 0])) {
            foreach ($groups as $group) {
                $group->set('table_id', $this->object->id);
                $group->save();
            }
        }

        if($columns = $this->modx->getCollection('pbTableColumn', ['table_id' => 0, 'collection_id' => 0])) {
            foreach ($columns as $column) {
                $column->set('table_id', $this->object->id);
                $column->save();
            }
        }

        return parent::afterSave();
    }

}

return 'blockTableCreateProcessor';