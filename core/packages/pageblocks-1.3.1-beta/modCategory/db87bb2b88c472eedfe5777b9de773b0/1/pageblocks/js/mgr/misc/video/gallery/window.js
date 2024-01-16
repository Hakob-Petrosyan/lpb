PageBlocks.window.VideoUpload = function (config) {
    config = config || {};
    config.idVideo = config.id || Ext.id();
    Ext.applyIf(config, {
        title: _('pb_video_upload_title'),
        cls: 'modx-window pageblocks-window',
        width: 750,
        autoHeight: true,
        maxHeight: 600,
        autoScroll: true,
        d: config.idVideo,
        url: PageBlocks.config.connector_url,
        action: 'mgr/video/gallery/create',
        fields: this.getFields(config),
        source: config.source,
        source_path: config.source_path,
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });

    PageBlocks.window.VideoUpload.superclass.constructor.call(this, config);

    this.on('beforeSubmit', function(values) {
        Ext.getCmp(config.id + '-embed_video').setDisabled(false);
    });
};
Ext.extend(PageBlocks.window.VideoUpload, MODx.Window, {

    getFields: function (config) {
        var fields = [{
            xtype: 'textfield',
            fieldLabel: _('pb_video_upload_url'),
            name: 'video',
            id: config.idVideo + '-video',
            anchor: '100%',
            allowBlank: false,
            listeners: {
                change: (el) => {
                    var value = el.getValue();
                    if(!Ext.isEmpty(value)) {
                        this.setPreview(value);
                    }
                },
            },
        }, {
            xtype: 'label',
            cls: 'desc-under',
            text: _('pb_video_upload_url_desc'),
        }, {
            xtype: 'textfield',
            fieldLabel: _('pb_video_title'),
            name: 'title',
            id: config.idVideo + '-title',
            anchor: '100%',
            allowBlank: false,
            hidden: true,
        }, {
            xtype: 'pb-panel-image',
            fieldLabel: _('pb_video_preview'),
            name: 'thumbnail',
            id: config.idVideo + '-thumbnail',
            anchor: '100%',
            allowBlank: true,
            source: config.source,
            source_path: config.source_path,
            hidden: true,
        }, {
            xtype: 'textarea',
            fieldLabel: _('pb_video_description'),
            name: 'description',
            id: config.idVideo + '-description',
            anchor: '100%',
            height:150,
            allowBlank: true,
            hidden: true,
        }, {
            xtype: 'statictextfield',
            fieldLabel: _('pb_video_embed'),
            name: 'embed_video',
            id: config.idVideo + '-embed_video',
            anchor: '100%',
            allowBlank: true,
            hidden: true,
        }];

        var defFields = ['resource_id', 'context_key', 'cultureKey', 'block_id', 'provider',
            'field_id', 'grid_id', 'path', 'video_id', 'thumbnail_width', 'thumbnail_height'];
        defFields.forEach(function (name){
            fields.push({
                xtype: 'hidden',
                name: name
            })
        });
        return fields;
    },

    getInput: function (input) {
        return Ext.getCmp(this.idVideo + '-' + input);
    },

    setPreview: function (video) {
        this.getPreview(video, (record) => {
            // Заполняем данные
            this.setValues(record);
            // Показываем поля
            this.showField(record);
            // Показываем превью картинки
            if(record.thumbnail) {
                this.getInput('thumbnail').updateImage(record.thumbnail);
            }
        });
    },

    getPreview: function (video, callback) {
        MODx.Ajax.request({
            url: PageBlocks.config.connectorUrl,
            params: {
                action: 'mgr/video/parse',
                data: Ext.util.JSON.encode(urlParser.parse(video)),
            },
            listeners: {
                success: {
                    fn: function (r) {
                        if(typeof callback == 'function') {
                            callback.call(this, r.object);
                        }
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

    showField: function (object) {
        for (const [key, value] of Object.entries(object)) {
            if(['title', 'description', 'thumbnail', 'embed_video'].includes(key)) {
                this.getInput(key).show();
            }
        }
    },

});
Ext.reg('pb-video-upload', PageBlocks.window.VideoUpload);