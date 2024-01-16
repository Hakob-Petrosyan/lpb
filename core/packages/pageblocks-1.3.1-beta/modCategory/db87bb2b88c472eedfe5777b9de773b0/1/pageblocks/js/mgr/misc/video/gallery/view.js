PageBlocks.panel.Videos = function (config) {
    config = config || {};
    config.idPanel = config.id;
    this.view = MODx.load({
        xtype: 'pb-gallery-videos-view',
        id: Ext.id(),
        idPanel: config.id,
        style: {padding: '0', float: 'left', width: '100%'},
        containerScroll: true,
        pageSize: parseInt(config.pageSize || MODx.config.default_per_page),
        emptyText: _('pb_gallery_emptytext'),

        resource_id: config.resource,
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
        id: Ext.id(),
        cls: 'browser-view',
        border: false,
        style: {padding: '0'},
        items: [this.view],
        tbar: this.getTopBar(config),
        bbar: this.getBottomBar(config),
    });
    PageBlocks.panel.Videos.superclass.constructor.call(this, config);

    var dv = this.view;
    dv.on('render', function () {
        dv.dragZone = new PageBlocks.DragZone(dv);
        dv.dropZone = new PageBlocks.DropZone(dv);
    });
};
Ext.extend(PageBlocks.panel.Videos, MODx.Panel, {

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

        return [{
            xtype: 'button',
            text: '<i class="icon icon-plus"></i> ' + _('pb_video_gallery_upload_btn'),
            handler: this.uploadVideo,
            resource_id: PageBlocks.resource.id,
            context_key: PageBlocks.resource.context_key,
            cultureKey: MODx.config.cultureKey,
            block_id: config.block_id,
            field_id: config.field_id,
            grid_id: config.grid_id,
            path: config.source_path,
            object: this,
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

    uploadVideo: function () {
        var w = MODx.load({
            xtype: 'pb-video-upload',
            id: Ext.id(),
            source: this.source,
            source_path: this.source_path,
            idVideo: this.idVideo,
            idPanel: this.id,
            listeners: {
                success: {
                    fn: function () {
                        this.object.bottomToolbar.store.reload();
                    }, scope: this
                }
            }
        });
        w.setValues({
            resource_id: PageBlocks.resource.id,
            context_key: PageBlocks.resource.context_key,
            cultureKey: MODx.config.cultureKey,
            block_id: this.block_id,
            field_id: this.field_id,
            grid_id: this.grid_id,
            path: this.source_path,
        });
        w.show();
    }

});
Ext.reg('pb-gallery-videos-panel', PageBlocks.panel.Videos);


PageBlocks.view.Videos = function (config) {
    config = config || {};
    this._initTemplates();
    Ext.applyIf(config, {
        url: PageBlocks.config.connector_url,
        fields: [
            'id', 'version_id', 'resource_id', 'context_key', 'cultureKey', 'block_id', 'field_id', 'path',
            'url', 'provider', 'video', 'embed_video', 'rank', 'video_id', 'active', 'actions',
            'description', 'title', 'thumbnail', 'thumbnail_width', 'thumbnail_height', 'baseblock'
        ],
        id: config.id + '-view',
        style: {'width' : '100%'},
        baseParams: {
            action: 'mgr/video/gallery/getlist',
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
    PageBlocks.view.Videos.superclass.constructor.call(this, config);

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
Ext.extend(PageBlocks.view.Videos, MODx.DataView, {
    templates: {},
    windows: {},

    onSort: function (o) {

        if (o.source.data.version_id) {
            return true;
        }

        var el = this.getEl();
        el.mask(_('loading'), 'x-mask-loading');
        MODx.Ajax.request({
            url: PageBlocks.config.connector_url,
            params: {
                action: 'mgr/video/gallery/sort',
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

        if (this.version_id) {
            this.viewData(node, e);
        } else if (node.getAttribute('data-baseblock') == 0) {
            this.updateData(node, e);
        }
    },

    viewData: function (btn, e) {
        var node = this.cm.activeNode;
        var data = this.lookup[node.id];
        if (!data) {
            return;
        }

        MODx.Ajax.request({
            url: PageBlocks.config.connector_url,
            params: {
                action: 'mgr/video/get',
                id: data.id,
                version_id: data.version_id,
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'pb-video-update',
                            id: Ext.id(),
                            record: r.object,
                            source: this.source,
                            source_path: this.source_path,
                            idVideo: this.idVideo,
                            idPanel: this.idPanel,
                        });
                        w.setValues(r.object);
                        w.show();

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

    updateData: function (btn, e) {
        var node = this.cm.activeNode;
        var data = this.lookup[node.id];
        if (!data) {
            return;
        }

        MODx.Ajax.request({
            url: PageBlocks.config.connector_url,
            params: {
                action: 'mgr/video/get',
                id: data.id,
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'pb-video-update',
                            id: Ext.id(),
                            record: r.object,
                            source: this.source,
                            source_path: this.source_path,
                            idVideo: this.idVideo,
                            idPanel: this.idPanel,
                        });
                        w.setValues(r.object);
                        w.show();

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

    removeVideo: function () {
        var ids = this._getSelectedIds();
        var title = ids.length > 1
            ? 'pb_video_remove_multiple'
            : 'pb_video_remove';
        var message = ids.length > 1
            ? 'pb_video_remove_multiple_confirm'
            : 'pb_video_remove_confirm';
        Ext.MessageBox.confirm(
            _(title),
            _(message),
            function (val) {
                if (val == 'yes') {
                    this.fileAction('video/gallery/remove');
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
        data.title = Ext.util.Format.ellipsis(data.title, 20);
        this.lookup['pb-gallery-video-' + data.id] = data;
        return data;
    },

    _initTemplates: function () {
        this.templates.thumb = new Ext.XTemplate(
            '<tpl for=".">\
                <div class="modx-browser-thumb-wrap modx-pb-thumb-wrap pb-gallery-thumb-wrap {class}" data-baseblock="{baseblock}" id="pb-gallery-video-{id}">\
                    <div class="modx-browser-thumb modx-pb-thumb pb-gallery-thumb">\
                        <img src="{thumbnail}" title="{title}" width="100"/>\
                    </div>\
                    <small>{title}</small>\
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
Ext.reg('pb-gallery-videos-view', PageBlocks.view.Videos);