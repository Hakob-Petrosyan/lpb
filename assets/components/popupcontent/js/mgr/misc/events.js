// Events
popupcontent.combo.Events = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0
            ,fields: ['event']
            ,data: [
                ['click'],
                ['time']
            ]
        })
        ,mode: 'local'
        ,displayField: 'event'
        ,valueField: 'event'
    });
    popupcontent.combo.Events.superclass.constructor.call(this,config);
};
Ext.extend(popupcontent.combo.Events,MODx.combo.ComboBox);
Ext.reg('popupcontent-combo-events',popupcontent.combo.Events);

// How show
popupcontent.combo.Howshow = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0
            ,fields: ['value','alias']
            ,data: [
                ['1','Раз в сутки'],
                ['0','При каждом заходе']
            ]
        })
        ,mode: 'local'
        ,displayField: 'alias'
        ,valueField: 'value'
    });
    popupcontent.combo.Howshow.superclass.constructor.call(this,config);
};
Ext.extend(popupcontent.combo.Howshow,MODx.combo.ComboBox);
Ext.reg('popupcontent-combo-howshow',popupcontent.combo.Howshow);

// wheretoplay
popupcontent.combo.Wheretoplay = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0
            ,fields: ['value','alias']
            ,data: [
                ['all','На всех страницах'],
                ['some','На определенных']
            ]
        })
        ,mode: 'local'
        ,displayField: 'alias'
        ,valueField: 'value'
    });
    popupcontent.combo.Wheretoplay.superclass.constructor.call(this,config);
};
Ext.extend(popupcontent.combo.Wheretoplay,MODx.combo.ComboBox);
Ext.reg('popupcontent-combo-wheretoplay',popupcontent.combo.Wheretoplay);

// clickdo - действия при клике
popupcontent.combo.Clickdo = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0
            ,fields: ['value','alias']
            ,data: [
                ['nothing','Ничего'],
                ['link','Ссылка'],
                ['scroll','Скролл']
            ]
        })
        ,mode: 'local'
        ,displayField: 'alias'
        ,valueField: 'value'
    });
    popupcontent.combo.Clickdo.superclass.constructor.call(this,config);
};
Ext.extend(popupcontent.combo.Clickdo,MODx.combo.ComboBox);
Ext.reg('popupcontent-combo-clickdo', popupcontent.combo.Clickdo);