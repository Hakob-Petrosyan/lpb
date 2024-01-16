<?php

class blockVideoGetUrlProcessor extends modProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockVideo';
    public $languageTopics = ['pageblocks:default'];

    public function process()
    {
        if ($video = $this->modx->getObject($this->classKey, [
            'block_id' => $this->properties['block_id'],
            'field_id' => $this->properties['field_id'],
            'grid_id' => $this->properties['grid_id'],
            'resource_id' => $this->properties['resource_id'],
            'context_key' => $this->properties['context_key'],
            'cultureKey' => $this->properties['cultureKey'],
        ])) {
            return '{"success":true, "url":"'.$video->video.'", "id":"'.$video->id.'"}';
        }

        return '{"success":false}';
    }

}

return 'blockVideoGetUrlProcessor';