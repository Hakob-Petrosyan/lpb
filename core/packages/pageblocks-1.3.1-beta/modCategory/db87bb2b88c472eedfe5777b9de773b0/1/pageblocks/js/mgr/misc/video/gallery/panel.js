PageBlocks.panel.VideoGallery = function (config) {
    config = config || {};
    config.idPanel = Ext.id();
    config.idButton = Ext.id();

    Ext.apply(config, {
        border: false,
        id: config.idPanel,
        cls: 'pb-video-gallery',
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
            xtype: 'pb-gallery-videos-panel',
            id: config.idPanel + '-videos',
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
    PageBlocks.panel.VideoGallery.superclass.constructor.call(this, config);

    this.on('afterrender', function () {
        window.setTimeout(() => {
            this.initialize();
        }, 300);
    });
};
Ext.extend(PageBlocks.panel.VideoGallery, MODx.Panel, {
    errors: [],
    progress: null,

    initialize: function () {
        if (this.initialized) {
            return;
        }

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

});
Ext.reg('pb-video-gallery', PageBlocks.panel.VideoGallery);