<?php

class blockConstructorRemoveProcessor extends modObjectRemoveProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockConstructor';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'remove';


    /**
     * @return array|string
     */
    public function initialize()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        return parent::initialize();
    }

    public function afterRemove()
    {
        // Удаляем чанк
        $remove_chunk = $this->modx->getOption('pageblocks_remove_chunk');
        if($remove_chunk && $chunk = $this->modx->getObject('modChunk', ['name' => $this->object->chunk])) {
            $chunk->remove();
        }

        return true;
    }

}

return 'blockConstructorRemoveProcessor';