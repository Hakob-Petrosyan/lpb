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

PageBlocks.grid.Block = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-grid-blocks';
    }
    config.language = localStorage.getItem('pb_lang') ||  MODx.config.cultureKey;
    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/block/getlist',
            sort: 'rank',
            dir: 'asc',
            resource_id: PageBlocks.resource.id,
            context: PageBlocks.resource.context_key,
            language: config.language,
            collection_id: 0,
        },
        multi_select: true,
        changed: false,
        stateful: false,
        stateId: config.id,
        ddGroup: 'pb-grid-blockDD',
        ddAction: 'mgr/block/sort',
        enableDragDrop: true,
        paging: +MODx.config.pageblocks_paging,
        pageSize: MODx.config.pageblocks_limit,
        remoteSort: true,
        autoHeight: true,
    });
    config.listeners = {
        rowDblClick: function (grid, rowIndex, e) {
            var row = grid.store.getAt(rowIndex);
            this.updateBlock(grid, e, row);
        }
    };
    PageBlocks.grid.Block.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);

};
Ext.extend(PageBlocks.grid.Block, PageBlocks.grid.Default, {

    addBlock: function (btn, e) {
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/constructor/getlist',
                resource_id: PageBlocks.resource.id,
                sort: 'rank',
                dir: 'asc',
                combo: 1,
                limit: 0
            },
            listeners: {
                success: {
                    fn: function (r) {
                        if (this.viewAddBlock) {
                            this.viewAddBlock.destroy();
                        }
                        this.viewAddBlock = MODx.load({
                            xtype: 'pb-block-window-list',
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
                        this.viewAddBlock.reset();
                        this.viewAddBlock.setValues({
                            block_id: 0,
                            resource_id: PageBlocks.resource.id,
                            context_key: PageBlocks.resource.context_key,
                            cultureKey: MODx.config.cultureKey,
                            active: true,
                        });
                        this.viewAddBlock.show(e.target);

                    }, scope: this
                }
            }
        });
    },

    addBaseBlock: function (btn, e) {
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/block/getlist',
                resource_id: 0,
                context: PageBlocks.resource.context_key,
                language: MODx.config.cultureKey,
                sort: 'rank',
                dir: 'asc',
                combo: 1
            },
            listeners: {
                success: {
                    fn: function (r) {
                        r.collection_id = this.collection_id || 0;
                        var w = MODx.load({
                            xtype: 'pb-base-block-window-list',
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
                        w.show(e.target);
                    }, scope: this
                }
            }
        });


    },

    updateBlock: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;
        var block_name = this.menu.record.block_name

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/block/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        r.object.name = block_name;
                        var w = MODx.load({
                            xtype: 'pb-block-window-update',
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
                        var values = Object.assign(r.object, JSON.parse(r.object.values), {
                            'resource_id': PageBlocks.resource.id,
                            'context_key': PageBlocks.resource.context_key,
                            'cultureKey': MODx.config.cultureKey,
                        });
                        w.setValues(values);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    updateChunk: function (btn, e, row) {
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
                action: 'mgr/block/get',
                id: id,
                chunk: 1,
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'pb-chunk-window-update',
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
                        w.setValues({
                            'id' : r.object.chunk_id,
                            'name' : r.object.chunk,
                            'snippet' : r.object.chunk_code
                        });
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
            (ids.length == 1) ? _('pb_block_remove') : _('pb_blocks_remove'),
            (ids.length == 1) ? _('pb_block_remove_confirm') : _('pb_blocks_remove_confirm'),
            function (val) {
                if (val == 'yes') {
                    this.blockAction('block/remove');
                }
            }, this
        );
    },

    copyBlock: function () {
        Ext.MessageBox.confirm(
            _('pb_block_copy'),
            _('pb_block_copy_confirm'),
            function (val) {
                if (val == 'yes') {
                    this.blockAction('block/copy');
                }
            }, this
        );
    },

    copyBlockResource: function() {
        var w = MODx.load({
            xtype: 'pb-blocks-copy-resource',
            id: Ext.id(),
            listeners: {
                success: {
                    fn: function (res) {
                        this.refresh();
                    }, scope: this
                },
            }
        });
        w.reset();
        w.setValues({
            resource_id: PageBlocks.resource.id,
            cultureKey: MODx.config.cultureKey,
            context_key: PageBlocks.resource.context_key,
            collection_id: this.collection_id || 0,
        });
        w.show();
    },

    copyBlockId: function() {
        var w = MODx.load({
            xtype: 'pb-block-copy-id',
            id: Ext.id(),
            listeners: {
                success: {
                    fn: function (res) {
                        this.refresh();
                    }, scope: this
                },
            }
        });
        w.reset();
        w.setValues({
            resource_id: PageBlocks.resource.id,
            cultureKey: MODx.config.cultureKey,
            context_key: PageBlocks.resource.context_key,
            collection_id: this.collection_id || 0,
        });
        w.show();
    },

    disableBlock: function () {
        this.blockAction('block/disable');
    },

    enableBlock: function () {
        this.blockAction('block/enable');
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
                resource_id: PageBlocks.resource.id,
                context_key: PageBlocks.resource.context_key,
                cultureKey: MODx.config.cultureKey,
                collection_id: this.config.collection_id,
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

    exportBlocks: function (btn, e) {
        // Запускаем экспорт сразу же
        if(btn.collection_id > 0 && !MODx.config.pageblocks_languages) {
            MODx.Ajax.request({
                url: this.config.url,
                params: {
                    action: 'mgr/block/export',
                    resource_id: PageBlocks.resource.id,
                    context_key: PageBlocks.resource.context_key,
                    language: MODx.config.cultureKey,
                    collection_id: btn.collection_id || 0,
                    download: 0,
                },
                listeners: {
                    success: {
                        fn: function (res) {
                            if(res.success) {
                                location.href = this.config.url + '?action=mgr/block/export&resource_id=' + PageBlocks.resource.id + '&language=' + res.object.language + '&download=1&HTTP_MODAUTH=' + MODx.siteId;
                            }
                        }, scope: this
                    },
                }
            })
        } else {

            MODx.Ajax.request({
                url: this.config.url,
                params: {
                    action: 'mgr/constructor/getlist',
                    resource_id: PageBlocks.resource.id,
                    sort: 'rank',
                    dir: 'asc',
                    combo: 1
                },
                listeners: {
                    success: {
                        fn: function (r) {
                            var w = MODx.load({
                                xtype: 'pb-blocks-export',
                                id: Ext.id(),
                                record: r,
                                collection_id: btn.collection_id || 0,
                                listeners: {
                                    success: {
                                        fn: function (res) {
                                            if(res.a.result.success) {
                                                location.href = this.config.url + '?action=mgr/block/export&resource_id=' + PageBlocks.resource.id + '&language=' + res.a.result.object.language + '&download=1&HTTP_MODAUTH=' + MODx.siteId;
                                            }
                                        }, scope: this
                                    },
                                }
                            });
                            w.reset();
                            w.setValues({
                                resource_id: PageBlocks.resource.id,
                                language: MODx.config.cultureKey,
                                context_key: PageBlocks.resource.context_key,
                                collection_id: btn.collection_id || 0,
                                download: 0,
                            });
                            w.show(e.target);

                        }, scope: this
                    }
                }
            });
        }
    },

    importBlocks: function (btn, e) {
        var w = MODx.load({
            xtype: 'pb-blocks-import',
            id: Ext.id(),
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                },
            }
        });
        w.reset();
        w.setValues({
            resource_id: PageBlocks.resource.id,
            context_key: PageBlocks.resource.context_key,
            collection_id: btn.collection_id || 0,
            cultureKey: MODx.config.cultureKey,
        });
        w.show(e.target);
    },

    languageDuplicate: function (btn, e) {
        var w = MODx.load({
            xtype: 'pb-block-language-dublicate',
            id: Ext.id(),
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                },
            }
        });
        w.reset();
        w.setValues({
            resource_id: PageBlocks.resource.id,
            collection_id: btn.scope.collection_id,
        });
        w.show(e.target);
    },

    getFields: function () {
        return ['id', 'resource_id', 'baseblock', 'block_name', 'chunk', 'source', 'source_chunk', 'active', 'actions', 'values'];
    },

    getColumns: function () {
        return [{
            header: _('pb_id'),
            dataIndex: 'id',
            sortable: true,
            width: 50,
        }, {
            header: _('pb_block_name'),
            dataIndex: 'block_name',
            sortable: true,
            width: 75,
        }, {
            header: _('pb_chunk'),
            dataIndex: 'chunk',
            sortable: false,
            width: 75,
        }, {
            header: _('pb_values'),
            dataIndex: 'values',
            sortable: false,
            width: 300,
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
            width: 75,
            id: 'actions'
        }];
    },

    getTopBar: function (config) {

        var bar = [{
            text: '<i class="icon icon-plus"></i>&nbsp;' + (config.btn_add || _('pb_block_create')),
            handler: this.addBlock,
            scope: this
        }];

        var menu = [];

        if (PageBlocks.resource.id) {
            menu.push({
                text: '<i class="icon icon-th icon-gray"></i> ' + _('pb_baseblock_added'),
                cls: 'pb-bar-cog',
                handler: this.addBaseBlock,
                collection_id: config.collection_id,
                scope: this
            })
        }

        menu.push({
            text: '<i class="icon icon-copy"></i> ' + _('pb_block_copy_resource'),
            cls: 'pb-bar-cog',
            handler: this.copyBlockResource,
            collection_id: config.collection_id,
            scope: this
        }, {
            text: '<i class="icon icon-copy"></i> ' + _('pb_block_copy_id'),
            cls: 'pb-bar-cog',
            handler: this.copyBlockId,
            collection_id: config.collection_id,
            scope: this
        })

        if (!Ext.isEmpty(MODx.config.pageblocks_languages)) {
            menu.push({
                text: '<i class="icon icon-globe action-blue"></i> ' + _('pb_language_duplicate'),
                cls: 'pb-bar-cog',
                handler: this.languageDuplicate,
                scope: this
            })
        }

        menu.push({
            text: '<i class="icon icon-upload action-yellow"></i> ' +  _('pb_import'),
            cls: 'pb-bar-cog',
            handler: this.importBlocks,
            collection_id: config.collection_id,
            scope: this
        }, {
            text: '<i class="icon icon-download action-green"></i> ' + _('pb_export'),
            cls: 'pb-bar-cog',
            handler: this.exportBlocks,
            collection_id: config.collection_id,
            scope: this
        });

        bar.push({
            text: '<i class="icon icon-cog"></i> ',
            menu: menu,
        });

        if(!Ext.isEmpty(MODx.config.pageblocks_languages)) {
            bar.push({
                xtype: 'pb-combo-language',
                name: 'cultureKey',
                hiddenName: 'cultureKey',
                id: config.id + '-cultureKey',
                listeners: {
                    render: function (cultureKey) {
                        if (Ext.isEmpty(cultureKey.value)) {
                            cultureKey.setValue(config.language);
                            MODx.config.cultureKey = config.language;
                        }
                    },
                    select: (combo, row) => {
                        this.getStore().baseParams.language = row.data.value;
                        if (MODx.config.pageblocks_paging) {
                            this.getBottomToolbar().changePage(1);
                        } else {
                            this.refresh();
                        }
                        MODx.config.cultureKey = row.data.value;
                        localStorage.setItem('pb_lang', row.data.value);
                    }
                },
            });
        }

        bar.push('->');

        if(!PageBlocks.resource.id || MODx.config.pageblocks_search) {
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
        }

        return bar;
    },
});
Ext.reg('pb-grid-blocks', PageBlocks.grid.Block);