PageBlocks.panel.Gallery = function (config) {
    config = config || {};
    config.idPanel = Ext.id();
    config.idButton = Ext.id();

    Ext.apply(config, {
        border: false,
        id: config.idPanel,
        cls: 'pb-image-gallery',
        style: {padding: '0'},
        layout: 'anchor',
        hideMode: 'visibility',
        items: [{
            xtype: 'label',
            cls: 'desc-under',
            text: config.gallery_help,
            hidden: Ext.isEmpty(config.gallery_help) ? 1 : 0,
        }, {
            name: config.name,
            border: false,
            xtype: 'pb-gallery-images-panel',
            id: config.idPanel + '-images',
            pageSize: config.pageSize || (MODx.config.default_per_page / 2),

            resource_id: PageBlocks.resource.id,
            context_key: PageBlocks.resource.context_key,
            cultureKey: MODx.config.cultureKey,
            block_id: config.block_id,
            version_id: config.version_id,
            baseblock: config.baseblock,
            unique: config.unique,
            table_id: config.table_id,
            field_id: config.field_id,
            grid_id: config.grid_id,
            source: config.source,
            source_path: config.source_path,
            idButton: config.idButton,
            idPanel: config.idPanel
        }]
    });
    PageBlocks.panel.Gallery.superclass.constructor.call(this, config);

    this.on('afterrender', function () {
        window.setTimeout(() => {
            this.initialize();
        }, 300);
    });
};
Ext.extend(PageBlocks.panel.Gallery, MODx.Panel, {
    errors: [],
    progress: null,

    initialize: function () {
        if (this.initialized) {
            return;
        }
        this._initUploader();

        var el = document.getElementById(this.id);
        el.addEventListener('dragenter', function () {
            if (!this.className.match(/drag-over/)) {
                this.className += ' drag-over';
            }
        }, false);
        el.addEventListener('dragleave', function () {
            this.className = this.className.replace(' drag-over', '');
        }, false);
        el.addEventListener('drop', function () {
            this.className = this.className.replace(' drag-over', '');
        }, false);

        this.initialized = true;
    },

    _initUploader: function () {
        var params = {
            action: 'mgr/gallery/upload',
            resource_id: PageBlocks.resource.id,
            context_key: PageBlocks.resource.context_key,
            cultureKey: MODx.config.cultureKey,
            block_id: this.block_id,
            version_id: this.version_id,
            table_id: this.table_id,
            field_id: this.field_id,
            grid_id: this.grid_id,
            source: this.source,
            source_path: this.source_path,
            HTTP_MODAUTH: MODx.siteId
        };

        this.uploader = new plupload.Uploader({
            url: PageBlocks.config.connector_url + '?' + Ext.urlEncode(params),
            browse_button: this.idButton + '-upload-btn',
            container: this.id,
            drop_element: this.id,
            multipart: true,
            max_file_size: MODx.config.upload_maxsize,
            filters: [{
                extensions: PageBlocks.config.media_source[this.source].allowedFileTypes || MODx.config.upload_files
            }],
        });

        var uploaderEvents = ['QueueChanged', 'UploadProgress', 'FileUploaded', 'UploadComplete'];
        Ext.each(uploaderEvents, function (v) {
            var fn = 'on' + v;
            this.uploader.bind(v, this[fn], this);
        }, this);
        this.updateList = true;
        this.uploader.init();
    },

    onFileUploaded: function (uploader, file, xhr) {
        var r = Ext.util.JSON.decode(xhr.response);
        if (!r.success) {
            if(typeof this.errors != 'object') {
                this.errors = [];
            }
            this.errors.push(r.message);
        }
    },

    onQueueChanged: function (up) {
        if (this.updateList) {
            if (this.uploader.files.length > 0) {
                this.progress = Ext.MessageBox.progress(_('please_wait'));
                this.uploader.start();
            }
            else if (this.progress) {
                this.progress.hide();
            }
            up.refresh();
        }
    },

    onUploadProgress: function (uploader, file) {
        if (this.progress) {
            this.progress.updateText(file.name);
            this.progress.updateProgress(file.percent / 100);
        }
    },

    onUploadComplete: function () {
        if (this.progress) {
            this.progress.hide();
        }
        if (this.errors.length > 0) {
            this.fireAlert();
        }
        this.resetUploader();
    },

    resetUploader: function () {
        var images = Ext.getCmp(this.idPanel + '-view');
        if(images) {
            images.ownerCt.bottomToolbar.doRefresh();
        }
        this.uploader.files = {};
        this.uploader.destroy();
        this.errors = [];
        this._initUploader();
    },

    fireAlert: function () {
        MODx.msg.alert(_('error'), this.errors.join('<br>'));
        this.errors = [];
    },

    removeFile: function (id) {
        this.updateList = true;
        var f = this.uploader.getFile(id);
        this.uploader.removeFile(f);
    },


});
Ext.reg('pb-image-gallery', PageBlocks.panel.Gallery);