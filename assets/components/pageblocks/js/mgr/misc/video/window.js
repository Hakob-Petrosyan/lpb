PageBlocks.window.VideoDetail = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = Ext.id();
    }
    Ext.applyIf(config, {
        title: config.record['title'],
        cls: 'modx-window pageblocks-window',
        width: 750,
        autoHeight: true,
        maxHeight: 600,
        autoScroll: true,
        url: PageBlocks.config.connector_url,
        action: 'mgr/video/update',
        fields: this.getFields(config),
        buttons: this.getButtons(config),
        source: config.source,
        source_path: config.source_path,
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    PageBlocks.window.VideoDetail.superclass.constructor.call(this, config);

    this.on('success', function() {
        Ext.getCmp(config.idPanel).bottomToolbar.store.reload();
    });
};
Ext.extend(PageBlocks.window.VideoDetail, MODx.Window, {

    getButtons: function (config) {
        var btns = [{
            text: config.cancelBtnText || _("cancel"),
            scope: this,
            handler: function() {
                this.hide()
            }
        }, {
            text: config.saveBtnText || _("save"),
            cls: "primary-button",
            scope: this,
            handler: this.submit
        }];

        if (config.record.version_id) {
            btns = [{
                text: config.cancelBtnText || _("close"),
                scope: this,
                handler: function() {
                    this.hide()
                }
            }];
        }

        return btns;
    },

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
        }, {
            xtype: 'hidden',
            name: 'provider',
            id: config.id + '-provider',
            anchor: '100%',
            allowBlank: false,
        }, {
            xtype: 'hidden',
            name: 'video_id',
            id: config.id + '-video_id',
            anchor: '100%',
            allowBlank: false,
        }, {
            xtype: 'hidden',
            name: 'video',
            id: config.id + '-video',
            anchor: '100%',
            allowBlank: false,
        }, {
            xtype: 'hidden',
            name: 'thumbnail_width',
            id: config.id + '-thumbnail_width',
            anchor: '100%',
            allowBlank: false,
        }, {
            xtype: 'hidden',
            name: 'thumbnail_height',
            id: config.id + '-thumbnail_height',
            anchor: '100%',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            fieldLabel: _('pb_video_title'),
            name: 'title',
            id: config.id + '-title',
            anchor: '100%',
            allowBlank: false,
        }, {
            xtype: 'pb-panel-image',
            fieldLabel: _('pb_video_preview'),
            name: 'thumbnail',
            id: config.id + '-thumbnail',
            anchor: '100%',
            allowBlank: true,
            source: config.source,
            source_path: config.source_path,
        }, {
            xtype: 'textarea',
            fieldLabel: _('pb_video_description'),
            name: 'description',
            id: config.id + '-description',
            anchor: '100%',
            height:150,
            allowBlank: true,
        }, {
            xtype: 'statictextfield',
            fieldLabel: _('pb_video_embed'),
            name: 'embed_video',
            id: config.id + '-embed_video',
            anchor: '100%',
            allowBlank: true,
        }];
    },

    loadDropZones: function() {}

});
Ext.reg('pb-video-update', PageBlocks.window.VideoDetail);