textAdvs.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'textadvs-panel-home',
            renderTo: 'textadvs-panel-home-div'
        }]
    });
    textAdvs.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(textAdvs.page.Home, MODx.Component);
Ext.reg('textadvs-page-home', textAdvs.page.Home);