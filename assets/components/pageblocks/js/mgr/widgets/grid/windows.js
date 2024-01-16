PageBlocks.window.CreateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-grid-window-create';
    }
    config.richtext = [];
    Ext.applyIf(config, {
        title: config.record.object.table_name,
        cls: 'modx-window pageblocks-window',
        width: 750,
        autoHeight: true,
        maxHeight: 600,
        autoScroll: true,
        url: PageBlocks.config.connector_url,
        action: 'mgr/grid/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    PageBlocks.window.CreateItem.superclass.constructor.call(this, config);

    this.on('beforeSubmit', function(values) {
        if(typeof CKEDITOR == 'object') {
            config.richtext.forEach(function (field){
                var content = CKEDITOR.instances[config.id + '-' + field].getData();
                Ext.getCmp(config.id + '-' + field).setValue(content);
            });
        }
    });
};
Ext.extend(PageBlocks.window.CreateItem, MODx.Window, {

    getFields: function (config) {

        var record = config.record.object;
        var tabs = record.groups;
        var all = [];

        if (record.version_table_id) {
            record.id = record.version_table_id;
        }

        // Формируем поля
        tabs.forEach(function(tab) {

            var column = false;
            var index = 0;
            var items = [];
            tab['fields'].forEach(function (field) {

                if(field.name == 'chunk') chunk = true;

                var result = PageBlocks.utils.createField(field,record,config);
                var xtype = result.field;
                xtype.version_id = record.version_id;

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
        ['id', 'block_id', 'resource_id', 'context_key', 'cultureKey', 'table_id', 'field_id', 'grid_id'].forEach(function (field){
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

        return fields;
    },

});
Ext.reg('pb-grid-window-create', PageBlocks.window.CreateItem);


PageBlocks.window.updateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-grid-window-update';
    }

    Ext.applyIf(config, {
        title: _('pb_update') + ': ' + config.record.object.table_name,
        action: 'mgr/grid/update',
        buttons: this.getButtons(config),
    });

    PageBlocks.window.updateItem.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.window.updateItem, PageBlocks.window.CreateItem, {

    getButtons: function (config) {

        var btns = [{
            text: config.cancelBtnText || _("cancel"),
            scope: this,
            handler: function() {
                this.hide()
            }
        }];

        if (!+config.record.object.baseblock || +config.record.object.unique) {
            btns.push({
                text: config.saveBtnText || _("save"),
                cls: "primary-button",
                scope: this,
                handler: this.submit
            })
        }
            
        if (config.record.object.version_id) {
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

});
Ext.reg('pb-grid-window-update', PageBlocks.window.updateItem);