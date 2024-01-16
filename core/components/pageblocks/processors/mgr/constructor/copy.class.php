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
        $array['name'] = trim($this->properties['name']);
        $array['chunk'] = '';
        $block->fromArray($array, '', false, true);
        if($block->save()) {

            // Копируем поля блока
            $fields = $this->object->getMany('Fields', ['group_id' => 0]);
            foreach ($fields as $field) {
                $newField = $this->modx->newObject('blockField');
                $newField->fromArray($field->toArray(), '', false, true);
                $newField->set('block_id', $block->id);
                $newField->save();
            }

            // Копируем все группы блока
            $groups = $this->object->getMany('Groups');
            foreach ($groups as $group) {
                $newGroup = $this->modx->newObject('blockFieldGroup');
                $newGroup->fromArray($group->toArray(), '', false, true);
                $newGroup->set('block_id', $block->id);
                if($newGroup->save()) {

                    // Копируем поля группы
                    $fields = $group->getMany('Fields');
                    foreach ($fields as $field) {
                        $newField = $this->modx->newObject('blockField');
                        $newField->fromArray($field->toArray(), '', false, true);
                        $newField->set('block_id', $block->id);
                        $newField->set('group_id', $newGroup->id);
                        $newField->save();
                    }
                }
            }
        }

        return $this->success('',$array);
    }

}

return 'blockConstructorGetProcessor';