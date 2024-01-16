PageBlocks.window.versionView = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-version-window-view';
    }
    config.richtext = [];
    Ext.applyIf(config, {
        title: config.record.block_name,
        cls: 'modx-window pageblocks-window',
        width: 750,
        autoHeight: true,
        maxHeight: 600,
        autoScroll: true,
        url: PageBlocks.config.connector_url,
        action: 'mgr/version/restore',
        fields: this.getFields(config),
        saveBtnText: _("pb_version_btn_restore"),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                "close" !== config.closeAction ? this.hide() : this.close()
            }, scope: this
        }],
    });
    PageBlocks.window.versionView.superclass.constructor.call(this, config);

    this.on('beforeSubmit', function(values) {
        if(typeof CKEDITOR == 'object') {
            config.richtext.forEach(function (field){
                var content = CKEDITOR.instances[config.id + '-' + field].getData();
                Ext.getCmp(config.id + '-' + field).setValue(content);
            });
        }
    });
};
Ext.extend(PageBlocks.window.versionView, MODx.Window, {

    getFields: function (config) {

        var chunk = false;
        var record = config.record;
        var tabs = record.groups;
        var all = [];

        PageBlocks.resource = {};
        PageBlocks.resource.id = record.resource_id;
        PageBlocks.resource.context_key = record.context_key;

        // Формируем поля
        tabs.forEach(function(tab) {

            var column = false;
            var index = 0;
            var items = [];
            tab['fields'].forEach(function (field) {

                if(field.name == 'chunk') chunk = true;

                var result = PageBlocks.utils.createField(field,record,config);
                var xtype = result.field;
                xtype.version_id = record.id;

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
        ['id', 'version_id'].forEach(function (field){
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
            checked: config.record ? config.record['active'] : true,
        });

        return fields;
    },

});
Ext.reg('pb-version-window-view', PageBlocks.window.versionView);