<?php return array (
  'b34668c9d16f0605dd12d7336a143f3c' => 
  array (
    'criteria' => 
    array (
      'name' => 'sweetalert2',
    ),
    'object' => 
    array (
      'name' => 'sweetalert2',
      'path' => '{core_path}components/sweetalert2/',
      'assets_path' => '',
    ),
  ),
  '0b9b2584dd213d0d288b9d5b04a647f1' => 
  array (
    'criteria' => 
    array (
      'key' => 'swal2_frontend_css',
    ),
    'object' => 
    array (
      'key' => 'swal2_frontend_css',
      'value' => '',
      'xtype' => 'textfield',
      'namespace' => 'sweetalert2',
      'area' => 'swal2_frontend',
      'editedon' => NULL,
    ),
  ),
  'd59d774abed47ebf3ab6fd46ecd8f3f5' => 
  array (
    'criteria' => 
    array (
      'key' => 'swal2_frontend_js',
    ),
    'object' => 
    array (
      'key' => 'swal2_frontend_js',
      'value' => '//cdn.jsdelivr.net/npm/sweetalert2@9,[[+jsUrl]]default.min.js',
      'xtype' => 'textfield',
      'namespace' => 'sweetalert2',
      'area' => 'swal2_frontend',
      'editedon' => NULL,
    ),
  ),
  '7aeb0714a078c838eaf4d87cb1fbf464' => 
  array (
    'criteria' => 
    array (
      'key' => 'swal2_position',
    ),
    'object' => 
    array (
      'key' => 'swal2_position',
      'value' => 'top-end',
      'xtype' => 'textfield',
      'namespace' => 'sweetalert2',
      'area' => 'swal2_main',
      'editedon' => NULL,
    ),
  ),
  '502fb7958c3f7296d7b52f5e5b8496b9' => 
  array (
    'criteria' => 
    array (
      'key' => 'swal2_timer',
    ),
    'object' => 
    array (
      'key' => 'swal2_timer',
      'value' => '3000',
      'xtype' => 'numberfield',
      'namespace' => 'sweetalert2',
      'area' => 'swal2_main',
      'editedon' => NULL,
    ),
  ),
  '6dad880872ec640bde1cf6b0856b7300' => 
  array (
    'criteria' => 
    array (
      'key' => 'swal2_showconfirmbutton',
    ),
    'object' => 
    array (
      'key' => 'swal2_showconfirmbutton',
      'value' => '',
      'xtype' => 'combo-boolean',
      'namespace' => 'sweetalert2',
      'area' => 'swal2_main',
      'editedon' => NULL,
    ),
  ),
  'e2926c91567fc7834497805a346ba018' => 
  array (
    'criteria' => 
    array (
      'key' => 'swal2_toast',
    ),
    'object' => 
    array (
      'key' => 'swal2_toast',
      'value' => '1',
      'xtype' => 'combo-boolean',
      'namespace' => 'sweetalert2',
      'area' => 'swal2_main',
      'editedon' => '2023-01-22 14:17:31',
    ),
  ),
  'df4a2dc1541d66f31c043d4d520a94c1' => 
  array (
    'criteria' => 
    array (
      'category' => 'SweetAlert2',
    ),
    'object' => 
    array (
      'id' => 21,
      'parent' => 0,
      'category' => 'SweetAlert2',
      'rank' => 0,
    ),
  ),
  '12ccec3c0cb3b20d531eff39ce6ec44b' => 
  array (
    'criteria' => 
    array (
      'name' => 'SweetAlert2',
    ),
    'object' => 
    array (
      'id' => 20,
      'source' => 1,
      'property_preprocess' => 0,
      'name' => 'SweetAlert2',
      'description' => '',
      'editor_type' => 0,
      'category' => 21,
      'cache_type' => 0,
      'plugincode' => '/** @var modX $modx */
if ($modx->event->name != \'OnWebPageInit\') return;
if ($SweetAlert2 = $modx->getService(\'SweetAlert2\', \'SweetAlert2\', MODX_CORE_PATH . \'components/sweetalert2/model/\')) {
    $SweetAlert2->initialize();
}',
      'locked' => 0,
      'properties' => NULL,
      'disabled' => 0,
      'moduleguid' => '',
      'static' => 0,
      'static_file' => 'core/components/sweetalert2/elements/plugins/sweetalert2.php',
      'content' => '/** @var modX $modx */
if ($modx->event->name != \'OnWebPageInit\') return;
if ($SweetAlert2 = $modx->getService(\'SweetAlert2\', \'SweetAlert2\', MODX_CORE_PATH . \'components/sweetalert2/model/\')) {
    $SweetAlert2->initialize();
}',
    ),
  ),
  'fafe90753409bfc850bedd4a91ff39bf' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 20,
      'event' => 'OnWebPageInit',
    ),
    'object' => 
    array (
      'pluginid' => 20,
      'event' => 'OnWebPageInit',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
);