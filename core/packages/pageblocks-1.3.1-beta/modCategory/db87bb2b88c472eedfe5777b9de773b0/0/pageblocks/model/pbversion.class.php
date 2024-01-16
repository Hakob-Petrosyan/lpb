<?php

class PageBlockVersion
{
    /** @var modX $modx */
    public $modx;
    /** @var PageBlocks $pp */
    public $pb;

    public $classKey = 'pbVersion';

    /**
     * PageBlockFiles constructor.
     * @param modX $modx
     * @param $pageblocks
     */
    public function __construct(modX $modx, $pageblocks)
    {
        $this->modx = $modx;
        $this->pb = $pageblocks;
    }

    /**
     * @param pageBlock $block
     * @param string $mode
     * @return bool
     */
    public function create(pageBlock $block, $mode = 'new')
    {
        $version = $this->modx->newObject('pbVersion');
        $version->fromArray(array_merge($block->toArray(),[
            'block_id' => $block->id,
            'user' => $this->modx->user->id,
            'mode' => $mode,
        ]), '', false, true);

        if (!$version->save()) return false;

        // Images
        $files = $block->getMany('Files');
        foreach ($files as $file) {
            $f = $this->modx->newObject('pbVersionFile');
            $f->fromArray($file->toArray(), '', false, true);
            $f->set('version_id', $version->id);
            $f->save();
        }

        // Videos
        $videos = $block->getMany('Videos');
        foreach ($videos as $video) {
            $v = $this->modx->newObject('pbVersionVideo');
            $v->fromArray($video->toArray(), '', false, true);
            $v->set('version_id', $version->id);
            $v->save();
        }

        // Tables
        $tables = $block->getMany('Tables');
        foreach ($tables as $table) {
            $t = $this->modx->newObject('pbVersionTableValue');
            $t->fromArray($table->toArray(), '', false, true);
            $t->set('version_id', $version->id);
            $t->set('version_table_id', $table->id);
            $t->save();
        }

        return true;
    }


    /**
     * @param pageBlock $block
     */
    public function update(pageBlock $block)
    {
        $this->create($block, 'upd');
    }


    /**
     * @param pageBlock $block
     */
    public function remove(pageBlock $block)
    {
        $this->create($block, 'remove');
    }


    /**
     * @param int $id
     * @return bool
     */
    public function restore(int $id)
    {
        if (!$version = $this->modx->getObject($this->classKey, (int) $id)) {
            return false;
        }

        if (!$block = $this->modx->getObject('pageBlock', (int) $version->block_id)) {
            $block = $this->modx->newObject('pageBlock');
        }

        $block->fromArray($version->toArray(), '', false, true);
        if (!$block->save()) {
            return false;
        }

        // Images
        $this->modx->removeCollection('blockFile', ['block_id' => $version->block_id]);
        $files = $version->getMany('Files');
        foreach ($files as $file) {
            $f = $this->modx->newObject('blockFile');
            $f->fromArray($file->toArray(), '', true);
            $f->save();
        }

        // Videos
        $this->modx->removeCollection('blockVideo', ['block_id' => $version->block_id]);
        $videos = $version->getMany('Videos');
        foreach ($videos as $video) {
            $v = $this->modx->newObject('blockVideo');
            $v->fromArray($video->toArray(), '', true);
            $v->save();
        }

        // Tables
        $this->modx->removeCollection('blockTableValue', ['block_id' => $version->block_id]);
        $tables = $version->getMany('Tables');
        foreach ($tables as $table) {
            $t = $this->modx->newObject('blockTableValue');
            $t->fromArray($table->toArray(), '', true);
            $t->set('id', $table->version_table_id);
            $t->save();
        }

        return true;
    }

}