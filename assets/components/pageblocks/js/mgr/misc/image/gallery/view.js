PageBlocks.panel.Images = function (config) {
    config = config || {};

    this.view = MODx.load({
        xtype: 'pb-gallery-images-view',
        id: config.idPanel + '-view',
        style: {padding: '0', float: 'left', width: '100%'},
        containerScroll: true,
        pageSize: parseInt(config.pageSize || MODx.config.default_per_page),
        emptyText: _('pb_gallery_emptytext'),

        resource_id: config.resource || PageBlocks.resource.id,
        context_key: config.context_key,
        cultureKey: config.cultureKey,
        block_id: config.block_id,
        version_id: config.version_id,
        baseblock: config.baseblock,
        unique: config.unique,
        table_id: config.table_id,
        field_id: config.field_id,
        grid_id: config.grid_id,
        source: config.source,
        source_path: config.source_path,
    });
    Ext.applyIf(config, {
        id: Ext.id() + '-view-images',
        cls: 'browser-view',
        border: false,
        style: {padding: '0'},
        items: [this.view],
        tbar: this.getTopBar(config),
        bbar: this.getBottomBar(config),
    });
    PageBlocks.panel.Images.superclass.constructor.call(this, config);

    var dv = this.view;
    dv.on('render', function () {
        dv.dragZone = new PageBlocks.DragZone(dv);
        dv.dropZone = new PageBlocks.DropZone(dv);
    });
};
Ext.extend(PageBlocks.panel.Images, MODx.Panel, {

    _doSearch: function (tf) {
        this.view.getStore().baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
    },

    _clearSearch: function () {
        this.view.getStore().baseParams.query = '';
        this.getBottomToolbar().changePage(1);
    },

    getTopBar: function (config) {
        if (config.baseblock > 0 && !config.unique) return [];
        if (config.version_id) return [];

        let self = this;

        return [{
            xtype: 'button',
            text: '<i class="icon icon-upload"></i> ' + _('pb_gallery_upload_btn'),
            id: config.idButton + '-upload-btn',
        }, {
            xtype: 'button',
            text: '<i class="icon icon-image"></i> Media',
            id: config.idButton + '-media-btn',
            handler: function() {

                var browser = MODx.load({
                    xtype: 'modx-browser',
                    id: Ext.id(),
                    multiple: true,
                    source: config.source || MODx.config['default_media_source'],
                    rootVisible: false,
                    allowedFileTypes: config.allowedFileTypes || '',
                    wctx: config.wctx || 'web',
                    openTo: config.openTo || '',
                    rootId: config.rootId || '/',
                    hideSourceCombo: config.hideSourceCombo || false,
                    hideFiles: config.hideFiles || true,
                    listeners: {
                        select: {
                            fn: function (data) {
                                // console.log(data);

                                if (Ext.isEmpty(data.pathRelative)) return;

                                MODx.Ajax.request({
                                    url: PageBlocks.config.connector_url,
                                    params: {
                                        action: 'mgr/gallery/create',
                                        filepath: data.pathRelative,
                                        filename: data.name,
                                        resource_id: config.resource || PageBlocks.resource.id,
                                        context_key: config.context_key,
                                        cultureKey: config.cultureKey,
                                        block_id: config.block_id,
                                        version_id: config.version_id,
                                        baseblock: config.baseblock,
                                        unique: config.unique,
                                        table_id: config.table_id,
                                        field_id: config.field_id,
                                        grid_id: config.grid_id,
                                        source: config.source,
                                        source_path: config.source_path,
                                    },
                                    listeners: {
                                        success: {
                                            fn: function (r) {
                                                self.view.store.reload();
                                            }, scope: this
                                        },
                                        failure: {
                                            fn: function (response) {
                                                MODx.msg.alert(_('error'), response.message);
                                            }, scope: this
                                        },
                                    }
                                });

                            }, scope: this
                        }
                    },
                });
                browser.show();
            }
        }];
    },

    getBottomBar: function (config) {
        return new Ext.PagingToolbar({
            pageSize: parseInt(config.pageSize || (MODx.config.default_per_page / 2)),
            store: this.view.store,
            displayInfo: true,
            autoLoad: true,
        });
    },

});
Ext.reg('pb-gallery-images-panel', PageBlocks.panel.Images);


PageBlocks.view.Images = function (config) {
    config = config || {};
    this._initTemplates();
    Ext.applyIf(config, {
        url: PageBlocks.config.connector_url,
        fields: [
            'id', 'version_id', 'resource_id', 'context_key', 'cultureKey', 'block_id', 'field_id', 'path',
            'filename', 'name', 'url', 'type', 'source', 'rank', 'active', 'actions', 'description', 'title',
            'thumb', 'thumb_width', 'thumb_height', 'baseblock'
        ],
        id: config.id + '-view',
        style: {'width' : '100%'},
        baseParams: {
            action: 'mgr/gallery/getlist',
            resource_id: PageBlocks.resource.id,
            context_key: PageBlocks.resource.context_key,
            cultureKey: config.cultureKey,
            block_id: config.block_id || 0,
            version_id: config.version_id || 0,
            baseblock: config.baseblock,
            unique: config.unique,
            table_id: config.table_id,
            field_id: config.field_id,
            grid_id: config.grid_id || 0,
            source: config.source,
            source_path: config.source_path,
            limit: config.pageSize || (MODx.config.default_per_page / 2),
        },
        enableDD: true,
        multiSelect: true,
        tpl: this.templates.thumb,
        itemSelector: 'div.modx-browser-thumb-wrap',
        listeners: {},
        prepareData: this.formatData.createDelegate(this)
    });
    PageBlocks.view.Images.superclass.constructor.call(this, config);

    this.addEvents('sort', 'select');
    this.on('sort', this.onSort, this);
    this.on('dblclick', this.onDblClick, this);

    var widget = this;
    this.getStore().on('beforeload', function () {
        widget.getEl().mask(_('loading'), 'x-mask-loading');
    });
    this.getStore().on('load', function () {
        widget.getEl().unmask();
    });
};
Ext.extend(PageBlocks.view.Images, MODx.DataView, {
    templates: {},
    windows: {},

    onSort: function (o) {
        var el = this.getEl();
        el.mask(_('loading'), 'x-mask-loading');
        MODx.Ajax.request({
            url: PageBlocks.config.connector_url,
            params: {
                action: 'mgr/gallery/sort',
                source: o.source.id,
                target: o.target.id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        el.unmask();
                        this.store.reload();
                    }, scope: this
                }
            }
        });
    },

    onDblClick: function (e) {
        var node = this.getSelectedNodes()[0];
        if (!node) {
            return;
        }

        this.cm.activeNode = node;
        if (node.getAttribute('data-baseblock') == 0) {
            this.updateFile(node, e);
        }
    },

    viewFile: function (btn, e) {
        var node = this.cm.activeNode;
        var data = this.lookup[node.id];
        if (!data) {
            return;
        }

        var w = MODx.load({
            xtype: 'pb-gallery-image',
            id: Ext.id(),
            record: data,
            listeners: {
                success: {
                    fn: function () {
                        this.store.reload()
                    }, scope: this
                }
            }
        });
        w.setValues(data);
        w.show(e.target);
    },

    updateFile: function (btn, e) {
        var node = this.cm.activeNode;
        var data = this.lookup[node.id];
        if (!data) {
            return;
        }

        var w = MODx.load({
            xtype: 'pb-gallery-image',
            id: Ext.id(),
            record: data,
            listeners: {
                success: {
                    fn: function () {
                        this.store.reload()
                    }, scope: this
                }
            }
        });
        w.setValues(data);
        w.show(e.target);
    },

    fileAction: function (method) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        this.getEl().mask(_('loading'), 'x-mask-loading');
        MODx.Ajax.request({
            url: PageBlocks.config.connector_url,
            params: {
                action: 'mgr/multiple',
                method: method,
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function (r) {
                        this.store.reload();
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

    deleteFiles: function () {
        var ids = this._getSelectedIds();
        var title = ids.length > 1
            ? 'pb_gallery_file_delete_multiple'
            : 'pb_gallery_file_delete';
        var message = ids.length > 1
            ? 'pb_gallery_file_delete_multiple_confirm'
            : 'pb_gallery_file_delete_multiple';
        Ext.MessageBox.confirm(
            _(title),
            _(message),
            function (val) {
                if (val == 'yes') {
                    this.fileAction('gallery/remove');
                }
            },
            this
        );
    },

    run: function (p) {
        p = p || {};
        var v = {};
        Ext.apply(v, this.store.baseParams);
        Ext.apply(v, p);
        this.changePage(1);
        this.store.baseParams = v;
        this.store.load();
    },

    formatData: function (data) {
        data.shortName = Ext.util.Format.ellipsis(data.name, 20);
        this.lookup['pb-gallery-image-' + data.id] = data;
        return data;
    },

    _initTemplates: function () {
        this.templates.thumb = new Ext.XTemplate(
            '<tpl for=".">\
                <div class="modx-browser-thumb-wrap modx-pb-thumb-wrap pb-gallery-thumb-wrap {class}" data-baseblock="{baseblock}" id="pb-gallery-image-{id}">\
                    <div class="modx-browser-thumb modx-pb-thumb pb-gallery-thumb">\
                        <img src="{thumb}" title="{name}" width="{thumb_width}" height="{thumb_height}"/>\
                    </div>\
                    <small>{shortName}</small>\
                </div>\
            </tpl>'
        );
        this.templates.thumb.compile();
    },

    _showContextMenu: function (v, i, n, e) {
        e.preventDefault();
        var data = this.lookup[n.id];
        var m = this.cm;
        m.removeAll();

        var menu = PageBlocks.utils.getMenu(data.actions, this, this._getSelectedIds());
        for (var item in menu) {
            if (!menu.hasOwnProperty(item)) {
                continue;
            }
            m.add(menu[item]);
        }

        m.show(n, 'tl-c?');
        m.activeNode = n;
    },

    _getSelectedIds: function () {
        var ids = [];
        var selected = this.getSelectedRecords();

        for (var i in selected) {
            if (!selected.hasOwnProperty(i)) {
                continue;
            }
            ids.push(selected[i]['id']);
        }

        return ids;
    },

});
Ext.reg('pb-gallery-images-view', PageBlocks.view.Images);