<?php

class textAdvs
{
    public $config = array();
    public $initialized = array();
    /** @var modX $modx */
    public $modx;
    /** @var txaTools $tools */
    public $tools;
    /** @var pdoTools $pdoTools */
    public $pdoTools;
    /** @var pdoFetch $pdoFetch */
    public $pdoFetch;

    /**
     * @param modX  $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx = &$modx;

        $corePath = $this->modx->getOption('txa_core_path', $config, MODX_CORE_PATH . 'components/textadvs/');
        $assetsUrl = $this->modx->getOption('txa_assets_url', $config, MODX_ASSETS_URL . 'components/textadvs/');
        $assetsPath = $this->modx->getOption('txa_assets_path', $config, MODX_ASSETS_PATH . 'components/textadvs/');

        $this->config = array_merge(array(
            'assetsUrl' => $assetsUrl,
            'assetsPath' => $assetsPath,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
            'connectorUrl' => $assetsUrl . 'connector.php',

            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'pluginsPath' => $corePath . 'plugins/',
            'handlersPath' => $corePath . 'handlers/',
            'templatesPath' => $corePath . 'elements/templates/',
            'processorsPath' => $corePath . 'processors/',

            'prepareResponse' => false,
            'jsonResponse' => false,
        ), $config);

        $this->modx->addPackage('textadvs', $this->config['modelPath']);
        $this->modx->lexicon->load('textadvs:default');
    }

    /**
     * @param string $ctx
     * @param array  $sp
     *
     * @return boolean
     */
    public function initialize($ctx = 'web', $sp = array())
    {
        $this->config = array_merge($this->config, $sp, array('ctx' => $ctx));

        $this->getTools();
        if ($pdoTools = $this->getPdoTools()) {
            $pdoTools->setConfig($this->config);
        }
        if ($pdoFetch = $this->getPdoFetch()) {
            $pdoFetch->setConfig($this->config);
        }

        if (empty($this->initialized[$ctx])) {
            switch ($ctx) {
                case 'mgr':
                    break;
                default:
                    if (!defined('MODX_API_MODE') || !MODX_API_MODE) {
                        // $this->loadFrontendScripts();
                    }
                    break;
            }
        }

        return ($this->initialized[$ctx] = true);
    }

    /**
     * @return txaTools
     */
    public function getTools()
    {
        if (!is_object($this->tools)) {
            if ($class = $this->modx->loadClass('tools.txaTools', $this->config['handlersPath'], true, true)) {
                $this->tools = new $class($this->modx, $this->config);
            }
        }

        return $this->tools;
    }

    /**
     * @return pdoTools
     */
    public function getPdoTools()
    {
        if (class_exists('pdoTools') && !is_object($this->pdoTools)) {
            $this->pdoTools = $this->modx->getService('pdoTools');
        }

        return $this->pdoTools;
    }

    /**
     * @return pdoFetch
     */
    public function getPdoFetch()
    {
        if (class_exists('pdoFetch') && !is_object($this->pdoFetch)) {
            $this->pdoFetch = $this->modx->getService('pdoFetch');
        }

        return $this->pdoFetch;
    }

    /**
     * @param txaObject|null $object
     * @param string|null    $tag
     *
     * @return bool|float
     */
    public function getTagClass($object = null, $tag = null)
    {
        if (empty($tag) && is_object($object)) {
            $tag = $object->get('tag');
        }
        $class = null;
        $className = 'txaTag' . ucfirst($tag);
        $path = $this->config['handlersPath'] . 'tags/';
        $this->modx->loadClass('txaTagBase', $path, true, true);
        $this->modx->loadClass($className, $path, true, true);
        if (class_exists($className)) {
            $class = new $className($this, $object);
        }

        return $class;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        $tags = [];
        $files = scandir($this->config['handlersPath'] . 'tags/');

        foreach ($files as $v) {
            if (preg_match('/^txatag([a-z0-9]+)\.class\.php$/i', $v, $match)) {
                $match = $match[1];
                if ($match == 'base') {
                    continue;
                }

                /** @var txaTagBase $cls */
                if ($cls = $this->getTagClass(null, $match)) {
                    if (($key = $cls->getKey()) && ($name = $cls->getName())) {
                        $tags[] = [
                            'key' => $key,
                            'name' => $name,
                        ];
                    }
                }
                unset($cls);
            }
        }

        return $tags;
    }
}