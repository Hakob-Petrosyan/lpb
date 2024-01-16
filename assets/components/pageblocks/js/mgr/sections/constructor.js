PageBlocks.page.Constructor = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'pageblocks-panel-constructor',
            renderTo: 'pageblocks-panel-constructor-div'
        }],
        buttons: [{
            xtype: 'button',
            text: '<i class="icon icon-large icon-th"></i> ' + _('pb_baseblocks'),
            handler: function () {
                MODx.loadPage('home', 'namespace=pageblocks');
            }
        }]
    });
    PageBlocks.page.Constructor.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.page.Constructor, MODx.Component);
Ext.reg('pageblocks-page-constructor', PageBlocks.page.Constructor);