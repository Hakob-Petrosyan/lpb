<?php

class txaObjectRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'txaObject';
    public $classKey = 'txaObject';
    public $languageTopics = array('textadvs:default');
    public $permission = 'remove';

    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('txa_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var txaObject $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('txa_err_nf'));
            }
            $object->remove();
        }

        return $this->success();
    }
}

return 'txaObjectRemoveProcessor';