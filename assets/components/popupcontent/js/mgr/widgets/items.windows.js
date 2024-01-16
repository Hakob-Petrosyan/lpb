popupcontent.window.CreateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'popupcontent-item-window-create';
    }
    Ext.applyIf(config, {
        title: _('popupcontent_item_create'),
        width: 550,
        autoHeight: true,
        url: popupcontent.config.connector_url,
        action: 'mgr/item/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    popupcontent.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(popupcontent.window.CreateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('popupcontent_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            layout:'column'
            ,border: false
            ,anchor: '100%'
            ,items: [{
                    columnWidth: .5
                    ,layout: 'form'
                    ,defaults: { msgTarget: 'under' }
                    ,border:false
                    ,items: [
                        {
                            xtype: 'popupcontent-combo-types',
                            fieldLabel: _('popupcontent_item_type'),
                            name: 'type',
                            id: config.id + '-type',
                            anchor: '99%'            
                        },
                        {
                            xtype: 'popupcontent-combo-events',
                            fieldLabel: _('popupcontent_item_event'),
                            name: 'event',
                            id: config.id + '-event',
                            anchor: '99%',
                            listeners : {
                                    change : function() {
                                        var eventname = Ext.get(config.id + '-event').getValue();
                                        if(eventname == "time"){
                                            Ext.getCmp(config.id + '-clickelement').setDisabled(true);
                                            Ext.getCmp(config.id + '-howshow').setDisabled(false);
                                            Ext.getCmp(config.id + '-showtime').setDisabled(false);
                                            Ext.getCmp(config.id + '-wheretoplay').setDisabled(false);
                                            Ext.getCmp(config.id + '-wheretoplayid').setDisabled(false);
                                        }
                                        if(eventname == "click"){
                                            Ext.getCmp(config.id + '-clickelement').setDisabled(false);
                                            Ext.getCmp(config.id + '-howshow').setDisabled(true);
                                            Ext.getCmp(config.id + '-showtime').setDisabled(true);
                                            Ext.getCmp(config.id + '-wheretoplay').setDisabled(true);
                                            Ext.getCmp(config.id + '-wheretoplayid').setDisabled(true);
                                        }
                                    }
                                }           
                        },{
                            xtype: 'textfield',
                            fieldLabel: _('popupcontent_item_clickelement'),
                            name: 'clickelement',
                            id: config.id + '-clickelement',
                            anchor: '99%'
                        },{
                            xtype: 'popupcontent-combo-wheretoplay',
                            fieldLabel: _('popupcontent_item_wheretoplay'),
                            name: 'wheretoplay',
                            hiddenName: 'wheretoplay',
                            id: config.id + '-wheretoplay',
                            anchor: '99%'
                        },{
                            xtype: 'popupcontent-combo-clickdo',
                            fieldLabel: _('popupcontent_item_clickdo'),
                            name: 'clickdo',
                            hiddenName: 'clickdo',
                            id: config.id + '-clickdo',
                            anchor: '99%'
                        },{
                            xtype: 'textfield',
                            fieldLabel: _('popupcontent_item_notplayid'),
                            name: 'notplayid',                            
                            id: config.id + '-notplayid',
                            anchor: '99%',
                        }
                    ]
                },{
                    columnWidth: .5
                    ,layout: 'form'
                    ,defaults: { msgTarget: 'under' }
                    ,border:false
                    ,items: [
                        {
                            xtype: 'textfield',
                            fieldLabel: _('popupcontent_item_chunk'),
                            name: 'chunk',
                            id: config.id + '-chunk',
                            anchor: '99%'
                        },
                        {
                            xtype: 'popupcontent-combo-howshow',
                            fieldLabel: _('popupcontent_item_howshow'),
                            name: 'howshow',
                            hiddenName: 'howshow',
                            id: config.id + '-howshow',            
                            anchor: '99%'            
                        },{
                            xtype: 'textfield',
                            fieldLabel: _('popupcontent_item_showtime'),
                            name: 'showtime',
                            id: config.id + '-showtime',
                            anchor: '99%'
                        },{
                            xtype: 'textfield',
                            fieldLabel: _('popupcontent_item_wheretoplayid'),
                            name: 'wheretoplayid',
                            id: config.id + '-wheretoplayid',
                            anchor: '99%'
                        },{
                            xtype: 'textfield',
                            fieldLabel: _('popupcontent_item_clickdoelement'),
                            name: 'clickdoelement',
                            hiddenName: 'clickdoelement',
                            id: config.id + '-clickdoelement',
                            anchor: '99%'
                        }
                    ]
                }]
            }, {
            xtype: 'xcheckbox',
            boxLabel: _('popupcontent_item_active'),
            name: 'active',
            id: config.id + '-active',
            checked: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('popupcontent-item-window-create', popupcontent.window.CreateItem);


popupcontent.window.UpdateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'popupcontent-item-window-update';
    }
    Ext.applyIf(config, {
        title: _('popupcontent_item_update'),
        width: 550,
        autoHeight: true,
        url: popupcontent.config.connector_url,
        action: 'mgr/item/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    popupcontent.window.UpdateItem.superclass.constructor.call(this, config);
};
Ext.extend(popupcontent.window.UpdateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('popupcontent_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            layout:'column'
            ,border: false
            ,anchor: '100%'
            ,items: [{
                    columnWidth: .5
                    ,layout: 'form'
                    ,defaults: { msgTarget: 'under' }
                    ,border:false
                    ,items: [
                        {
                            xtype: 'popupcontent-combo-types',
                            fieldLabel: _('popupcontent_item_type'),
                            name: 'type',
                            id: config.id + '-type',
                            anchor: '99%'
                        },
                        {
                            xtype: 'popupcontent-combo-events',
                            fieldLabel: _('popupcontent_item_event'),
                            name: 'event',
                            id: config.id + '-event',
                            anchor: '99%',
                            listeners : {
                                    change : function() {
                                        var eventname = Ext.get(config.id + '-event').getValue();
                                        if(eventname == "time"){
                                            Ext.getCmp(config.id + '-clickelement').setDisabled(true);
                                            Ext.getCmp(config.id + '-howshow').setDisabled(false);
                                            Ext.getCmp(config.id + '-showtime').setDisabled(false);
                                            Ext.getCmp(config.id + '-wheretoplay').setDisabled(false);
                                            Ext.getCmp(config.id + '-wheretoplayid').setDisabled(false);
                                        }
                                        if(eventname == "click"){
                                            Ext.getCmp(config.id + '-clickelement').setDisabled(false);
                                            Ext.getCmp(config.id + '-howshow').setDisabled(true);
                                            Ext.getCmp(config.id + '-showtime').setDisabled(true);
                                            Ext.getCmp(config.id + '-wheretoplay').setDisabled(true);
                                            Ext.getCmp(config.id + '-wheretoplayid').setDisabled(true);
                                        }
                                    }
                                }        
                        },{
                            xtype: 'textfield',
                            fieldLabel: _('popupcontent_item_clickelement'),
                            name: 'clickelement',
                            id: config.id + '-clickelement',
                            anchor: '99%',
                        },{
                            xtype: 'popupcontent-combo-wheretoplay',
                            fieldLabel: _('popupcontent_item_wheretoplay'),
                            name: 'wheretoplay',
                            hiddenName: 'wheretoplay',
                            id: config.id + '-wheretoplay',
                            anchor: '99%',
                        },{
                            xtype: 'popupcontent-combo-clickdo',
                            fieldLabel: _('popupcontent_item_clickdo'),
                            name: 'clickdo',
                            hiddenName: 'clickdo',
                            id: config.id + '-clickdo',
                            anchor: '99%'
                        },{
                            xtype: 'textfield',
                            fieldLabel: _('popupcontent_item_notplayid'),
                            name: 'notplayid',                            
                            id: config.id + '-notplayid',
                            anchor: '99%',
                        }
                    ]
                },{
                    columnWidth: .5
                    ,layout: 'form'
                    ,defaults: { msgTarget: 'under' }
                    ,border:false
                    ,items: [
                        {
                            xtype: 'textfield',
                            fieldLabel: _('popupcontent_item_chunk'),
                            name: 'chunk',
                            id: config.id + '-chunk',
                            anchor: '99%',
                        },
                        {
                            xtype: 'popupcontent-combo-howshow',
                            fieldLabel: _('popupcontent_item_howshow'),
                            name: 'howshow',
                            hiddenName: 'howshow',
                            id: config.id + '-howshow',            
                            anchor: '99%',
                        },{
                            xtype: 'textfield',
                            fieldLabel: _('popupcontent_item_showtime'),
                            name: 'showtime',
                            id: config.id + '-showtime',
                            anchor: '99%'
                        },{
                            xtype: 'textfield',
                            fieldLabel: _('popupcontent_item_wheretoplayid'),
                            name: 'wheretoplayid',
                            id: config.id + '-wheretoplayid',
                            anchor: '99%'
                        },{
                            xtype: 'textfield',
                            fieldLabel: _('popupcontent_item_clickdoelement'),
                            name: 'clickdoelement',
                            hiddenName: 'clickdoelement',
                            id: config.id + '-clickdoelement',
                            anchor: '99%'
                        }
                    ]
                }]
            },{
            xtype: 'xcheckbox',
            boxLabel: _('popupcontent_item_active'),
            name: 'active',
            id: config.id + '-active',
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('popupcontent-item-window-update', popupcontent.window.UpdateItem);