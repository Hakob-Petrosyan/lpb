/**
 * Вкладки/поля для окон добавления/редактирования
 *
 * @param config
 * @returns {{object}}
 * @constructor
 */
textAdvs.fields.Object = function (config) {
    var data = config['record'] ? config.record['object'] : null;

    var r = {
        xtype: 'modx-tabs',
        border: true,
        autoHeight: true,
        // style: {marginTop: '10px'},
        anchor: '100% 100%',
        items: [{
            title: _('txa_tab_main'),
            layout: 'form',
            cls: 'modx-panel txa-panel',
            autoHeight: true,
            items: [],
        }],
        listeners: {
            afterrender: function (tabs) {
                // Рендерим вторую вкладку, иначе данные с неё не передаются в процессор
                tabs.setActiveTab(1);
                tabs.setActiveTab(0);

                if (config['activeTab']) {
                    tabs.setActiveTab(config['activeTab']);
                }
            },
        },
    };

    r.items[0].items.push({
        layout: 'column',
        border: false,
        style: {marginTop: '0px'},
        anchor: '100%',
        items: [{
            columnWidth: .8,
            layout: 'form',
            style: {marginRight: '5px'},
            items: [{
                xtype: 'textfield',
                id: config['id'] + '-name',
                name: 'name',
                fieldLabel: _('txa_field_name'),
                anchor: '100%',
            }],
        }, {
            columnWidth: .2,
            layout: 'form',
            style: {marginTop: '20px', marginLeft: '5px'},
            items: [{
                xtype: 'xcheckbox',
                id: config['id'] + '-active',
                name: 'active',
                boxLabel: _('txa_field_active'),
            }],
        }],
    }, {
        layout: 'column',
        border: false,
        style: {marginTop: '0px'},
        anchor: '100%',
        items: [{
            columnWidth: .2,
            layout: 'form',
            style: {marginRight: '5px'},
            items: [{
                xtype: 'txa-combo-position',
                id: config['id'] + '-position',
                name: 'position',
                fieldLabel: _('txa_field_position'),
                anchor: '100%',
            }],
        }, {
            columnWidth: .6,
            layout: 'form',
            style: {marginLeft: '5px', marginRight: '5px'},
            items: [{
                xtype: 'txa-combo-tag',
                id: config['id'] + '-tag',
                name: 'tag',
                fieldLabel: _('txa_field_tag'),
                anchor: '100%',
            }],
        }, {
            columnWidth: .2,
            layout: 'form',
            style: {marginLeft: '5px'},
            items: [{
                xtype: 'numberfield',
                id: config['id'] + '-index',
                name: 'index',
                fieldLabel: _('txa_field_index'),
                anchor: '100%',
                decimalPrecision: 0,
            }],
        }],
    }, {
        layout: 'column',
        border: false,
        anchor: '100%',
        items: [{
            columnWidth: 1,
            layout: 'form',
            items: [{
                xtype: 'txa-combo-template',
                id: config['id'] + '-template',
                name: 'template',
                fieldLabel: _('txa_field_template'),
                anchor: '100%',
                // editable: true,
            }],
        }],
    });

    if (data) {
        r.items[0].items.push({
            layout: 'column',
            border: false,
            anchor: '100%',
            items: [{
                columnWidth: 1,
                layout: 'form',
                items: [{
                    xtype: 'txa-grid-contents',
                    object_id: data['id'],
                }],
            }],
        });
        r.items[0].items.push({
            xtype: 'hidden',
            id: config['id'] + '-id',
            name: 'id',
        });
    } else {
        r.items[0].items.push({
            layout: 'column',
            border: false,
            anchor: '100%',
            items: [{
                columnWidth: 1,
                layout: 'form',
                items: [{
                    html: _('txa_message_content_before_save'),
                    style: {margin: '15px 0 0', textAlign: 'center'},
                }],
            }],
        });
    }

    return r;
};

/**
 * Окно добавления объекта
 *
 * @param config
 * @constructor
 */
textAdvs.window.ObjectCreate = function (config) {
    config = config || {};
    if (!config['id']) {
        config['id'] = 'txa-window-object-create';
    }
    Ext.applyIf(config, {
        title: _('txa_window_object_create'),
        baseParams: {
            action: 'mgr/object/create',
        },
        modal: true,
    });
    textAdvs.window.ObjectCreate.superclass.constructor.call(this, config);
};
Ext.extend(textAdvs.window.ObjectCreate, textAdvs.window.Default, {
    getFields: function (config) {
        return textAdvs.fields.Object(config);
    },
});
Ext.reg('txa-window-object-create', textAdvs.window.ObjectCreate);

/**
 * Окно редактирования объекта
 *
 * @param config
 * @constructor
 */
textAdvs.window.ObjectUpdate = function (config) {
    config = config || {};
    if (!config['id']) {
        config['id'] = 'txa-window-object-update';
    }
    Ext.applyIf(config, {
        title: _('txa_window_object_update'),
        baseParams: {
            action: 'mgr/object/update',
        },
        modal: true,
        width: 750,
    });
    textAdvs.window.ObjectUpdate.superclass.constructor.call(this, config);
};
Ext.extend(textAdvs.window.ObjectUpdate, textAdvs.window.Default, {
    getFields: function (config) {
        return textAdvs.fields.Object(config);
    },
});
Ext.reg('txa-window-object-update', textAdvs.window.ObjectUpdate);