popupcontent.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'popupcontent-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('popupcontent') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('popupcontent_items'),
                layout: 'anchor',
                items: [{
                    html: _('popupcontent_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'popupcontent-grid-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    popupcontent.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(popupcontent.panel.Home, MODx.Panel);
Ext.reg('popupcontent-panel-home', popupcontent.panel.Home);
