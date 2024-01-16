PageBlocks.window.CreateField = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-field-window-create';
    }
    Ext.applyIf(config, {
        title: _('block_field_create'),
        width: 750,
        autoHeight: true,
        url: PageBlocks.config.connector_url,
        action: 'mgr/field/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    PageBlocks.window.CreateField.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.window.CreateField, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'hidden',
            name: 'block_id',
            id: config.id + '-block_id',
        }, {
            xtype: 'hidden',
            name: 'table_id',
            id: config.id + '-table_id',
        }, {
            layout: 'column',
            items: [{
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items:[{
                    xtype: 'textfield',
                    fieldLabel: _('block_field_caption'),
                    name: 'caption',
                    id: config.id + '-caption',
                    anchor: '100%',
                    width: 100,
                    allowBlank: true,
                }]
            }, {
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items:[{
                    xtype: 'textfield',
                    fieldLabel: _('block_field_name'),
                    name: 'name',
                    id: config.id + '-name',
                    anchor: '100%',
                    width: 100,
                    allowBlank: false,
                }, {
                    xtype: 'label',
                    cls: 'desc-under',
                    text: _('block_field_name_desc')
                }]
            }]
        }, {
            layout: 'column',
            items: [{
                columnWidth: .40,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'pb-combo-field-types',
                    fieldLabel: _('block_field_xtype'),
                    name: 'xtype',
                    hiddenName: 'xtype',
                    id: config.id + '-xtype',
                    combo: config.combo,
                    anchor: '100%',
                    width: 100,
                    allowBlank: false,
                    listeners: {
                        render: {
                            fn: this.changeFields,
                            scope: this,
                        },
                        select: {
                            fn: this.changeFields,
                            scope: this,
                        }
                    }
                }]
            }, {
                columnWidth: .20,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'numberfield',
                    fieldLabel: _('block_field_width'),
                    description: _('block_field_width_desc'),
                    name: 'width',
                    id: config.id + '-width',
                    minValue:0,
                    maxValue:100,
                    anchor: '100%',
                    width: 100,
                    allowBlank: false,
                    listeners: {
                        render: function(width){
                            if(Ext.isEmpty(width.value)) {
                                width.setValue(100);
                            }
                        }
                    }
                }]
            }, {
                columnWidth: .40,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'pb-combo-getlist',
                    fieldLabel: _('pb_group'),
                    name: 'group_id',
                    allowBlank: true,
                    baseParams: {
                        action: 'mgr/group/getlist',
                        sort: 'rank',
                        dir: 'asc',
                        combo: true,
                        block_id: config.record ? config.record.object.block_id : config.block_id,
                        table_id: config.record ? config.record.object.table_id : config.table_id,
                    },
                    listeners: {
                        render: function(el){
                            if(Ext.isEmpty(el.value)) {
                                el.setValue(config.group_id);
                            }
                        }
                    }
                }]
            }]
        },{
            layout: 'column',
            items: [{
                columnWidth: .3,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'pb-combo-boolean',
                    fieldLabel: _('number_allownegative'),
                    name: 'number_allownegative',
                    hiddenName: 'number_allownegative',
                    id: config.id + '-number_allownegative',
                    anchor: '100%',
                    width: 100,
                    allowBlank: true,
                }],
            },{
                columnWidth: .35,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'numberfield',
                    fieldLabel: _('number_minvalue'),
                    name: 'number_minvalue',
                    id: config.id + '-number_minvalue',
                    anchor: '100%',
                    width: 100,
                    allowBlank: true,
                }],
            },{
                columnWidth: .35,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'numberfield',
                    fieldLabel: _('number_maxvalue'),
                    name: 'number_maxvalue',
                    id: config.id + '-number_maxvalue',
                    anchor: '100%',
                    width: 100,
                    allowBlank: true,
                }],
            }]
        }, {
            layout: 'column',
            items: [{
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items:[{
                    xtype: 'modx-combo-source',
                    fieldLabel: _('source'),
                    id: config.id + '-source',
                    name: 'source',
                    hiddenName: 'source',
                    anchor: '100%',
                    width: 100,
                    listeners: {
                        render: function (el) {
                            if(Ext.isEmpty(el.value) || el.value == 0) {
                                el.setValue(MODx.config.default_media_source);
                            }
                        }
                    }
                }]
            },{
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items:[{
                    xtype: 'textfield',
                    fieldLabel: _('pb_field_source_path'),
                    id: config.id + '-source_path',
                    name: 'source_path',
                    anchor: '100%',
                    width: 100,
                }]
            }]
        }, {
            xtype: 'textarea',
            fieldLabel: _('block_field_values'),
            name: 'values',
            height: 150,
            id: config.id + '-values',
            anchor: '100%',
            width: 100,
            hidden: true,
            allowBlank: true,
        }, {
            xtype: 'label',
            id: config.id + '-values-desc',
            cls: 'desc-under',
            text: _('block_field_values_desc')
        }, {
            xtype: 'pb-combo-getlist',
            fieldLabel: _('pb_table'),
            name: 'field_table_id',
            id: config.id + '-field_table_id',
            hidden: true,
            allowBlank: true,
            baseParams: {
                action: 'mgr/table/getlist',
                sort: 'rank',
                dir: 'asc',
                combo: true,
            }
        }, {
            xtype: 'textarea',
            fieldLabel: _('resourcelist_where'),
            name: 'where',
            height: 150,
            id: config.id + '-where',
            anchor: '100%',
            width: 100,
            hidden: true,
            allowBlank: true,
        }, {
            xtype: 'label',
            id: config.id + '-where-desc',
            cls: 'desc-under',
            text: _('resourcelist_where_desc')
        }, {
            xtype: 'textfield',
            fieldLabel: _('block_field_combo'),
            name: 'combo',
            id: config.id + '-combo',
            anchor: '100%',
            width: 100,
            hidden: true,
            allowBlank: true,
        }, {
            xtype: 'label',
            id: config.id + '-combo-desc',
            cls: 'desc-under',
            text: _('block_field_combo_desc'),
            hidden: true,
        }, {
            xtype: 'textfield',
            fieldLabel: _('block_field_default'),
            name: 'default',
            id: config.id + '-default',
            anchor: '100%',
            width: 100,
            allowBlank: true,
        }, {
            xtype: 'label',
            id: config.id + '-default-desc',
            cls: 'desc-under',
            text: _('tv_default_desc'),
        }, {
            xtype: 'numberfield',
            fieldLabel: _('checkbox_columns'),
            name: 'columns',
            id: config.id + '-columns',
            anchor: '100%',
            width: 100,
            minValue:1,
            maxValue:10,
            hidden: true,
            allowBlank: false,
            listeners: {
                render: function (columns) {
                    if(Ext.isEmpty(columns.value)) {
                        columns.setValue(3);
                    }
                }
            }
        }, {
            xtype: 'label',
            id: config.id + '-columns-desc',
            cls: 'desc-under',
            text: _('checkbox_columns_desc')
        }, {
            xtype: 'textarea',
            fieldLabel: _('block_field_help'),
            name: 'help',
            height: 50,
            id: config.id + '-help',
            anchor: '100%',
            width: 100,
            allowBlank: true,
        }, {
            xtype: 'checkboxgroup',
            hideLabel: true,
            name: 'checkboxgroup',
            columns: 3,
            items: [{
                xtype: 'xcheckbox',
                boxLabel: _('pb_grid_active'),
                name: 'active',
                id: config.id + '-active',
                checked: config.record ? config.record.object['active'] : true,
            }, {
                xtype: 'xcheckbox',
                boxLabel: _('block_field_required'),
                name: 'required',
                id: config.id + '-required',
                checked: config.record ? config.record.object['required'] : false,
                hidden: true,
            }]
        }];
    },

    changeFields: function (combo, row) {
        var values = Ext.getCmp(this.id + '-values');
        var values_desc = Ext.getCmp(this.id + '-values-desc');
        var defaultfield = Ext.getCmp(this.id + '-default');
        var defaultfield_desc = Ext.getCmp(this.id + '-default-desc');
        var where = Ext.getCmp(this.id + '-where');
        var where_desc = Ext.getCmp(this.id + '-where-desc');
        var table = Ext.getCmp(this.id + '-field_table_id');
        var number_allownegative = Ext.getCmp(this.id + '-number_allownegative');
        var number_minvalue = Ext.getCmp(this.id + '-number_minvalue');
        var number_maxvalue = Ext.getCmp(this.id + '-number_maxvalue');
        var pbcombo = Ext.getCmp(this.id + '-combo');
        var pbcombo_desc = Ext.getCmp(this.id + '-combo-desc');
        var columns = Ext.getCmp(this.id + '-columns');
        var columns_desc = Ext.getCmp(this.id + '-columns-desc');
        var width = Ext.getCmp(this.id + '-width');
        var required = Ext.getCmp(this.id + '-required');
        var source = Ext.getCmp(this.id + '-source');
        var source_path = Ext.getCmp(this.id + '-source_path');

        values.hide();
        values_desc.hide();
        where.hide();
        where_desc.hide();
        table.hide();
        number_allownegative.hide();
        number_minvalue.hide();
        number_maxvalue.hide();
        pbcombo.hide();
        pbcombo_desc.hide();
        columns.hide();
        columns_desc.hide();
        width.setDisabled(false);
        source.hide();
        source_path.hide();

        defaultfield.show();
        defaultfield_desc.show();
        required.show();

        switch (combo.value) {
            case 'listbox':
            case 'listbox-multiple':
                values.show();
                values_desc.show();
                break;
            case 'numberfield':
                number_allownegative.show().setWidth('100%');
                number_minvalue.show();
                number_maxvalue.show();
                break;
            case 'checkboxgroup':
                values.show();
                values_desc.show();
                columns.show();
                columns_desc.show().setText(_('checkbox_columns_desc'));
                break;
            case 'checkbox-bool':
                break;
            case 'radiogroup':
                values.show();
                values_desc.show();
                columns.show();
                columns_desc.show();
                columns_desc.setText(_('radio_columns_desc'));
                break;
            case 'pb-combo-resource':
                where.show();
                where_desc.show();
                break;
            case 'pb-grid-table':
                table.show().setWidth('100%');
                defaultfield.hide();
                defaultfield_desc.hide();
                required.hide();
                break;
            case 'pb-image-gallery':
            case 'pb-video-gallery':
                defaultfield.hide();
                defaultfield_desc.hide();
                width.setValue(100);
                required.hide();
                source.show().setValue(MODx.config.default_media_source);
                source_path.show();
                break;
            case 'pb-panel-image':
                source.show().setValue(MODx.config.default_media_source);
                source_path.show();
                break;
            case 'pb-panel-video':
            case 'modx-combo-browser':
                defaultfield.hide();
                defaultfield_desc.hide();
                source.show().setValue(MODx.config.default_media_source);
                source_path.show();
                break;
            case 'pb-xtype':
                pbcombo.show();
                pbcombo_desc.show();
                break;
        }

    }

});
Ext.reg('pb-field-window-create', PageBlocks.window.CreateField);


PageBlocks.window.updateField = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-field-window-update';
    }
    Ext.applyIf(config, {
        title: _('block_field_update') + ': ' + config.record.object.caption,
        action: 'mgr/field/update',
    });
    PageBlocks.window.updateField.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.window.updateField, PageBlocks.window.CreateField);
Ext.reg('pb-field-window-update', PageBlocks.window.updateField);