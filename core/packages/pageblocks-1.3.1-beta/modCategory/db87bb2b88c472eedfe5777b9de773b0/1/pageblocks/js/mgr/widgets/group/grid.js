PageBlocks.grid.Group = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-grid-group';
    }

    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/group/getlist',
            block_id: config.block_id,
            table_id: config.table_id,
            collection_id: config.collection_id,
            sort: 'rank',
            dir: 'asc',
        },
        cls: 'pageblocks-grid',
        multi_select: false,
        stateful: true,
        stateId: config.id,
        ddGroup: 'pb-grid-groupDD',
        ddAction: 'mgr/group/sort',
        enableDragDrop: true,
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateGroup(grid, e, row);
            }
        },
        paging: false,
        remoteSort: true,
        autoHeight: true,
    });
    PageBlocks.grid.Group.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(PageBlocks.grid.Group, PageBlocks.grid.Default, {

    createGroup: function (btn, e) {
        var w = MODx.load({
            xtype: 'pb-group-window-create',
            id: Ext.id(),
            block_id: this.block_id,
            table_id: this.table_id,
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
            block_id: this.block_id,
            table_id: this.table_id,
        });
        w.show(e.target);
    },

    updateGroup: function (btn, e, row) {
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
                action: 'mgr/group/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'pb-group-window-update',
                            id: Ext.id(),
                            block_id: this.block_id,
                            table_id: this.table_id,
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

    removeGroup: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }

        Ext.MessageBox.confirm(
            _('block_group_remove'),
            _('block_group_remove_confirm'),
            function (val) {
                if (val == 'yes') {
                    this.groupAction('group/remove');
                }
            }, this
        );
    },

    disableGroup: function () {
        this.groupAction('group/disable');
    },

    enableGroup: function () {
        this.groupAction('group/enable');
    },

    groupAction: function (method) {
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
        return ['id', 'block_id', 'name', 'active', 'actions'];
    },

    getColumns: function () {
        return [{
            header: _('block_group_name'),
            dataIndex: 'name',
            sortable: true,
            width: 200,
            renderer: function (value){
                if(Ext.isEmpty(value)) {
                    return _('block_group_empty');
                }
                return value;
            }

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
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('block_group_create'),
            handler: this.createGroup,
            scope: this
        }];
    },
});
Ext.reg('pb-grid-group', PageBlocks.grid.Group);
