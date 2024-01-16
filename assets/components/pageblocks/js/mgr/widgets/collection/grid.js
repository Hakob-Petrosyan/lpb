PageBlocks.grid.Collection = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-grid-collection';
    }
    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/collection/getlist',
            sort: 'rank',
            dir: 'asc',
        },
        multi_select: false,
        changed: false,
        stateful: true,
        stateId: config.id,
        ddGroup: 'pb-grid-collectionDD',
        ddAction: 'mgr/collection/sort',
        enableDragDrop: true,
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.changeBlock(grid, e, row);
            }
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
    });
    PageBlocks.grid.Collection.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(PageBlocks.grid.Collection, PageBlocks.grid.Default, {
    windows: {},

    createBlock: function (btn, e) {
        var w = MODx.load({
            xtype: 'pb-collection-window-create',
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
        });
        w.show(e.target);
    },

    changeBlock: function (btn, e, row) {
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
                action: 'mgr/collection/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'pb-collection-window-update',
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

    removeBlock: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }

        Ext.MessageBox.confirm(
            _('pb_remove'),
            _('pb_remove_confirm'),
            function (val) {
                if (val == 'yes') {
                    this.blockAction('collection/remove');
                }
            }, this
        );
    },

    copyBlock: function () {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        Ext.MessageBox.prompt(
            _('pb_remove'),
            _('pb_remove_confirm'),
            function (result, name){
                if(result == 'ok') {
                    MODx.Ajax.request({
                        url: this.config.url,
                        params: {
                            action: 'mgr/collection/copy',
                            id: id,
                            name: name,
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

    disableBlock: function () {
        this.blockAction('collection/disable');
    },

    enableBlock: function () {
        this.blockAction('collection/enable');
    },

    blockAction: function (method) {
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
            header: _('pb_name'),
            dataIndex: 'name',
            sortable: true,
            width: 300,
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
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('pb_create'),
            handler: this.createBlock,
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
Ext.reg('pb-grid-collection', PageBlocks.grid.Collection);
