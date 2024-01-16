popupcontent.combo.Types = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0
            ,fields: ['type']
            ,data: [
                ['image'],
                ['inline']
            ]
        })
        ,mode: 'local'
        ,displayField: 'type'
        ,valueField: 'type'
    });
    popupcontent.combo.Types.superclass.constructor.call(this,config);
};
Ext.extend(popupcontent.combo.Types,MODx.combo.ComboBox);
Ext.reg('popupcontent-combo-types',popupcontent.combo.Types);