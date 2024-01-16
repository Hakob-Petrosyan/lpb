<?php

class pbVersionGetProcessor extends modObjectGetProcessor
{
    public $objectType = 'pb';
    public $classKey = 'pbVersion';
    public $languageTopics = ['pageblocks:default'];
    //public $permission = 'view';

    /** @var PageBlocks $pb */
    public $pb;

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
        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        return parent::process();
    }


    public function cleanup()
    {
        $array = $this->object->toArray();

        $array['groups'] = [];
        if ($constructor = $this->object->getOne('Constructor')) {
            $array['block_name'] = $constructor->name;

            // Получаем поля без групп
            $fields = $this->pb->getMany($constructor,'Fields', ['active' => 1, 'group_id' => 0]);
            $values = array_map(function ($field) {
                return $this->pb->getFieldValue($field);
            }, $fields);
            if (count($values)) {
                $array['groups'][] = [
                    'name' => '',
                    'fields' => array_values($values),
                ];
            }

            $groups = $this->pb->getMany($constructor, 'Groups');
            foreach ($groups as $group) {
                $array['groups'][] = [
                    'name' => $group->name,
                    'fields' => array_values($this->pb->getGroupValues($group)),
                ];
            }
        }

        if ($array['object_id'] && $resource = $this->pb->resource->getResource($array['object_id'])) {
            $res_arr = $resource->toArray();
            $values = json_decode($array['values'],1);
            $fields = $this->object->getOne('Constructor')->getMany('Fields', ['active' => 1]);
            foreach ($fields as $field) {
                if (isset($res_arr[$field->name])) {
                    $values[$field->name] = $res_arr[$field->name];
                }
            }
            $array['values'] = json_encode($values);
            // Нового поля нет в параметре values, поэтому оно и не подгружается
            // $array['values'] = json_encode(array_intersect_key($resource->toArray(), $values));
        }

        return $this->success('',$array);
    }

}

return 'pbVersionGetProcessor';