<?php

/**
 *
 */
class txaOnLoadWebDocument extends txaPlugin
{
    public function run()
    {
        $modx = &$this->modx;
        if (empty($modx->resourceGenerated)) {
            return;
        }

        // Выборка
        $q = $modx->newQuery('txaObject', array('active' => true));
        $q->where(array(
            'template IS NULL',
            'OR:template:=' => $modx->resource->get('template') ?: 0,
        ));
        if (!$objects = $modx->getCollection('txaObject', $q)) {
            return;
        }

        // Преобразование
        foreach ($objects as $object) {
            /** @var txaTagBase $cls */
            if (!$cls = $this->txa->getTagClass($object)) {
                continue;
            }

            $content = $modx->resource->get('content');
            $modx->resource->set('content', $cls->prepare($content));
        }
    }
}