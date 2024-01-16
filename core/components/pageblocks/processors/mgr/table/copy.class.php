<?php

class blockTableCopyProcessor extends modObjectGetProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockTable';
    public $languageTopics = ['pageblocks:default'];
    //public $permission = 'view';


    /**
     * We doing special check of permission
     * because of our objects is not an instances of modAccessibleObject
     *
     * @return mixed
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        return parent::process();
    }


    public function cleanup() {

        $array = $this->object->toArray();
        $array['rank'] = $this->modx->getCount($this->classKey);

        $grid = $this->modx->newObject($this->classKey);
        $grid->fromArray($array, '', false, true);
        $grid->save();

        // Копируем поля таблицы
        $fields = $this->object->getMany('Fields');
        foreach ($fields as $field) {
            $newField = $this->modx->newObject('blockField');
            $newField->fromArray($field->toArray(), '', false, true);
            $newField->set('table_id', $grid->id);
            $newField->save();
        };

        // Копируем колонки таблицы
        $columns = $this->object->getMany('Columns');
        foreach ($columns as $column) {
            $newColumn = $this->modx->newObject('pbTableColumn');
            $newColumn->fromArray($column->toArray(), '', false, true);
            $newColumn->set('table_id', $grid->id);
            $newColumn->save();
        };

        return $this->success('',$array);
    }

}

return 'blockTableCopyProcessor';