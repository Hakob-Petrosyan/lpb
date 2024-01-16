<?php

class blockVideoCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockVideo';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        if (!empty($this->properties['thumbnail'])) {
            $this->properties['thumbnail'] = trim($this->properties['thumbnail'], '/');
        }

        $where = [
            'block_id' => $this->properties['block_id'],
            'field_id' => $this->properties['field_id'],
            'grid_id' => $this->properties['grid_id'],
            'provider' => $this->properties['provider'],
            'resource_id' => $this->properties['resource_id'],
            'context_key' => $this->properties['context_key'],
            'cultureKey' => $this->properties['cultureKey'],
            'video_id' => $this->properties['video_id'],
        ];

        if ($video = $this->modx->getObject($this->classKey, $where)) {
            $this->object = $video;
            $this->properties = [];
        }

        return parent::beforeSet();
    }

}

return 'blockVideoCreateProcessor';