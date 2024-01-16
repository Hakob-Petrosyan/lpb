PageBlocks.page.Version = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'pageblocks-panel-version',
            renderTo: 'pageblocks-panel-version-div'
        }],
        buttons: [{
            xtype: 'button',
            text: '<i class="icon icon-cog"></i> ' + _('block_constructor_title'),
            handler: function () {
                MODx.loadPage('constructor', 'namespace=pageblocks');
            }
        }]
    });
    PageBlocks.page.Version.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.page.Version, MODx.Component);
Ext.reg('pageblocks-page-version', PageBlocks.page.Version);