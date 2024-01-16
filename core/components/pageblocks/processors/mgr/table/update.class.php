<?php

class blockTableUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockTable';
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
        $name = trim($this->properties['name']);
        if (empty($id)) {
            return $this->modx->lexicon('block_table_err_ns');
        }

        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('block_table_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name, 'id:!=' => $id])) {
            $this->modx->error->addField('name', $this->modx->lexicon('block_table_err_ae'));
        }

        return parent::beforeSet();
    }

    /**
     * Обновляем источник файлов для полей таблицы
     * @return bool
     */
    public function afterSave()
    {
        $field = $this->object->getOne('Field');
        if(!$field) return false;
        $constructor = $field->getOne('Constructor');
        if(!$constructor) return false;

        $source = $constructor->source;
        $source_path = $constructor->source_path;

        $fields =  $this->object->getMany('Fields');
        foreach ($fields as $field) {
            $field->set('source', $source);
            $field->set('source_path', $source_path);
            $field->save();
        }

        return parent::afterSave();
    }
}

return 'blockTableUpdateProcessor';
