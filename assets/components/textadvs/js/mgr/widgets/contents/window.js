/**
 * Вкладки/поля для окон добавления/редактирования
 *
 * @param config
 * @returns {{object}}
 * @constructor
 */
textAdvs.fields.Content = function (config) {
    var data = config['record'] ? config.record['object'] : null;
    var r = [];

    r.push({
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
        anchor: '100%',
        items: [{
            columnWidth: 1,
            layout: 'form',
            items: [{
                xtype: Ext.ComponentMgr.types['modx-texteditor'] ? 'modx-texteditor' : 'textarea',
                id: config['id'] + '-content',
                name: 'content',
                // fieldLabel: _('txa_field_content'),
                hideLabel: true,
                anchor: '100%',
                height: 200,
            }],
        }],
    });

    r.push({
        xtype: 'hidden',
        id: config['id'] + '-object',
        name: 'object',
    });

    if (data) {
        r.push({
            xtype: 'hidden',
            id: config['id'] + '-id',
            name: 'id',
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
textAdvs.window.ContentCreate = function (config) {
    config = config || {};
    if (!config['id']) {
        config['id'] = 'txa-window-content-create';
    }
    Ext.applyIf(config, {
        title: _('txa_window_content_create'),
        baseParams: {
            action: 'mgr/content/create',
        },
        modal: true,
    });
    textAdvs.window.ContentCreate.superclass.constructor.call(this, config);
};
Ext.extend(textAdvs.window.ContentCreate, textAdvs.window.Default, {
    getFields: function (config) {
        return textAdvs.fields.Content(config);
    },
});
Ext.reg('txa-window-content-create', textAdvs.window.ContentCreate);

/**
 * Окно редактирования объекта
 *
 * @param config
 * @constructor
 */
textAdvs.window.ContentUpdate = function (config) {
    config = config || {};
    if (!config['id']) {
        config['id'] = 'txa-window-content-update';
    }
    Ext.applyIf(config, {
        title: _('txa_window_content_update'),
        baseParams: {
            action: 'mgr/content/update',
        },
        modal: true,
    });
    textAdvs.window.ContentUpdate.superclass.constructor.call(this, config);
};
Ext.extend(textAdvs.window.ContentUpdate, textAdvs.window.Default, {
    getFields: function (config) {
        return textAdvs.fields.Content(config);
    },
});
Ext.reg('txa-window-content-update', textAdvs.window.ContentUpdate);