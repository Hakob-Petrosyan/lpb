<?php

class blockFieldGroupUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockFieldGroup';
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
        
        $this->modx->log(1, print_r($this->properties,1));

        return parent::initialize();
    }


    /**
     * @return bool
     */
    public function beforeSet()
    {
        
        $this->modx->log(1, print_r($this->properties,1));
        
        
        $id = (int) $this->properties['id'];
        $name = trim($this->properties['name']);
        if (empty($id)) {
            return $this->modx->lexicon('block_group_err_ns');
        }

        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('pb_err_name'));
        } elseif ($this->modx->getCount($this->classKey, [
            'block_id' => $this->properties['block_id'],
            'table_id' => $this->properties['table_id'],
            'name' => $name,
            'id:!=' => $id
        ])) {
            $this->modx->error->addField('name', $this->modx->lexicon('pb_err_ae'));
        }

        return parent::beforeSet();
    }
}

return 'blockFieldGroupUpdateProcessor';
