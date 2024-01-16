PageBlocks.grid.Table = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-grid-table';
    }
    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/table/getlist',
            sort: 'rank',
            dir: 'asc',
        },
        multi_select: false,
        changed: false,
        stateful: true,
        stateId: config.id,
        ddGroup: 'pb-grid-tableDD',
        ddAction: 'mgr/table/sort',
        enableDragDrop: true,
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateTable(grid, e, row);
            }
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
    });
    PageBlocks.grid.Table.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(PageBlocks.grid.Table, PageBlocks.grid.Default, {
    windows: {},

    createTable: function (btn, e) {
        var w = MODx.load({
            xtype: 'pb-table-window-create',
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
            active: true,
            table_id: 0
        });
        w.show(e.target);
    },

    updateTable: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/table/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'pb-table-window-update',
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
                        w.setValues(r.object);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    removeTable: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }

        Ext.MessageBox.confirm(
            _('block_table_remove'),
             _('block_table_remove_confirm'),
            function (val) {
                if (val == 'yes') {
                    this.tableAction('table/remove');
                }
            }, this
        );
    },

    copyTable: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }

        Ext.MessageBox.confirm(
            _('block_table_copy'),
            _('block_table_copy_confirm'),
            function (val) {
                if (val == 'yes') {
                    this.tableAction('table/copy');
                }
            }, this
        );
    },

    disableTable: function () {
        this.tableAction('table/disable');
    },

    enableTable: function () {
        this.tableAction('table/enable');
    },

    tableAction: function (method) {
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

    getFields: function () {
        return ['id', 'name', 'active', 'actions'];
    },

    getColumns: function () {
        return [{
            header: _('pb_id'),
            dataIndex: 'id',
            sortable: true,
            width: 70
        }, {
            header: _('block_table_name'),
            dataIndex: 'name',
            sortable: true,
            width: 400,
        }, {
            header: _('pb_grid_active'),
            dataIndex: 'active',
            renderer: PageBlocks.utils.renderBoolean,
            sortable: true,
            width: 100,
        }, {
            header: _('pb_grid_actions'),
            dataIndex: 'actions',
            renderer: PageBlocks.utils.renderActions,
            sortable: false,
            width: 100,
            id: 'actions'
        }];
    },

    getTopBar: function () {
        return [{
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('block_table_create'),
            handler: this.createTable,
            scope: this
        }, '->', {
            xtype: 'pb-field-search',
            width: 250,
            listeners: {
                search: {
                    fn: function (field) {
                        this._doSearch(field);
                    }, scope: this
                },
                clear: {
                    fn: function (field) {
                        field.setValue('');
                        this._clearSearch();
                    }, scope: this
                },
            }
        }];
    },
});
Ext.reg('pb-grid-table', PageBlocks.grid.Table);
