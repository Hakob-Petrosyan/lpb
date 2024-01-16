PageBlocks.panel.Video = function (config) {
    config = config || {};
    config.idVideo = Ext.id();
    Ext.apply(config, {
        baseCls: 'pb-panel-video',
        id: config.idVideo,
        layout: 'anchor',
        hideMode: 'offsets',
        items: this.getFields(config),
    });
    PageBlocks.panel.Video.superclass.constructor.call(this, config);

};
Ext.extend(PageBlocks.panel.Video, MODx.Panel, {

    getFields: function (config) {
        return [{
            xtype: 'trigger',
            id: config.idVideo + '-input',
            name: config.name,
            allowBlank: config.allowBlank,
            msgTarget: 'title',
            triggerConfig: {
                tag: 'div',
                cls: 'pb-combo-btns',
                cn: [
                    {tag: 'div', cls: 'x-form-trigger icon icon-close', trigger: 'clear'},
                    {tag: 'div', cls: 'x-form-trigger icon icon-refresh', trigger: 'refresh'},
                    {tag: 'div', cls: 'x-form-trigger icon icon-update', trigger: 'update'}
                ]
            },
            onTriggerClick:  function(event, btn) {
                switch (btn.getAttribute('trigger')) {
                    case 'clear':
                        this.setValue('');
                        this.fireEvent('change', this);
                        break;
                    case 'refresh':
                        this.fireEvent('refresh', this);
                        break;
                    default:
                        this.fireEvent('update', this);
                }
            },
            listeners: {
                afterrender: (el) => {
                    if(!Ext.isEmpty(el.getValue())) {
                        this.setUrl();
                    }
                },
                change: (el) => {
                    var value = el.getValue();
                    if(Ext.isEmpty(value)) {
                        this.removePreview();
                    } else {
                        this.getPreview(value, (record) => {
                            if(!Ext.isEmpty(record.embed_video)) {
                                this.updatePreview(record);
                                if(this.record.id) {
                                    this.updateVideo(record);
                                } else {
                                    this.createVideo(record);
                                }
                            }
                        });
                    }
                },
                refresh: (el) => {
                    var value = el.getValue();
                    if(Ext.isEmpty(value)) return;
                    this.refreshVideo(value);
                },
                update: (el) => {
                    var value = el.getValue();
                    if(Ext.isEmpty(value)) return;
                    if(!this.record || !this.record.id) {
                        this.getPreview(value, (record) => {
                            this.updatePreview(record);
                            this.updateData(record);
                        });
                    } else {
                        this.getPreview(value, (record) => {
                            this.updateData(record);
                        });
                    }
                }
            },
        }, {
            xtype: 'label',
            cls: 'desc-under',
            text: config.video_help,
            hidden: Ext.isEmpty(config.video_help) ? 1 : 0,
        }, {
            anchor: '100%',
            html: '',
            defaults: {msgTarget: 'under'},
            id: config.idVideo + '-preview',
        }];
    },

    getInput: function (input) {
        return Ext.getCmp(this.idVideo + '-' + input);
    },

    removePreview: function () {
        if(!this.preview) {
            this.preview = this.getInput('preview');
        }
        this.preview.update('');
    },

    createVideo: function (record) {
        MODx.Ajax.request({
            url: PageBlocks.config.connectorUrl,
            params: Object.assign({
                action: 'mgr/video/create',
                resource_id: PageBlocks.resource.id,
                context_key: PageBlocks.resource.context_key,
                cultureKey: MODx.config.cultureKey,
                block_id: this.block_id,
                field_id: this.field_id,
                grid_id: this.grid_id,
                path: this.source_path,
            }, record),
            listeners: {
                success: {
                    fn: function (r) {
                        if(r.object.id) {
                            this.record.id = r.object.id
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

    updateVideo: function (record) {
        record.action = 'mgr/video/update';
        MODx.Ajax.request({
            url: PageBlocks.config.connectorUrl,
            params: record,
            listeners: {
                success: {
                    fn: function () {
                        MODx.msg.status({
                            title: _('success'),
                        })
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

    getPreview: function (video, callback) {
        var id = this.record ? this.record.id : 0;
        MODx.Ajax.request({
            url: PageBlocks.config.connectorUrl,
            params: {
                action: 'mgr/video/parse',
                data: Ext.util.JSON.encode(urlParser.parse(video)),
            },
            listeners: {
                success: {
                    fn: function (r) {
                        this.record = r.object;
                        if(id) this.record.id = id;
                        if(typeof callback == 'function') {
                            callback.call(this, r.object);
                        }
                    }, scope: this
                },
                failure: {
                    fn: function (response) {
                        MODx.msg.alert(_('error'), response.message);
                        this.removePreview();
                    }, scope: this
                },
            }
        })
    },

    updatePreview: function (record) {
        this.preview = this.getInput('preview');
        var video = record.embed_video;
        if(!Ext.isEmpty(video)) {
            video = PageBlocks.utils.renderVideo(video, record.title);
        }
        this.preview.update(video);
    },

    updateData: function (record) {
        MODx.Ajax.request({
            url: PageBlocks.config.connector_url,
            params: {
                action: 'mgr/video/get',
                id: record.id,
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

    refreshVideo: function (video) {
        Ext.MessageBox.show({
            title : _('pb_video_refresh_title'),
            msg : _('pb_video_refresh_desc'),
            width : 300,
            buttons : Ext.MessageBox.YESNO,
            fn : function(answer) {
                if(answer == 'yes') {
                    this.getPreview(video, this.updateVideo);
                }
            },
            scope: this,
            icon : Ext.MessageBox.QUESTION
        });
    },

    setUrl: function () {
        this.getUrl((value) => {
            this.preview = this.getInput('input');
            this.preview.setValue(value.url);
            this.getPreview(value.url, (record) => {
                this.updatePreview(record);
                this.record.id = value.id;
            });
        });
    },

    getUrl: function (callback) {
        MODx.Ajax.request({
            url: PageBlocks.config.connectorUrl,
            params: {
                action: 'mgr/video/geturl',
                resource_id: PageBlocks.resource.id,
                context_key: PageBlocks.resource.context_key,
                cultureKey: MODx.config.cultureKey,
                block_id: this.block_id,
                field_id: this.field_id,
                grid_id: this.grid_id,
            },
            listeners: {
                success: {
                    fn: function (record) {
                        if(record.success) {
                            if(typeof callback == 'function') {
                                callback.call(this, record);
                            }
                        } else {
                            this.getInput('input').setValue('');
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
});
Ext.reg('pb-panel-video', PageBlocks.panel.Video);