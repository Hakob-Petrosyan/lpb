<?php

/**
 * The home manager controller for popupcontent.
 *
 */
class popupcontentHomeManagerController extends modExtraManagerController
{
    /** @var popupcontent $popupcontent */
    public $popupcontent;


    /**
     *
     */
    public function initialize()
    {
        $this->popupcontent = $this->modx->getService('popupcontent', 'popupcontent', MODX_CORE_PATH . 'components/popupcontent/model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['popupcontent:default'];
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
        return $this->modx->lexicon('popupcontent');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->popupcontent->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->popupcontent->config['jsUrl'] . 'mgr/popupcontent.js');
        $this->addJavascript($this->popupcontent->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->popupcontent->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->popupcontent->config['jsUrl'] . 'mgr/misc/types.js');
        $this->addJavascript($this->popupcontent->config['jsUrl'] . 'mgr/misc/events.js');
        $this->addJavascript($this->popupcontent->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->popupcontent->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->popupcontent->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->popupcontent->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        popupcontent.config = ' . json_encode($this->popupcontent->config) . ';
        popupcontent.config.connector_url = "' . $this->popupcontent->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "popupcontent-page-home"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="popupcontent-panel-home-div"></div>';

        return '';
    }
}