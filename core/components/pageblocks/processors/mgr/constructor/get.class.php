<?php

class blockConstructorGetProcessor extends modObjectGetProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockConstructor';
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

    public function cleanup() {

        $array = $this->object->toArray();
        $array['groups'] = [];

        $baseblock = $this->properties['baseblock'];
        $array['baseblock'] = $baseblock;

        if($baseblock) {
            if($block = $this->modx->getObject('pageBlock', (int) $baseblock)) {
                $array['values'] = $block->values;
            }
        }

        if($this->properties['fields']) {

            // Получаем поля без групп
            $fields = $this->pb->getMany($this->object,'Fields', ['active' => 1, 'group_id' => 0]);
            $values = array_map(function ($field) {
                return $this->pb->getFieldValue($field);
            }, $fields);
            if(count($values)) {
                $array['groups'][] = [
                    'name' => '',
                    'fields' => array_values($values),
                ];
            }

            // Получаем поля c группами
            $groups = $this->pb->getMany($this->object, 'Groups');
            foreach ($groups as $group) {
                $array['groups'][] = [
                    'name' => $group->name,
                    'fields' => array_values($this->pb->getGroupValues($group)),
                ];
            }
        }

        // Получаем чанк
        $array['chunk_code'] = '';
        if($chunk = $this->modx->getObject('modChunk', ['name' => $array['chunk']])) {
            $array['chunk_code'] = $chunk->snippet;
        }

        return $this->success('',$array);
    }

}

return 'blockConstructorGetProcessor';