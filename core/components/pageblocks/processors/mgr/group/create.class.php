<?php

class blockFieldGroupCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockFieldGroup';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->properties['name']);
        if ($this->modx->getCount($this->classKey, [
                'name' => $name, 
                'block_id' => $this->properties['block_id'],
                'table_id' => $this->properties['table_id']
            ])) {
            $this->modx->error->addField('name', $this->modx->lexicon('block_group_err_ae'));
        }

        return parent::beforeSet();
    }

    public function beforeSave()
    {
        $this->object->fromArray(array(
            'rank' => $this->modx->getCount($this->classKey, [
                'block_id' => $this->properties['block_id'],
                'table_id' => $this->properties['table_id'],
            ]),
        ));

        return parent::beforeSave();
    }

}

return 'blockFieldGroupCreateProcessor';