var popupcontent = function (config) {
    config = config || {};
    popupcontent.superclass.constructor.call(this, config);
};
Ext.extend(popupcontent, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('popupcontent', popupcontent);

popupcontent = new popupcontent();