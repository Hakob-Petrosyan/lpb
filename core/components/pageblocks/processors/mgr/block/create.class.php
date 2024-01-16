<?php

class pageBlockCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'pageBlock';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'create';

    /** @var PageBlocks $pb */
    public $pb;

    public $beforeSaveEvent = 'pbBeforeSaveBlock';
    public $afterSaveEvent = 'pbAfterSaveBlock';

    /**
     * {@inheritDoc}
     * @return boolean
     */
    public function initialize()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }
        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        // Создаем ресурс
        if($res = $this->pb->resource->create($this->properties)) {
            $this->properties['object_id'] = $res['id'];
            $this->properties['alias'] = $res['alias'];
            $this->properties['active'] = $this->modx->getOption('publish_default');
        }

        return parent::initialize();
    }


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $values = $this->pb->block->filterValues($this->properties);
        $this->properties['values'] = json_encode($values, JSON_UNESCAPED_UNICODE);
        $this->properties['rank'] = $this->pb->block->getRank([
            'resource_id' => $this->properties['resource_id'],
            'context_key' => $this->properties['context_key'],
            'cultureKey' => $this->properties['cultureKey'],
        ]);

        return parent::beforeSet();
    }


    public function afterSave()
    {
        // Обновляем значения
        $this->pb->block->createValues($this->object);

        // Сохраняем текущую версию блока
        $this->pb->version->create($this->object);

        return parent::afterSave();

    }


}

return 'pageBlockCreateProcessor';