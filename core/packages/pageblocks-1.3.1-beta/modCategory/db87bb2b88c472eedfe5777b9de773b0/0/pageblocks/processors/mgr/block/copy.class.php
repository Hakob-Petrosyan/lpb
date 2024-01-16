<?php

class pageBlockCopyProcessor extends modObjectGetProcessor
{
    public $objectType = 'pb';
    public $classKey = 'pageBlock';
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

        // Копируем ресурс
        if ($array['object_id']) {
            if (!$resource = $this->pb->resource->copy($array['object_id'], $this->properties['resource_id'])) {
                return $this->failure($this->modx->lexicon('pb_resource_err_copy'), $array);
            }
            // Привязываем новый ресурс к блоку
            $this->properties['object_id'] = $resource['id'];

            // Обновляем поля для блока
            $fields = $this->object->getOne('Constructor')->getMany('Fields', ['active' => 1]);
            $values = json_decode($array['values'],1);
            foreach ($fields as $field) {
                if (isset($resource[$field->name])) {
                    $values[$field->name] = $resource[$field->name];
                }
            }
            $this->properties['values'] = json_encode($values);
        }

        if (!$this->pb->block->copy($this->object, $this->properties)) {
            return $this->failure($this->modx->lexicon('pb_block_err_copy'), $array);
        }

        return $this->success('',$array);
    }

}

return 'pageBlockCopyProcessor';