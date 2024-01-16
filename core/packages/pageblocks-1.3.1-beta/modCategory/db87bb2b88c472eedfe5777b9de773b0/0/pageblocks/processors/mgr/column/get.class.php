<?php

class pbTableColumnGetProcessor extends modObjectGetProcessor
{
    public $objectType = 'pb';
    public $classKey = 'pbTableColumn';
    public $languageTopics = ['pageblocks:default'];
    //public $permission = 'view';


    /**
     * We doing special check of permission
     * because of our objects is not an instances of modAccessibleObject
     *
     * @return mixed
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        return parent::process();
    }

    /**
     * Return the response
     * @return array
     */
    public function cleanup()
    {

        $array = $this->object->toArray();
        $array['caption'] = $this->object->getOne('Field')->caption;

        return $this->success('',$array);
    }

}

return 'pbTableColumnGetProcessor';