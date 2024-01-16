<?php return array (
  '5bbd84fdcad158220a31d3f10b62433b' => 
  array (
    'criteria' => 
    array (
      'name' => 'ckeditor',
    ),
    'object' => 
    array (
      'name' => 'ckeditor',
      'path' => '{core_path}components/ckeditor/',
      'assets_path' => '',
    ),
  ),
  '92f54bc8ccf032bbac22f85fe3fb16e7' => 
  array (
    'criteria' => 
    array (
      'name' => 'CKEditor',
    ),
    'object' => 
    array (
      'id' => 45,
      'source' => 0,
      'property_preprocess' => 0,
      'name' => 'CKEditor',
      'description' => 'CKEditor WYSIWYG editor plugin for MODx Revolution',
      'editor_type' => 0,
      'category' => 29,
      'cache_type' => 0,
      'plugincode' => '/**
 * CKEditor WYSIWYG Editor Plugin
 *
 * Events: OnManagerPageBeforeRender, OnRichTextEditorRegister, OnRichTextEditorInit, OnRichTextBrowserInit
 *
 * @var modX $modx
 * @author Danil Kostin <danya.postfactum(at)gmail.com>
 *
 * @package ckeditor
 */
$enabled = $modx->getOption(\'which_editor\', null, \'CKEditor\') == \'CKEditor\' && $modx->getOption(\'use_editor\', null, true);

switch ($modx->event->name) {
    case \'OnRichTextEditorRegister\':
        $modx->event->output(\'CKEditor\');
        break;
    case \'OnManagerPageBeforeRender\':
        if ($enabled) {
            /** @var CKEditor $ckeditor */
            $ckeditor = $modx->getService(\'ckeditor\', \'CKEditor\', $modx->getOption(\'ckeditor.core_path\', null, $modx->getOption(\'core_path\').\'components/ckeditor/\') . \'model/ckeditor/\');
            $ckeditor->initialize();
        }
        break;
    case \'OnRichTextEditorInit\':
        break;
    case \'OnRichTextBrowserInit\':
        if ($enabled) {
            $funcNum = $_REQUEST[\'CKEditorFuncNum\'];
            $modx->event->output("function(data){
                window.parent.opener.CKEDITOR.tools.callFunction({$funcNum}, data.fullRelativeUrl);
            }");
        }
        break;
}

return;',
      'locked' => 0,
      'properties' => NULL,
      'disabled' => 0,
      'moduleguid' => '',
      'static' => 1,
      'static_file' => 'ckeditor/elements/plugins/ckeditor.plugin.php',
      'content' => '/**
 * CKEditor WYSIWYG Editor Plugin
 *
 * Events: OnManagerPageBeforeRender, OnRichTextEditorRegister, OnRichTextEditorInit, OnRichTextBrowserInit
 *
 * @var modX $modx
 * @author Danil Kostin <danya.postfactum(at)gmail.com>
 *
 * @package ckeditor
 */
$enabled = $modx->getOption(\'which_editor\', null, \'CKEditor\') == \'CKEditor\' && $modx->getOption(\'use_editor\', null, true);

switch ($modx->event->name) {
    case \'OnRichTextEditorRegister\':
        $modx->event->output(\'CKEditor\');
        break;
    case \'OnManagerPageBeforeRender\':
        if ($enabled) {
            /** @var CKEditor $ckeditor */
            $ckeditor = $modx->getService(\'ckeditor\', \'CKEditor\', $modx->getOption(\'ckeditor.core_path\', null, $modx->getOption(\'core_path\').\'components/ckeditor/\') . \'model/ckeditor/\');
            $ckeditor->initialize();
        }
        break;
    case \'OnRichTextEditorInit\':
        break;
    case \'OnRichTextBrowserInit\':
        if ($enabled) {
            $funcNum = $_REQUEST[\'CKEditorFuncNum\'];
            $modx->event->output("function(data){
                window.parent.opener.CKEDITOR.tools.callFunction({$funcNum}, data.fullRelativeUrl);
            }");
        }
        break;
}

return;',
    ),
  ),
  'a650b9eab06854577b9edc2c71aa3f75' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 45,
      'event' => 'OnManagerPageBeforeRender',
    ),
    'object' => 
    array (
      'pluginid' => 45,
      'event' => 'OnManagerPageBeforeRender',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '5c900798936e16f857f153603e361d0a' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 45,
      'event' => 'OnRichTextEditorRegister',
    ),
    'object' => 
    array (
      'pluginid' => 45,
      'event' => 'OnRichTextEditorRegister',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  'b51d656cd26f497f1bed94d8c8decc14' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 45,
      'event' => 'OnRichTextBrowserInit',
    ),
    'object' => 
    array (
      'pluginid' => 45,
      'event' => 'OnRichTextBrowserInit',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '21d2a25a7806299bd3a131c523df7010' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 45,
      'event' => 'OnRichTextEditorInit',
    ),
    'object' => 
    array (
      'pluginid' => 45,
      'event' => 'OnRichTextEditorInit',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '5d0c5a7c8cd4dd28bf2db415139fd13c' => 
  array (
    'criteria' => 
    array (
      'key' => 'ckeditor.ui_color',
    ),
    'object' => 
    array (
      'key' => 'ckeditor.ui_color',
      'value' => '#DDDDDD',
      'xtype' => 'textfield',
      'namespace' => 'ckeditor',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
  '80e9fae6dcea2c10909a5146b4349e51' => 
  array (
    'criteria' => 
    array (
      'key' => 'ckeditor.toolbar',
    ),
    'object' => 
    array (
      'key' => 'ckeditor.toolbar',
      'value' => '',
      'xtype' => 'textarea',
      'namespace' => 'ckeditor',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
  'f3cb8cf0bec1ed0d79fbbb3737be6ff3' => 
  array (
    'criteria' => 
    array (
      'key' => 'ckeditor.toolbar_groups',
    ),
    'object' => 
    array (
      'key' => 'ckeditor.toolbar_groups',
      'value' => '[{"name":"document","groups":["mode","document","doctools"]},{"name":"clipboard","groups":["clipboard","undo"]},{"name":"editing","groups":["find","selection","spellchecker"]},{"name":"links"},{"name":"insert"},{"name":"forms"},"/",{"name":"basicstyles","groups":["basicstyles","cleanup"]},{"name":"paragraph","groups":["list","indent","blocks","align","bidi"]},{"name":"styles"},{"name":"colors"},{"name":"tools"},{"name":"others"},{"name":"about"}]',
      'xtype' => 'textarea',
      'namespace' => 'ckeditor',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
  '902fb14c59424f45c8a6382aa1f1e82f' => 
  array (
    'criteria' => 
    array (
      'key' => 'ckeditor.format_tags',
    ),
    'object' => 
    array (
      'key' => 'ckeditor.format_tags',
      'value' => 'p;h1;h2;h3;h4;h5;h6;pre;address;div',
      'xtype' => 'textfield',
      'namespace' => 'ckeditor',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
  '3823ffd09b5ea1ef4a567bdc995fa767' => 
  array (
    'criteria' => 
    array (
      'key' => 'ckeditor.skin',
    ),
    'object' => 
    array (
      'key' => 'ckeditor.skin',
      'value' => 'moono-lisa',
      'xtype' => 'textfield',
      'namespace' => 'ckeditor',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
  '11d83eb3e8da27094312857411d8b316' => 
  array (
    'criteria' => 
    array (
      'key' => 'ckeditor.extra_plugins',
    ),
    'object' => 
    array (
      'key' => 'ckeditor.extra_plugins',
      'value' => 'button,btgrid,contextmenu,menu,floatpanel,panel,dialog,dialogui',
      'xtype' => 'textfield',
      'namespace' => 'ckeditor',
      'area' => 'general',
      'editedon' => '2021-06-08 09:03:01',
    ),
  ),
  '3dd00a679ed0f20e839995d7d6d207da' => 
  array (
    'criteria' => 
    array (
      'key' => 'ckeditor.object_resizing',
    ),
    'object' => 
    array (
      'key' => 'ckeditor.object_resizing',
      'value' => '0',
      'xtype' => 'combo-boolean',
      'namespace' => 'ckeditor',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
  '9dbaecc9aa2319eeadcf785f7e1e1a9a' => 
  array (
    'criteria' => 
    array (
      'key' => 'ckeditor.autocorrect_dash',
    ),
    'object' => 
    array (
      'key' => 'ckeditor.autocorrect_dash',
      'value' => '—',
      'xtype' => 'textfield',
      'namespace' => 'ckeditor',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
  '870781843fcdcc3ed5bdb4692c1a05eb' => 
  array (
    'criteria' => 
    array (
      'key' => 'ckeditor.autocorrect_double_quotes',
    ),
    'object' => 
    array (
      'key' => 'ckeditor.autocorrect_double_quotes',
      'value' => '«»',
      'xtype' => 'textfield',
      'namespace' => 'ckeditor',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
  'e99a6f50a64371b9c188ea8e6a4be3eb' => 
  array (
    'criteria' => 
    array (
      'key' => 'ckeditor.autocorrect_single_quotes',
    ),
    'object' => 
    array (
      'key' => 'ckeditor.autocorrect_single_quotes',
      'value' => '„“',
      'xtype' => 'textfield',
      'namespace' => 'ckeditor',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
  '569966c89d0459b623d3211901b56228' => 
  array (
    'criteria' => 
    array (
      'key' => 'ckeditor.styles_set',
    ),
    'object' => 
    array (
      'key' => 'ckeditor.styles_set',
      'value' => 'default',
      'xtype' => 'textarea',
      'namespace' => 'ckeditor',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
  'd25054337727d72b48e71670f9ab376b' => 
  array (
    'criteria' => 
    array (
      'key' => 'ckeditor.remove_plugins',
    ),
    'object' => 
    array (
      'key' => 'ckeditor.remove_plugins',
      'value' => 'forms,smiley,autogrow,pagebreak,indentblock,font,newpage,print,save,language,bidi,selectall,preview,image2,about',
      'xtype' => 'textfield',
      'namespace' => 'ckeditor',
      'area' => 'general',
      'editedon' => '2021-06-08 09:03:12',
    ),
  ),
  '2a631bfe37c4b64947e9e34a1e76c55f' => 
  array (
    'criteria' => 
    array (
      'key' => 'ckeditor.native_spellchecker',
    ),
    'object' => 
    array (
      'key' => 'ckeditor.native_spellchecker',
      'value' => '1',
      'xtype' => 'combo-boolean',
      'namespace' => 'ckeditor',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
  '90887235d375fb9aec852e22924a1595' => 
  array (
    'criteria' => 
    array (
      'key' => 'ckeditor.resource_editor_height',
    ),
    'object' => 
    array (
      'key' => 'ckeditor.resource_editor_height',
      'value' => '600',
      'xtype' => 'textfield',
      'namespace' => 'ckeditor',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
);