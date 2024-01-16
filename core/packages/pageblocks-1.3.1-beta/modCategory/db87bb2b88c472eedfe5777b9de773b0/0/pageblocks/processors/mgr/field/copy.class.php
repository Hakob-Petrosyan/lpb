<?php

class blockFieldCopyProcessor extends modObjectGetProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockField';
    public $languageTopics = ['pageblocks:default'];
    //public $permission = 'view';


    /**
     * @return mixed
     */
    public function initialize()
    {
        $name = trim($this->properties['name']);
        if (empty($name)) {
            return $this->modx->lexicon('block_field_err_name');
        } elseif ($this->modx->getCount($this->classKey, [
            'name' => $name,
            'block_id' => $this->properties['block_id'],
            'table_id' => $this->properties['table_id'],
        ])) {
            return $this->modx->lexicon('block_field_err_ae');
        }
        if(!preg_match("/^[a-z]/", $name)) {
            return $this->modx->lexicon('block_field_validation_name');
        }

        // reserved names
        if(in_array($name, ['id', 'block_id', 'resource_id', 'group_id', 'table_id', 'values', 'rank', 'active'])) {
            return $this->modx->lexicon('block_field_err_reserved_names');
        }

        $this->properties['name'] = $name;

        return parent::initialize();
    }

    public function cleanup()
    {
        $array = $this->object->toArray();
        $array['name'] = trim($this->properties['name']);
        $array['rank'] = $this->modx->getCount($this->classKey, [
            'block_id' => $this->properties['block_id'],
            'table_id' => $this->properties['table_id'],
        ]);

        $field = $this->modx->newObject($this->classKey);
        $field->fromArray($array, '', false, true);
        if(!$field->save()) return $this->failure();

        return $this->success('',$array);
    }

}

return 'blockFieldCopyProcessor';