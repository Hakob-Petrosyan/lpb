<?php  return '/** @var modX $modx */
/** @var array $scriptProperties */
/** @var PageBlocks $PageBlocks */
switch ($modx->event->name) {
    case \'OnMODXInit\':
        if ($PageBlocks = $modx->getService(\'pageblocks\', \'PageBlocks\', MODX_CORE_PATH . \'components/pageblocks/model/\')) {
            $PageBlocks->initialize($contextKey);
        }
        break;
    default:
        if ($PageBlocks = $modx->getService(\'PageBlocks\')) {
            $PageBlocks->handleEvent($modx->event, $scriptProperties);
        }
}
return;
';