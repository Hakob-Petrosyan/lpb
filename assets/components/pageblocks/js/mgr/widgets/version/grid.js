if (MODx.loadRTE && typeof TinyMCERTE == 'object') {
    TinyMCERTE.editorConfig = {
        language: MODx.config['manager_language'],
        enable_link_list: MODx.config['tinymcerte.enable_link_list'],
        plugins: MODx.config['tinymcerte.plugins'],
        image_advtab: MODx.config['tinymcerte.image_advtab'],
        relative_urls: MODx.config['tinymcerte.relative_urls'],
        remove_script_host: MODx.config['tinymcerte.remove_script_host'],
        skin: MODx.config['tinymcerte.skin'],
        statusbar: MODx.config['tinymcerte.statusbar'],
        menubar: MODx.config['tinymcerte.menubar'],
        toolbar1: MODx.config['tinymcerte.toolbar1'],
    };
}

PageBlocks.grid.Version = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-grid-version';
    }
    config.language = localStorage.getItem('pb_lang') ||  MODx.config.cultureKey;
    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/version/getlist',
            sort: 'saved',
            dir: 'desc',
        },
        multi_select: true,
        changed: false,
        stateful: false,
        stateId: config.id,
        enableDragDrop: false,
        paging: +MODx.config.pageblocks_paging,
        pageSize: MODx.config.pageblocks_limit,
        remoteSort: true,
        autoHeight: true,
    });
    config.listeners = {
        rowDblClick: function (grid, rowIndex, e) {
            var row = grid.store.getAt(rowIndex);
            this.viewVersion(grid, e, row);
        }
    };
    PageBlocks.grid.Version.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);

};
Ext.extend(PageBlocks.grid.Version, PageBlocks.grid.Default, {

    viewVersion: function (btn, e, row) {

        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/version/get',
                id: this.menu.record.id
            },
            listeners: {
                success: {
                    fn: function (r) {

                        var w = MODx.load({
                            xtype: 'pb-version-window-view',
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
                        var values = JSON.parse(r.object.values);
                        values['active'] = 1;
                        w.setValues(values);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    restoreVersion: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/version/restore',
                id: this.menu.record.id
            },
            listeners: {
                success: {
                    fn: function (response) {
                        MODx.msg.alert(_('success'), response.message);
                    }, scope: this
                },
                failure: {
                    fn: function (response) {
                        MODx.msg.alert(_('error'), response.message);
                    }, scope: this
                },
            }
        });
    },

    removeVersion: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }

        Ext.MessageBox.confirm(
            (ids.length == 1) ? _('pb_block_remove') : _('pb_blocks_remove'),
            _('pb_version_remove_confirm'),
            function (val) {
                if (val == 'yes') {
                    this.versionAction('version/remove');
                }
            }, this
        );
    },

    versionAction: function (method) {
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
        return ['id', 'block_id', 'block_name', 'saved', 'user', 'mode', 'deleted', 'source_chunk', 'deletedby', 'description', 'actions', 'admin'];
    },

    getColumns: function () {
        return [{
            header: _('pb_version_id'),
            dataIndex: 'id',
            sortable: true,
            width: 50,
        }, {
            header: _('pb_version_block_id'),
            dataIndex: 'block_id',
            sortable: true,
            width: 75,
        }, {
            header: _('pb_version_block_name'),
            dataIndex: 'block_name',
            sortable: false,
            width: 150,
        }, {
            header: _('pb_version_saved'),
            dataIndex: 'saved',
            sortable: false,
            width: 80,
        }, {
            header: _('pb_version_user'),
            dataIndex: 'user',
            sortable: true,
            width: 75,
        }, {
            header: _('pb_version_mode'),
            dataIndex: 'mode',
            renderer: function (val) { return _('pb_version_mode_'+val); },
            sortable: true,
            width: 75,
        }, {
            header: _('pb_grid_actions'),
            dataIndex: 'actions',
            renderer: PageBlocks.utils.renderActions,
            sortable: false,
            width: 75,
            id: 'actions'
        }];
    },

    clearVersion: function() {

        Ext.MessageBox.confirm(
            _('pb_version_clear_title'),
            _('pb_version_clear_confirm'),
            function (val) {
                if (val == 'yes') {
                    var el = this.getEl();
                    el.mask(_('pb_version_clear_loading'), 'x-mask-loading');
                    MODx.Ajax.request({
                        url: this.config.url,
                        params: {
                            action: 'mgr/version/clear',
                        },
                        listeners: {
                            success: {
                                fn: function (response) {
                                    el.unmask();

                                    var w = Ext.getCmp(el.id);
                                    w.refresh();
                                    MODx.msg.alert(_('success'), response.message);
                                }, scope: this
                            },
                            failure: {
                                fn: function (response) {
                                    el.unmask();
                                    var w = Ext.getCmp(el.id);
                                    w.refresh();
                                    MODx.msg.alert(_('error'), response.message);
                                }, scope: this
                            },
                        }
                    });
                }
            }, this
        );

    },

    getTopBar: function (config) {
        var bar = [];

        bar.push({
            text: '<i class="icon icon-trash-o"></i> ' + _('pb_version_clear_btn'),
            cls: 'pb-bar-cog action-red',
            handler: this.clearVersion,
            scope: this
        });

        bar.push('->');
        bar.push({
            xtype: 'pb-field-search',
            width: 350,
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
        });

        return bar;
    },
});
Ext.reg('pb-grid-version', PageBlocks.grid.Version);