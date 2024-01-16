Ext.ComponentMgr.onAvailable("modx-resource-tabs", function() {

    if (!MODx.config.pageblocks_hide_template.split(',').includes(PageBlocks.resource.template.toString())) {
        var index = +MODx.config.pageblocks_tab_index || 0;
        this.items.splice(index, 0, {
            title: _('pageblocks'),
            layout: 'form',
            cls: 'modx-resource-tab',
            id: 'modx-resource-pageblocks',
            hideMode: 'offsets',
            items: [{
                xtype: 'pb-grid-blocks',
            }]
        });
    }

    PageBlocks.collections.forEach( (collection) => {
        this.items.splice(collection.index, 0, {
            title: collection.name,
            layout: 'form',
            cls: 'modx-resource-tab',
            id: 'modx-resource-collection-' + collection.id,
            hideMode: 'offsets',
            items: [{
                xtype: 'pb-grid-collection-block',
                id: 'pb-grid-blocks-' + collection.id,
                btn_add: collection.btn_add,
                collection_id: collection.id,
                constructor_id: collection.constructor_id,
                collection_columns: collection.columns,
            }]
        });
    });

});