<?php

/**
 * The version manager controller for PageBlocks.
 */
class PageBlocksVersionManagerController extends modExtraManagerController
{
    /** @var PageBlocks $pb */
    public $pb;

    public function initialize()
    {
        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['pageblocks:default', 'pageblocks:version'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('pageblocks');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        // Загружаем тектовый редактор
        $this->pb->loadRTE();

        $jsUrl = $this->pb->config['jsUrl'];

        $this->addCss($this->pb->config['cssUrl'] . 'mgr/main.css');
        $this->addCss($this->pb->config['cssUrl'] . 'mgr/manager.css');

        $this->addJavascript($jsUrl . 'mgr/pageblocks.js');
        $this->addJavascript($jsUrl . 'mgr/misc/utils.js');
        $this->addJavascript($jsUrl . 'mgr/misc/combo.js');
        $this->addJavascript($jsUrl . 'mgr/misc/default.grid.js');
        $this->addJavascript($jsUrl . 'mgr/misc/default.window.js');

        // Image
        $this->addJavascript($jsUrl . 'mgr/misc/image/panel.js');

        // Image gallery
        $this->addJavascript($jsUrl . 'mgr/misc/plupload/plupload.full.min.js');
        $this->addJavascript($jsUrl . 'mgr/misc/ext.ddview.js');
        $this->addJavascript($jsUrl . 'mgr/misc/image/gallery/panel.js');
        $this->addJavascript($jsUrl . 'mgr/misc/image/gallery/view.js');
        $this->addJavascript($jsUrl . 'mgr/misc/image/gallery/window.js');

        // Video
        $this->addJavascript($jsUrl . 'mgr/misc/video/jsVideoUrlParser.min.js');
        $this->addJavascript($jsUrl . 'mgr/misc/video/panel.js');
        $this->addJavascript($jsUrl . 'mgr/misc/video/window.js');

        // Video gallery
        $this->addJavascript($jsUrl . 'mgr/misc/video/gallery/panel.js');
        $this->addJavascript($jsUrl . 'mgr/misc/video/gallery/view.js');
        $this->addJavascript($jsUrl . 'mgr/misc/video/gallery/window.js');

        // Grids
        $this->addJavascript($jsUrl . 'mgr/widgets/grid/grid.js');
        $this->addJavascript($jsUrl . 'mgr/widgets/grid/windows.js');

        // Version
        $this->addJavascript($jsUrl . 'mgr/widgets/version/grid.js');
        $this->addJavascript($jsUrl . 'mgr/widgets/version/windows.js');

        $this->addJavascript($jsUrl . 'mgr/panel/version.js');
        $this->addJavascript($jsUrl . 'mgr/sections/version.js');

        // ACE
        if ($ace = $this->modx->getObject('transport.modTransportPackage', [
            'package_name' => 'Ace',
            'installed:!=' => null,
            'version_minor' => 9,
            'version_patch:>' => 1,
        ])) {
            $this->addJavascript('/assets/components/ace/ace/ace.min.js');
        }

        $this->addHtml('<script>
        PageBlocks.config = ' . json_encode($this->pb->config) . ';
        PageBlocks.config.connector_url = "' . $this->pb->config['connectorUrl'] . '";
        PageBlocks.config.media_source = ' . json_encode($this->pb->getMediaSources()) . ';
        Ext.onReady(function() {MODx.load({ xtype: "pageblocks-page-version"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="pageblocks-panel-version-div"></div>';

        return '';
    }
}