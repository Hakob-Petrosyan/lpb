<?php

class blockVideoUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'pb_video';
    public $classKey = 'blockVideo';
    public $languageTopics = array('default');

    /** @var PageBlocks $pb */
    public $pb;


    /**
     * @return bool|null|string
     */
    public function initialize()
    {
        if (!$this->modx->hasPermission($this->permission)) {
            return $this->modx->lexicon('access_denied');
        }
        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        return parent::initialize();
    }

    /**
     * @return array|bool|string
     */
    public function beforeSet()
    {
        if(!$this->properties['id']) {
            return $this->modx->lexicon('pb_video_err_ns');
        }

        if (!empty($this->properties['thumbnail'])) {
            $this->properties['thumbnail'] = trim($this->properties['thumbnail'], '/');
        }

        return parent::beforeSet();
    }

}

return 'blockVideoUpdateProcessor';