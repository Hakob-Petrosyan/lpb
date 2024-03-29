<?php
/** @var modX $modx */
/** @var textAdvs $txa */
$txa = $modx->getService('textadvs', 'textAdvs',
    $modx->getOption('txa_core_path', null, MODX_CORE_PATH . 'components/textadvs/') . 'model/textadvs/');
$className = 'txa' . $modx->event->name;
$modx->loadClass('txaPlugin', $txa->config['pluginsPath'], true, true);
$modx->loadClass($className, $txa->config['pluginsPath'], true, true);
if (class_exists($className)) {
    $handler = new $className($modx, $scriptProperties);
    $handler->run();
} else {
    // Удаляем событие у плагина, если такого класса не существует
    $event = $modx->getObject('modPluginEvent', array(
        'pluginid' => $modx->event->plugin->get('id'),
        'event' => $modx->event->name,
    ));
    if ($event instanceof modPluginEvent) {
        $event->remove();
    }
}
return;