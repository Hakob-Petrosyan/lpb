<?php

class blockFieldUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockField';
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
        $block_id = (int) $this->properties['block_id'];
        $table_id = (int) $this->properties['table_id'];
        $group_id = (int) $this->properties['group_id'];
        $id = (int) $this->properties['id'];
        $name = trim($this->properties['name']);
        if (empty($id)) {
            return $this->modx->lexicon('block_group_err_ns');
        }

        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('block_field_err_name'));
        } elseif ($this->modx->getCount($this->classKey, [
            'name' => $name,
            'id:!=' => $id,
            'group_id' => $group_id,
            'block_id' => $block_id,
            'table_id' => $table_id,
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
}

return 'blockFieldUpdateProcessor';