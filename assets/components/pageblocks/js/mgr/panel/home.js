PageBlocks.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('pageblocks') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            id: 'pageblocks-tabs',
            // stateful: true,
            // stateId: 'pageblocks-panel-home',
            // stateEvents: ['tabchange'],
            // getState: function () {
            //     return {
            //         activeTab: this.items.indexOf(this.getActiveTab())
            //     };
            // },
            items: [{
                title: _('pb_baseblocks'),
                layout: 'anchor',
                items: [{
                    xtype: 'pb-grid-blocks',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    PageBlocks.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.panel.Home, MODx.Panel);
Ext.reg('pageblocks-panel-home', PageBlocks.panel.Home);
