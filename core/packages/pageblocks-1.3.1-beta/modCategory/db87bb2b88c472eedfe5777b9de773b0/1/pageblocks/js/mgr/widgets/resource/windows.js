PageBlocks.window.ResourceFieldCreate = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-resource-field-window-create';
    }
    Ext.applyIf(config, {
        title: _('block_field_create'),
        width: 600,
        autoHeight: true,
        url: PageBlocks.config.connector_url,
        action: 'mgr/resource/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    PageBlocks.window.ResourceFieldCreate.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.window.ResourceFieldCreate, MODx.Window, {

    getFields: function (config) {
        var editable = config.record ? true : false;

        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: editable ? 'statictextfield' : 'textfield',
            fieldLabel: _('block_field_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
            listeners: {
                render: function(name){
                    if(editable) {
                        name.setReadOnly(true);
                    }
                }
            }
        }, {
            xtype: 'label',
            cls: 'desc-under',
            text: editable ? _('block_field_name_fix_desc') : _('block_field_name_desc')
        }, {
            xtype: 'pb-combo-resource-field-types',
            fieldLabel: _('block_field_xtype'),
            name: 'xtype',
            hiddenName: 'xtype',
            id: config.id + '-xtype',
            anchor: '99%',
            allowBlank: false,
            listeners: {
                render: function(xtype){
                    if(Ext.isEmpty(xtype.value)) {
                        xtype.setValue('textfield');
                    }
                }
            }
        }];
    },

});
Ext.reg('pb-resource-field-window-create', PageBlocks.window.ResourceFieldCreate);

PageBlocks.window.ResourceFieldUpdate = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'pb-resource-field-window-update';
    }
    Ext.applyIf(config, {
        title: _('block_field_update') + ': ' + config.record.name,
        action: 'mgr/resource/update',
    });
    PageBlocks.window.ResourceFieldUpdate.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.window.ResourceFieldUpdate, PageBlocks.window.ResourceFieldCreate);
Ext.reg('pb-resource-field-window-update', PageBlocks.window.ResourceFieldUpdate);