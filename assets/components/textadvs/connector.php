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
/** @var textAdvs $textAdvs */
$textAdvs = $modx->getService('textadvs', 'textAdvs', $modx->getOption('textadvs_core_path', null, $modx->getOption('core_path') .
                                                                                                   'components/textadvs/') .
                                                      'model/textadvs/');
$modx->lexicon->load('textadvs:default');

// handle request
$corePath = $modx->getOption('textadvs_core_path', null, $modx->getOption('core_path') . 'components/textadvs/');
$path = $modx->getOption('processorsPath', $textAdvs->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));