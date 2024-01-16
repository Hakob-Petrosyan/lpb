<?php

class pageBlockEnableProcessor extends modProcessor
{
    public $classKey = 'pageBlock';

    /** @var PageBlocks $pb */
    public $pb;

    public function initialize()
    {
        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');
        return true;
    }


    /**
     * @return array|string
     */
    public function process()
    {
        if($block = $this->modx->getObject($this->classKey, $this->properties['id'])) {
            $block->set('active', 1);
            $block->save();
            if($block->object_id) {
                $this->pb->resource->published($block->object_id, 1);
            }
            return $this->success();
        }

        return $this->failure();
    }

}

return 'pageBlockEnableProcessor';
