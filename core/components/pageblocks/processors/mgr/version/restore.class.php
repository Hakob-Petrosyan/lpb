<?php

class pbVersionRestoreProcessor extends modProcessor
{
    public $classKey = 'pbVersion';
    public $languageTopics = ['pageblocks:version'];

    /** @var PageBlocks $pb */
    public $pb;

    public function process()
    {
        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        foreach ($this->languageTopics as $topic) {
            $this->modx->lexicon->load($topic);
        }

        $result = $this->pb->version->restore($this->properties['id']);
        if (!$result) $this->failure($this->modx->lexicon('pb_version_restore_err'));

        return $this->success($this->modx->lexicon('pb_version_restore_success'));
    }

}

return 'pbVersionRestoreProcessor';