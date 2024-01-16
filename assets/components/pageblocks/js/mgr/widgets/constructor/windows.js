PageBlocks.window.CreateBlock = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-constructor-window-create';
    }
    Ext.applyIf(config, {
        title: _('pb_create'),
        width: 750,
        autoHeight: true,
        url: PageBlocks.config.connector_url,
        action: 'mgr/constructor/create',
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
        var ace = (typeof(MODx.ux) != 'undefined' && typeof(MODx.ux.Ace) == 'function') ? 1 : 0;

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
                    fieldLabel: _('pb_block_name'),
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
                    fieldLabel: _('pb_chunk'),
                    name: 'chunk',
                    id: config.id + '-chunk',
                    anchor: '99%',
                    allowBlank: false,
                }]
            }]
        }, {
            xtype:'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            style: {margin: '15px 0'},
            items: [{
                xtype: 'pb-grid-field',
                id: Ext.id(),
                title: _('pb_fields'),
                combo: { table: 1 },
                block_id: config.record ? config.record.object.id : 0,
                table_id: 0,
                group_id: 0,
                baseParams: {
                    action: 'mgr/field/getlist',
                    sort: 'rank',
                    dir: 'asc',
                    block_id: config.record ? config.record.object.id : 0,
                    table_id: 0,
                    all:1,
                },
            }, {
                xtype: 'pb-grid-group',
                id: Ext.id(),
                title: _('pb_groups'),
                block_id: config.record ? config.record.object.id : 0,
                table_id: 0
            }, {
                title: _('block_availability_title'),
                layout: 'form',
                cls: '',
                items: [{
                    html: _('block_availability_intro_msg'),
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
            }, {
                title: _('chunk'),
                layout: 'form',
                cls: '',
                items: [{
                    xtype: ace ? 'modx-texteditor': 'textarea',
                    fieldLabel: _('chunk_code'),
                    name: 'chunk_code',
                    id: config.id + '-chunk_code',
                    anchor: '100%',
                    height: 200,
                    allowBlank: false,
                    mimeType: ace ? 'text/x-smarty' : 'text/html',
                    modxTags: true,
                    listeners: {
                        render: function (el) {
                            if(el.getValue() == 'undefined') {
                                el.setValue('');
                            }
                            el.setHeight(el.height);
                        }
                    }
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
Ext.reg('pb-constructor-window-create', PageBlocks.window.CreateBlock);


PageBlocks.window.changeBlock = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-constructor-window-update';
    }
    Ext.applyIf(config, {
        title: _('pb_update') + ': ' + config.record.object.name,
        width: 750,
        action: 'mgr/constructor/update',
    });
    PageBlocks.window.changeBlock.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.window.changeBlock, PageBlocks.window.CreateBlock);
Ext.reg('pb-constructor-window-update', PageBlocks.window.changeBlock);