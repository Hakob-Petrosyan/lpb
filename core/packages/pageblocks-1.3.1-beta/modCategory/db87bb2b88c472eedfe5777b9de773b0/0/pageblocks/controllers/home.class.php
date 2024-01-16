<?php

/**
 * The home manager controller for PageBlocks.
 */
class PageBlocksHomeManagerController extends modExtraManagerController
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
        return ['pageblocks:default', 'core:tv_input_types', 'core:tv_widget', 'core:chunk'];
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

        $res = [
            'id' => 0,
            'context_key' => 'web',
        ];

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

        // Blocks
        $this->addJavascript($jsUrl . 'mgr/widgets/block/grid.js');
        $this->addJavascript($jsUrl . 'mgr/widgets/block/windows.js');

        // Grids
        $this->addJavascript($jsUrl . 'mgr/widgets/grid/grid.js');
        $this->addJavascript($jsUrl . 'mgr/widgets/grid/windows.js');

        // Home
        $this->addJavascript($jsUrl . 'mgr/panel/home.js');
        $this->addJavascript($jsUrl . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        PageBlocks.config = ' . json_encode($this->pb->config) . ';
        PageBlocks.config.connector_url = "' . $this->pb->config['connectorUrl'] . '";
        PageBlocks.resource = ' . json_encode($res) .';
        PageBlocks.config.media_source = ' . json_encode($this->pb->getMediaSources()) . ';
        Ext.onReady(function() {MODx.load({ xtype: "pageblocks-page-home"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="pageblocks-panel-home-div"></div>';

        return '';
    }
}