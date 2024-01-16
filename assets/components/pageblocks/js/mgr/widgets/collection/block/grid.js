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

PageBlocks.grid.CollectionBlock = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-grid-blocks-' + config.collection_id ;
    }
    config.language = localStorage.getItem('pb_lang') ||  MODx.config.cultureKey;
    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/block/getlist',
            sort: 'rank',
            dir: 'asc',
            resource_id: PageBlocks.resource.id,
            context: PageBlocks.resource.context_key,
            language: MODx.config.cultureKey,
            collection_id: config.collection_id,
        },
        multi_select: true,
        changed: false,
        stateful: false,
        stateId: config.id,
        ddGroup: 'pb-grid-collection-blockDD',
        ddAction: 'mgr/block/sort',
        enableDragDrop: true,
        paging: true,
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
    PageBlocks.grid.CollectionBlock.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);

};
Ext.extend(PageBlocks.grid.CollectionBlock, PageBlocks.grid.Block, {

    addBlock: function (btn,e){
        var store = this;
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/constructor/get',
                fields: 1,
                id: this.constructor_id,
            },
            listeners: {
                success: {
                    fn: function (r) {
                        r.object.constructor_id = r.object.id;
                        r.object.id = 0;
                        var w = MODx.load({
                            xtype: 'pb-block-window-create',
                            record: r,
                            id: Ext.id(),
                            listeners: {
                                success: function () {
                                    store.refresh();
                                }
                            }
                        });
                        w.reset();
                        w.setValues({
                            resource_id: PageBlocks.resource.id,
                            context_key: PageBlocks.resource.context_key,
                            cultureKey: MODx.config.cultureKey,
                            chunk: r.object.chunk,
                            constructor_id: this.constructor_id,
                            collection_id: this.collection_id,
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

    getFields: function (config) {
        var fields = ['id', 'resource_id', 'chunk', 'source', 'source_chunk', 'active', 'actions', 'object_id', 'resource_url'];
        if(config.collection_columns.length) {
            config.collection_columns.forEach( field => {
                fields.push(field.name);
            });
        }
        return fields;
    },

    viewResource: function () {
        window.open(this.menu.record.resource_url);
        return false;
    },

    openResource: function (btn, e, row) {
        location.href = location.origin + location.pathname + '?a=resource/update&id=' + this.menu.record.object_id;
    },

    getColumns: function (config) {

        var columns = [{
            header: _('pb_id'),
            dataIndex: 'id',
            sortable: true,
            width: 50,
        }];
        if(config.collection_columns.length) {
            config.collection_columns.forEach( field => {
                columns.push({
                    header: field.caption,
                    dataIndex: field.name,
                    id: config.id + '-' + field.name,
                    renderer: field.render ? PageBlocks.utils[field.render] : '',
                    sortable: false,
                    width: +field.width,
                    fixed: field.fixed,
                });
            });
        }

        columns.push({
            header: _('pb_grid_active'),
            dataIndex: 'active',
            renderer: PageBlocks.utils.renderBoolean,
            sortable: true,
            width: 100,
            fixed: true,
        }, {
            header: _('pb_grid_actions'),
            dataIndex: 'actions',
            renderer: PageBlocks.utils.renderActions,
            sortable: false,
            width: 150,
            id: 'actions',
        });

        return columns;
    },
});
Ext.reg('pb-grid-collection-block', PageBlocks.grid.CollectionBlock);