<?php

class pageBlockUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'pageBlock';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'save';

    /** @var PageBlocks $pb */
    public $pb;
    /** @var PageBlocks $baseblock */
    public $baseblock;

    public $unique = 0;

    public $beforeSaveEvent = 'pbBeforeSaveBlock';
    public $afterSaveEvent = 'pbAfterSaveBlock';


    public function initialize()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }
        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        return parent::initialize();
    }


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $id = (int)$this->properties['id'];
        if (empty($id)) {
            return $this->modx->lexicon('pb_block_err_ns');
        }

        $values = $this->pb->block->filterValues($this->properties);
        $this->properties['values'] = json_encode($values, JSON_UNESCAPED_UNICODE);

        return parent::beforeSet();
    }

    public function beforeSave()
    {
        // Обновляем ресурс
        $this->pb->resource->update($this->object);

        return parent::beforeSave();
    }

    public function afterSave()
    {
        // Обновляем значения
        if ($this->object->baseblock) {

            if ($this->object->unique) {
                $this->pb->block->updateValues($this->object);
            } else {
                $this->pb->block->updateBaseBlock($this->object, $this->object->baseblock);
            }

        } else {
            $this->pb->block->updateValues($this->object);
            // Если мы обновили базовый блок, то и все его копии нужно тоже обновить.
            if (!$this->object->resource_id) {
                $this->pb->block->updateBaseBlocks($this->object);
            }
        }

        // Сохраняем текущую версию блока
        $this->pb->version->update($this->object);

        return parent::afterSave();
    }

}

return 'pageBlockUpdateProcessor';
