<?php return array (
  '76d4b975f76a1dac750e8ccaba5868e2' => 
  array (
    'criteria' => 
    array (
      'name' => 'clientconfig',
    ),
    'object' => 
    array (
      'name' => 'clientconfig',
      'path' => '{core_path}components/clientconfig/',
      'assets_path' => '{assets_path}components/clientconfig/',
    ),
  ),
  '0da2f65ab9579157233835f27463a25b' => 
  array (
    'criteria' => 
    array (
      'key' => 'clientconfig.admin_groups',
    ),
    'object' => 
    array (
      'key' => 'clientconfig.admin_groups',
      'value' => 'Administrator',
      'xtype' => 'textfield',
      'namespace' => 'clientconfig',
      'area' => 'Default',
      'editedon' => NULL,
    ),
  ),
  '012e5b54134679b947e009cf24b8758b' => 
  array (
    'criteria' => 
    array (
      'key' => 'clientconfig.clear_cache',
    ),
    'object' => 
    array (
      'key' => 'clientconfig.clear_cache',
      'value' => '1',
      'xtype' => 'combo-boolean',
      'namespace' => 'clientconfig',
      'area' => 'Default',
      'editedon' => NULL,
    ),
  ),
  'b6b4d80e1b3f47aa2c550daca0cf1d9c' => 
  array (
    'criteria' => 
    array (
      'key' => 'clientconfig.vertical_tabs',
    ),
    'object' => 
    array (
      'key' => 'clientconfig.vertical_tabs',
      'value' => '',
      'xtype' => 'combo-boolean',
      'namespace' => 'clientconfig',
      'area' => 'Default',
      'editedon' => NULL,
    ),
  ),
  'd9bff22d7578812fdecc1abfdcec671e' => 
  array (
    'criteria' => 
    array (
      'key' => 'clientconfig.context_aware',
    ),
    'object' => 
    array (
      'key' => 'clientconfig.context_aware',
      'value' => '1',
      'xtype' => 'combo-boolean',
      'namespace' => 'clientconfig',
      'area' => 'Default',
      'editedon' => '2021-05-06 10:43:49',
    ),
  ),
  '7fdbe7487efd259dea90b433dbc44e8d' => 
  array (
    'criteria' => 
    array (
      'key' => 'clientconfig.google_fonts_api_key',
    ),
    'object' => 
    array (
      'key' => 'clientconfig.google_fonts_api_key',
      'value' => '',
      'xtype' => 'textfield',
      'namespace' => 'clientconfig',
      'area' => 'Default',
      'editedon' => NULL,
    ),
  ),
  'e617e7f7ebe9186c6919496fc7c46935' => 
  array (
    'criteria' => 
    array (
      'name' => 'ClientConfig_ConfigChange',
    ),
    'object' => 
    array (
      'name' => 'ClientConfig_ConfigChange',
      'service' => 6,
      'groupname' => 'clientconfig',
    ),
  ),
  'c933869631d4ec0d3d85af17f005a1ea' => 
  array (
    'criteria' => 
    array (
      'name' => 'ClientConfig',
    ),
    'object' => 
    array (
      'id' => 17,
      'source' => 0,
      'property_preprocess' => 0,
      'name' => 'ClientConfig',
      'description' => 'Sets system settings from the Client Config CMP.',
      'editor_type' => 0,
      'category' => 0,
      'cache_type' => 0,
      'plugincode' => '/**
 * ClientConfig
 *
 * Copyright 2011-2014 by Mark Hamstra <hello@markhamstra.com>
 *
 * ClientConfig is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * ClientConfig is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ClientConfig; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package clientconfig
 *
 * @var modX $modx
 * @var int $id
 * @var string $mode
 * @var modResource $resource
 * @var modTemplate $template
 * @var modTemplateVar $tv
 * @var modChunk $chunk
 * @var modSnippet $snippet
 * @var modPlugin $plugin
*/

$eventName = $modx->event->name;

switch($eventName) {
    case \'OnMODXInit\':
    case \'OnHandleRequest\':
    case \'pdoToolsOnFenomInit\':
        /* Grab the class */
        $path = $modx->getOption(\'clientconfig.core_path\', null, $modx->getOption(\'core_path\') . \'components/clientconfig/\');
        $path .= \'model/clientconfig/\';
        $clientConfig = $modx->getService(\'clientconfig\',\'ClientConfig\', $path);

        /* If we got the class (gotta be careful of failed migrations), grab settings and go! */
        if ($clientConfig instanceof ClientConfig) {
            $contextKey = $modx->context instanceof modContext ? $modx->context->get(\'key\') : \'web\';
            $settings = $clientConfig->getSettings($contextKey);

            /* Make settings available as [[++tags]] */
            $modx->setPlaceholders($settings, \'+\');

            /* Make settings available for $modx->getOption() */
            foreach ($settings as $key => $value) {
                $modx->setOption($key, $value);
            }
        }
        break;
}

return;',
      'locked' => 0,
      'properties' => NULL,
      'disabled' => 0,
      'moduleguid' => '',
      'static' => 0,
      'static_file' => '',
      'content' => '/**
 * ClientConfig
 *
 * Copyright 2011-2014 by Mark Hamstra <hello@markhamstra.com>
 *
 * ClientConfig is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * ClientConfig is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ClientConfig; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package clientconfig
 *
 * @var modX $modx
 * @var int $id
 * @var string $mode
 * @var modResource $resource
 * @var modTemplate $template
 * @var modTemplateVar $tv
 * @var modChunk $chunk
 * @var modSnippet $snippet
 * @var modPlugin $plugin
*/

$eventName = $modx->event->name;

switch($eventName) {
    case \'OnMODXInit\':
    case \'OnHandleRequest\':
    case \'pdoToolsOnFenomInit\':
        /* Grab the class */
        $path = $modx->getOption(\'clientconfig.core_path\', null, $modx->getOption(\'core_path\') . \'components/clientconfig/\');
        $path .= \'model/clientconfig/\';
        $clientConfig = $modx->getService(\'clientconfig\',\'ClientConfig\', $path);

        /* If we got the class (gotta be careful of failed migrations), grab settings and go! */
        if ($clientConfig instanceof ClientConfig) {
            $contextKey = $modx->context instanceof modContext ? $modx->context->get(\'key\') : \'web\';
            $settings = $clientConfig->getSettings($contextKey);

            /* Make settings available as [[++tags]] */
            $modx->setPlaceholders($settings, \'+\');

            /* Make settings available for $modx->getOption() */
            foreach ($settings as $key => $value) {
                $modx->setOption($key, $value);
            }
        }
        break;
}

return;',
    ),
  ),
  '1de084892c88b37688e4a57fcabfd616' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 17,
      'event' => 'OnMODXInit',
    ),
    'object' => 
    array (
      'pluginid' => 17,
      'event' => 'OnMODXInit',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '2f3033a7aad8b2cb45220a5daaae4ae5' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 17,
      'event' => 'OnHandleRequest',
    ),
    'object' => 
    array (
      'pluginid' => 17,
      'event' => 'OnHandleRequest',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '7303bd25a258838a68f760fef1f0d8a2' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 17,
      'event' => 'pdoToolsOnFenomInit',
    ),
    'object' => 
    array (
      'pluginid' => 17,
      'event' => 'pdoToolsOnFenomInit',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '7863cbc266a1bc209e18ce92295eec9f' => 
  array (
    'criteria' => 
    array (
      'text' => 'clientconfig',
    ),
    'object' => 
    array (
      'text' => 'clientconfig',
      'parent' => 'components',
      'action' => 'home',
      'description' => 'clientconfig.desc',
      'icon' => '<i class="icon icon-wrench"></i>',
      'menuindex' => 0,
      'params' => '',
      'handler' => '',
      'permissions' => '',
      'namespace' => 'clientconfig',
    ),
  ),
  'd9b66058fab5170a7b1e9df8fc2883db' => 
  array (
    'criteria' => 
    array (
      'category' => 'ClientConfig',
    ),
    'object' => 
    array (
      'id' => 19,
      'parent' => 0,
      'category' => 'ClientConfig',
      'rank' => 0,
    ),
  ),
);