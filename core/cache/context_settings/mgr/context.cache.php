<?php  return array (
  'config' => 
  array (
    'allow_tags_in_post' => '1',
    'modRequest.class' => 'modManagerRequest',
  ),
  'aliasMap' => 
  array (
  ),
  'webLinkMap' => 
  array (
  ),
  'eventMap' => 
  array (
    'OnBeforeDocFormSave' => 
    array (
      74 => '74',
      18 => '18',
      46 => '46',
    ),
    'OnBeforeEmptyTrash' => 
    array (
      18 => '18',
      56 => '56',
      74 => '74',
    ),
    'OnChunkFormPrerender' => 
    array (
      59 => '59',
      13 => '13',
      58 => '58',
    ),
    'OnChunkFormSave' => 
    array (
      58 => '58',
    ),
    'OnDocFormPrerender' => 
    array (
      58 => '58',
      56 => '56',
      12 => '12',
      18 => '18',
      59 => '59',
      13 => '13',
    ),
    'OnDocFormRender' => 
    array (
      21 => '21',
      18 => '18',
      74 => '74',
    ),
    'OnDocFormSave' => 
    array (
      12 => '12',
      58 => '58',
      56 => '56',
      47 => '47',
      46 => '46',
    ),
    'OnFileCreateFormPrerender' => 
    array (
      13 => '13',
    ),
    'OnFileEditFormPrerender' => 
    array (
      13 => '13',
      59 => '59',
    ),
    'OnFileManagerUpload' => 
    array (
      60 => '60',
    ),
    'OnHandleRequest' => 
    array (
      17 => '17',
    ),
    'OnLoadWebDocument' => 
    array (
      74 => '74',
      40 => '40',
      12 => '12',
      46 => '46',
    ),
    'OnManagerAuthentication' => 
    array (
      12 => '12',
    ),
    'OnManagerPageAfterRender' => 
    array (
      12 => '12',
    ),
    'OnManagerPageBeforeRender' => 
    array (
      8 => '8',
      65 => '65',
      21 => '21',
      12 => '12',
      13 => '13',
      18 => '18',
    ),
    'OnManagerPageInit' => 
    array (
      12 => '12',
      18 => '18',
    ),
    'OnMODXInit' => 
    array (
      12 => '12',
      4 => '4',
      17 => '17',
      56 => '56',
    ),
    'OnPageNotFound' => 
    array (
      46 => '46',
    ),
    'OnPluginFormPrerender' => 
    array (
      59 => '59',
      58 => '58',
      13 => '13',
    ),
    'OnPluginFormSave' => 
    array (
      58 => '58',
    ),
    'OnResourceBeforeSort' => 
    array (
      18 => '18',
    ),
    'OnResourceDelete' => 
    array (
      47 => '47',
    ),
    'OnResourceDuplicate' => 
    array (
      56 => '56',
      18 => '18',
    ),
    'OnResourceUndelete' => 
    array (
      47 => '47',
    ),
    'OnRichTextBrowserInit' => 
    array (
      65 => '65',
    ),
    'OnRichTextEditorInit' => 
    array (
      65 => '65',
    ),
    'OnRichTextEditorRegister' => 
    array (
      13 => '13',
      65 => '65',
    ),
    'OnSiteRefresh' => 
    array (
      4 => '4',
    ),
    'OnSnipFormPrerender' => 
    array (
      58 => '58',
      13 => '13',
      59 => '59',
    ),
    'OnSnipFormSave' => 
    array (
      58 => '58',
    ),
    'OnTempFormPrerender' => 
    array (
      13 => '13',
      59 => '59',
      12 => '12',
      58 => '58',
    ),
    'OnTempFormRender' => 
    array (
      21 => '21',
    ),
    'OnTempFormSave' => 
    array (
      58 => '58',
    ),
    'OnTVFormPrerender' => 
    array (
      58 => '58',
    ),
    'OnTVFormSave' => 
    array (
      58 => '58',
    ),
    'OnTVInputPropertiesList' => 
    array (
      21 => '21',
    ),
    'OnTVInputRenderList' => 
    array (
      21 => '21',
      13 => '13',
    ),
    'OnTVOutputRenderList' => 
    array (
      21 => '21',
    ),
    'OnTVOutputRenderPropertiesList' => 
    array (
      21 => '21',
    ),
    'OnWebPageInit' => 
    array (
      20 => '20',
    ),
    'OnWebPagePrerender' => 
    array (
      4 => '4',
      53 => '53',
      26 => '26',
    ),
    'pdoToolsOnFenomInit' => 
    array (
      17 => '17',
    ),
  ),
  'pluginCache' => 
  array (
    4 => 
    array (
      'id' => '4',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'pdoTools',
      'description' => '',
      'editor_type' => '0',
      'category' => '4',
      'cache_type' => '0',
      'plugincode' => '/** @var modX $modx */
switch ($modx->event->name) {

    case \'OnMODXInit\':
        $fqn = $modx->getOption(\'pdoTools.class\', null, \'pdotools.pdotools\', true);
        $path = $modx->getOption(\'pdotools_class_path\', null, MODX_CORE_PATH . \'components/pdotools/model/\', true);
        $modx->loadClass($fqn, $path, false, true);

        $fqn = $modx->getOption(\'pdoFetch.class\', null, \'pdotools.pdofetch\', true);
        $path = $modx->getOption(\'pdofetch_class_path\', null, MODX_CORE_PATH . \'components/pdotools/model/\', true);
        $modx->loadClass($fqn, $path, false, true);
        break;

    case \'OnSiteRefresh\':
        /** @var pdoTools $pdoTools */
        if ($pdoTools = $modx->getService(\'pdoTools\')) {
            if ($pdoTools->clearFileCache()) {
                $modx->log(modX::LOG_LEVEL_INFO, $modx->lexicon(\'refresh_default\') . \': pdoTools\');
            }
        }
        break;

    case \'OnWebPagePrerender\':
        $parser = $modx->getParser();
        if ($parser instanceof pdoParser) {
            foreach ($parser->pdoTools->ignores as $key => $val) {
                $modx->resource->_output = str_replace($key, $val, $modx->resource->_output);
            }
        }
        break;
}',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'core/components/pdotools/elements/plugins/plugin.pdotools.php',
    ),
    8 => 
    array (
      'id' => '8',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'FormIt',
      'description' => '',
      'editor_type' => '0',
      'category' => '9',
      'cache_type' => '0',
      'plugincode' => '/**
 * FormIt
 *
 * Copyright 2009-2017 by Sterc <modx@sterc.nl>
 *
 * FormIt is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * FormIt is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * FormIt; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package formit
 */
/**
 * FormIt plugin
 *
 * @package formit
 */

$formit = $modx->getService(
    \'formit\',
    \'FormIt\',
    $modx->getOption(\'formit.core_path\', null, $modx->getOption(\'core_path\').\'components/formit/\') .\'model/formit/\',
    array()
);

if (!($formit instanceof FormIt)) {
    return;
}

switch ($modx->event->name) {
    case \'OnManagerPageBeforeRender\':
        // If migration status is false, show migrate alert message bar in manager
        if (method_exists(\'FormIt\',\'encryptionMigrationStatus\')) {
            if (!$formit->encryptionMigrationStatus()) {
                $modx->lexicon->load(\'formit:mgr\');
                $properties = array(\'message\' => $modx->lexicon(\'formit.migrate_alert\'));
                $chunk = $formit->_getTplChunk(\'migrate/alert\');
                if ($chunk) {
                    $modx->regClientStartupHTMLBlock($chunk->process($properties));
                    $modx->regClientCSS($formit->config[\'cssUrl\'] . \'migrate.css\');
                }
            }
        }
}',
      'locked' => '0',
      'properties' => 'a:0:{}',
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    12 => 
    array (
      'id' => '12',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'AdminTools',
      'description' => '',
      'editor_type' => '0',
      'category' => '14',
      'cache_type' => '0',
      'plugincode' => '/** @var array $scriptProperties */
$path = $modx->getOption(\'admintools_core_path\', null, $modx->getOption(\'core_path\') . \'components/admintools/\') . \'services/\';
/** @var AdminTools $AdminTools */
$AdminTools = $modx->getService(\'admintools\', \'AdminTools\', $path);
$elementType = null;
if ($AdminTools instanceof AdminTools) {
    switch ($modx->event->name) {
        case \'OnManagerPageBeforeRender\':
            if ($modx->user->id) {
                $AdminTools->initialize();
            }
            break;
        case \'OnManagerPageAfterRender\':
            if ($AdminTools->isLocked()) {
                $controller->content = $modx->getChunk(\'tpl.lockScreen\', [
                        \'username\' => $modx->user->username,
                        \'photo\' => $modx->user->getPhoto(),
                        \'title\' => $modx->getOption(\'site_name\'),
                        \'lang\' => $modx->getOption(\'manager_language\'),
                        \'form_action\' => $AdminTools->getOption(\'connectorUrl\'),
                        \'auth\' => $modx->user->getUserToken(\'mgr\'),
                        \'assets_url\' => MODX_ASSETS_URL,
                        \'input_placeholder\' => $AdminTools->getInputPlaceholder(),
                    ]
                );
            }
            break;
        case \'OnDocFormSave\':
            if ($modx->getOption(\'admintools_clear_only_resource_cache\', null, false) && $modx->event->params[\'mode\'] === modSystemEvent::MODE_UPD) {
                if ($resource->get(\'syncsite\')) {
                    $AdminTools->clearResourceCache($resource);
                }
                if (!empty($_POST[\'createCache\'])) {
                    $AdminTools->createResourceCache($resource->uri);
                }
            }
            break;
        case \'OnManagerPageInit\':
            if (!$modx->user->isAuthenticated(\'mgr\') && $modx->getOption(\'admintools_email_authorization\', null, false)) {
                $id = (int) $modx->getOption(\'admintools_loginform_resource\');
                if (!empty($id) && $modx->getCount(\'modResource\', [\'id\' => $id, \'published\' => 1, \'deleted\' => 0])) {
                    $url = $modx->makeUrl($id, \'\', \'\', \'full\');
                    $modx->setOption(\'manager_login_url_alternate\', $url);
                }
            }
            break;
        case \'OnManagerAuthentication\':
            if ($modx->getOption(\'admintools_user_can_login\', null, false)) {
                $modx->setOption(\'admintools_user_can_login\', false);
                $modx->event->output(true);
            }
            break;
        case \'OnLoadWebDocument\':
            if ((!$modx->user->active || $modx->user->Profile->blocked) && $modx->user->isAuthenticated($modx->context->get(\'key\'))) {
                $modx->runProcessor(\'security/logout\');
            }
            if ($modx->getOption(\'admintools_alternative_permissions\', null, false) && !$AdminTools->hasPermissions()){
                $modx->sendUnauthorizedPage();
            }
            break;
        case \'OnTempFormPrerender\':
            if ($modx->getOption(\'admintools_template_resource_relationship\', null, true)) {
                $modx->controller->addLastJavascript($AdminTools->getOption(\'jsUrl\') . \'mgr/templates.js\');
            }
            break;
        case \'OnDocFormPrerender\':
            $_html = [];
            $output = \'\';
            if ($modx->getOption(\'admintools_template_resource_relationship\', null, true)) {
                $_html[\'tpl_res_relationship\'] = \'
            var tmpl = Ext.getCmp("modx-resource-template");
            if (tmpl.getValue()) tmpl.label.update(_("resource_template") + "&nbsp;&nbsp;<a href=\\"?a=element/template/update&id=" + tmpl.getValue() + "\\"><i class=\\"icon icon-external-link\\"></i></a>");\';
            }
            if ($modx->getOption(\'admintools_clear_only_resource_cache\', null, true) && $modx->event->params[\'mode\'] != modSystemEvent::MODE_NEW) {
                $_html[\'create_resource_cache\'] = \'
            var cb = Ext.create({
                xtype: "xcheckbox",
                boxLabel: _("admintools_create_resource_cache"),
                description: _("admintools_create_resource_cache_help"),
                hideLabel: true,
                name: "createCache",
                id: "createCache",
                checked: \'. (int)$modx->getOption(\'admintools_create_resource_cache\', null, false) .\'
            });
            if (Ext.getCmp("modx-page-settings-right-box-right")) {
                Ext.getCmp("modx-page-settings-right-box-right").insert(2,cb);
                Ext.getCmp("modx-page-settings-right-box-left").add(Ext.getCmp("modx-resource-uri-override"));
                Ext.getCmp("modx-panel-resource").on("success", function(o){
                    if (o.result.object.createCache != 0) {
                        cb.setValue(true);
                    }
                });
            }\';
            }
            if (!empty($_html)) {
            $output .= \'
    Ext.onReady(function() {
        setTimeout(function(){\' . implode("\\n", $_html) . \'
        }, 200);
    });\';
            }
            if ($modx->getOption(\'admintools_alternative_permissions\', null, true) && $modx->hasPermission(\'access_permissions\')) {
                $modx->controller->addLastJavascript($AdminTools->getOption(\'jsUrl\') . \'mgr/permissions.js\');
                $output .= \'
    Ext.ComponentMgr.onAvailable("modx-resource-tabs", function() {
		this.on("beforerender", function() {
			this.add({
				title: _("admintools_permissions"),
				border: false,
				items: [{
					layout: "anchor",
					border: false,
					items: [{
						html: _("admintools_permissions_desc"),
						border: false,
						bodyCssClass: "panel-desc"
					}, {
						xtype: "admintools-grid-permissions",
						anchor: "100%",
						cls: "main-wrapper",
						resource: \' . $id . \'
					}]
				}]
			});
		});
	});
\';
            }
            if (!empty($output)) {
                $modx->controller->addHtml(\'<script>\' . $output . \'</script>\');
            }
            break;
        case \'OnMODXInit\':
            if (($modx->context->get(\'key\') !== \'mgr\')
                && $modx->getOption(\'admintools_only_current_context_user\', null, false)
                && $modx->user->isAuthenticated(\'mgr\')
                && !$modx->user->isAuthenticated($modx->context->get(\'key\')))
            {
               $modx->user = $modx->newObject(\'modUser\');
                $modx->user->fromArray([\'id\' => 0, \'username\' => $modx->getOption(\'default_username\', \'\', \'(anonymous)\', true)], \'\', true);
            }
            break;
    }
}',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'core/components/admintools/elements/plugins/plugin.admintools.php',
    ),
    13 => 
    array (
      'id' => '13',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'Ace',
      'description' => 'Ace code editor plugin for MODx Revolution',
      'editor_type' => '0',
      'category' => '29',
      'cache_type' => '0',
      'plugincode' => '/**
 * Ace Source Editor Plugin
 *
 * Events: OnManagerPageBeforeRender, OnRichTextEditorRegister, OnSnipFormPrerender,
 * OnTempFormPrerender, OnChunkFormPrerender, OnPluginFormPrerender,
 * OnFileCreateFormPrerender, OnFileEditFormPrerender, OnDocFormPrerender
 *
 * @author Danil Kostin <danya.postfactum(at)gmail.com>
 *
 * @package ace
 *
 * @var array $scriptProperties
 * @var Ace $ace
 */
if ($modx->event->name == \'OnRichTextEditorRegister\') {
    $modx->event->output(\'Ace\');
    return;
}

if ($modx->getOption(\'which_element_editor\', null, \'Ace\') !== \'Ace\') {
    return;
}

$corePath = $modx->getOption(\'ace.core_path\', null, $modx->getOption(\'core_path\').\'components/ace/\');
$ace = $modx->getService(\'ace\', \'Ace\', $corePath.\'model/ace/\');
$ace->initialize();

$extensionMap = array(
    \'tpl\'   => \'text/x-smarty\',
    \'htm\'   => \'text/html\',
    \'html\'  => \'text/html\',
    \'css\'   => \'text/css\',
    \'scss\'  => \'text/x-scss\',
    \'less\'  => \'text/x-less\',
    \'svg\'   => \'image/svg+xml\',
    \'xml\'   => \'application/xml\',
    \'xsl\'   => \'application/xml\',
    \'js\'    => \'application/javascript\',
    \'json\'  => \'application/json\',
    \'php\'   => \'application/x-php\',
    \'sql\'   => \'text/x-sql\',
    \'md\'    => \'text/x-markdown\',
    \'txt\'   => \'text/plain\',
    \'twig\'  => \'text/x-twig\'
);

// Define default mime for html elements(templates, chunks and html resources)
$html_elements_mime=$modx->getOption(\'ace.html_elements_mime\',null,false);
if(!$html_elements_mime){
    // this may deprecated in future because components may set ace.html_elements_mime option now
    switch (true) {
        case $modx->getOption(\'twiggy_class\'):
            $html_elements_mime = \'text/x-twig\';
            break;
        case $modx->getOption(\'pdotools_fenom_parser\'):
            $html_elements_mime = \'text/x-smarty\';
            break;
        default:
            $html_elements_mime = \'text/html\';
    }
}

// Defines wether we should highlight modx tags
$modxTags = false;
switch ($modx->event->name) {
    case \'OnSnipFormPrerender\':
        $field = \'modx-snippet-snippet\';
        $mimeType = \'application/x-php\';
        break;
    case \'OnTempFormPrerender\':
        $field = \'modx-template-content\';
        $modxTags = true;
        $mimeType = $html_elements_mime;
        break;
    case \'OnChunkFormPrerender\':
        $field = \'modx-chunk-snippet\';
        if ($modx->controller->chunk && $modx->controller->chunk->isStatic()) {
            $extension = pathinfo($modx->controller->chunk->name, PATHINFO_EXTENSION);
            if(!$extension||!isset($extensionMap[$extension])){
                $extension = pathinfo($modx->controller->chunk->getSourceFile(), PATHINFO_EXTENSION);
            }
            $mimeType = isset($extensionMap[$extension]) ? $extensionMap[$extension] : \'text/plain\';
        } else {
            $mimeType = $html_elements_mime;
        }
        $modxTags = true;
        break;
    case \'OnPluginFormPrerender\':
        $field = \'modx-plugin-plugincode\';
        $mimeType = \'application/x-php\';
        break;
    case \'OnFileCreateFormPrerender\':
        $field = \'modx-file-content\';
        $mimeType = \'text/plain\';
        break;
    case \'OnFileEditFormPrerender\':
        $field = \'modx-file-content\';
        $extension = pathinfo($scriptProperties[\'file\'], PATHINFO_EXTENSION);
        $mimeType = isset($extensionMap[$extension])
            ? $extensionMap[$extension]
            : (\'@FILE:\'.pathinfo($scriptProperties[\'file\'], PATHINFO_BASENAME));
        $modxTags = $extension == \'tpl\';
        break;
    case \'OnDocFormPrerender\':
        if (!$modx->controller->resourceArray) {
            return;
        }
        $field = \'ta\';
        $mimeType = $modx->getObject(\'modContentType\', $modx->controller->resourceArray[\'content_type\'])->get(\'mime_type\');

        if($mimeType == \'text/html\')$mimeType = $html_elements_mime;

        if ($modx->getOption(\'use_editor\')){
            $richText = $modx->controller->resourceArray[\'richtext\'];
            $classKey = $modx->controller->resourceArray[\'class_key\'];
            if ($richText || in_array($classKey, array(\'modStaticResource\',\'modSymLink\',\'modWebLink\',\'modXMLRPCResource\'))) {
                $field = false;
            }
        }
        $modxTags = true;
        break;
    case \'OnTVInputRenderList\':
        $modx->event->output($corePath . \'elements/tv/input/\');
        break;
    default:
        return;
}

$modxTags = (int) $modxTags;
$script = \'\';
if (!empty($field)) {
    $script .= "MODx.ux.Ace.replaceComponent(\'$field\', \'$mimeType\', $modxTags);";
}

if ($modx->event->name == \'OnDocFormPrerender\' && !$modx->getOption(\'use_editor\')) {
    $script .= "MODx.ux.Ace.replaceTextAreas(Ext.query(\'.modx-richtext\'));";
}

if ($script) {
    $modx->controller->addHtml(\'<script>Ext.onReady(function() {\' . $script . \'});</script>\');
}',
      'locked' => '0',
      'properties' => 'a:0:{}',
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'ace/elements/plugins/ace.plugin.php',
    ),
    17 => 
    array (
      'id' => '17',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'ClientConfig',
      'description' => 'Sets system settings from the Client Config CMP.',
      'editor_type' => '0',
      'category' => '0',
      'cache_type' => '0',
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
        // Measure to guard against pdoTools fenom parser loop bug: https://github.com/modmore/ClientConfig/issues/192
        // Here we only allow the pdoToolsOnFenomInit event to trigger the first time.
        if ($eventName === \'pdoToolsOnFenomInit\') {
            if ($modx->getOption(\'clientconfig.fenom_initialized\')) {
                return;
            }
            $modx->setOption(\'clientconfig.fenom_initialized\', true);
        }

        /* Grab the class */
        $path = $modx->getOption(\'clientconfig.core_path\', null, $modx->getOption(\'core_path\') . \'components/clientconfig/\');
        $path .= \'model/clientconfig/\';
        $clientConfig = $modx->getService(\'clientconfig\',\'ClientConfig\', $path);

        /* If we got the class (gotta be careful of failed migrations), grab settings and go! */
        if ($clientConfig instanceof ClientConfig) {
            $contextKey = $modx->context instanceof modContext || $modx->context instanceof \\MODX\\Revolution\\modContext
                ? $modx->context->get(\'key\') : \'web\';
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
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    18 => 
    array (
      'id' => '18',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'Collections',
      'description' => '',
      'editor_type' => '0',
      'category' => '20',
      'cache_type' => '0',
      'plugincode' => '/**
 * Collections
 *
 * DESCRIPTION
 *
 * This plugin inject JS to handle proper working of close buttons in Resource\'s panel (OnDocFormPrerender)
 * This plugin handles setting proper show_in_tree parameter (OnBeforeDocFormSave, OnResourceSort)
 *
 * @var modX $modx
 * @var array $scriptProperties
 */
$corePath = $modx->getOption(\'collections.core_path\', null, $modx->getOption(\'core_path\', null, MODX_CORE_PATH) . \'components/collections/\');
/** @var Collections $collections */
$collections = $modx->getService(
    \'collections\',
    \'Collections\',
    $corePath . \'model/collections/\',
    array(
        \'core_path\' => $corePath
    )
);

if (!($collections instanceof Collections)) return \'\';

$className = "\\\\Collections\\\\Events\\\\{$modx->event->name}";
if (class_exists($className)) {
    /** @var \\Collections\\Events\\Event $handler */
    $handler = new $className($modx, $scriptProperties);
    $handler->run();
}

return;',
      'locked' => '0',
      'properties' => 'a:0:{}',
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    20 => 
    array (
      'id' => '20',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'SweetAlert2',
      'description' => '',
      'editor_type' => '0',
      'category' => '21',
      'cache_type' => '0',
      'plugincode' => '/** @var modX $modx */
if ($modx->event->name != \'OnWebPageInit\') return;
if ($SweetAlert2 = $modx->getService(\'SweetAlert2\', \'SweetAlert2\', MODX_CORE_PATH . \'components/sweetalert2/model/\')) {
    $SweetAlert2->initialize();
}',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'core/components/sweetalert2/elements/plugins/sweetalert2.php',
    ),
    21 => 
    array (
      'id' => '21',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'icontv',
      'description' => '',
      'editor_type' => '0',
      'category' => '22',
      'cache_type' => '0',
      'plugincode' => '/**
 * IconTv Runtime Hooks
 *
 * Registers custom TV input & output types and includes javascripts on document
 * edit pages so that the TV can be used from within other extras (i.e. MIGX,
 * Collections)
 *
 * @package icontv
 * @subpackage plugin
 *
 *
 * @event OnManagerPageBeforeRender
 * @event OnTVInputRenderList
 * @event OnTVOutputRenderList
 * @event OnTVInputPropertiesList
 * @event OnTVOutputRenderPropertiesList
 * @event OnDocFormRender
 *
 * @var modX $modx
 */
$corePath = $modx->getOption(\'core_path\', null, MODX_CORE_PATH) . \'components/icontv/\';
/** @var IconTv $icontv */
$icontv = $modx->getService(
    \'icontv\',
    \'IconTv\',
    $corePath . \'model/icontv/\',
    array(
        \'core_path\' => $corePath
    )
);

switch ($modx->event->name) {
    case \'OnManagerPageBeforeRender\':
        $modx->controller->addLexiconTopic(\'icontv:default\');
        //$icontv->includeScriptAssets();
        break;
    case \'OnTVInputRenderList\':
        $modx->event->output($corePath . \'elements/tv/input/\');
        break;
    case \'OnTVOutputRenderList\':
        $modx->event->output($corePath . \'elements/tv/output/\');
        break;
    case \'OnTVInputPropertiesList\':
        $modx->event->output($corePath . \'elements/tv/inputoptions/\');
        break;
    case \'OnTVOutputRenderPropertiesList\':
        $modx->event->output($corePath . \'elements/tv/output/options/\');
        break;
    case \'OnDocFormRender\':
        $icontv->includeScriptAssets();
        break;
    case \'OnTempFormRender\':
        $icontv->includeScriptAssets();
        $icontv->includeInTemplate();
        break;
}',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'core/components/icontv/elements/plugins/icontv.plugin.php',
    ),
    26 => 
    array (
      'id' => '26',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'wrapYoutube',
      'description' => '',
      'editor_type' => '0',
      'category' => '27',
      'cache_type' => '0',
      'plugincode' => '/** @var modX $modx */
switch ($modx->event->name) {
    case \'OnWebPagePrerender\':
        $excluded = $modx->getOption(\'wrapyoutube_excluded_templates\', null, \'\');
        if ($excluded !== \'\') {
            $template = $modx->resource->template;
            $tmpl_arr = explode(\',\', $excluded);
            if (in_array($template, $tmpl_arr)) {
                return;
            }
        }
        $tpl = $modx->getOption(\'wrapyoutube_tpl\', null, \'tpl.wrapYoutube\');
        if (!$modx->getObject(\'modChunk\', array(\'name\' => $tpl))) {
            return;
        }
        require_once $modx->getOption(\'core_path\') . \'components/wrapyoutube/lib/simple_html_dom.php\';
        $html= new simple_html_dom();
        $html->load($modx->resource->_output, false, false, DEFAULT_BR_TEXT);
        
        $iframes = $html->find(\'iframe\');
        if (!$iframes) {
            return;
        }
        foreach($iframes as $iframe) {
            if (strpos($iframe->src, \'youtube.com\') !== false) {
                $placeholders = array(
                    \'id\' => \'\',
                    \'img\' => \'\',
                    \'link\' => $iframe->src,
                    \'embed\' => $iframe->src,
                    \'width\' => $iframe->width,
                    \'height\' => $iframe->height
                );
                $matches = array();
                preg_match(\'#(\\.be/|/embed/|/v/|/watch\\?v=)([A-Za-z0-9_-]{5,11})#\', $iframe->src, $matches);
                if(isset($matches[2]) && $matches[2] != \'\'){
                    $placeholders[\'id\'] = $matches[2];
                    $placeholders[\'img\'] = "//img.youtube.com/vi/{$placeholders[\'id\']}/hqdefault.jpg";
                    $placeholders[\'embed\'] = "//www.youtube.com/embed/{$placeholders[\'id\']}?autoplay=1";
                }
                $iframe->outertext = $modx->getChunk($tpl, $placeholders);
            }
        }
        $css = $modx->getOption(\'wrapyoutube_front_css\', null, \'[[++assets_url]]components/wrapyoutube/css/web/default.css\', true);
        $js  = $modx->getOption(\'wrapyoutube_front_js\',  null, \'[[++assets_url]]components/wrapyoutube/js/web/default.js\',   true);
        if ($css) {
            $css = str_replace(\'[[++assets_url]]\', $modx->getOption(\'assets_url\'), $css);
            $html->find(\'head\', 0)->innertext .= \'<link rel="stylesheet" href="\'.$css.\'" type="text/css" />\' . PHP_EOL;
        }
        if ($js) {
            $js = str_replace(\'[[++assets_url]]\', $modx->getOption(\'assets_url\'), $js);
            $html->find(\'body\', 0)->innertext .= \'<script type="text/javascript" src="\'.$js.\'"></script>\' . PHP_EOL;
        }
        $modx->resource->_output = $html;
        break;
    default:
        break;
}
return;',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'core/components/wrapyoutube/elements/plugins/plugin.wrapyoutube.php',
    ),
    40 => 
    array (
      'id' => '40',
      'source' => '2',
      'property_preprocess' => '0',
      'name' => 'txaSystem',
      'description' => '',
      'editor_type' => '0',
      'category' => '41',
      'cache_type' => '0',
      'plugincode' => '/** @var modX $modx */
/** @var textAdvs $txa */
$txa = $modx->getService(\'textadvs\', \'textAdvs\',
    $modx->getOption(\'txa_core_path\', null, MODX_CORE_PATH . \'components/textadvs/\') . \'model/textadvs/\');
$className = \'txa\' . $modx->event->name;
$modx->loadClass(\'txaPlugin\', $txa->config[\'pluginsPath\'], true, true);
$modx->loadClass($className, $txa->config[\'pluginsPath\'], true, true);
if (class_exists($className)) {
    $handler = new $className($modx, $scriptProperties);
    $handler->run();
} else {
    // Удаляем событие у плагина, если такого класса не существует
    $event = $modx->getObject(\'modPluginEvent\', array(
        \'pluginid\' => $modx->event->plugin->get(\'id\'),
        \'event\' => $modx->event->name,
    ));
    if ($event instanceof modPluginEvent) {
        $event->remove();
    }
}
return;',
      'locked' => '0',
      'properties' => 'a:0:{}',
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    46 => 
    array (
      'id' => '46',
      'source' => '2',
      'property_preprocess' => '0',
      'name' => 'SeoFilter',
      'description' => '',
      'editor_type' => '0',
      'category' => '43',
      'cache_type' => '0',
      'plugincode' => '/** @var modX $modx */

/** @var array $scriptProperties */
switch ($modx->event->name) {
    case \'OnLoadWebDocument\':
        if ($page = $modx->resource->id) {
            $modx->addPackage(\'seofilter\', $modx->getOption(\'core_path\').\'components/seofilter/model/\');
            $proMode = $modx->getOption(\'seofilter_pro_mode\', null, 0, true);
            $q = $modx->newQuery(\'sfRule\');
            $q->where([\'active\' => 1]);
            if ($proMode) {
                $q->where(\'1=1 AND FIND_IN_SET(\'.$page.\',REPLACE(IFNULL(NULLIF(pages,""),page)," ",""))\');
            } else {
                $q->where([\'page\' => $page]);
            }
            if ($modx->getCount(\'sfRule\', $q)) {
                $SeoFilter = $modx->getService(\'seofilter\', \'SeoFilter\', $modx->getOption(\'seofilter_core_path\', null,
                        $modx->getOption(\'core_path\').\'components/seofilter/\').\'model/seofilter/\',
                    $scriptProperties);
                if (!($SeoFilter instanceof SeoFilter)) {
                    break;
                }
                $SeoFilter->initialize($modx->resource->context_key, [\'page\' => $page]);
            }
        }
        break;
    case \'OnBeforeDocFormSave\':
        if (!$sf_count = $modx->getOption(\'seofilter_count\', null, 0, true)) {
            break;
        }

        if (!$modx->getOption(\'seofilter_collect_words\', null, 1)) {
            break;
        }

        $sf_classes = $modx->getOption(\'seofilter_classes\', null, \'msProduct\', true);
        if ($sf_classes && !in_array($resource->get(\'class_key\'), array_map(\'trim\', explode(\',\', $sf_classes)), true)) {
            break;
        }
        $sf_templates = $modx->getOption(\'seofilter_templates\', null, \'\', true);
        if ($sf_templates && !in_array((int)$resource->get(\'template\'),
                array_map(\'intval\', array_map(\'trim\', explode(\',\', $sf_templates))), true)) {
            break;
        }

        $before = [];
        if ($mode === \'upd\') {
            $SeoFilter = $modx->getService(\'seofilter\', \'SeoFilter\', $modx->getOption(\'seofilter_core_path\', null,
                    $modx->getOption(\'core_path\').\'components/seofilter/\').\'model/seofilter/\', $scriptProperties);
            if (!($SeoFilter instanceof SeoFilter)) {
                break;
            }

            $fields = $SeoFilter->getFieldsKey(\'key\', $resource->id);
            $before = $SeoFilter->getResourceData($resource->id, $fields);
        }
        $_SESSION[\'SeoFilter\'][\'before\'] = $before;
        // @session_write_close();
        break;
    case \'OnDocFormSave\':
        if (!$modx->getOption(\'seofilter_collect_words\', null, 1)) {
            break;
        }
        $sf_classes = $modx->getOption(\'seofilter_classes\', null, \'msProduct\', true);
        if ($sf_classes && !in_array($resource->get(\'class_key\'), array_map(\'trim\', explode(\',\', $sf_classes)), true)) {
            break;
        }
        $sf_templates = $modx->getOption(\'seofilter_templates\', null, \'\', true);
        if ($sf_templates && !in_array((int)$resource->get(\'template\'),
                array_map(\'intval\', array_map(\'trim\', explode(\',\', $sf_templates))), true)) {
            break;
        }

        $sf_count = $modx->getOption(\'seofilter_count\', null, 0, true);
        $SeoFilter = $modx->getService(\'seofilter\', \'SeoFilter\', $modx->getOption(\'seofilter_core_path\', null,
                $modx->getOption(\'core_path\').\'components/seofilter/\').\'model/seofilter/\', $scriptProperties);
        $pdo = $SeoFilter->pdo;
        if (!($SeoFilter instanceof SeoFilter) && !($pdo instanceof pdoFetch)) {
            break;
        }

        $dictionary = $changes = $before = [];
        $fields = $SeoFilter->getFieldsKey(\'key\', $resource->id);
        $after = $SeoFilter->getResourceData($resource->id, $fields);

        if (array_key_exists(\'tagger\', $fields)) {
            $taggerPath = $modx->getOption(\'tagger.core_path\', null,
                $modx->getOption(\'core_path\', null, MODX_CORE_PATH).\'components/tagger/\');
            /** @var Tagger $tagger */
            $tagger = $modx->getService(\'tagger\', \'Tagger\', $taggerPath.\'model/tagger/\',
                [\'core_path\' => $taggerPath]);
            if (($tagger instanceof Tagger)) {
                $q = $modx->newQuery(\'TaggerGroup\');
                $q->where([\'id:IN\' => array_keys($fields[\'tagger\']), \'OR:alias:IN\' => array_keys($fields[\'tagger\'])]);
                $q->select(\'id,alias\');
                if ($q->prepare() && $q->stmt->execute()) {
                    while ($group = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                        if ($resource->get(\'tagger-\'.$group[\'id\'])) {
                            if (array_key_exists($group[\'id\'], $fields[\'tagger\'])) {
                                $after[\'tagger\'][$group[\'id\']] = $tagger->explodeAndClean($resource->get(\'tagger-\'.$group[\'id\']));
                            } else {
                                $after[\'tagger\'][$group[\'alias\']] = $tagger->explodeAndClean($resource->get(\'tagger-\'.$group[\'id\']));
                            }
                        }
                    }
                }
            }
        }

        if ($sf_count) {
            $SeoFilter->loadHandler();
            $before = $_SESSION[\'SeoFilter\'][\'before\'];
            unset($_SESSION[\'SeoFilter\']);
        }

        foreach ([\'tvs\', \'tvss\', \'data\', \'tagger\'] as $var) {
            $dictionary = $SeoFilter->returnChanges($after[$var], [], $var);

            if (!empty($after[$var])) {
                if (!empty($before[$var])) {
                    if ($change = $SeoFilter->returnChanges($before[$var], $after[$var], $var)) {
                        $changes[$var] = $change;
                    }
                    // сравнить значения
                } elseif ($change = $SeoFilter->returnChanges($after[$var], [], $var)) {
                    $changes[$var] = $change;
                }
            } elseif (!empty($before[$var])) {
                if ($change = $SeoFilter->returnChanges($before[$var], [], $var)) {
                    $changes[$var] = $change;
                }
                // удалились значения
            }


            if (!empty($dictionary)) {
                foreach ($dictionary as $field_key => $words) {
                    foreach ($words as $word) {
                        if (empty($word)) {
                            continue;
                        }
                        $slider = (int)$fields[$var][$field_key][\'slider\'];
                        if ($word_array = $SeoFilter->getWordArray($word, $fields[$var][$field_key][\'id\'], 0,
                            !$slider)) {
                            if ($sf_count && is_array($changes[$var][$field_key])
                                && in_array($word, $changes[$var][$field_key], true)) {
                                $recount = $SeoFilter->countHandler->countByWord($word_array[\'id\']);
                            }
                        } elseif ($sf_count && $slider && is_array($changes[$var][$field_key])
                            && in_array($word, $changes[$var][$field_key], true)) {
                            $recount = $SeoFilter->countHandler->countBySlider($fields[$var][$field_key][\'id\'],
                                $fields[$var][$field_key]);
                        }
                        if (is_array($changes[$var][$field_key])) {
                            foreach ($changes[$var][$field_key] as $key => $value) {
                                if ($word === $value) {
                                    unset($changes[$var][$field_key][$key]);
                                }
                                //здесь пересчитали только новые значения
                            }
                        }
                    }
                }
            }


            if (!empty($changes[$var]) && $sf_count) {
                // действия на пересчёт слов, которые удалены
                foreach ($changes[$var] as $field_key => $words) {
                    foreach ($words as $_word) {
                        if (is_array($_word)) {
                            $word_arr = $_word;
                        } else {
                            $word_arr = [$_word];
                        }
                        foreach ($word_arr as $word) {
                            if (empty($word)) {
                                continue;
                            }
                            $slider = (int)$fields[$var][$field_key][\'slider\'];
                            if ($word_array = $SeoFilter->getWordArray($word, $fields[$var][$field_key][\'id\'], 0,
                                !$slider)) {
                                $recount = $SeoFilter->countHandler->countByWord($word_array[\'id\']);
                            } elseif ($slider) {
                                $recount = $SeoFilter->countHandler->countBySlider($fields[$var][$field_key][\'id\'],
                                    $fields[$var][$field_key]);
                            }
                        }
                    }
                }
            }
        }

        break;
    case \'OnPageNotFound\':
        $alias = $modx->context->getOption(\'request_param_alias\', \'q\');

        if (isset($_REQUEST[$alias])) {
            /** @var SeoFilter $SeoFilter */
            $SeoFilter = $modx->getService(\'seofilter\', \'SeoFilter\', $modx->getOption(\'seofilter_core_path\', null,
                    $modx->getOption(\'core_path\').\'components/seofilter/\').\'model/seofilter/\', $scriptProperties);
            if (!($SeoFilter instanceof SeoFilter)) {
                break;
            }

            $SeoFilter->processUrl(trim($_REQUEST[$alias]));
        }
        break;
}',
      'locked' => '0',
      'properties' => 'a:0:{}',
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    47 => 
    array (
      'id' => '47',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'mSearch2',
      'description' => '',
      'editor_type' => '0',
      'category' => '51',
      'cache_type' => '0',
      'plugincode' => '$id = 0;

switch ($modx->event->name) {

	case \'OnDocFormSave\':
	case \'OnResourceDelete\':
	case \'OnResourceUndelete\':
		/* @var modResource $modResource */
		if (!empty($resource) && $resource instanceof modResource) {
			$id = $resource->get(\'id\');
		}
	break;

	case \'OnCommentSave\':
	case \'OnCommentRemove\':
	case \'OnCommentDelete\':
		/* @var TicketComment $TicketComment */
		if (!empty($TicketComment) && $TicketComment instanceof TicketComment) {
			$id = $TicketComment->getOne(\'Thread\')->get(\'resource\');
		}
	break;

}


if (!empty($id)) {
	/* @var modProcessorResponse $response */
	$response = $modx->runProcessor(\'mgr/index/update\', array(\'id\' => $id), array(\'processors_path\' => MODX_CORE_PATH . \'components/msearch2/processors/\'));

	if ($response->isError()) {
		$modx->log(modX::LOG_LEVEL_ERROR, print_r($response->getAllErrors(), true));
	}
}',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'core/components/msearch2/elements/plugins/plugin.msearch2.php',
    ),
    53 => 
    array (
      'id' => '53',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'DirectResize2',
      'description' => 'New version of great plugin for expand pictures similar to Lightbox. The following viewers can be selected Highslide, Colorbox and prettyPhoto.',
      'editor_type' => '0',
      'category' => '57',
      'cache_type' => '0',
      'plugincode' => '/**
 * DirectResize2 Plugin
 
 * Author: Stepan Prishepenko (Setest) <itman116@gmail.com>
 
 * Version: 1.1.4 (17.04.2013) Added new parameters in all lightboxes(min_width,min_height)
 * Version: 1.1.3 (17.04.2013) Fixed a bug check of imagesize
 * Version: 1.1.2 (16.04.2013) Fixed a bugs in parser html5 and html4 documents, fix css style, add FancyBox2 lightbox
 * Version: 1.0.2 (14.04.2013) Fixed a bugs in js and css paths, fix parameter style (colorbox part) in set of parameters.
 * Version: 1.0.1 (09.04.2013) Fixed a bugs in processing exception parameters
 * Version: 1.0.0 (08.04.2013) It`s must correctly work in ModX {REVO} 2.2 - 2.2.6
 
 * Events: OnWebPagePrerender
 * Required: PhpThumbOf snippet for resizing images

 * Based on: DirectResize by Adrian Cherry <github.com/apcherry/directresize>

   Description:   
		A modx revo plugin to apply the a selected image expander to any 
		images in modx Revo. The available packages are available for selection 
		via the plugin properties.

		* Highslide
		* Colorbox
		* prettyPhoto
 */
 

// if ($modx->user->get(\'id\')!=1) {return;}
$e = &$modx->event;
// проверяем нужное событие
if ($e->name != \'OnWebPagePrerender\') {return;}

$log = $modx->getOption(\'log\', $scriptProperties,false);
// if ($modx->user->get(\'id\')!=1) {$log=false;}
////////////////////////////////--=LOG=--///////////////////////////////////
class log{
	function __construct($modx,$debug) {
		$this->modx = &$modx;
		$this->debug = $debug; // принимает true,false
		if ($this->debug){
			$logFileName = $this->modx->event->activePlugin;
			$this->modx->setLogLevel(modX::LOG_LEVEL_INFO);
				$date = date(\'Y-m-d____H-i-s\');  // использовать в выводе даты : - нельзя, иначе не создается лог в файл
				$this->modx->setLogTarget(array(
				   // \'target\' => \'ECHO\',
				   \'target\' => \'FILE\',
				   \'options\' => array(\'filename\' => "{$logFileName}_$date.log")				   
			));		
		} 
	}
	function write($info){
		if (!$this->debug){return;}
		$this->modx->log(modX::LOG_LEVEL_INFO, $info);
	}
}
$log=new log($modx,$log);	
////////////////////////////////--=LOG=--///////////////////////////////////
// $log->write(777); return;

// $modx->lexicon->load(\'directresize2:properties\');

// $path = $modx->getOption(\'cache_path\',$scriptProperties,\'assets/components/directresize2/cache\');

$thumb_key = $modx->getOption(\'thumb_key\',$scriptProperties,\'\'); // this parameter add in the filename of thumbnail
$thumbnail_dir = $modx->getOption(\'thumbnail_dir\', $scriptProperties);
$thumbnail_dir = str_replace(\'//\', \'/\', $thumbnail_dir);
$thumbnail_dir = str_replace(array("..","."), "", $thumbnail_dir);
if (empty($thumbnail_dir)) return;

$config_default_thumb_param = $modx->getOption(\'thumb_param\', $scriptProperties, "
\'zc\'=1,\'bg\'=\'#fff\',\'q\'=80");
// \'w\'=200,\'h\'=150,\'zc\'=1,\'bg\'=\'#fff\',\'q\'=70");
$config_default_thumb_param = str_replace(array("\'"," "),"",$config_default_thumb_param);


// $r = $modx->getOption(\'method\',$scriptProperties,0);
// $q_jpg = $modx->getOption(\'jpg_quality\',$scriptProperties,85);
// $q_png = $modx->getOption(\'png_quality\',$scriptProperties,8);

$default_thumb_path = $modx->getOption(\'default_thumb_path\',$scriptProperties,null); // assets/images/thumbs

// if enabled then insert special JS for lighbox 
$insert_expander = $modx->getOption(\'insert_expander\',$scriptProperties,true);
// if enabled then insert JS code of components such as: jquery.js, colorbox.js etc.
$insert_expander_js = $modx->getOption(\'insert_expander_js\',$scriptProperties,true);
// if enabled then insert CSS code of components such as: colorbox.css, highslide.css etc.
$insert_expander_css = $modx->getOption(\'insert_expander_css\',$scriptProperties,true);
// rewrite thubmnail image if it exist, you can off it to add speed this plugin
$rewrite_image_on_exist = $modx->getOption(\'rewrite_image_on_exist\',$scriptProperties,false);

/*===================--THUMBNAIL PARAMETERS--====================*/
// $lightbox = $modx->getOption(\'enable\',$scriptProperties,true);
$expander = $modx->getOption(\'expander\',$scriptProperties,\'highslide\');
$lightbox_w = $modx->getOption(\'max_width\',$scriptProperties,800);
$lightbox_h = $modx->getOption(\'max_height\',$scriptProperties,600);

$lightbox_w_min = $modx->getOption(\'min_width\',$scriptProperties,100);
$lightbox_h_min = $modx->getOption(\'min_height\',$scriptProperties,100);


$slideshow = ($modx->getOption(\'slideshow\',$scriptProperties,false))? \'true\' : \'false\';
$duration = $modx->getOption(\'slide_duration\',$scriptProperties,2500);
$opacity = number_format($modx->getOption(\'opacity\',$scriptProperties,50)/100,2);

// FancyBox2
$fb2_closeClick = $modx->getOption(\'fb2_closeClick\',$scriptProperties,true);
$fb2_closeClick = $fb2_closeClick ? \'true\' : \'false\';

$fb2_closeEffect = $modx->getOption(\'fb2_closeEffect\',$scriptProperties,\'elastic\');
$fb2_openEffect = $modx->getOption(\'fb2_openEffect\',$scriptProperties,\'elastic\');
$fb2_openSpeed = $modx->getOption(\'fb2_openSpeed\',$scriptProperties,150);
$fb2_closeSpeed = $modx->getOption(\'fb2_closeSpeed\',$scriptProperties,150);
$fb2_padding = $modx->getOption(\'fb2_padding\',$scriptProperties,0);
$fb2_autoPlay = $modx->getOption(\'fb2_autoPlay\',$scriptProperties,false);
$fb2_autoPlay = $fb2_autoPlay ? \'true\' : \'false\';

$fb2_playSpeed = $modx->getOption(\'fb2_playSpeed\',$scriptProperties,3000);


// Highslide
$captionPosition = $modx->getOption(\'caption_position\',$scriptProperties,\'below\');
$hs_captionEval = $modx->getOption(\'caption_source\',$scriptProperties,\'this.thumb.alt\');
$largeCaption = $modx->getOption(\'large_caption\',$scriptProperties,120);
$hs_outlineType = $modx->getOption(\'outline_type\',$scriptProperties,\'rounded-white\');
$hs_credit = $modx->getOption(\'hs_credit\',$scriptProperties,\'Highslide JS\');
// Colorbox
$cb_style = $modx->getOption(\'style\',$scriptProperties,\'style1\');
if (empty($cb_style)) $cb_style=\'style1\';
$cb_transition = $modx->getOption(\'transition\',$scriptProperties,\'elastic\');
// PrettyPhoto
$pp_theme = $modx->getOption(\'theme\',$scriptProperties,\'pp_default\');

/*===================--EXCLUDE--====================*/
$templates = $modx->getOption(\'templates\', $scriptProperties, \'\');
$exclude_templates = $modx->getOption(\'exclude_templates\', $scriptProperties, \'\');
$exclude_dirs = $modx->getOption(\'exclude_dirs\', $scriptProperties, null);	// папки исключения
if ($exclude_dirs) $exclude_dirs=explode(",",$exclude_dirs);

$exclude_dirs_suffix = $modx->getOption(\'exclude_dirs_suffix\', $scriptProperties, "{ExChild}");	// суффикс папки исключения, при наличии, которого дочерние папки исключаются
$exclude_dirs_children = $modx->getOption(\'exclude_dirs_children\', $scriptProperties, null);	// исключать ли дочерние директории?
$exclude_text_in_elements = $modx->getOption(\'exclude_text_in_elements\', $scriptProperties, "noresize");	// исключает из проверки изображения которые содержат данный текст в элементах alt, class, id, tittle
$exclude_extensions = $modx->getOption(\'exclude_extensions\', $scriptProperties, null);	// исключаем файлы с раширением ... содержащиеся в exclude_extensions, перечисленные через запятую

// подключаем собственную функцию уменьшения картинок
// require_once MODX_CORE_PATH.\'components/directresize2/elements/plugins/plugin.directresize.php\';
// подключаем phpthumb
require_once MODX_CORE_PATH.\'model/phpthumb/phpthumb.class.php\';

$o = &$modx->resource->_output; // get a reference to the output
$cur_output = $modx->resource->get(\'content\');
$foundImage = false; // if no image found then don\'t insert javascript

// working only in templates
$cur_param_res_template = $modx->resource->get(\'template\');
if (!empty($templates) and $cur_param_res_template and !in_array($cur_param_res_template, explode(\',\', str_replace(" ","",$templates)))){
	// если документ не попадает в шаблон то изменения не проиводятся
	// in_array($cur_param_res_template, explode(\',\', $templates))
	return;
}	

// exclude templates
if (!empty($exclude_templates) and $cur_param_res_template and in_array($cur_param_res_template, explode(\',\', str_replace(" ","",$exclude_templates)))){
	// если документ попадает в шаблон то изменения не проиводятся
	return;
}	

$output_dom=new DOMDocument();

// рабочий вариант, но при нем функция asXml() возвращает данные в ASCII
// которые никак не хотят конвертироваться в родную кодировку
// $output_dom->loadHTML(\'xml encoding="UTF-8">\' . $cur_output);

$charset=$modx->getOption(\'modx_charset\');
if (!$charset) $charset="UTF-8";
$cur_output="<html>
 <head>
    <meta http-equiv=\'content-type\' content=\'text/html; charset={$charset}\'>
  </head>
<body>{$cur_output}</body>
</html>";
$output_dom->loadHTML($cur_output);


$xml=simplexml_import_dom($output_dom); // just to make xpath more simple
$images=$xml->xpath(\'//img\');
// print_r($images);

if (!function_exists(\'css_parse\')) {
	function css_parse($styles){
		// parse css and get all the key:value pair styles
		$css_array = array(); // master array to hold all values
		if (isset($styles) and $styles = explode(\';\', strtolower($styles)) and !empty($styles)){
			foreach ($styles as $style) {
				$value = explode(\':\', $style);
				// build the master css array
				if (!empty($value[0]))	$css_array[$value[0]] = $value[1];
			}
		}
		return $css_array;
	}
}
// функция разбивает строку вида "\'param1\'=\'value1\',..." и возвращает массив
if (!function_exists(\'getconfigparam\')) {
	// function getconfigparam($config_default_param, $type){
	function getconfigparam($config_default_param){
		foreach (explode(",",$config_default_param) as $parametr) {
			$param_arr=explode("=",$parametr);
				// $param[$type][$param_arr[0]]=$param_arr[1];
				$param[$param_arr[0]]=$param_arr[1];
		}
		return $param;
	}
}

$count_imgs=0;

if (!empty($images)) {
	// get version modx
	$log->write("ModX version:".$modx->getOption(\'settings_version\'));
	// приводим к общему виду все img
	$o = preg_replace(\'/<img\\s+(([a-z]+=".*?")+\\s*)>/\' , "<img $1 />", $o);
}
if (strpos("<!DOCTYPE html>")) $html5=true; // в связи с различной обработкой тегов в html4 и 5 версии
// хотя можно поиграться и с normalizeDocument()

foreach ($images as $imgs) {
	$imgstring = $imgs->asXML(); // так как при этом возврате у нас происходит замена " />" на "/>" то нам нужно вернуть этот пробел иначе мы не получим замену в итоге
	if ($html5==true) {
		$imgstring=str_replace(array(\' />\',\'/>\'), \'>\', $imgstring);
	}
	else {
		$imgstring=str_replace(\'/>\', \' />\', $imgstring);
	}

	$path_img  = $imgs[\'src\'];   
	$id        = $imgs[\'id\'];
	$alt       = $imgs[\'alt\'];
	$title     = $imgs[\'title\'];
	// $class     = explode(" ",$imgs[\'class\']);
	$class     = $imgs[\'class\']; /*Fix by Setest 2013-04-09*/
	
	$path_img = urldecode($path_img); // Fix by Fi1osof
	// $path_img = $path_img; // Fix by Fi1osof
	$log->write(print_r($path_img,true));
	
	if (file_exists($path_img)) {
		// echo "|".substr($path_img,0,strlen($path_base))."|".PHP_EOL;
		// echo "$path_img".PHP_EOL;
		// echo "$path_base".PHP_EOL;
		// echo "=====".PHP_EOL;
		$count_imgs++;
		$log->write("==========---IMG №{$count_imgs}---==========");
		if (strpos("{$id} {$alt} {$title} {$class}",$exclude_text_in_elements)!== false){
			$log->write("Exclude image: $path_img, because \'id\', \'class\', \'title\' or \'id\' is contains \'$exclude_text_in_elements\'");
			continue;
		}

		
		$img_dir=dirname($path_img);
		$path_img_full = MODX_BASE_PATH.$path_img;
// echo "@@@$path_img_full@@@";
		$img_name = pathinfo($path_img, PATHINFO_FILENAME);
		$ext = pathinfo($path_img, PATHINFO_EXTENSION);	
		// получаем конфигурацию по умолчанию
		$config_default = getconfigparam($config_default_thumb_param);	

		// проверяем исключение расширение файла exclude_extensions
		/*Fix by Setest 2013-04-09*/
		if ($exclude_extensions and $exclude_extensions=str_replace(\' \', \'\', $exclude_extensions) and ($exclude_extensions=explode(",",$exclude_extensions)) and (in_array($ext, $exclude_extensions))){
			$log->write("except extension of file ({$ext}), return;");
			continue;	
		}
		
		// проверяем на исключения директории
		// if ($exclude_dirs and $exclude_dirs=str_replace(\' \', \'\', $exclude_dirs) and (in_array($cur_dir,explode(",",$exclude_dirs)))){
		$excl=false;
		if ($exclude_dirs){
			// $log->write("EXCL");
			// return;
			if ($exclude_dirs_children) {
			
				foreach ($exclude_dirs as $path) {
						if (strpos($img_dir, $path) !== false) //return;
						{
							$log->write("except children, return;");
							$excl=true; break;
						}
				}
			}
			else {
				foreach ($exclude_dirs as $path) { 
					$log->write("EXCLUDE DIRS CONDITIONS: curdir ($img_dir), exclude dir ($path)");
					/*Fix by Setest 2013-04-09*/
					// так как пользователь может указать папку исключения в двух видах к примеру:
					// images/{ExChild} или images{ExChild}, то нужно это учесть
					if ((strpos($path, $exclude_dirs_suffix) !== false) && (
						strpos($img_dir, substr($path,0,-1*(strlen($exclude_dirs_suffix)))) !== false
						or
						strpos($img_dir, substr($path,0,-1*((strlen($exclude_dirs_suffix))+1))) !== false
					)) {
						// если содержит в строке &ExChild
						$log->write("except {$exclude_dirs_suffix} in: {$path}, return;");
						$excl=true; break;
					}
					else {
						if ($img_dir==str_replace($exclude_dirs_suffix, \'\', $path)) {
							$log->write("except dir, return;");
							$excl=true; break;
						}
					}
				// return $modx->error->failure("Записать в данную директорию нельзя она находится в исключениях плагина");
				// return $modx->error->failure("parent");
				}
			}
		}
		if ($excl==true) continue;


		// для определения реального пути дабы исключить картинки из веба realpath
		// dirname(__FILE__); basename pathinfo
		// $img = strtolower($imgstring);
		$verif_balise = sizeof(explode("width",$imgstring)) + sizeof(explode("height",$imgstring)) - 2;
		
		if (empty($verif_balise)) continue; // если нет ширины или высоты игнорируем
											// ведь эти параметры зачастую появляются при изменении высоты и ширины

		$height=(int)$imgs[\'height\'];
		$width=(int)$imgs[\'width\'];
		// $log->write("before: $height - $width");
		// get size from style if it exist
		if ($style=css_parse($imgs[\'style\'])) {
			if 	((int)$style[\'height\']>0) $height=(int)str_replace(\'px\',"",$style[\'height\']);
			if 	((int)$style[\'width\']>0)  $width=(int)str_replace(\'px\',"",$style[\'width\']);
		}
		$log->write("image tag size: $width(w) - $height(h)");
		
		// check if the real size bigger than in HTML then create thubnail
		$real_size_of_img = getimagesize($path_img_full);
		$img_src_w  = (int)$real_size_of_img[0];
		$img_src_h  = (int)$real_size_of_img[1];
		$log->write("realsize: ".$real_size_of_img[0]." - ".$real_size_of_img[1]);
		$log->write("realsize_array: ".print_r($real_size_of_img,true));
		
		if ($img_src_w <= $width || $img_src_h <= $height) {continue;}
		
		$foundImage = true; // if needed to add ligtbox to image

		$thumb_dir = MODX_BASE_PATH.$img_dir."/".$thumbnail_dir."/";
		if ($default_thumb_path) {
			if (substr($default_thumb_path, -1, 1)!="/") $default_thumb_path.="/";
			$thumb_dir = MODX_BASE_PATH.$default_thumb_path;
		}
		$log->write("Thumbnail full path: {$thumb_dir}");
		if(!is_dir($thumb_dir)) {
			$log->write("Thumbnail dir not exist");
			if (!mkdir($thumb_dir,0755)){
				$log->write("Thumbnail error:".$modx->lexicon(\'dirres_error_createdir\'));
				// return $modx->error->failure($modx->lexicon(\'dirres_error_createdir\'));
			}
			else{
				$log->write("Thumbnail dir created successfull");
			}
		}
		else {
			$log->write("Thumbnail dir already exist");
		}
		// $filename = $thumb_dir.$name;
		$imgName = "{$thumb_dir}{$img_name}{$thumb_key}_w{$width}_h{$height}.{$ext}";
		
		if ($rewrite_image_on_exist or !file_exists($imgName)) {
			// old method
			// $imgName = directResize($path_img,$path,$thumb_key,$width,$height,$r,$q_jpg,$q_png);

			// new method
			// создаем объект phpThumb..
			$phpThumb = new phpThumb();
			$phpThumb->setSourceFilename($path_img_full);
			if (empty($config_default[\'f\'])){
				$config_default[\'f\']=$ext; // без этого мы не увидим прозрачности в png и gif
			}
			if (!empty($config_default)){
				$config_default[\'h\']=$height;
				$config_default[\'w\']=$width;
				$log->write("setParameter:  {$config_default_thumb_param}");
				$log->write("itogParameter: ".implode(", ",$config_default));
				foreach ($config_default as $k => $v) {
					$phpThumb->setParameter($k, $v);
				}
			}
		   
			// генерируем файл
			if ($phpThumb->GenerateThumbnail()) {
				$log->write("GenerateThumbnail - OK");
				if ($phpThumb->RenderToFile($imgName)) {
					$log->write("RenderToFile - OK");
					// устанавливаем права на файл, это опционально, зависит от сервера
					chmod($imgName, 0666);
				}
				else {
					$log->write("Error: RenderToFile: $imgName");
					continue;
				}
			}
			else {
				$log->write("Error: GenerateThumbnail");
				continue;
			}		
		}
		// возвращаем нормальный путь к файлу чтобы можно было передать его пользователю
		$imgName=str_replace(MODX_BASE_PATH, \'\', $imgName);
		$log->write("Itog thumb filename: $imgName");
		//-------------------
		// в этой строке происходит замена начинки src на новую ужатую картинку
		// $new_link = $path_g[0].$pathRedim.$path_d[0];
		$log->write("Replace string in output: 
			search:  {$path_img}
			replace: {$imgName}
			subject: {$imgstring}
		");
		
		$new_link = str_replace($path_img,$imgName,$imgstring);

		###############################
		// непонятная строка разобраться и что за verif_light
		// preg_match("/directresize2/",strtolower($imgstring),$verif_light);
		// if ($lightbox == 1 && $verif_light[0] == "directresize") {
		// if ($lightbox) {
		// create the expanded image legend from the title and alt tags, for colorbox and prettyPhoto
		$log->write("Create the legend for $expander");

		if ($alt <> "" || $title <> "") {
			$legende = " title=\\"$alt";
			if ($alt <> "" && $title <> "") $legende .= "<br />";
			if ($title <> "") $legende .= "<span style=\'font-weight:normal; font-size: 9px\'>$title</span>";
			$legende .= "\\" ";
		} else {
			$legende = "";
		}
		// work out if the caption is large enough to go into the right hand panel
		if ($largeCaption > 0 && ( strlen($title) > $largeCaption || strlen($alt) > $largeCaption )) {
			$override = \', { captionOverlay: { position: \\\'rightpanel\\\', width: \\\'250px\\\' } }\';
		} else {
			$override = \'\';
		}

		
		// select which expander to apply to the graphical element
		switch ($expander) {
			case "fancybox2" :
				$group="";	if ($fb2_autoPlay==\'true\') $group="rel=\'group\'";
				$new_link = "<a class=\'fancybox2\' {$group} ".$legende." href=\'".$path_img."\' >".$new_link."</a>";
				break;		
			case "colorbox" :
				$new_link = "<a class=\'colorbox cboxElement\' ".$legende." href=\'".$path_img."\' >".$new_link."</a>";
				break;
			case "prettyphoto" :
				$new_link = "<a rel=\'prettyPhoto[[pp_gal]]\' ".$legende." href=\'".$path_img."\' >".$new_link."</a>";
				break;
			default : //use highslide as the default
				$new_link = "<a class=\'highslide\' onclick=\\"return hs.expand(this".$override.")\\" href=\'".$path_img."\' >".$new_link."</a>";
		}
		// } // end lightbox highslide test
		$log->write("Replace in output:
			ImageString: {$imgstring}
			NewLink:     {$new_link}
		");

		$o = str_replace($imgstring,$new_link,$o);
	} // end path_base test
} // end for loop

// only add style sheet and javascript if there is an image to resize
if ( $insert_expander and $foundImage ) {
	// select which expander style sheet and java script is required
	switch ($expander) {
		case "fancybox2" :
			$drStyle = "
				<link rel=\'stylesheet\' type=\'text/css\' href=\'assets/components/directresize2/fancybox2/jquery.fancybox.css?v=2.1.4\' media=\'screen\' />\\n
				<link rel=\'stylesheet\' type=\'text/css\' href=\'assets/components/directresize2/fancybox2/helpers/jquery.fancybox-buttons.css?v=1.0.5\' media=\'screen\' />\\n
				<link rel=\'stylesheet\' type=\'text/css\' href=\'assets/components/directresize2/fancybox2/helpers/jquery.fancybox-thumbs.css?v=1.0.7\' />\\n
			";
			$jsCall =  "
				<script type=\'text/javascript\' src=\'http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js\'></script>
				<script type=\'text/javascript\' src=\'assets/components/directresize2/fancybox2/jquery.mousewheel-3.0.6.pack.js\'></script>
				<script type=\'text/javascript\' src=\'assets/components/directresize2/fancybox2/jquery.fancybox.pack.js?v=2.1.4\'></script>
				<script type=\'text/javascript\' src=\'assets/components/directresize2/fancybox2/helpers/jquery.fancybox-buttons.js?v=1.0.5\'></script>
				<script type=\'text/javascript\' src=\'assets/components/directresize2/fancybox2/helpers/jquery.fancybox-thumbs.js?v=1.0.7\'></script>
				<script type=\'text/javascript\' src=\'assets/components/directresize2/fancybox2/helpers/jquery.fancybox-media.js?v=1.0.5\'></script>
			";
			$js 	=  "<script>
							jQuery(\'a.fancybox2\').fancybox({
								padding: {$fb2_padding},

								minWidth: {$lightbox_w_min},
								minHeight: {$lightbox_h_min},

								maxWidth: {$lightbox_w},
								maxHeight: {$lightbox_h},
								
								autoPlay: {$fb2_autoPlay},
								playSpeed: {$fb2_playSpeed},

								openEffect : \'{$fb2_openEffect}\',
								openSpeed  : {$fb2_openSpeed},

								closeEffect : \'{$fb2_closeEffect}\',
								closeSpeed  : {$fb2_closeSpeed},

								closeClick : {$fb2_closeClick},

								helpers : {
									overlay : null
								}
							});
						</script>\\n";
		break;	
		case "colorbox" :
			$drStyle = "<link rel=\'stylesheet\' type=\'text/css\' href=\'assets/components/directresize2/colorbox/".$cb_style."/colorbox.css\' />\\n";
			$jsCall =  "<script type=\'text/javascript\' src=\'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js\'></script>
						<script type=\'text/javascript\' src=\'assets/components/directresize2/js/jquery.colorbox-min.js\'></script>";
			$js 	=  "<script>
							jQuery(\'a.colorbox\').colorbox({
								rel:\'colorbox\',
								opacity:".$opacity.",
								transition:\'".$cb_transition."\',
								slideshow:".$slideshow.",
								slideshowSpeed:".$duration.",
								
								initialWidth: {$lightbox_w_min},
								initialHeight: {$lightbox_h_min},

								maxWidth:".$lightbox_w.",
								maxHeight:".$lightbox_w."});
						</script>\\n";
		break;

		case "prettyphoto" :
			$drStyle = "<link rel=\'stylesheet\' type=\'text/css\' href=\'assets/components/directresize2/css/prettyPhoto.css\' />\\n";
			$jsCall  = "<script type=\'text/javascript\' src=\'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js\'></script>
						<script type=\'text/javascript\'src=\'assets/components/directresize2/js/jquery.prettyPhoto.js\'></script>";
			$js		 = "<script>
							$(document).ready(function(){
							$(\\"a[rel^=\'prettyPhoto\']\\").prettyPhoto({
								theme:\'".$pp_theme."\',
								default_width: {$lightbox_w},
								default_height: {$lightbox_w},
								opacity:".$opacity.",
								autoplay_slideshow:".$slideshow.",
								slideshow:".$duration."
							});});
						</script>\\n";
		break;
		
		default :// default to highslide settings
			$drStyle = "<link rel=\'stylesheet\' type=\'text/css\' href=\'assets/components/directresize2/highslide/highslide.css\' />\\n";
			$jsCall  = "<script type=\'text/javascript\' src=\'assets/components/directresize2/js/highslide-with-gallery.min.js\'></script>";
			$js		 = "<script type=\'text/javascript\'>
							hs.graphicsDir = \'assets/components/directresize2/highslide/graphics/\'; // path to the graphical elements of highslide
							hs.outlineType = \'".$hs_outlineType."\';
							hs.captionEval = \'".$hs_captionEval."\';
							hs.captionOverlay.position = \'".$captionPosition."\';
							hs.dimmingOpacity = ".$opacity.";
							hs.numberPosition = \'caption\';
							hs.lang.number = \'Image %1 of %2\';
							hs.minWidth = {$lightbox_w_min};
							hs.minHeight = {$lightbox_h_min};
							hs.maxWidth = \'".$lightbox_w."\';
							hs.maxHeight = \'".$lightbox_h."\';
							hs.lang.creditsText = \'".$hs_credit."\';
						</script>\\n";
			if ( $slideshow == \'true\' ) {
				$js = $js."
						<script type=\'text/javascript\'>
							hs.addSlideshow({
								interval: ".$duration.",
								repeat: false,
								useControls: true,
								fixedControls: true,
								overlayOptions: {
									opacity: ".$opacity.",
									position: \'top center\',
									hideOnMouseOut: true,
								}
							});
				</script>\\n";
			}
		break;
	}
	
	if ($insert_expander_css){
		$log->write("Insert expander css");

		// add the style sheet to the head of the html file
		$o = preg_replace(\'~(</head>)~i\', $drStyle . \'\\1\', $o);
	}
	if ($insert_expander_js){ $js=$jsCall.$js;}
	$log->write("Insert expander JS"); 
	// add the javascript to the bottom of the page 
	$o = preg_replace(\'~(</body>)~i\', $js . \'\\1\', $o);
	
}
return;',
      'locked' => '0',
      'properties' => 'a:39:{s:3:"log";a:7:{s:4:"name";s:3:"log";s:4:"desc";s:11:"dirres2_log";s:4:"type";s:13:"combo-boolean";s:7:"options";a:0:{}s:5:"value";b:0;s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:0:"";}s:7:"opacity";a:7:{s:4:"name";s:7:"opacity";s:4:"desc";s:15:"dirres2_opacity";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";s:2:"40";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:0:"";}s:14:"slide_duration";a:7:{s:4:"name";s:14:"slide_duration";s:4:"desc";s:22:"dirres2_slide_duration";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";s:4:"5000";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:0:"";}s:12:"exclude_dirs";a:7:{s:4:"name";s:12:"exclude_dirs";s:4:"desc";s:20:"dirres2_exclude_dirs";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:53:"assets/images/banners/,assets/images/aliens/{ExChild}";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:18:"Exclusion settings";}s:21:"exclude_dirs_children";a:7:{s:4:"name";s:21:"exclude_dirs_children";s:4:"desc";s:29:"dirres2_exclude_dirs_children";s:4:"type";s:13:"combo-boolean";s:7:"options";a:0:{}s:5:"value";b:0;s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:18:"Exclusion settings";}s:19:"exclude_dirs_suffix";a:7:{s:4:"name";s:19:"exclude_dirs_suffix";s:4:"desc";s:27:"dirres2_exclude_dirs_suffix";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:9:"{ExChild}";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:18:"Exclusion settings";}s:18:"exclude_extensions";a:7:{s:4:"name";s:18:"exclude_extensions";s:4:"desc";s:26:"dirres2_exclude_extensions";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:18:"Exclusion settings";}s:17:"exclude_templates";a:7:{s:4:"name";s:17:"exclude_templates";s:4:"desc";s:25:"dirres2_exclude_templates";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:18:"Exclusion settings";}s:24:"exclude_text_in_elements";a:7:{s:4:"name";s:24:"exclude_text_in_elements";s:4:"desc";s:32:"dirres2_exclude_text_in_elements";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:8:"noresize";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:18:"Exclusion settings";}s:9:"templates";a:7:{s:4:"name";s:9:"templates";s:4:"desc";s:17:"dirres2_templates";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:1:"2";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:18:"Exclusion settings";}s:15:"insert_expander";a:7:{s:4:"name";s:15:"insert_expander";s:4:"desc";s:23:"dirres2_insert_expander";s:4:"type";s:13:"combo-boolean";s:7:"options";a:0:{}s:5:"value";b:1;s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:13:"Expander code";}s:19:"insert_expander_css";a:7:{s:4:"name";s:19:"insert_expander_css";s:4:"desc";s:27:"dirres2_insert_expander_css";s:4:"type";s:13:"combo-boolean";s:7:"options";a:0:{}s:5:"value";b:1;s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:13:"Expander code";}s:18:"insert_expander_js";a:7:{s:4:"name";s:18:"insert_expander_js";s:4:"desc";s:26:"dirres2_insert_expander_js";s:4:"type";s:13:"combo-boolean";s:7:"options";a:0:{}s:5:"value";b:1;s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:13:"Expander code";}s:8:"expander";a:7:{s:4:"name";s:8:"expander";s:4:"desc";s:16:"dirres2_expander";s:4:"type";s:4:"list";s:7:"options";a:4:{i:0;a:2:{s:4:"text";s:9:"HighSlide";s:5:"value";s:9:"highslide";}i:1;a:2:{s:4:"text";s:8:"Colorbox";s:5:"value";s:8:"colorbox";}i:2;a:2:{s:4:"text";s:11:"prettyPhoto";s:5:"value";s:11:"prettyphoto";}i:3;a:2:{s:4:"text";s:9:"FancyBox2";s:5:"value";s:9:"fancybox2";}}s:5:"value";s:8:"colorbox";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:8:"Lightbox";}s:10:"max_height";a:7:{s:4:"name";s:10:"max_height";s:4:"desc";s:18:"dirres2_max_height";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";s:3:"600";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:8:"Lightbox";}s:9:"max_width";a:7:{s:4:"name";s:9:"max_width";s:4:"desc";s:17:"dirres2_max_width";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";s:3:"800";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:8:"Lightbox";}s:10:"min_height";a:7:{s:4:"name";s:10:"min_height";s:4:"desc";s:18:"dirres2_min_height";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";s:3:"100";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:8:"Lightbox";}s:9:"min_width";a:7:{s:4:"name";s:9:"min_width";s:4:"desc";s:17:"dirres2_min_width";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";s:3:"100";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:8:"Lightbox";}s:9:"slideshow";a:7:{s:4:"name";s:9:"slideshow";s:4:"desc";s:17:"dirres2_slideshow";s:4:"type";s:13:"combo-boolean";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:8:"Lightbox";}s:5:"style";a:7:{s:4:"name";s:5:"style";s:4:"desc";s:13:"dirres2_style";s:4:"type";s:4:"list";s:7:"options";a:5:{i:0;a:2:{s:4:"text";s:6:"Style1";s:5:"value";s:6:"style1";}i:1;a:2:{s:4:"text";s:6:"Style2";s:5:"value";s:6:"style2";}i:2;a:2:{s:4:"text";s:6:"Style3";s:5:"value";s:6:"style3";}i:3;a:2:{s:4:"text";s:6:"Style4";s:5:"value";s:6:"style4";}i:4;a:2:{s:4:"text";s:6:"Style5";s:5:"value";s:6:"style5";}}s:5:"value";s:6:"style1";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:18:"Lightbox: Colorbox";}s:10:"transition";a:7:{s:4:"name";s:10:"transition";s:4:"desc";s:18:"dirres2_transition";s:4:"type";s:4:"list";s:7:"options";a:3:{i:0;a:2:{s:4:"text";s:7:"Elastic";s:5:"value";s:7:"elastic";}i:1;a:2:{s:4:"text";s:4:"Fade";s:5:"value";s:4:"fade";}i:2;a:2:{s:4:"text";s:4:"None";s:5:"value";s:4:"none";}}s:5:"value";s:7:"elastic";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:18:"Lightbox: Colorbox";}s:12:"fb2_autoPlay";a:7:{s:4:"name";s:12:"fb2_autoPlay";s:4:"desc";s:20:"dirres2_fb2_autoPlay";s:4:"type";s:13:"combo-boolean";s:7:"options";a:0:{}s:5:"value";b:0;s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:19:"Lightbox: FancyBox2";}s:14:"fb2_closeClick";a:7:{s:4:"name";s:14:"fb2_closeClick";s:4:"desc";s:22:"dirres2_fb2_closeClick";s:4:"type";s:13:"combo-boolean";s:7:"options";a:0:{}s:5:"value";b:0;s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:19:"Lightbox: FancyBox2";}s:15:"fb2_closeEffect";a:7:{s:4:"name";s:15:"fb2_closeEffect";s:4:"desc";s:23:"dirres2_fb2_closeEffect";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:7:"elastic";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:19:"Lightbox: FancyBox2";}s:14:"fb2_closeSpeed";a:7:{s:4:"name";s:14:"fb2_closeSpeed";s:4:"desc";s:22:"dirres2_fb2_closeSpeed";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:3:"150";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:19:"Lightbox: FancyBox2";}s:14:"fb2_openEffect";a:7:{s:4:"name";s:14:"fb2_openEffect";s:4:"desc";s:22:"dirres2_fb2_openEffect";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:7:"elastic";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:19:"Lightbox: FancyBox2";}s:13:"fb2_openSpeed";a:7:{s:4:"name";s:13:"fb2_openSpeed";s:4:"desc";s:21:"dirres2_fb2_openSpeed";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:3:"150";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:19:"Lightbox: FancyBox2";}s:11:"fb2_padding";a:7:{s:4:"name";s:11:"fb2_padding";s:4:"desc";s:19:"dirres2_fb2_padding";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:1:"0";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:19:"Lightbox: FancyBox2";}s:13:"fb2_playSpeed";a:7:{s:4:"name";s:13:"fb2_playSpeed";s:4:"desc";s:21:"dirres2_fb2_playSpeed";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:4:"3000";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:19:"Lightbox: FancyBox2";}s:16:"caption_position";a:7:{s:4:"name";s:16:"caption_position";s:4:"desc";s:24:"dirres2_caption_position";s:4:"type";s:4:"list";s:7:"options";a:7:{i:0;a:2:{s:4:"text";s:11:"Above image";s:5:"value";s:5:"above";}i:1;a:2:{s:4:"text";s:12:"Top of image";s:5:"value";s:3:"top";}i:2;a:2:{s:4:"text";s:14:"Lefthand panel";s:5:"value";s:9:"leftpanel";}i:3;a:2:{s:4:"text";s:15:"Middle of image";s:5:"value";s:6:"middle";}i:4;a:2:{s:4:"text";s:15:"Righthand panel";s:5:"value";s:10:"rightpanel";}i:5;a:2:{s:4:"text";s:6:"Bottom";s:5:"value";s:6:"bottom";}i:6;a:2:{s:4:"text";s:5:"Below";s:5:"value";s:5:"below";}}s:5:"value";s:5:"below";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:19:"Lightbox: Highslide";}s:14:"caption_source";a:7:{s:4:"name";s:14:"caption_source";s:4:"desc";s:22:"dirres2_caption_source";s:4:"type";s:4:"list";s:7:"options";a:3:{i:0;a:2:{s:4:"text";s:14:"Image Alt text";s:5:"value";s:14:"this.thumb.alt";}i:1;a:2:{s:4:"text";s:16:"Image title text";s:5:"value";s:16:"this.thumb.title";}i:2;a:2:{s:4:"text";s:18:"Image anchor title";s:5:"value";s:12:"this.a.title";}}s:5:"value";s:16:"this.thumb.title";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:19:"Lightbox: Highslide";}s:13:"large_caption";a:7:{s:4:"name";s:13:"large_caption";s:4:"desc";s:21:"dirres2_large_caption";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";s:3:"120";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:19:"Lightbox: Highslide";}s:12:"outline_type";a:7:{s:4:"name";s:12:"outline_type";s:4:"desc";s:20:"dirres2_outline_type";s:4:"type";s:4:"list";s:7:"options";a:7:{i:0;a:2:{s:4:"text";s:21:"Rounded white corners";s:5:"value";s:13:"rounded-white";}i:1;a:2:{s:4:"text";s:4:"None";s:5:"value";s:4:"null";}i:2;a:2:{s:4:"text";s:10:"Outer glow";s:5:"value";s:10:"outer-glow";}i:3;a:2:{s:4:"text";s:11:"Glossy dark";s:5:"value";s:11:"glossy-dark";}i:4;a:2:{s:4:"text";s:21:"Rounded black corners";s:5:"value";s:13:"rounded-black";}i:5;a:2:{s:4:"text";s:7:"Beveled";s:5:"value";s:7:"beveled";}i:6;a:2:{s:4:"text";s:11:"Drop shadow";s:5:"value";s:11:"drop-shadow";}}s:5:"value";s:13:"rounded-white";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:19:"Lightbox: Highslide";}s:5:"theme";a:7:{s:4:"name";s:5:"theme";s:4:"desc";s:13:"dirres2_theme";s:4:"type";s:4:"list";s:7:"options";a:6:{i:0;a:2:{s:4:"text";s:7:"Default";s:5:"value";s:10:"pp_default";}i:1;a:2:{s:4:"text";s:12:"Dark rounded";s:5:"value";s:12:"dark_rounded";}i:2;a:2:{s:4:"text";s:11:"Dark square";s:5:"value";s:11:"dark_square";}i:3;a:2:{s:4:"text";s:13:"Light rounded";s:5:"value";s:13:"light_rounded";}i:4;a:2:{s:4:"text";s:12:"Light square";s:5:"value";s:12:"light_square";}i:5;a:2:{s:4:"text";s:8:"Facebook";s:5:"value";s:8:"facebook";}}s:5:"value";s:10:"pp_default";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:21:"Lightbox: PrettyPhoto";}s:18:"default_thumb_path";a:7:{s:4:"name";s:18:"default_thumb_path";s:4:"desc";s:26:"dirres2_default_thumb_path";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:9:"Thumbnail";}s:22:"rewrite_image_on_exist";a:7:{s:4:"name";s:22:"rewrite_image_on_exist";s:4:"desc";s:30:"dirres2_rewrite_image_on_exist";s:4:"type";s:13:"combo-boolean";s:7:"options";a:0:{}s:5:"value";b:0;s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:9:"Thumbnail";}s:9:"thumb_key";a:7:{s:4:"name";s:9:"thumb_key";s:4:"desc";s:17:"dirres2_thumb_key";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:6:"_thumb";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:9:"Thumbnail";}s:11:"thumb_param";a:7:{s:4:"name";s:11:"thumb_param";s:4:"desc";s:19:"dirres2_thumb_param";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:25:"\'zc\'=1,\'bg\'=\'#fff\',\'q\'=80";s:7:"lexicon";s:24:"directresize2:properties";s:4:"area";s:9:"Thumbnail";}s:13:"thumbnail_dir";a:7:{s:4:"name";s:13:"thumbnail_dir";s:4:"desc";s:21:"dirres2_thumbnail_dir";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:6:"thumbs";s:7:"lexicon";N;s:4:"area";s:9:"Thumbnail";}}',
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    56 => 
    array (
      'id' => '56',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'PageBlocks',
      'description' => '',
      'editor_type' => '0',
      'category' => '60',
      'cache_type' => '0',
      'plugincode' => '/** @var modX $modx */
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
}',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'core/components/pageblocks/elements/plugins/pageblocks.php',
    ),
    58 => 
    array (
      'id' => '58',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'VersionX',
      'description' => 'The plugin that enables VersionX of tracking your content.',
      'editor_type' => '0',
      'category' => '0',
      'cache_type' => '0',
      'plugincode' => '$corePath = $modx->getOption(\'versionx.core_path\',null,$modx->getOption(\'core_path\').\'components/versionx/\');
require_once $corePath.\'model/versionx.class.php\';
$modx->versionx = new VersionX($modx);

include $corePath . \'elements/plugins/versionx.plugin.php\';
return;',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    59 => 
    array (
      'id' => '59',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'tagElementPlugin',
      'description' => '',
      'editor_type' => '0',
      'category' => '64',
      'cache_type' => '0',
      'plugincode' => 'switch ($modx->event->name) {
    case \'OnDocFormPrerender\':
        $field = \'ta\';
        $panel = \'\';
        break;
    case \'OnTempFormPrerender\':
        $field = \'modx-template-content\';
        $panel = \'modx-panel-template\';
        break;
    case \'OnChunkFormPrerender\':
        $field = \'modx-chunk-snippet\';
        $panel = \'modx-panel-chunk\';
        break;
    case \'OnSnipFormPrerender\':
        $field = \'modx-snippet-snippet\';
        $panel = \'modx-panel-snippet\';
        break;
    case \'OnPluginFormPrerender\':
        $field = \'modx-plugin-plugincode\';
        $panel = \'modx-panel-plugin\';
        break;
    case \'OnFileEditFormPrerender\':
        $field = \'modx-file-content\';
        $panel = \'modx-panel-file-edit\';
        break;
    default:
        return;
}
if (!empty($field)) {
    $modx->controller->addLexiconTopic(\'core:chunk\');
    $modx->controller->addLexiconTopic(\'core:snippet\');
    $modx->controller->addLexiconTopic(\'tagelementplugin:default\');
    $jsUrl = $modx->getOption(\'tagelementplugin_assets_url\', null, $modx->getOption(\'assets_url\') . \'components/tagelementplugin/\').\'js/mgr/\';
    /** @var modManagerController */
    $modx->controller->addLastJavascript($jsUrl.\'tagelementplugin.js\');
    $modx->controller->addLastJavascript($jsUrl.\'dialogs.js\');
    $usingFenon = $modx->getOption(\'pdotools_fenom_parser\', null, false) ? \'true\' : \'false\';
    $connectorUrl = $modx->getOption("tagelementplugin_assets_url", null, $modx->getOption("assets_url") . "components/tagelementplugin/")."connector.php";
    $_html = <<<SCRIPT
<script type="text/javascript">
    var tagElPlugin = {};
    tagElPlugin.config = {
        panel : \'{$panel}\',
        field : \'{$field}\',
        parent : [],
        keys : {
        	quickEditor: {$modx->getOption(\'tagelementplugin_quick_editor_keys\', null, \'\')},
            elementEditor: {$modx->getOption(\'tagelementplugin_element_editor_keys\', null, \'\')},
            chunkEditor: {$modx->getOption(\'tagelementplugin_chunk_editor_keys\', null, \'\')},
            quickChunkEditor: {$modx->getOption(\'tagelementplugin_quick_chunk_editor_keys\', null,\' \')},
            elementProperties: {$modx->getOption(\'tagelementplugin_element_prop_keys\', null, \'\')}
        },
        using_fenom: {$usingFenon},
        elementEditor: \'{$modx->getOption("which_element_editor")}\',
        connector_url: \'{$connectorUrl}\'
    };
</script>
SCRIPT;
    $modx->controller->addHtml($_html);
}',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'core/components/tagelementplugin/elements/plugins/plugin.tagelementplugin.php',
    ),
    60 => 
    array (
      'id' => '60',
      'source' => '2',
      'property_preprocess' => '0',
      'name' => 'TransliterateFileNames',
      'description' => '',
      'editor_type' => '0',
      'category' => '29',
      'cache_type' => '0',
      'plugincode' => 'switch ($modx->event->name) {
    case \'OnFileManagerUpload\':
        $generator = $modx->newObject(\'modResource\');
        $bases = $source->getBases($directory);
        $fullPath = $bases[\'pathAbsolute\'].ltrim($directory,\'/\');
        $directory = $source->fileHandler->make($fullPath);
        foreach ($files as $file) {
            $ext = @pathinfo($file[\'name\'],PATHINFO_EXTENSION);
            rename($directory->getPath().$file[\'name\'], $directory->getPath() .
            $generator->cleanAlias($file[\'name\']));
        }
        break;
    default: break;
}
return true;',
      'locked' => '0',
      'properties' => 'a:0:{}',
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    65 => 
    array (
      'id' => '65',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'TinyMCE Rich Text Editor',
      'description' => 'TinyMCE Rich Text Editor runtime hooks - registers and includes javascripts on document edit pages',
      'editor_type' => '0',
      'category' => '66',
      'cache_type' => '0',
      'plugincode' => '/**
 * TinyMCE Rich Tech Editor Plugin
 *
 * @package tinymcerte
 * @subpackage plugin
 *
 * @var modX $modx
 * @var array $scriptProperties
 */

$className = \'TinyMCERTE\\Plugins\\Events\\\\\' . $modx->event->name;

$corePath = $modx->getOption(\'tinymcerte.core_path\', null, $modx->getOption(\'core_path\') . \'components/tinymcerte/\');
/** @var TinyMCERTE $tinymcerte */
$tinymcerte = $modx->getService(\'tinymcerte\', \'TinyMCERTE\', $corePath . \'model/tinymcerte/\', [
    \'core_path\' => $corePath
]);

if ($tinymcerte) {
    if (class_exists($className)) {
        $handler = new $className($modx, $scriptProperties);
        if (get_class($handler) == $className) {
            $handler->run();
        } else {
            $modx->log(xPDO::LOG_LEVEL_ERROR, $className. \' could not be initialized!\', \'\', \'TinyMCE RTE Plugin\');
        }
    } else {
        $modx->log(xPDO::LOG_LEVEL_ERROR, $className. \' was not found!\', \'\', \'TinyMCE RTE Plugin\');
    }
}

return;',
      'locked' => '0',
      'properties' => 'a:0:{}',
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    74 => 
    array (
      'id' => '74',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'ms2Gallery',
      'description' => 'Main plugin for ms2Gallery',
      'editor_type' => '0',
      'category' => '71',
      'cache_type' => '0',
      'plugincode' => '/** @var modX $modx */
/** @var array $scriptProperties */
switch ($modx->event->name) {

    case \'OnDocFormRender\':
        /** @var modResource $resource */
        $templates = array_map(\'trim\', explode(\',\', $modx->getOption(\'ms2gallery_disable_for_templates\')));
        $disable = $mode == \'new\' ||
            ($templates[0] != \'\' && in_array($resource->get(\'template\'), $templates)) ||
            ($resource->class_key == \'msProduct\' &&
                $modx->getOption(\'ms2gallery_disable_for_ms2\', null, true) &&
                !$modx->getOption(\'ms2gallery_sync_ms2\', null, false)
            );
        if (!$disable) {
            /** @var ms2Gallery $ms2Gallery */
            $ms2Gallery = $modx->getService(\'ms2gallery\', \'ms2Gallery\',
                MODX_CORE_PATH . \'components/ms2gallery/model/ms2gallery/\');
            if ($ms2Gallery) {
                $ms2Gallery->loadManagerFiles($modx->controller, $resource);
            }
        }
        break;

    case \'OnBeforeDocFormSave\':
        if ($source_id = $resource->get(\'media_source\')) {
            $resource->setProperties(array(\'media_source\' => $source_id), \'ms2gallery\');
        }
        break;

    case \'OnLoadWebDocument\':
        if (!$modx->getOption(\'ms2gallery_set_placeholders\', null, false, true)) {
            return;
        }
        $tstart = microtime(true);
        /** @var pdoFetch $pdoFetch */
        $pdoFetch = $modx->getService(\'pdoFetch\');
        $plTemplates = array_map(\'trim\', explode(\',\', $modx->getOption(\'ms2gallery_placeholders_for_templates\')));
        if (!empty($plTemplates[0]) && !in_array($modx->resource->get(\'template\'), $plTemplates)) {
            return;
        }
        $plPrefix = $modx->getOption(\'ms2gallery_placeholders_prefix\', null, \'ms2g.\', true);
        $plThumbs = array_map(\'trim\', explode(\',\', $modx->getOption(\'ms2gallery_placeholders_thumbs\')));
        $tplName = $modx->getOption(\'ms2gallery_placeholders_tpl\');

        // Check for assigned TV
        $q = $modx->newQuery(\'modTemplateVarTemplate\');
        $q->innerJoin(\'modTemplateVar\', \'TemplateVar\');
        $q->innerJoin(\'modTemplate\', \'Template\');
        $q->where(array(
            \'TemplateVar.name\' => $tplName,
            \'Template.id\' => $modx->resource->get(\'template\'),
        ));
        $q->select(\'TemplateVar.id\');
        $tpl = $modx->getCount(\'modTemplateVarTemplate\', $q)
            ? \'@INLINE \' . $modx->resource->getTVValue($tplName)
            : $tplName;

        $options = array(\'loadModels\' => \'ms2gallery\');
        $where = array(\'resource_id\' => $modx->resource->id, \'parent\' => 0);

        $parents = $pdoFetch->getCollection(\'msResourceFile\', $where, $options);
        $options[\'select\'] = \'url\';
        foreach ($parents as &$parent) {
            $where = array(\'parent\' => $parent[\'id\']);
            if (!empty($plThumbs[0])) {
                $where[\'path:IN\'] = array();
                foreach ($plThumbs as $thumb) {
                    $where[\'path:IN\'][] = $parent[\'path\'] . $thumb . \'/\';
                }
            }
            if ($children = $pdoFetch->getCollection(\'msResourceFile\', $where, $options)) {
                foreach ($children as $child) {
                    if (preg_match("#/{$parent[\'resource_id\']}/(.*?)/#", $child[\'url\'], $size)) {
                        $parent[$size[1]] = $child[\'url\'];
                    }
                }
            }
            $pls = $pdoFetch->makePlaceholders($parent, $plPrefix . $parent[\'rank\'] . \'.\', \'[[+\', \']]\', false);
            $pls[\'vl\'][$plPrefix . $parent[\'rank\']] = $pdoFetch->getChunk($tpl, $parent);
            $modx->setPlaceholders($pls[\'vl\']);
        }

        $modx->log(modX::LOG_LEVEL_INFO, \'[ms2Gallery] Set image placeholders for page id = \' . $modx->resource->id .
            \' in \' . number_format(microtime(true) - $tstart, 7) . \' sec.\');
        break;

    case \'OnBeforeEmptyTrash\':
        if (empty($scriptProperties[\'ids\']) || !is_array($scriptProperties[\'ids\'])) {
            return;
        }
        if (!$modx->addPackage(\'ms2gallery\', MODX_CORE_PATH . \'components/ms2gallery/model/\')) {
            return;
        }
        $resources = $modx->getIterator(\'modResource\', array(\'id:IN\' => $scriptProperties[\'ids\']));
        /** @var modResource $resource */
        foreach ($resources as $resource) {
            $properties = $resource->getProperties(\'ms2gallery\');
            if (!empty($properties[\'media_source\'])) {
                /** @var modMediaSource $source */
                $source = $modx->getObject(\'modMediaSource\', $properties[\'media_source\']);
                $resource_id = $resource->get(\'id\');
                if ($source) {
                    $source->set(\'ctx\', $resource->get(\'context_key\'));
                    $source->initialize();
                }
                $images = $modx->getIterator(\'msResourceFile\', array(\'resource_id\' => $resource_id, \'parent\' => 0));
                /** @var msResourceFile $image */
                foreach ($images as $image) {
                    $prepare = $image->prepareSource($source);
                    if ($prepare === true) {
                        $image->remove();
                    } else {
                        $modx->log(modX::LOG_LEVEL_ERROR, "[ms2Gallery] {$prepare}.");
                    }
                }
                if ($source) {
                    $source->removeContainer($source->getBasePath() . $resource_id);
                }
            }
        }
        break;

}',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'core/components/ms2gallery/elements/plugins/plugin.ms2gallery.php',
    ),
  ),
  'policies' => 
  array (
  ),
);