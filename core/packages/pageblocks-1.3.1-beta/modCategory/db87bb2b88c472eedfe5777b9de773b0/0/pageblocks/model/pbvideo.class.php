<?php

class PageBlockVideo
{
    /** @var modX $modx */
    public $modx;
    /** @var PageBlocks $pp */
    public $pb;

    public $classKey = 'blockVideo';


    /**
     * PageBlockVideo constructor.
     * @param modX $modx
     * @param $pageblocks
     */
    function __construct(modX $modx, $pageblocks)
    {
        $this->modx = $modx;
        $this->pb = $pageblocks;
    }


    /**
     * @param array $where
     * @return array
     */
    public function getValues(array $where = [])
    {
        $values = [];
        $videos = $this->pb->getFetchAll($this->classKey, $where);
        foreach ($videos as $video) {
            $values[] = [
                'video' => $video['video'],
                'title' => $video['title'],
                'description' => $video['description'],
                'provider' => $video['provider'],
                'thumbnail' => $video['thumbnail'],
                'thumbnail_width' => $video['thumbnail_width'],
                'thumbnail_height' => $video['thumbnail_height'],
                'embed_video' => $video['embed_video'],
                'video_id' => $video['video_id'],
            ];
        }

        return $values;
    }

    /**
     * @param array $where
     * @return array
     */
    public function getRows(array $where = [])
    {
        $rows = $this->pb->getCollection($this->classKey, $where);

        return $rows;
    }

    /**
     * @param array $where
     * @param array $new_data
     */
    public function copy(array $where, array $new_data = [])
    {
        $files = $this->pb->getCollection($this->classKey, $where);
        foreach ($files as $file) {
            $newFile = $this->modx->newObject($this->classKey);
            $newFile->fromArray(array_merge($file->toArray(), $new_data), '', false, true);
            $newFile->save();
        }
    }


    /**
     * @param array $where
     * @return mixed
     */
    public function remove(array $where = [])
    {
        return $this->modx->removeCollection($this->classKey, $where);
    }


    /**
     * @param $where
     * @return int|mixed
     */
    public function getRank($where)
    {
        return $this->pb->getRank($this->classKey, $where);
    }

}