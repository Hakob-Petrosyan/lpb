PageBlocks.panel.SuperImage = function (config) {
    config = config || {};
    config.idImage = config.id || Ext.id();

    if(Ext.isEmpty(config.source) || config.source == 0) {
        config.source = MODx.config.default_media_source;
    }
    if(Ext.isEmpty(config.source_path)) {
        config.source_path = MODx.config.pageblocks_source_path;
    }

    Ext.apply(config, {
        baseCls: 'pb-panel-image',
        id: config.idImage,
        layout: 'anchor',
        hideMode: 'offsets',
        items: [{
            xtype: 'modx-combo-browser',
            name: config.name,
            id: config.idImage + '-input',
            multiple: false,
            allowBlank: config.allowBlank,
            msgTarget: 'title',
            source: config.source,
            hideSourceCombo: true,
            rootVisible: config.rootVisible || false,
            hideFiles: config.hideFiles || false,
            allowedFileTypes: config.allowedFileTypes || '',
            openTo: config.openTo || '',
            rootId: config.source_path || '/',
                triggerConfig: {
                    tag: 'div',
                    cls: 'pb-combo-btns',
                    cn: [
                        {tag: 'div', cls: 'x-form-trigger icon icon-close', trigger: 'clear'},
                        {tag: 'div', cls: 'x-form-trigger x-field-combo-list icon icon-image', trigger: 'image'},
                        {tag: 'div', cls: 'x-form-trigger icon icon-desktop', trigger: 'desktop'}
                    ]
                },
            onTriggerClick:  function(event, btn) {
                switch (btn.getAttribute('trigger')) {
                    case 'clear':
                        this.setValue('');
                        this.fireEvent('change', this);
                        break;
                    case 'desktop':
                        Ext.getCmp(config.idImage + '-file').el.dom.nextSibling.click();
                        break;
                    default:
                        this.__proto__.onTriggerClick.call(this);
                }
            },
            listeners: {
                afterrender: (el) => {
                    setTimeout(() => {
                        this.updateImage(el.value);
                    },500)
                },
                select: (data) => {
                    this.setValue(data.fullRelativeUrl || data.url);
                    this.updateImage(data.fullRelativeUrl || data.url);
                },
                change: (el) => {
                    this.updateImage(el.getValue());
                }
            },
        }, {
            xtype: 'label',
            cls: 'desc-under',
            text: config.img_help,
            hidden: Ext.isEmpty(config.img_help) ? 1 : 0,
        }, {
            anchor: '100%',
            html: '',
            bodyCssClass: '',
            id: config.idImage + '-preview',
        }]
    });
    PageBlocks.panel.SuperImage.superclass.constructor.call(this, config);

    Ext.onReady(() => this.loadFileForm());
};
Ext.extend(PageBlocks.panel.SuperImage, MODx.Panel, {

    setValue: function (value) {
        this.input = this.getInput('input');
        this.input.setValue(value);
    },

    getInput: function (input) {
        return Ext.getCmp(this.idImage + '-' + input);
    },

    updateImage: function (value) {
        this.preview = this.getInput('preview');
        if(!Ext.isEmpty(value)) {
            value = PageBlocks.utils.renderImage(value);
        }
        this.preview.update(value);
    },

    loadFileForm: function () {
        this.fileform = new PageBlocks.fileform({
            id: this.idImage + '-fileform',
            renderTo: Ext.getBody(),
            idImage: this.idImage,
            source: this.source,
            source_path: this.source_path,
            block_id: this.block_id,
            table_id: this.table_id,
            field_id: this.field_id,
            grid_id: this.grid_id,
            pbImage: this,
        });
    },

});
Ext.reg('pb-panel-image', PageBlocks.panel.SuperImage);

PageBlocks.fileform = function(config){
    config = config||{};
    Ext.applyIf(config,{
        isUpload: true,
        hidden: true,
        fileUpload: true,
        url: PageBlocks.config.connectorUrl,
        baseParams: {
            action: 'mgr/browser/file/upload',
            source: config.source,
            path: config.source_path,
            block_id: config.block_id,
            table_id: config.table_id,
            field_id: config.field_id,
            grid_id: config.grid_id,
            resource_id: PageBlocks.resource.id,
            context_key: PageBlocks.resource.context_key,
            cultureKey: MODx.config.cultureKey,
            idFile: config.idImage + '-file',
        },
        items: [{
            xtype: 'fileuploadfield',
            id: config.idImage + '-file',
            source: config.source || MODx.config.default_media_source,
            allowedFileTypes: 'png',
            listeners: {
                fileselected: (data,value) => {
                    this.onFileSelected(data,value);
                },
            }
        }],
    });
    PageBlocks.fileform.superclass.constructor.call(this,config);
};
Ext.extend(PageBlocks.fileform, Ext.FormPanel,{

    onFileSelected: function (field,value) {
        this.form.baseParams.file = value;

        this.form.submit({
            waitMsg: 'Uploading...',
            params: {},
            success: function(fp, o){
                var value = o.result.object.url;
                this.pbImage.setValue(value);
                this.pbImage.updateImage(value);
            }
            ,failure: function(fp, o) {
                MODx.msg.alert('Error', o.result.message);
            }
            ,scope:this
        });
    }

})
Ext.reg('pageblocks-fileform', PageBlocks.fileform);