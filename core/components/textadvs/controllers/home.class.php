<?php

class textAdvsHomeManagerController extends modExtraManagerController
{
    /** @var textAdvs $txa */
    public $txa;

    /**
     *
     */
    public function initialize()
    {
        $this->txa = $this->modx->getService('textadvs', 'textAdvs',
            $this->modx->getOption('txa_core_path', null, MODX_CORE_PATH . 'components/textadvs/') . 'model/textadvs/');

        parent::initialize();
    }

    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return array('textadvs:default');
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
        return $this->modx->lexicon('textadvs');
    }

    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->txa->config['cssUrl'] . 'mgr/main.css');
        $this->addCss($this->txa->config['cssUrl'] . 'mgr/bootstrap.buttons.css');

        $this->addJavascript($this->txa->config['jsUrl'] . 'mgr/textadvs.js');

        $this->addJavascript($this->txa->config['jsUrl'] . 'mgr/misc/ux.js');
        $this->addJavascript($this->txa->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->txa->config['jsUrl'] . 'mgr/misc/renderer.js');
        $this->addJavascript($this->txa->config['jsUrl'] . 'mgr/misc/combo.js');

        $this->addJavascript($this->txa->config['jsUrl'] . 'mgr/misc/default/grid.js');
        $this->addJavascript($this->txa->config['jsUrl'] . 'mgr/misc/default/window.js');
        $this->addJavascript($this->txa->config['jsUrl'] . 'mgr/misc/default/formpanel.js');
        $this->addJavascript($this->txa->config['jsUrl'] . 'mgr/misc/default/panel.js');

        $this->addJavascript($this->txa->config['jsUrl'] . 'mgr/widgets/contents/grid.js');
        $this->addJavascript($this->txa->config['jsUrl'] . 'mgr/widgets/contents/window.js');

        $this->addJavascript($this->txa->config['jsUrl'] . 'mgr/widgets/objects/grid.js');
        $this->addJavascript($this->txa->config['jsUrl'] . 'mgr/widgets/objects/window.js');

        $this->addJavascript($this->txa->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->txa->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('
            <script type="text/javascript">
                textAdvs.config = ' . json_encode($this->txa->config) . ';
                textAdvs.config[\'connector_url\'] = "' . $this->txa->config['connectorUrl'] . '";
                Ext.onReady(function() {
                    MODx.load({
                        xtype: "textadvs-page-home",
                    });
                });
            </script>
        ');
    }

    /**
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->txa->config['templatesPath'] . 'home.tpl';
    }
}