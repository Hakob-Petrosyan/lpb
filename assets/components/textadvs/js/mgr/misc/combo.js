/**
 *
 * @param config
 * @constructor
 */
textAdvs.combo.Search = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        xtype: 'twintrigger',
        ctCls: 'x-field-search',
        allowBlank: true,
        msgTarget: 'under',
        emptyText: _('search'),
        name: 'query',
        triggerAction: 'all',
        clearBtnCls: 'x-field-search-clear',
        searchBtnCls: 'x-field-search-go',
        onTrigger1Click: this._triggerSearch,
        onTrigger2Click: this._triggerClear,
    });
    textAdvs.combo.Search.superclass.constructor.call(this, config);
    this.on('render', function () {
        this.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
            this._triggerSearch();
        }, this);
        this.positionEl.setStyle('margin-right', '1px');
    });
    this.addEvents('clear', 'search');
};
Ext.extend(textAdvs.combo.Search, Ext.form.TwinTriggerField, {
    initComponent: function () {
        Ext.form.TwinTriggerField.superclass.initComponent.call(this);
        this.triggerConfig = {
            tag: 'span',
            cls: 'x-field-search-btns',
            cn: [
                {tag: 'div', cls: 'x-form-trigger ' + this.searchBtnCls},
                {tag: 'div', cls: 'x-form-trigger ' + this.clearBtnCls}
            ]
        };
    },
    _triggerSearch: function () {
        this.fireEvent('search', this);
    },
    _triggerClear: function () {
        this.fireEvent('clear', this);
    },
});
Ext.reg('txa-combo-search', textAdvs.combo.Search);
Ext.reg('txa-field-search', textAdvs.combo.Search);


/**
 *
 * @param config
 * @constructor
 */
textAdvs.combo.Template = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'template',
        fieldLabel: config['name'] || 'template',
        hiddenName: config['name'] || 'template',
        url: textAdvs.config['connector_url'],
        baseParams: {
            action: 'mgr/combo/gettemplates',
            filter: config['filter'] || 0,
            notempty: config['notempty'] || 1,
            combo: config['combo'] || 1,
        },
        typeAhead: false,
        editable: true,
        anchor: '100%',
        listEmptyText: '<div style="padding: 7px;">' + _('txa_combo_list_empty') + '</div>',
        tpl: new Ext.XTemplate('\
            <tpl for="."><div class="x-combo-list-item txa-combo__list-item">\
                <span style="font-weight:bold">\
                    {templatename:htmlEncode}\
                </span>\
                <tpl if="category_name"> - <span style="font-style:italic">{category_name:htmlEncode}</span></tpl>\
                <br>{description:htmlEncode()}\
            </div></tpl>',
            {compiled: true}
        ),
    });
    textAdvs.combo.Template.superclass.constructor.call(this, config);

    // // Обновляем список при открытии
    // this.on('expand', function () {
    //     this.getStore().load();
    // }, this);
};
Ext.extend(textAdvs.combo.Template, MODx.combo.Template);
Ext.reg('txa-combo-template', textAdvs.combo.Template);


/**
 *
 * @param config
 * @constructor
 */
textAdvs.combo.Position = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'position',
        fieldLabel: config['name'] || 'position',
        hiddenName: config['name'] || 'position',
        displayField: 'display',
        valueField: 'value',
        fields: ['value', 'display'],
        url: textAdvs.config['connector_url'],
        baseParams: {
            action: 'mgr/combo/getpositions',
            filter: config['filter'] || 0,
            notempty: config['notempty'] || 1,
        },
        pageSize: 20,
        typeAhead: false,
        editable: false,
        anchor: '100%',
        listEmptyText: '<div style="padding: 7px;">' + _('txa_combo_list_empty') + '</div>',
        tpl: new Ext.XTemplate('\
            <tpl for="."><div class="x-combo-list-item txa-combo__list-item">\
                <span>\
                    {display}\
                </span>\
            </div></tpl>',
            {compiled: true}
        ),
    });
    textAdvs.combo.Position.superclass.constructor.call(this, config);

    // // Обновляем список при открытии
    // this.on('expand', function () {
    //     this.getStore().load();
    // }, this);
};
Ext.extend(textAdvs.combo.Position, MODx.combo.ComboBox);
Ext.reg('txa-combo-position', textAdvs.combo.Position);


/**
 *
 * @param config
 * @constructor
 */
textAdvs.combo.Tag = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'tag',
        fieldLabel: config['name'] || 'tag',
        hiddenName: config['name'] || 'tag',
        displayField: 'display',
        valueField: 'value',
        fields: ['value', 'display'],
        url: textAdvs.config['connector_url'],
        baseParams: {
            action: 'mgr/combo/gettags',
            filter: config['filter'] || 0,
            notempty: config['notempty'] || 1,
        },
        pageSize: 20,
        typeAhead: false,
        editable: false,
        anchor: '100%',
        listEmptyText: '<div style="padding: 7px;">' + _('txa_combo_list_empty') + '</div>',
        tpl: new Ext.XTemplate('\
            <tpl for="."><div class="x-combo-list-item txa-combo__list-item">\
                <span>\
                    {display:htmlEncode}\
                </span>\
            </div></tpl>',
            {compiled: true}
        ),
    });
    textAdvs.combo.Tag.superclass.constructor.call(this, config);

    // // Обновляем список при открытии
    // this.on('expand', function () {
    //     this.getStore().load();
    // }, this);
};
Ext.extend(textAdvs.combo.Tag, MODx.combo.ComboBox);
Ext.reg('txa-combo-tag', textAdvs.combo.Tag);