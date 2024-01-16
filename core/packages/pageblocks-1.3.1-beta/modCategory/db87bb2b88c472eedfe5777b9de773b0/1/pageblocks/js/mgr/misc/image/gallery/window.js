PageBlocks.window.GalleryImage = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = Ext.id();
    }
    Ext.applyIf(config, {
        title: config.record['name'],
        width: 500,
        url: PageBlocks.config.connector_url,
        action: 'mgr/gallery/update',
        fields: this.getFields(config),
        buttons: this.getButtons(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    PageBlocks.window.GalleryImage.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.window.GalleryImage, MODx.Window, {

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
            id: config.id + '-id'
        }, {
            xtype: 'textfield',
            fieldLabel: _('pb_gallery_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '100%',
            allowBlank: false,
        }, {
            xtype: 'label',
            cls: 'desc-under',
            text: _('pb_gallery_name_desc')
        },{
            xtype: 'textfield',
            fieldLabel: _('pb_gallery_title'),
            name: 'title',
            id: config.id + '-title',
            anchor: '100%',
            allowBlank: true,
        }, {
            xtype: 'textarea',
            fieldLabel: _('pb_gallery_desc'),
            name: 'description',
            id: config.id + '-description',
            anchor: '100%',
            allowBlank: true,
        }];
    },

    loadDropZones: function() {}

});
Ext.reg('pb-gallery-image', PageBlocks.window.GalleryImage);