<?php

class popupcontentItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'popupcontentItem';
    public $classKey = 'popupcontentItem';
    public $languageTopics = ['popupcontent'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('popupcontent_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            $this->modx->error->addField('name', $this->modx->lexicon('popupcontent_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'popupcontentItemCreateProcessor';