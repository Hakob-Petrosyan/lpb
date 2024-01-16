PageBlocks.window.CreateGroup = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-group-window-create';
    }
    Ext.applyIf(config, {
        title: _('block_group_create'),
        width: 700,
        autoHeight: true,
        url: PageBlocks.config.connector_url,
        action: 'mgr/group/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    PageBlocks.window.CreateGroup.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.window.CreateGroup, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'hidden',
            name: 'block_id',
            id: config.id + '-block',
        }, {
            xtype: 'hidden',
            name: 'table_id',
            id: config.id + '-table',
        }, {
            xtype: 'textfield',
            fieldLabel: _('block_group_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: true,
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
Ext.reg('pb-group-window-create', PageBlocks.window.CreateGroup);


PageBlocks.window.updateGroup = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-group-window-update';
    }
    Ext.applyIf(config, {
        title: _('block_group_update') + ': ' + (config.record.object.name || _('block_group_empty')),
        action: 'mgr/group/update',
    });
    PageBlocks.window.updateGroup.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.window.updateGroup, PageBlocks.window.CreateGroup, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'hidden',
            name: 'block_id',
            id: config.id + '-block',
        }, {
            xtype: 'hidden',
            name: 'table_id',
            id: config.id + '-table',
        }, {
            xtype: 'textfield',
            fieldLabel: _('block_group_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: true,
        }, {
            xtype: 'pb-grid-field',
            id: config.id + '-grid-field',
            title: _('pb_fields'),
            combo: { table: 1 },
            block_id: config.block_id,
            table_id: config.table_id,
            group_id: config.record ? config.record.object.id : 0,
            baseParams: {
                action: 'mgr/field/getlist',
                sort: 'rank',
                dir: 'asc',
                block_id: config.block_id,
                table_id: config.table_id,
                group_id: config.record ? config.record.object.id : 0,
            },
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('pb_grid_active'),
            name: 'active',
            id: config.id + '-active',
            checked: config.record ? config.record.object['active'] : true,
        }];
    },

});
Ext.reg('pb-group-window-update', PageBlocks.window.updateGroup);