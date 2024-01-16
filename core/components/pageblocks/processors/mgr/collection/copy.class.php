<?php

class blockConstructorGetProcessor extends modObjectGetProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockConstructor';
    public $languageTopics = ['pageblocks:default'];
    //public $permission = 'view';

    public function initialize() {

        $name = trim($this->properties['name']);
        if (empty($name)) {
            return $this->modx->lexicon('pb_err_name');
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            return $this->modx->lexicon('pb_err_ae');
        }

        return parent::initialize();
    }


    public function cleanup() {

        $array = $this->object->toArray();
        $array['rank'] = $this->modx->getCount($this->classKey);

        // Копируем блок
        $block = $this->modx->newObject($this->classKey);
        $block->fromArray($array, '', false, true);
        $block->set('name', trim($this->properties['name']));
        $block->save();

        return $this->success('',$array);
    }

}

return 'blockConstructorGetProcessor';