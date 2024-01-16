PageBlocks.panel.pbVersion = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('pb_versions_menu_desc') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            id: 'pageblocks-tabs',
            stateful: true,
            stateId: 'pageblocks-panel-version',
            stateEvents: ['tabchange'],
            getState: function () {
                return {
                    activeTab: this.items.indexOf(this.getActiveTab())
                };
            },
            items: [{
                title: _('pb_versions'),
                layout: 'anchor',
                items: [{
                    html: _('pb_blocks_version'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'pb-grid-version',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    PageBlocks.panel.pbVersion.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.panel.pbVersion, MODx.Panel);
Ext.reg('pageblocks-panel-version', PageBlocks.panel.pbVersion);
