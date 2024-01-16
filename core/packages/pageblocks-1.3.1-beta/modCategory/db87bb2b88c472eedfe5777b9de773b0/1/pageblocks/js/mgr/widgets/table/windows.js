PageBlocks.window.CreateTable = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-table-window-create';
    }
    Ext.applyIf(config, {
        title: _('block_table_create'),
        width: 750,
        autoHeight: true,
        url: PageBlocks.config.connector_url,
        action: 'mgr/table/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    PageBlocks.window.CreateTable.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.window.CreateTable, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('block_table_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            id: Ext.id(),
            items: [{
                title: _('block_table_tab_fields'),
                layout: 'anchor',
                items: [{
                    xtype: 'pb-grid-field',
                    id: Ext.id(),
                    block_id: 0,
                    table_id: config.record ? config.record.object.id : 0,
                    baseParams: {
                        action: 'mgr/field/getlist',
                        sort: 'rank',
                        dir: 'asc',
                        block_id: 0,
                        table_id: config.record ? config.record.object.id : 0,
                        all:1,
                    },
                }]
            }, {
                xtype: 'pb-grid-group',
                id: Ext.id(),
                title: _('pb_groups'),
                block_id: 0,
                table_id: config.record ? config.record.object.id : 0
            }, {
                title: _('pb_columns'),
                layout: 'anchor',
                items: [{
                    xtype: 'pb-grid-column',
                    id: Ext.id(),
                    block_id: 0,
                    table_id: config.record ? config.record.object.id : 0
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

});
Ext.reg('pb-table-window-create', PageBlocks.window.CreateTable);


PageBlocks.window.updateTable = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-table-window-update';
    }
    Ext.applyIf(config, {
        title: _('block_table_update') + ': ' + config.record.object.name,
        action: 'mgr/table/update',
    });
    PageBlocks.window.updateTable.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.window.updateTable, PageBlocks.window.CreateTable);
Ext.reg('pb-table-window-update', PageBlocks.window.updateTable);