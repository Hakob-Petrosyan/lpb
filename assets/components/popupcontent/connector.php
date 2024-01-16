<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var popupcontent $popupcontent */
$popupcontent = $modx->getService('popupcontent', 'popupcontent', MODX_CORE_PATH . 'components/popupcontent/model/');
$modx->lexicon->load('popupcontent:default');

// handle request
$corePath = $modx->getOption('popupcontent_core_path', null, $modx->getOption('core_path') . 'components/popupcontent/');
$path = $modx->getOption('processorsPath', $popupcontent->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest([
    'processors_path' => $path,
    'location' => '',
]);