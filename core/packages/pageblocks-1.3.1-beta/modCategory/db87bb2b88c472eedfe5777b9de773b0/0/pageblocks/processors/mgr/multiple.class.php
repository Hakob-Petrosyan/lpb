<?php

class PageBlocksMultipleProcessor extends modProcessor
{

    /**
     * @return array|string
     */
    public function process()
    {
        /** @var PageBlocks $PageBlocks */
        $PageBlocks = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        $ids = $this->properties['ids'];
        if($donor = $this->properties['donor']) {
            $this->properties['method'] = 'block/copy';
            $rows = $PageBlocks->getCollection('pageBlock', [
                'resource_id' => (int) $donor,
                'cultureKey' => $this->properties['language'],
                'collection_id' => $this->properties['collection_id'],
            ]);
            $ids = array_map(function ($row){
                return $row->id;
            }, $rows);
            $ids = json_encode($ids);
        }


        if (empty($ids)) return $this->success();
        if (!is_array($ids)) $ids = json_decode($ids, 1);

        if (!$method = $this->properties['method']) {
            return $this->failure();
        }

        foreach ($ids as $id) {
            /** @var modProcessorResponse $response */

            $response = $PageBlocks->runProcessor('mgr/' . $method, array_merge(['id' => $id], $this->properties));
            if ($response->isError()) {
                return $response->getResponse();
            }
        }

        return $this->success();
    }

}

return 'PageBlocksMultipleProcessor';