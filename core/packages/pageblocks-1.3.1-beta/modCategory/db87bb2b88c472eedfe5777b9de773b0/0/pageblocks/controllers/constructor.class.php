<?php

/**
 * The constructor manager controller for PageBlocks.
 */
class PageBlocksConstructorManagerController extends modExtraManagerController
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
        $jsUrl = $this->pb->config['jsUrl'];

        $this->addCss($this->pb->config['cssUrl'] . 'mgr/main.css');
        $this->addCss($this->pb->config['cssUrl'] . 'mgr/manager.css');

        $this->addJavascript($jsUrl . 'mgr/pageblocks.js');
        $this->addJavascript($jsUrl . 'mgr/misc/utils.js');
        $this->addJavascript($jsUrl . 'mgr/misc/combo.js');
        $this->addJavascript($jsUrl . 'mgr/misc/default.grid.js');
        $this->addJavascript($jsUrl . 'mgr/misc/default.window.js');

        // Constructor
        $this->addJavascript($jsUrl . 'mgr/widgets/constructor/grid.js');
        $this->addJavascript($jsUrl . 'mgr/widgets/constructor/windows.js');

        // Table
        $this->addJavascript($jsUrl . 'mgr/widgets/table/grid.js');
        $this->addJavascript($jsUrl . 'mgr/widgets/table/windows.js');

        // Collection
        $this->addJavascript($jsUrl . 'mgr/widgets/collection/grid.js');
        $this->addJavascript($jsUrl . 'mgr/widgets/collection/windows.js');

        // Resource fields
        $this->addJavascript($jsUrl . 'mgr/widgets/resource/grid.js');
        $this->addJavascript($jsUrl . 'mgr/widgets/resource/windows.js');

        $this->addJavascript($jsUrl . 'mgr/widgets/group/grid.js');
        $this->addJavascript($jsUrl . 'mgr/widgets/group/windows.js');

        $this->addJavascript($jsUrl . 'mgr/widgets/field/grid.js');
        $this->addJavascript($jsUrl . 'mgr/widgets/field/windows.js');

        $this->addJavascript($jsUrl . 'mgr/widgets/column/grid.js');
        $this->addJavascript($jsUrl . 'mgr/widgets/column/windows.js');

        $this->addJavascript($jsUrl . 'mgr/panel/constructor.js');
        $this->addJavascript($jsUrl . 'mgr/sections/constructor.js');

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
        Ext.onReady(function() {MODx.load({ xtype: "pageblocks-page-constructor"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="pageblocks-panel-constructor-div"></div>';

        return '';
    }
}