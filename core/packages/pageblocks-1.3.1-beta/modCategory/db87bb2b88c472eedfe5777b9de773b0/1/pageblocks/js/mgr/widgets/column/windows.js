PageBlocks.window.addColumn = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-column-window-create';
    }
    Ext.applyIf(config, {
        title: _('block_field_create'),
        width: 750,
        autoHeight: true,
        url: PageBlocks.config.connector_url,
        action: 'mgr/column/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    PageBlocks.window.addColumn.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.window.addColumn, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'hidden',
            name: 'table_id',
            id: config.id + '-table',
        }, {
            xtype: 'hidden',
            name: 'collection_id',
            id: config.id + '-collection_id',
        }, {
            layout: 'column',
            items: [{
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items:[{
                    xtype: 'pb-combo-getlist',
                    fieldLabel: _('block_column_field'),
                    name: 'field_id',
                    displayField: 'caption',
                    fields: ['id', 'caption'],
                    baseParams: {
                        action: 'mgr/field/getlist',
                        sort: 'rank',
                        dir: 'asc',
                        combo: true,
                        all: 1,
                        table_id: config.record ? config.record.object.table_id : config.table_id,
                        block_id: PageBlocks.constructor_id,
                    }
                }]
            }, {
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items:[{
                    xtype: 'pb-combo-field-render',
                    fieldLabel: _('block_column_render'),
                    name: 'render',
                    hiddenName: 'render',
                    id: config.id + '-render',
                    anchor: '99%',
                    allowBlank: true,
                }]
            }]
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('block_column_fixed'),
            name: 'fixed',
            id: config.id + '-fixed',
            checked: config.record ? config.record.object['fixed'] : false,
            listeners: {
                check: el => {
                    var width = Ext.getCmp(config.id + '-width');
                    el.checked ? width.show() : width.hide();
                },
                render: el => {
                    var width = Ext.getCmp(config.id + '-width');
                    el.checked ? width.show() : width.hide();
                }
            }
        }, {
            xtype: 'numberfield',
            fieldLabel: _('block_field_width'),
            description: _('block_column_width_desc'),
            name: 'width',
            id: config.id + '-width',
            minValue:0,
            maxValue:600,
            anchor: '99%',
            allowBlank: true,
            emptyText: 'от 0 до 600',
            hidden: true,
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
            }]
        }];
    },

});
Ext.reg('pb-column-window-create', PageBlocks.window.addColumn);


PageBlocks.window.updateColumn = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-column-window-update';
    }
    Ext.applyIf(config, {
        title: _('block_field_update') + ': ' + config.record.object.caption,
        action: 'mgr/column/update',
    });
    PageBlocks.window.updateColumn.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.window.updateColumn, PageBlocks.window.addColumn);
Ext.reg('pb-column-window-update', PageBlocks.window.updateColumn);