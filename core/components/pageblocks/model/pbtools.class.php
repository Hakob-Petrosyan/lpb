<?php

class PageBlockTools
{
    /** @var modX $modx */
    public $modx;
    /** @var PageBlocks $pb */
    public $pb;
    /** @var pdoFetch $pdoTools */
    public $pdoTools;
    /** @var array $config */
    public $config = [];
    /** @var array $default */
    public $default = [
        'class' => 'pageBlock',
        'loadModels' => 'pageBlocks',
        'sortby' => 'rank',
        'sortdir' => 'asc',
        'outputSeparator' => '',
        'fastMode' => 0,
        'limit' => 0,
        'offset' => 0,
        'where' => [
            'active' => 1,
        ]
    ];

    /**
     * @param modX $modx
     */

    function __construct(modX $modx, $pageblocks)
    {
        $this->modx = $modx;
        $this->pb = $pageblocks;
        $this->pdoTools = $modx->getService('pdoFetch');
        $this->config = [];
    }

    public function getLog()
    {
        return '<pre>' . print_r($this->pdoTools->getTime(), 1) . '</pre>';
    }

    /**
     * @param array $properties
     * @return string
     */
    public function getOutput(array $properties = [])
    {
        $output = [];
        $this->config = $this->default;
        $this->setConfig($properties);
        $this->pdoTools->setConfig($this->config);
        $rows = $this->pdoTools->run();

        if (!empty($properties['return']) && strtolower($properties['return']) !== 'chunk') {

            $rows = json_decode($rows,1);
            foreach ($rows as $idx => $row) {
                $resource = [];
                foreach($row as $key => $value) {
                    if (strpos($key, 'resource.') === 0) {
                        $resource[str_replace('resource.', '', $key)] = $value;
                        unset($rows[$idx][$key]);
                    }
                }
                $rows[$idx] = array_merge($resource, $row['values']);
                if (!isset($rows[$idx]['id'])) {
                    $rows[$idx]['id'] = $row['id'];
                }
            }

            if (count($rows) == 1) {
                $rows = $rows[0];
            }

            $output = json_encode($rows);
        } else {
            foreach ($rows as $row) {

                $resource = [];
                foreach($row as $key => $value) {
                    if (strpos($key, 'resource.') === 0) {
                        $resource[str_replace('resource.', '', $key)] = $value;
                    }
                }
                $values = array_merge($resource, $row['values']);
                $values['id'] = $row['id'];

                $output[] = $this->pdoTools->getChunk(($properties['tpl'] ?: $row['chunk']), $values, $this->config['fastMode']);
            }
            $output = implode($this->config['outputSeparator'], $output);
        }

        return $output;
    }

    /**
     * @param array $properties
     */
    public function setConfig(array $properties = [])
    {
        if (empty($properties['return']) || strtolower($properties['return']) === 'chunk') {
            $properties['return'] = 'data';
        }

        if (empty($properties['where']) || (isset($properties['where']) && !is_array($properties['where']))) {
            $properties['where'] = [];
        }
        $properties['where'] = array_merge($this->config['where'], $properties['where']);


        if ($properties['where']['collection_id'] || $this->config['collection']) {
            $this->config['leftJoin'] = [
                'modResource' => [
                    'class' => 'modResource',
                    'on' => 'modResource.id = pageBlock.object_id'
                ],
            ];

            $this->config['select'] = [
                'pageBlock' => $this->modx->getSelectColumns('pageBlock', 'pageBlock'),
                'modResource' => $this->modx->getSelectColumns('modResource', 'modResource', 'resource.'),
            ];
        }

        $this->config = array_merge($this->config, $properties);
        $this->addWhere();
    }


    public function addWhere()
    {
        $config = $this->config;

        $where = [];
        foreach($this->config['where'] as $key => $value) {
            $where[preg_replace('/[^_a-z\d]/ui', '', $key)]  = $value;
        }

        // id
        if (!empty($config['id'])) {
            $this->setWhereNumeric('id', $config['id']);
            return true;
        }
        // object_id
        if (empty($config['object_id'])) {
            if (!isset($where['object_id']) && !isset($config['collection'])) {
                $this->config['where']['object_id'] = 0;
            }
        } else {
            $this->setWhereNumeric('object_id', $config['object_id']);
            return true;
        }
        // resource_id
        if (!$config['rid']) {
            if (!isset($where['resource_id'])) {
                $this->config['where']['resource_id'] = $this->modx->resource->id;
            }
        } else {
            $this->setWhereNumeric('resource_id', $config['rid']);
        }
        // constructor_id
        if (!empty($config['cid'])) {
            $this->setWhereNumeric('constructor_id', $config['cid']);
        }
        // collection_id
        if (empty($config['collection'])) {
            if (!isset($where['collection_id'])) {
                $this->config['where']['collection_id'] = 0;
            }
        } else {
            $this->config['where']['collection_id'] = $config['collection'];
        }
        // context_key
        if (empty($config['context'])) {
            $this->config['where']['context_key'] = $this->modx->resource->context_key;
        } else {
            $context = array_map('trim', explode(',', $config['context']));
            if (!empty($context) && is_array($context)) {
                if (count($context) == 1) {
                    $this->config['where']['context_key'] = $context[0];
                } else {
                    $this->config['where']['context_key:IN'] = $context;
                }
            }
        }
        // cultureKey
        if (empty($config['cultureKey'])) {
            if (!isset($where['cultureKey'])) {
                $this->config['where']['cultureKey'] = $this->modx->getOption('cultureKey', '', 'ru');
            }
        } else {
            $this->config['where']['cultureKey'] = $config['cultureKey'];
        }

        // up
        if (isset($config['up']) && $config['up'] == 1) {
            // Получаем все id блоков
            $where = $this->config['where'];
            if($where['resource_id']) {
                unset($where['resource_id']);
                $where['resource_id:>'] = 0;
            }
            $rows = $this->pb->getFetchAll($config['class'], $where);
            $ids = array_map(function($row){
                return $row['resource_id'];
            },$rows);
            // Удаляем дубли
            $ids = array_unique($ids);
            // Получаем родителей
            $rid = $this->modx->resource->id;
            $parentsId = array_reverse($this->modx->getParentIds($rid, 10));
            // Добавляем текущий ресурс
            $parentsId[] = $rid;
            // Определяем в каких ресурсах есть блоки
            $parents = array_intersect($ids, $parentsId);
            $rid = end($parents);
            $this->config['where']['resource_id'] = $rid;
        }

    }

    /**
     * @param $key
     * @param $param
     */
    public function setWhereNumeric($key, $param)
    {
        $params = array_map('trim', explode(',', $param));
        $params_in = $params_out = array();
        foreach ($params as $v) {
            if (!is_numeric($v)) {
                continue;
            }
            if ($v < 0) {
                $params_out[] = abs($v);
            } else {
                $params_in[] = abs($v);
            }
        }
        if (!empty($params_in)) {
            if (count($params_in) == 1) {
                $this->config['where'][$key] = $params_in[0];
            } else {
                $this->config['where'][$key . ':IN'] = $params_in;
            }

        }
        if (!empty($params_out)) {
            if (count($params_out) == 1) {
                $this->config['where'][$key . ':!='] = $params_out[0];
            } else {
                $this->config['where'][$key . ':NOT IN'] = $params_out;
            }
        }
    }

}