var textAdvs = function (config) {
    config = config || {};
    textAdvs.superclass.constructor.call(this, config);
};
Ext.extend(textAdvs, Ext.Component, {
    page: {},
    window: {},
    grid: {},
    tree: {},
    panel: {},
    formpanel: {},
    combo: {},
    config: {},
    view: {},
    ux: {},
    utils: {},
    renderer: {},
    fields: {},
});
Ext.reg('textadvs', textAdvs);

textAdvs = new textAdvs();