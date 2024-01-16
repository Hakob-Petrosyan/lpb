PageBlocks.grid.Field = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-grid-field';
    }

    Ext.applyIf(config, {
        cls: 'pageblocks-grid',
        multi_select: false,
        stateful: true,
        stateId: config.id,
        ddGroup: 'pb-grid-fieldDD',
        ddAction: 'mgr/field/sort',
        enableDragDrop: true,
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateField(grid, e, row);
            }
        },
        paging: true,
        pageSize: 5,
        remoteSort: true,
        autoHeight: true,
    });
    PageBlocks.grid.Field.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(PageBlocks.grid.Field, PageBlocks.grid.Default, {

    createField: function (btn, e) {
        var w = MODx.load({
            xtype: 'pb-field-window-create',
            id: Ext.id(),
            combo: this.combo,
            block_id: this.block_id,
            table_id: this.table_id,
            group_id: this.group_id,
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
            group_id: this.group_id,
        });
        w.show(e.target);
    },

    updateField: function (btn, e, row) {
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
                action: 'mgr/field/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'pb-field-window-update',
                            id: Ext.id(),
                            combo: this.combo,
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

    copyField: function () {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;
        var block_id = this.menu.record.block_id;
        var table_id = this.menu.record.table_id;

        Ext.MessageBox.prompt(
            _('block_field_copy'),
            _('block_field_copy_confirm'),
            function (result, name){
                if (result == 'ok') {
                    MODx.Ajax.request({
                        url: this.config.url,
                        params: {
                            action: 'mgr/field/copy',
                            id: id,
                            name: name,
                            block_id: block_id,
                            table_id: table_id,
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
                    });
                }
            }, this
        );
    },

    removeField: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }

        Ext.MessageBox.confirm(
            _('block_field_remove'),
            _('block_field_remove_confirm'),
            function (val) {
                if (val == 'yes') {
                    this.fieldAction('field/remove');
                }
            }, this
        );
    },

    disableField: function () {
        this.fieldAction('field/disable');
    },

    enableField: function () {
        this.fieldAction('field/enable');
    },

    fieldAction: function (method) {
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
        return ['id', 'block_id', 'table_id', 'group_id', 'name', 'group', 'caption', 'xtype', 'active', 'actions'];
    },

    getColumns: function () {
        return [{
            header: _('block_field_caption'),
            dataIndex: 'caption',
            sortable: true,
            width: 90,
        }, {
            header: _('block_field_name'),
            dataIndex: 'name',
            sortable: true,
            width: 90,
        }, {
            header: _('block_group'),
            dataIndex: 'group',
            sortable: true,
            width: 90,
        }, {
            header: _('pb_grid_active'),
            dataIndex: 'active',
            renderer: PageBlocks.utils.renderBoolean,
            sortable: true,
            width: 75,
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
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('block_field_create'),
            handler: this.createField,
            scope: this
        }];
    },
});
Ext.reg('pb-grid-field', PageBlocks.grid.Field);
