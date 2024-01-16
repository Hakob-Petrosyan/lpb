PageBlocks.grid.ResourceField = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-grid-resource-field';
    }
    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/resource/getlist',
        },
        cls: 'pageblocks-grid',
        multi_select: false,
        stateful: true,
        stateId: config.id,
        paging: true,
        remoteSort: true,
        autoHeight: true,
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateField(grid, e, row);
            }
        },
    });
    PageBlocks.grid.ResourceField.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(PageBlocks.grid.ResourceField, PageBlocks.grid.Default, {

    createField: function (btn, e) {
        var w = MODx.load({
            xtype: 'pb-resource-field-window-create',
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
                action: 'mgr/resource/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'pb-resource-field-window-update',
                            id: Ext.id(),
                            record: r.object,
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

    removeField: function () {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        Ext.MessageBox.alert(
            _('block_field_remove'),
            _('block_field_remove_confirm'),
            function (result){
                if(result == 'ok') {
                    var el = this.getEl();
                    el.mask(_('loading'), 'x-mask-loading');
                    MODx.Ajax.request({
                        url: this.config.url,
                        params: {
                            action: 'mgr/resource/remove',
                            id: id,
                        },
                        listeners: {
                            success: {
                                fn: function () {
                                    el.unmask();
                                    this.refresh();
                                }, scope: this
                            },
                            failure: {
                                fn: function (response) {
                                    el.unmask();
                                    MODx.msg.alert(_('error'), response.message);
                                }, scope: this
                            },
                        }
                    })
                }
            }, this
        );
    },

    getFields: function () {
        return ['id', 'name', 'xtype', 'actions'];
    },

    getColumns: function () {
        return [{
            header: _('pb_id'),
            dataIndex: 'id',
            sortable: true,
            width: 50,
        }, {
            header: _('block_field_name'),
            dataIndex: 'name',
            sortable: true,
            width: 75,
        }, {
            header: _('block_field_xtype'),
            dataIndex: 'xtype',
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
Ext.reg('pb-grid-resource-field', PageBlocks.grid.ResourceField);
