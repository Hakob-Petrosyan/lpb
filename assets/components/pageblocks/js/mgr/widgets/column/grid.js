PageBlocks.grid.Column = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-grid-column';
    }
    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/column/getlist',
            table_id: config.table_id,
            collection_id: config.collection_id,
            sort: 'rank',
            dir: 'asc',
        },
        cls: 'pageblocks-grid',
        multi_select: false,
        stateful: true,
        stateId: config.id,
        ddGroup: 'pb-grid-columnDD',
        ddAction: 'mgr/column/sort',
        enableDragDrop: true,
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateColumn(grid, e, row);
            }
        },
        paging: false,
        remoteSort: true,
        autoHeight: true,
    });
    PageBlocks.grid.Column.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(PageBlocks.grid.Column, PageBlocks.grid.Default, {

    addColumn: function (btn, e) {
        var w = MODx.load({
            xtype: 'pb-column-window-create',
            id: Ext.id(),
            table_id: this.table_id,
            collection_id: this.collection_id,
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
            table_id: this.table_id,
            collection_id: this.collection_id,
        });
        w.show(e.target);
    },

    updateColumn: function (btn, e, row) {
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
                action: 'mgr/column/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'pb-column-window-update',
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

    removeColumn: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }

        Ext.MessageBox.confirm(
            _('block_field_remove'),
            _('block_field_remove_confirm'),
            function (val) {
                if (val == 'yes') {
                    this.columnAction('column/remove');
                }
            }, this
        );
    },

    disableColumn: function () {
        this.columnAction('column/disable');
    },

    enableColumn: function () {
        this.columnAction('column/enable');
    },

    columnAction: function (method) {
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
        return ['id', 'table_id', 'collection', 'caption', 'name', 'field_id', 'width', 'render', 'active', 'actions'];
    },

    getColumns: function () {
        return [{
            header: _('block_field_caption'),
            dataIndex: 'caption',
            sortable: true,
            width: 175,
        }, {
            header: _('block_field_name'),
            dataIndex: 'name',
            sortable: true,
            width: 175,
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
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('block_field_added'),
            handler: this.addColumn,
            scope: this
        }];
    },
});
Ext.reg('pb-grid-column', PageBlocks.grid.Column);
