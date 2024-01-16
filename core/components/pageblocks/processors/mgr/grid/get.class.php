<?php

class blockTableValueGetProcessor extends modObjectGetProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockTableValue';
    public $languageTopics = ['pageblocks:default'];
    //public $permission = 'view';

    /** @var PageBlocks $pb */
    public $pb;


    /**
     * {@inheritDoc}
     * @return boolean
     */
    public function initialize()
    {

        $primaryKey = $this->getProperty($this->primaryKeyField,false);
        if (empty($primaryKey)) return $this->modx->lexicon($this->objectType.'_err_ns');

        if ($this->properties['version_id']) {
            $this->classKey = 'pbVersionTableValue';
            $primaryKey = [
                'version_table_id' => $primaryKey,
                'version_id' => $this->properties['version_id']
            ];
        }

        $this->object = $this->modx->getObject($this->classKey,$primaryKey);
        if (empty($this->object)) return $this->modx->lexicon($this->objectType.'_err_nfs',array($this->primaryKeyField => $primaryKey));

        if ($this->checkViewPermission && $this->object instanceof modAccessibleObject && !$this->object->checkPolicy('view')) {
            return $this->modx->lexicon('access_denied');
        }

        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        return true;
    }


    public function cleanup()
    {
        $array = $this->object->toArray();
        $array['groups'] = [];

        // Получаем поля без групп
        $fields = $this->pb->getMany($this->object,'Fields', ['active' => 1, 'group_id' => 0]);
        $values = array_map(function ($field) {
            return $this->pb->getFieldValue($field);
        }, $fields);
        if (count($values)) {
            $array['groups'][] = [
                'name' => '',
                'fields' => array_values($values),
            ];
        }

        $groups = $this->pb->getMany($this->object, 'Groups');
        foreach ($groups as $group) {
            $array['groups'][] = [
                'name' => $group->name,
                'fields' => array_values($this->pb->getGroupValues($group)),
            ];
        }

        return $this->success('',$array);
    }

}

return 'blockTableValueGetProcessor';