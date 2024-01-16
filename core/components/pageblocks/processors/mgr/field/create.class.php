<?php

class blockFieldCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockField';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->properties['name']);
        $block_id = (int) $this->properties['block_id'];
        $table_id = (int) $this->properties['table_id'];

        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('block_field_err_name'));
        } elseif ($this->modx->getCount($this->classKey, [
            'block_id' => $block_id,
            'table_id' => $table_id,
            'name' => $name,
        ])) {
            $this->modx->error->addField('name', $this->modx->lexicon('block_field_err_ae'));
        }
        if (!preg_match("/^[a-z]/", $name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('block_field_validation_name'));
        }

        // reserved field names
        if (in_array($name, ['id', 'block_id', 'resource_id', 'group_id', 'table_id', 'values', 'rank', 'active'])) {
            $this->modx->error->addField('name', $this->modx->lexicon('block_field_err_reserved_names'));
        }

        $this->properties['name'] = $name;

        return parent::beforeSet();
    }

    public function beforeSave()
    {
        $this->object->fromArray(array(
            'rank' => $this->modx->getCount($this->classKey, [
                'block_id' => $this->properties['block_id'],
                'table_id' => $this->properties['table_id'],
                'group_id' => $this->properties['group_id'],
            ]),
        ));

        return parent::beforeSave();
    }

}

return 'blockFieldCreateProcessor';