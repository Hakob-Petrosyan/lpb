PageBlocks.window.listBlock = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-block-window-list';
    }
    Ext.applyIf(config, {
        title: _('pb_block_create'),
        width: 750,
        autoHeight: true,
        maxHeight: 600,
        autoScroll: true,
        url: PageBlocks.config.connector_url,
        fields: this.getBlocks(config),
        buttons: [],
    });

    PageBlocks.window.listBlock.superclass.constructor.call(this, config);

    this.on('afterrender', function() {
        if (this.getHeight() > this.maxHeight) {
            this.setHeight(this.maxHeight);
        }
        this.center();
    }, this);
};
Ext.extend(PageBlocks.window.listBlock, MODx.Window, {
    windows:{},

    getBlocks: function (config) {
        var items = [{
            columnWidth: .33,
            items: [],
        }, {
            columnWidth: .33,
            items: [],
        }, {
            columnWidth: .33,
            items: [],
        }];
        var index = 0;

        if(!Ext.isArray(config.record.results)) {
            config.record.results = Object.values(config.record.results);
        }

        config.record.results.forEach((block) => {
            items[index++].items.push({
                xtype: 'button',
                text: block.name,
                name: block.name,
                constructor_id: block.id,
                anchor: '100%',
                cls : 'x-btn x-btn-small',
                handler: this.getFields,
                scope: this
            });
            if(index == 3) index = 0;
        });

        return [{
            layout: 'column',
            style: {margin: '15px 0'},
            items: items
        }];
    },

    getFields: function (btn,e){
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/constructor/get',
                fields: 1,
                id: btn.constructor_id,
                baseblock: 0,
            },
            listeners: {
                success: {
                    fn: function (r) {
                        r.object.id = 0;
                        this.close();
                        var w = MODx.load({
                            xtype: 'pb-block-window-create',
                            record: r,
                            id: Ext.id(),
                            listeners: {
                                success: function () {
                                    Ext.getCmp('pb-grid-blocks').refresh();
                                }
                            }
                        });
                        w.reset();
                        w.setValues({
                            resource_id: PageBlocks.resource.id,
                            context_key: PageBlocks.resource.context_key,
                            cultureKey: MODx.config.cultureKey,
                            chunk: r.object.chunk,
                            constructor_id: btn.constructor_id,
                            active: true,
                            baseblock: 0,
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

});
Ext.reg('pb-block-window-list', PageBlocks.window.listBlock);

PageBlocks.window.listBaseBlock = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-base-block-window-list';
    }

    Ext.applyIf(config, {
        title: _('pb_baseblock_added'),
        width: 750,
        autoHeight: true,
        maxHeight: 600,
        autoScroll: true,
        url: PageBlocks.config.connector_url,
        fields: this.getBlocks(config),
        buttons: [],
    });

    PageBlocks.window.listBaseBlock.superclass.constructor.call(this, config);

    this.on('afterrender', function() {
        if (this.getHeight() > this.maxHeight) {
            this.setHeight(this.maxHeight);
        }
        this.center();
    }, this);
};
Ext.extend(PageBlocks.window.listBaseBlock, MODx.Window, {
    windows:{},

    getBlocks: function (config) {
        var items = [{
            columnWidth: .33,
            items: [],
        }, {
            columnWidth: .33,
            items: [],
        }, {
            columnWidth: .33,
            items: [],
        }];
        var index = 0;
        config.record.results.forEach((block) => {
            items[index++].items.push({
                xtype: 'button',
                text: block.block_name + ' (' + block.id + ')',
                name: block.block_name,
                constructor_id: +block.constructor_id,
                collection_id: +config.record.collection_id || 0,
                baseblock: +block.id,
                anchor: '100%',
                cls : 'x-btn x-btn-small',
                handler: this.addBlock,
                scope: this
            });
            if(index == 3) index = 0;

        });

        return [{
            layout: 'column',
            style: {margin: '15px 0'},
            items: items
        }];
    },

    addBlock: function (config) {
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/block/copy',
                id: config.baseblock,
                baseblock: config.baseblock,
                resource_id: PageBlocks.resource.id,
                context_key: PageBlocks.resource.context_key,
                cultureKey: MODx.config.cultureKey,
                collection_id: config.collection_id,
            },
            listeners: {
                success: {
                    fn: function () {
                        this.close();
                        if(config.collection_id) {
                            Ext.getCmp('pb-grid-blocks-' + config.collection_id).getBottomToolbar().doRefresh();
                        } else {
                            Ext.getCmp('pb-grid-blocks').getBottomToolbar().doRefresh();
                        }
                    }, scope: this
                },
                failure: {
                    fn: function (r) {
                        console.log(r);
                    }, scope: this
                }
            }
        });
    }


});
Ext.reg('pb-base-block-window-list', PageBlocks.window.listBaseBlock);

PageBlocks.window.addBlock = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-block-window-create';
    }
    config.richtext = [];
    Ext.applyIf(config, {
        title: _('pb_block_create') + ': ' + config.record.object.name,
        cls: 'modx-window pageblocks-window',
        width: 750,
        autoHeight: true,
        maxHeight: 600,
        autoScroll: true,
        url: PageBlocks.config.connector_url,
        action: 'mgr/block/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });

    PageBlocks.window.addBlock.superclass.constructor.call(this, config);

    this.on('beforeSubmit', function(values) {
        if(typeof CKEDITOR == 'object') {
            config.richtext.forEach(function (field){
                var content = CKEDITOR.instances[config.id + '-' + field].getData();
                Ext.getCmp(config.id + '-' + field).setValue(content);
            });
        }
    });
};
Ext.extend(PageBlocks.window.addBlock, MODx.Window, {

    getFields: function (config){
        var chunk = false;
        var record = config.record.object;
        var tabs = record.groups;
        var all = [];

        // Формируем поля
        tabs.forEach(function(tab) {

            var column = false;
            var index = 0;
            var items = [];
            tab['fields'].forEach(function (field) {

                if(field.name == 'chunk') chunk = true;

                var result = PageBlocks.utils.createField(field, record, config);
                var xtype = result.field;

                // for CKEDITOR
                if(xtype.richtext) {
                    config.richtext.push(xtype.name);
                }

                if(field.width == 100) {
                    items.push(xtype);
                    if(!Ext.isEmpty(xtype.help)) {
                        items.push({
                            xtype: 'label',
                            cls: 'desc-under',
                            text: field.help
                        });
                    }
                    column = false;
                    index = 0;
                } else {
                    if(!column) {
                        items.push({
                            layout: 'column',
                            items:[{
                                columnWidth: .5,
                                layout: 'form',
                                width:'100%',
                                defaults: {msgTarget: 'under'},
                                items:[]
                            },{
                                columnWidth: .5,
                                layout: 'form',
                                width:'100%',
                                defaults: {msgTarget: 'under'},
                                items:[]
                            }]
                        });
                        column = true;
                    }

                    var width = field.width / 100;
                    if(index) {
                        width = (100 - items[items.length-1].items[0].columnWidth * 100) / 100;
                    }
                    items[items.length-1].items[index].columnWidth = width;

                    var shorty = items[items.length-1].items[index++].items;
                    shorty.push(xtype);

                    if(!Ext.isEmpty(xtype.help)) {
                        shorty.push({
                            xtype: 'label',
                            cls: 'desc-under',
                            text: field.help
                        });
                    }

                    if(index == 2) {
                        index = 0;
                        column = false;
                    }
                }
            });
            all.push({
                name: tab.name,
                fields: items
            });
        });

        // Добавляем скрытые поля
        var fields = [];
        ['id', 'resource_id', 'context_key', 'cultureKey', 'constructor_id', 'collection_id', 'chunk', 'baseblock'].forEach(function (field) {
            if(field == 'chunk' && chunk) return false;
            fields.push({
                xtype: 'hidden',
                name: field,
                id: config.id + '-' + field,
            })
        });

        // Формируем вкладки
        var tabFields = [];
        all.forEach(function(tab) {
            if(Ext.isEmpty(tab.name)) {
                tab.fields.forEach(function (field) {
                    fields.push(field);
                });
            } else {
                tabFields.push({
                    title: tab.name,
                    hideMode: 'offsets',
                    layout: 'form',
                    border: false,
                    items: tab.fields
                })
            }
        });
        if(tabFields.length) {
            fields.push({
                xtype: 'modx-tabs',
                deferredRender: false,
                // defaults: {border: false, autoHeight: true},
                border: true,
                style: {margin: '10px 0 0'},
                items: tabFields
            });
        }

        fields.push({
            xtype: 'xcheckbox',
            boxLabel: _('pb_grid_active'),
            name: 'active',
            id: config.id + '-active',
            checked: config.record ? config.record.object['active'] : true,
        });
        if(+record.baseblock && +PageBlocks.resource.id) {
            fields.push({
                xtype: 'xcheckbox',
                boxLabel: _('pb_block_unique'),
                name: 'unique',
                id: config.id + '-unique',
                checked: config.record ? config.record.object['unique'] : true,
            }, {
                xtype: 'label',
                id: config.id + '-unique-desc',
                cls: 'desc-under',
                text: _('pb_block_unique_desc')
            });
        }
        console.log(fields);
        return fields;
    },

});
Ext.reg('pb-block-window-create', PageBlocks.window.addBlock);

PageBlocks.window.updateBlock = function (config) {

    config = config || {};
    if (!config.id) {
        config.id = 'pb-block-window-update';
    }

    Ext.applyIf(config, {
        title: _('pb_block_update') + ': ' + config.record.object.block_name,
        action: 'mgr/block/update',
    });
    PageBlocks.window.updateBlock.superclass.constructor.call(this, config);

};
Ext.extend(PageBlocks.window.updateBlock, PageBlocks.window.addBlock);
Ext.reg('pb-block-window-update', PageBlocks.window.updateBlock);

PageBlocks.window.languageDuplicate = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-block-languages-dublicate';
    }
    Ext.applyIf(config, {
        title: _('pb_language_duplicate'),
        width: 450,
        autoHeight: true,
        url: PageBlocks.config.connector_url,
        action: 'mgr/block/language',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });

    PageBlocks.window.languageDuplicate.superclass.constructor.call(this, config);

};
Ext.extend(PageBlocks.window.languageDuplicate, MODx.Window, {
    windows: {},

    getFields: function (config) {

        return [{
            xtype: 'hidden',
            name: 'resource_id',
        }, {
            xtype: 'hidden',
            name: 'collection_id',
        }, {
            xtype: 'pb-combo-language',
            fieldLabel: _('pb_language_old'),
            name: 'language_old',
            hiddenName: 'language_old',
            id: config.id + '-language_old',
            anchor: '99%',
            allowBlank: false,
            listeners: {
                render: function (language) {
                    if(Ext.isEmpty(language.value)) {
                        language.setValue(MODx.config.cultureKey);
                    }
                },
            }
        }, {
            xtype: 'pb-combo-language',
            fieldLabel: _('pb_language_new'),
            name: 'language_new',
            hiddenName: 'language_new',
            id: config.id + '-language_new',
            anchor: '99%',
            allowBlank: false,
        }];
    }
});
Ext.reg('pb-block-language-dublicate', PageBlocks.window.languageDuplicate);

PageBlocks.window.Export = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-blocks-export';
    }
    Ext.applyIf(config, {
        title: _('pb_export'),
        width: 450,
        autoHeight: true,
        url: PageBlocks.config.connector_url,
        action: 'mgr/block/export',
        fields: this.getFields(config),
        saveBtnText: _('pb_export'),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });

    PageBlocks.window.Export.superclass.constructor.call(this, config);

};
Ext.extend(PageBlocks.window.Export, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'resource_id',
        }, {
            xtype: 'hidden',
            name: 'context_key',
        }, {
            xtype: 'hidden',
            name: 'collection_id',
        }, {
            xtype: 'pb-combo-language',
            fieldLabel: _('pb_language'),
            name: 'language',
            hiddenName: 'language',
            id: config.id + '-language',
            anchor: '99%',
            allowBlank: false,
            hidden: MODx.config.pageblocks_languages ? false : true,
            listeners: {
                render: function (language) {
                    if(Ext.isEmpty(language.value)) {
                        language.setValue(MODx.config.cultureKey);
                    }
                },
            }
        }, {
            xtype: 'pb-combo-listbox',
            fieldLabel: _('pb_blocks'),
            name: 'block_id',
            hiddenName: 'block_id',
            id: config.id + '-block',
            anchor: '99%',
            allowBlank: true,
            all: 1,
            values: config.record.results,
            hidden: config.collection_id ? true : false,
        }];
    }
});
Ext.reg('pb-blocks-export', PageBlocks.window.Export);

PageBlocks.window.Import = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-blocks-import';
    }
    Ext.applyIf(config, {
        title: _('pb_import'),
        width: 450,
        autoHeight: true,
        url: PageBlocks.config.connector_url,
        action: 'mgr/block/import',
        fields: this.getFields(config),
        fileUpload: true,
        enctype : 'multipart/form-data',
        saveBtnText: _('pb_import'),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });

    PageBlocks.window.Import.superclass.constructor.call(this, config);

};
Ext.extend(PageBlocks.window.Import, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'resource_id',
        }, {
            xtype: 'hidden',
            name: 'context_key',
        }, {
            xtype: 'hidden',
            name: 'collection_id',
        }, {
            xtype: 'hidden',
            name: 'cultureKey',
        }, {
            xtype: 'textfield',
            fieldLabel: _('pb_import_delimiter'),
            name: 'delimiter',
            id: config.id + '-delimiter',
            anchor: '99%',
            allowBlank: false,
            listeners: {
                render: el => {
                    if(Ext.isEmpty(el.value)) {
                        el.setValue(',');
                    }
                }
            }

        }, {
            xtype: 'fileuploadfield',
            fieldLabel: _('pb_import_file'),
            name: 'import',
            id: config.id + '-import',
            anchor: '99%',
            allowBlank: false,
        }];
    }
});
Ext.reg('pb-blocks-import', PageBlocks.window.Import);

PageBlocks.window.CopyResource = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-blocks-copy-resource';
    }
    Ext.applyIf(config, {
        title: _('pb_block_copy_resource'),
        width: 450,
        autoHeight: true,
        url: PageBlocks.config.connector_url,
        action: 'mgr/multiple',
        fields: this.getFields(config),
        saveBtnText: _('pb_copy'),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });

    PageBlocks.window.CopyResource.superclass.constructor.call(this, config);

};
Ext.extend(PageBlocks.window.CopyResource, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'resource_id',
        }, {
            xtype: 'hidden',
            name: 'context_key',
        }, {
            xtype: 'hidden',
            name: 'cultureKey',
        }, {
            xtype: 'hidden',
            name: 'collection_id',
        }, {
            xtype: 'pb-combo-resource',
            fieldLabel: _('pb_resource'),
            name: 'donor',
            hiddenName: 'donor',
            id: config.id + '-donor',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'label',
            cls: 'desc-under',
            text: _('pb_block_copy_resource_desc'),
        }, {
            xtype: 'pb-combo-language',
            fieldLabel: _('pb_language'),
            name: 'language',
            hiddenName: 'language',
            id: config.id + '-language',
            anchor: '99%',
            allowBlank: false,
            hidden: MODx.config.pageblocks_languages ? false : true,
            listeners: {
                render: function (language) {
                    if(Ext.isEmpty(language.value)) {
                        language.setValue(MODx.config.cultureKey);
                    }
                },
            }
        }, {
            xtype: 'label',
            cls: 'desc-under',
            text: _('pb_block_copy_language_desc'),
        }];
    }
});
Ext.reg('pb-blocks-copy-resource', PageBlocks.window.CopyResource);

PageBlocks.window.CopyBlockId = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-block-copy-id';
    }
    Ext.applyIf(config, {
        title: _('pb_block_copy_id'),
        width: 450,
        autoHeight: true,
        url: PageBlocks.config.connector_url,
        action: 'mgr/block/copy',
        fields: this.getFields(config),
        saveBtnText: _('pb_copy'),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });

    PageBlocks.window.CopyBlockId.superclass.constructor.call(this, config);

};
Ext.extend(PageBlocks.window.CopyBlockId, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'resource_id',
        }, {
            xtype: 'hidden',
            name: 'context_key',
        }, {
            xtype: 'hidden',
            name: 'cultureKey',
        }, {
            xtype: 'hidden',
            name: 'collection_id',
        }, {
            xtype: 'numberfield',
            fieldLabel: _('pb_id'),
            name: 'id',
            hiddenName: 'id',
            id: config.id + '-id',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'label',
            cls: 'desc-under',
            text: _('pb_block_copy_id_desc'),
        }];
    }
});
Ext.reg('pb-block-copy-id', PageBlocks.window.CopyBlockId);

PageBlocks.window.updateChunk = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-chunk-window-update';
    }
    Ext.applyIf(config, {
        title: _('pb_block_update_chunk') + ': ' + config.record.object.chunk,
        cls: 'modx-window pageblocks-window',
        width: 750,
        autoHeight: true,
        maxHeight: 600,
        autoScroll: true,
        url: MODx.config.connector_url,
        action: 'element/chunk/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });

    PageBlocks.window.updateChunk.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.window.updateChunk, MODx.Window, {

    getFields: function (config){
        var ace = (typeof(MODx.ux) != 'undefined' && typeof(MODx.ux.Ace) == 'function') ? 1 : 0;
        return [{
            xtype: 'hidden',
            name: 'id'
        }, {
            xtype: 'hidden',
            name: 'name'
        }, {
            xtype: ace ? 'modx-texteditor': 'textarea',
            fieldLabel: _('chunk_code'),
            name: 'snippet',
            id: config.id + '-snippet',
            anchor: '100%',
            height: 200,
            allowBlank: false,
            mimeType: ace ? 'text/x-smarty' : 'text/html',
            modxTags: true,
            listeners: {
                render: function (el) {
                    if(el.getValue() == 'undefined' || Ext.isEmpty(el.getValue())) {
                        el.setValue('');
                    }
                    el.setHeight(el.height);
                }
            }
        }];
    },

});
Ext.reg('pb-chunk-window-update', PageBlocks.window.updateChunk);