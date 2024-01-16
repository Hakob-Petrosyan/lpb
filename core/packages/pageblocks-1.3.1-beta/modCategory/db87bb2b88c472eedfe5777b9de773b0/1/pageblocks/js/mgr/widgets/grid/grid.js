PageBlocks.grid.Grid = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = Ext.id();
    }
    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/grid/getlist',
            block_id: config.block_id || config.baseblock,
            version_id: config.version_id,
            table_id: config.field_table_id,
            field_id: config.field_id,
            grid_id: config.table_id ? config.grid_id : '',
            resource_id: PageBlocks.resource.id,
            context_key: PageBlocks.resource.context_key,
            cultureKey: MODx.config.cultureKey,
            sort: 'rank',
            dir: 'asc',
        },
        border: false,
        style: {padding: '0'},
        multi_select: true,
        changed: false,
        stateful: false,
        stateId: config.id,
        ddGroup: 'pb-grid-tableDD',
        ddAction: 'mgr/grid/sort',
        enableDragDrop: true,
        remoteSort: true,
        autoHeight: true,
        displayInfo: true,
        paging: true,
        pageSize: 5,
    });

    config.listeners = {
        rowDblClick: function (grid, rowIndex, e) {
            var row = grid.store.getAt(rowIndex);

            if (row.data.version_id) {
                this.viewItem(grid, e, row);
            } else {
                this.updateItem(grid, e, row);
            }
        }
    };

    PageBlocks.grid.Grid.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(PageBlocks.grid.Grid, PageBlocks.grid.Default, {
    windows: {},

    createItem: function (btn, e) {
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/table/get',
                fields: 1,
                id: this.field_table_id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        r.object.id = 0;
                        r.object.table_id = this.field_table_id;
                        r.object.grid_id = this.grid_id || 0;
                        r.object.block_id = this.block_id || 0;
                        r.object.source = this.config.source;
                        r.object.source_path = this.config.source_path;
                        r.object.table_name = this.fieldLabel;
                        var w = MODx.load({
                            xtype: 'pb-grid-window-create',
                            record: r,
                            id: Ext.id(),
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                        w.reset();
                        w.setValues({
                            block_id: this.block_id || 0,
                            table_id: this.field_table_id,
                            field_id: this.field_id,
                            grid_id: this.grid_id || 0,
                            resource_id: PageBlocks.resource.id,
                            context_key: PageBlocks.resource.context_key,
                            cultureKey: MODx.config.cultureKey,
                            active: true,
                        });
                        w.show(e.target);

                    }, scope: this
                },
                failure: {
                    fn: function (r) {
                        console.log(r);
                    }, scope: this
                }
            }
        });
    },

    viewItem: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var record = this.menu.record;
        console.log(record);

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/grid/get',
                fields: 1,
                id: record.id,
                version_id: record.version_id,
            },
            listeners: {
                success: {
                    fn: function (r) {
                        r.object.grid_id = record.grid_id;
                        r.object.baseblock = this.baseblock;
                        r.object.unique = this.unique;
                        r.object.source = this.config.source;
                        r.object.source_path = this.config.source_path;
                        r.object.table_name = this.fieldLabel;
                        var w = MODx.load({
                            xtype: 'pb-grid-window-update',
                            id: Ext.id(),
                            record: r,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                        w.reset();

                        var values = Object.assign(r.object, JSON.parse(r.object.values));
                        values.resource_id = PageBlocks.resource.id;
                        values.context_key = PageBlocks.resource.context_key;
                        values.cultureKey = MODx.config.cultureKey;
                        w.setValues(values);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    updateItem: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;
        var grid_id = this.menu.record.grid_id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/grid/get',
                fields: 1,
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        r.object.grid_id = grid_id;
                        r.object.baseblock = this.baseblock;
                        r.object.unique = this.unique;
                        r.object.source = this.config.source;
                        r.object.source_path = this.config.source_path;
                        r.object.table_name = this.fieldLabel;
                        var w = MODx.load({
                            xtype: 'pb-grid-window-update',
                            id: Ext.id(),
                            record: r,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                        w.reset();

                        var values = Object.assign(r.object, JSON.parse(r.object.values));
                        values.resource_id = PageBlocks.resource.id;
                        values.context_key = PageBlocks.resource.context_key;
                        values.cultureKey = MODx.config.cultureKey;
                        w.setValues(values);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    removeItem: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }

        Ext.MessageBox.confirm(
            _('pb_remove'),
            _('pb_remove_confirm'),
            function (val) {
                if (val == 'yes') {
                    this.itemAction('grid/remove');
                }
            }, this
        );
    },

    copyItem: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }

        Ext.MessageBox.confirm(
            _('pb_copy'),
            _('pb_copy_confirm'),
            function (val) {
                if (val == 'yes') {
                    this.itemAction('grid/copy');
                }
            }, this
        );
    },

    disableItem: function () {
        this.itemAction('grid/disable');
    },

    enableItem: function () {
        this.itemAction('grid/enable');
    },

    itemAction: function (method) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/multiple',
                method: method,
                ids: Ext.util.JSON.encode(ids),

                block_id: this.block_id || 0,
                resource_id: PageBlocks.resource.id,
                context_key: PageBlocks.resource.context_key,
                cultureKey: MODx.config.cultureKey,
            },
            listeners: {
                success: {
                    fn: function () {
                        //noinspection JSUnresolvedFunction
                        this.refresh();
                    }, scope: this
                },
                failure: {
                    fn: function (response) {
                        MODx.msg.alert(_('error'), response.message);
                    }, scope: this
                },
            }
        })
    },

    getFields: function (config) {
        var fields = ['id', 'version_id', 'grid_id', 'block_id', 'table_id', 'values', 'active', 'actions'];
        if (config.table_columns) {
            config.table_columns.forEach(function (field){
                fields.push(field.name);
            });
        }

        return fields;
    },

    getColumns: function (config) {

        var columns = [];

        if (config.table_columns) {
            config.table_columns.forEach(function (field){
                columns.push({
                    header: field.caption,
                    dataIndex: field.name,
                    id: config.id + '-' + field.name,
                    renderer: field.render ? PageBlocks.utils[field.render] : '',
                    sortable: false,
                    width: field.width || 100,
                    fixed: field.fixed,
                });
            });
        }

        columns.push({
            header: _('pb_grid_actions'),
            dataIndex: 'actions',
            renderer: PageBlocks.utils.renderActions,
            sortable: false,
            width: 150,
            id: 'actions',
            // fixed: 1,
        });


        return columns;
    },

    getTopBar: function (config) {
        if (+config.baseblock > 0 && !config.unique) return [];
        if (config.version_id) return [];

        return [{
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('pb_create'),
            handler: this.createItem,
            scope: this
        }];
    },
});
Ext.reg('pb-grid-table', PageBlocks.grid.Grid);