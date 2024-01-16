PageBlocks.window.CreateBlock = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-collection-window-create';
    }
    Ext.applyIf(config, {
        title: _('pb_create'),
        width: 650,
        autoHeight: true,
        url: PageBlocks.config.connector_url,
        action: 'mgr/collection/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    PageBlocks.window.CreateBlock.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.window.CreateBlock, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            layout: 'column',
            items: [{
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items:[{
                    xtype: 'textfield',
                    fieldLabel: _('pb_name'),
                    name: 'name',
                    id: config.id + '-name',
                    anchor: '99%',
                    allowBlank: false,
                }]
            }, {
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'textfield',
                    fieldLabel: _('pb_collection_button'),
                    name: 'btn_add',
                    id: config.id + '-btn_add',
                    anchor: '99%',
                    allowBlank: false,
                    listeners: {
                        render: function (el) {
                            if(Ext.isEmpty(el.value)) {
                                el.setValue(_('pb_added'));
                            }
                        }
                    }
                }]
            }]
        }, {
            layout: 'column',
            items: [{
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items:[{
                    xtype: 'pb-combo-getlist',
                    fieldLabel: _('pb_blocks'),
                    name: 'constructor_id',
                    baseParams: {
                        action: 'mgr/constructor/getlist',
                        sort: 'rank',
                        dir: 'asc',
                        combo: true,
                    },
                    listeners: {
                        render: (el) => {
                            PageBlocks.constructor_id = el.value;
                        },
                        select: (el) => {
                            PageBlocks.constructor_id = el.value;
                        }
                    }

                }]
            }, {
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'numberfield',
                    fieldLabel: _('pb_collection_index'),
                    name: 'index',
                    id: config.id + '-index',
                    anchor: '99%',
                    allowBlank: false,
                    listeners: {
                        render: function (el) {
                            if(Ext.isEmpty(el.value)) {
                                el.setValue(0);
                            }
                        }
                    }
                }]
            }]
        }, {
            xtype:'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            style: {margin: '15px 0'},
            items: [{
                title: _('pb_collection_tab_columns'),
                layout: 'form',
                cls: '',
                items: [{
                    fieldLabel: _('pb_columns'),
                    xtype: 'pb-grid-column',
                    id: Ext.id(),
                    collection_id: config.record ? config.record.object.id : 0
                }]
            }, {
                title: _('block_availability_title'),
                layout: 'form',
                cls: '',
                items: [{
                    html: _('collection_availability_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'textfield',
                    fieldLabel: _('block_availability_templates'),
                    name: 'ab_templates',
                    id: config.id + '-ab_templates',
                    anchor: '100%',
                    allowBlank: true,
                }, {
                    xtype: 'textfield',
                    fieldLabel: _('block_availability_parents'),
                    name: 'ab_parents',
                    id: config.id + '-ab_parents',
                    anchor: '100%',
                    allowBlank: true,
                }, {
                    xtype: 'textfield',
                    fieldLabel: _('block_availability_resources'),
                    name: 'ab_resources',
                    id: config.id + '-ab_resources',
                    anchor: '100%',
                    allowBlank: true,
                }, {
                    layout: 'column',
                    items: [{
                        columnWidth: .5,
                        layout: 'form',
                        defaults: {msgTarget: 'under'},
                        cls: 'x-superboxselect',
                        items:[{
                            xtype: 'modx-combo-class-derivatives',
                            fieldLabel: _('block_availability_class'),
                            name: 'ab_class',
                            hiddenName: 'ab_class',
                            id: config.id + '-ab_class',
                            anchor: '100%',
                            style: {margin:'0 10px 0 0'},
                            allowBlank: true,
                            triggerConfig: {
                                tag: 'div',
                                cls: 'x-superboxselect-btns',
                                cn: [
                                    {tag: 'div', cls: 'x-superboxselect-btn-expand x-form-trigger'},
                                    {tag: 'div', cls: 'x-superboxselect-btn-clear x-form-trigger'}
                                ]
                            },
                            onTriggerClick: function(event, btn){
                                if (btn && Ext.get(btn).hasClass('x-superboxselect-btn-clear')) {
                                    Ext.getCmp(config.id + '-ab_class').setValue();
                                } else {
                                    MODx.combo.ComboBox.superclass.onTriggerClick.call(this);
                                }
                            }
                        }]
                    }, {
                        columnWidth: .5,
                        layout: 'form',
                        defaults: {msgTarget: 'under'},
                        cls: 'x-superboxselect',
                        items: [{
                            xtype: 'modx-combo-context',
                            fieldLabel: _('block_availability_context'),
                            name: 'ab_context',
                            hiddenName: 'ab_context',
                            id: config.id + '-ab_context',
                            anchor: '100%',
                            allowBlank: true,
                            triggerConfig: {
                                tag: 'div',
                                cls: 'x-superboxselect-btns',
                                cn: [
                                    {tag: 'div', cls: 'x-superboxselect-btn-expand x-form-trigger'},
                                    {tag: 'div', cls: 'x-superboxselect-btn-clear x-form-trigger'}
                                ]
                            },
                            onTriggerClick: function(event, btn){
                                if (btn && Ext.get(btn).hasClass('x-superboxselect-btn-clear')) {
                                    Ext.getCmp(config.id + '-ab_context').setValue();
                                } else {
                                    MODx.combo.ComboBox.superclass.onTriggerClick.call(this);
                                }
                            }
                        }]
                    }]
                }]
            }]
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('pb_grid_active'),
            name: 'active',
            id: config.id + '-active',
            checked: config.record ? config.record.object['active'] : true,
        }];
    },

    loadDropZones: function() {}

});
Ext.reg('pb-collection-window-create', PageBlocks.window.CreateBlock);


PageBlocks.window.changeBlock = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-collection-window-update';
    }
    Ext.applyIf(config, {
        title: _('pb_update') + ': ' + config.record.object.name,
        action: 'mgr/collection/update',
    });
    PageBlocks.window.changeBlock.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.window.changeBlock, PageBlocks.window.CreateBlock);
Ext.reg('pb-collection-window-update', PageBlocks.window.changeBlock);