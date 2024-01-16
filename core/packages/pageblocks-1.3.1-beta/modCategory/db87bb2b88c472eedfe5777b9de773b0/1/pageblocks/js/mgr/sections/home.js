PageBlocks.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'pageblocks-panel-home',
            renderTo: 'pageblocks-panel-home-div'
        }],
        buttons: [{
            xtype: 'button',
            text: '<i class="icon icon-cog"></i> ' + _('block_constructor_title'),
            handler: function () {
                MODx.loadPage('constructor', 'namespace=pageblocks');
            }
        }]
    });
    PageBlocks.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.page.Home, MODx.Component);
Ext.reg('pageblocks-page-home', PageBlocks.page.Home);