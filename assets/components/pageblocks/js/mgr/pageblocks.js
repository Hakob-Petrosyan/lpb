var PageBlocks = function (config) {
    config = config || {};
    PageBlocks.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {
        'Gallery' : [],
    }, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('pageblocks', PageBlocks);

PageBlocks = new PageBlocks();