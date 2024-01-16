textAdvs.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('textadvs') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            enableTabScroll: false,
            items: [{
                title: _('txa_tab_objects'),
                layout: 'anchor',
                items: [{
                    xtype: 'txa-grid-objects',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    textAdvs.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(textAdvs.panel.Home, MODx.Panel);
Ext.reg('textadvs-panel-home', textAdvs.panel.Home);
