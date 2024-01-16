<?php

class pbVersionClearProcessor extends modProcessor
{
    public $versions = ['pbVersion', 'pbVersionTableValue', 'pbVersionFile', 'pbVersionVideo'];
    public $languageTopics = ['pageblocks:version'];

    /**
     * @return array|string
     */
    public function process()
    {
        foreach ($this->languageTopics as $topic) {
            $this->modx->lexicon->load($topic);
        }

        if (!$this->modx->user->isMember('Administrator')) {
            $this->success($this->modx->lexicon('pb_version_clear_access_denied'));
        }

        foreach ($this->versions as $version) {
            $table = $this->modx->getTableName($version);
            $sql =  "TRUNCATE TABLE $table";
            $this->modx->exec($sql);
        }

        return $this->success($this->modx->lexicon('pb_version_clear_success'));
    }

}

return 'pbVersionClearProcessor';