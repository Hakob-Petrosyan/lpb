<?php

class popupcontentItemRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'popupcontentItem';
    public $classKey = 'popupcontentItem';
    public $languageTopics = ['popupcontent'];
    //public $permission = 'remove';


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
            return $this->failure($this->modx->lexicon('popupcontent_item_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var popupcontentItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('popupcontent_item_err_nf'));
            }

            $object->remove();
        }

        return $this->success();
    }

}

return 'popupcontentItemRemoveProcessor';