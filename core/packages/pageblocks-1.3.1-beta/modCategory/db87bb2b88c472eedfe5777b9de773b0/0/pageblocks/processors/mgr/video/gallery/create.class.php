<?php

class PageBlocksVideoCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockVideo';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'create';

    /** @var PageBlocks $pb */
    public $pb;

    public function initialize()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }
        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        return parent::initialize();
    }

    public function beforeSet()
    {
        if (!empty($this->properties['thumbnail'])) {
            $this->properties['thumbnail'] = trim($this->properties['thumbnail'], '/');
        }

        if ($this->modx->getCount($this->classKey, [
            'resource_id' => $this->properties['resource_id'],
            'context_key' => $this->properties['context_key'],
            'cultureKey' => $this->properties['cultureKey'],
            'block_id' => $this->properties['block_id'],
            'field_id' => $this->properties['field_id'],
            'grid_id' => $this->properties['grid_id'],
            'provider' => $this->properties['provider'],
            'video_id' => $this->properties['video_id'],
        ])) {
            $this->modx->error->addField('video', $this->modx->lexicon('pb_video_url_arr_ae'));
        }
        return parent::beforeSet();
    }


    public function beforeSave()
    {
        $this->object->set('rank', $this->pb->video->getRank([
            'block_id' => $this->properties['block_id'],
            'field_id' => $this->properties['field_id'],
            'resource_id' => $this->properties['resource_id'],
            'context_key' => $this->properties['context_key'],
            'cultureKey' => $this->properties['cultureKey'],
            'grid_id' => $this->properties['grid_id'],
        ]));

        return parent::beforeSave();
    }

}

return 'PageBlocksVideoCreateProcessor';