popupcontent.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'popupcontent-panel-home',
            renderTo: 'popupcontent-panel-home-div'
        }]
    });
    popupcontent.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(popupcontent.page.Home, MODx.Component);
Ext.reg('popupcontent-page-home', popupcontent.page.Home);