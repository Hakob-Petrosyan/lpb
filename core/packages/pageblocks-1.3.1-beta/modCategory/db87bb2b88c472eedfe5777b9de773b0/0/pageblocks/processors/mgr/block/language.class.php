<?php

class pageBlockLanguageProcessor extends modProcessor
{
    public $classKey = 'pageBlock';

    /** @var PageBlocks $pb */
    public $pb;


    public function process()
    {
        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        $language_old = trim($this->properties['language_old']);
        $language_new = trim($this->properties['language_new']);
        if ($language_old == $language_new) {
            return $this->failure($this->modx->lexicon('pb_identical_languages'));
        }

        $q = $this->modx->newQuery($this->classKey);
        $q->where([
            'resource_id' => $this->prperties['resource_id'],
            'collection_id' => $this->properties['collection_id'] ?: 0,
            'cultureKey' => $language_old,
        ]);
        $q->sortby('rank', 'asc');
        $blocks = $this->modx->getCollection($this->classKey, $q);
        foreach ($blocks as $block) {
            $this->pb->runProcessor('mgr/block/copy', [
                'id' => $block->id,
                'resource_id' => $block->resource_id,
                'context_key' => $block->context_key,
                'cultureKey' => $language_new,
                'collection_id' => $this->properties['collection_id'] ?: 0,
            ]);
        }

        return $this->success('', ['cultureKey' => $language_new]);
    }

}

return 'pageBlockLanguageProcessor';