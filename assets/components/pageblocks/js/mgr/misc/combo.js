PageBlocks.combo.ComboBoxDefault = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        assertValue : function () {
            var val = this.getRawValue(),
                rec;
            if (this.valueField && Ext.isDefined(this.value)) {
                rec = this.findRecord(this.valueField, this.value);
            }
            if (rec && rec.get(this.displayField) != val) {
                rec = null;
            }
            if (!rec && this.forceSelection) {
                if (val.length > 0 && val != this.emptyText) {
                    this.el.dom.value = Ext.value(this.lastSelectionText, '');
                    this.applyEmptyText();
                } else {
                    this.clearValue();
                }
            } else {
                if (rec && this.valueField) {
                    if (this.value == val) {
                        return;
                    }
                    val = rec.get(this.valueField || this.displayField);
                }
                this.setValue(val);
            }
        },

    });
    PageBlocks.combo.ComboBoxDefault.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.combo.ComboBoxDefault, MODx.combo.ComboBox);
Ext.reg('pb-combo-combobox-default', PageBlocks.combo.ComboBoxDefault);

PageBlocks.combo.Search = function (config) {
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
    PageBlocks.combo.Search.superclass.constructor.call(this, config);
    this.on('render', function () {
        this.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
            this._triggerSearch();
        }, this);
    });
    this.addEvents('clear', 'search');
};
Ext.extend(PageBlocks.combo.Search, Ext.form.TwinTriggerField, {

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
Ext.reg('pb-combo-search', PageBlocks.combo.Search);
Ext.reg('pb-field-search', PageBlocks.combo.Search);

PageBlocks.combo.Types = function(config) {
    config = config || {};

    var data = [
        [_('text'),'textfield'],
        [_('textarea'),'textarea'],
        [_('richtext'),'richtext'],
        [_('listbox'),'listbox'],
        [_('listbox-multiple'),'listbox-multiple'],
        [_('list') + ' ' + _('yesno'),'pb-combo-boolean'],
        [_('numberfield'),'numberfield'],
        [_('checkbox'),'checkboxgroup'],
        [_('pb_checkbox_bool'),'checkbox-bool'],
        [_('option'),'radiogroup'],
        [_('file'),'modx-combo-browser'],
        [_('image'),'pb-panel-image'],
        [_('pb_image_gallery'),'pb-image-gallery'],
        [_('pb_video'),'pb-panel-video'],
        [_('pb_video_gallery'),'pb-video-gallery'],
        [_('date'),'datefield'],
        [_('pb_timefield'),'timefield'],
        [_('resourcelist'),'pb-combo-resource'],
        [_('pb_xtype'),'pb-xtype'],
        [_('pb_grid'),'pb-grid-table'],
        [_('hidden'),'hidden'],
    ];

    var ace = (typeof(MODx.ux) != 'undefined' && typeof(MODx.ux.Ace) == 'function') ? 1 : 0;
    if (ace) {
        data.push([_('ace'), 'modx-texteditor'])
    }

    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 'value',
            fields: ['display','value'],
            data: data
        }),
        mode: 'local',
        displayField: 'display',
        valueField: 'value',
    });
    PageBlocks.combo.Types.superclass.constructor.call(this,config);
};
Ext.extend(PageBlocks.combo.Types,MODx.combo.ComboBox);
Ext.reg('pb-combo-field-types',PageBlocks.combo.Types);

PageBlocks.combo.ResourceFieldTypes = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0,
            fields: ['display','value'],
            data: [
                ['Text','textfield'],
                ['Textarea','textarea'],
                ['Richtext','richtext'],
                ['Number','numberfield'],
                ['Checkbox','xcheckbox'],
                ['Boolean','pb-combo-boolean'],
                ['Date','datefield'],
                ['Time','timefield'],
                ['Display','displayfield'],
            ]
        }),
        mode: 'local',
        displayField: 'display',
        valueField: 'value',
    });
    PageBlocks.combo.ResourceFieldTypes.superclass.constructor.call(this,config);
};
Ext.extend(PageBlocks.combo.ResourceFieldTypes,MODx.combo.ComboBox);
Ext.reg('pb-combo-resource-field-types',PageBlocks.combo.ResourceFieldTypes);

PageBlocks.combo.Boolean = function(config) {
    config = config || {};

    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0,
            fields: ['display','value'],
            data: [[_('yes'),1], [_('no'),0]]
        }),
        mode: 'local',
        displayField: 'display',
        valueField: 'value',
    });
    PageBlocks.combo.Boolean.superclass.constructor.call(this,config);
};
Ext.extend(PageBlocks.combo.Boolean,MODx.combo.ComboBox);
Ext.reg('pb-combo-boolean',PageBlocks.combo.Boolean);

PageBlocks.combo.Listbox = function(config) {

    var store = [];
    if (config.all) {
        store.push([
            _('pb_export_all'), ''
        ])
    }
    if (!Ext.isEmpty(config.values)) {
        var all = Object.values(config.values);
        all.forEach(function (value){
            store.push([
                value['name'],
                value['id']
            ]);
        })
    } else if (!Ext.isEmpty(config.data)) {
        var all = config.data.split('||');
        all.forEach(function (value) {
            var val = value.split('==');
            store.push([
                val[0],
                val[1] || val[0]
            ]);
        });
    }

    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0,
            fields: ['display','value'],
            data: store,
        }),
        mode: 'local',
        displayField: 'display',
        valueField: 'value',
        listeners: {
            render: function (el) {
                el.setValue('');
            }
        }
    });

    PageBlocks.combo.Listbox.superclass.constructor.call(this,config);
};
Ext.extend(PageBlocks.combo.Listbox,MODx.combo.ComboBox);
Ext.reg('pb-combo-listbox',PageBlocks.combo.Listbox);

PageBlocks.combo.ListboxMulti = function (config) {
    var store = [];
    if (!Ext.isEmpty(config.data)) {
        var all = config.data.split('||');
        all.forEach(function (value) {
            var val = value.split('==');
            store.push([
                val[0],
                val[1] || val[0]
            ]);
        });
    }

    config = config || {};
    Ext.applyIf(config, {
        xtype:'superboxselect',
        store: new Ext.data.ArrayStore({
            id: 0,
            fields: ['display','value'],
            data: store
        }),
        mode: 'local',
        displayField: 'display',
        valueField: 'value',
        triggerAction: 'all',
        extraItemCls: 'x-tag',
        expandBtnCls: 'x-form-trigger',
        clearBtnCls: 'x-form-trigger',
        renderTo: Ext.getBody(),
    });
    config.name += '[]';

    PageBlocks.combo.ListboxMulti.superclass.constructor.call(this, config);
};p
Ext.extend(PageBlocks.combo.ListboxMulti, Ext.ux.form.SuperBoxSelect);
Ext.reg('pb-combo-listbox-multiple', PageBlocks.combo.ListboxMulti);

PageBlocks.combo.Resource = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        displayField: 'pagetitle',
        valueField: 'id',
        editable: true,
        fields: ['id', 'pagetitle'],
        pageSize: 10,
        emptyText: _('pb_combo_empty'),
        // hideMode: 'offsets',
        mode: 'remote',
        url: PageBlocks.config['connector_url'],
        baseParams: {
            action: 'mgr/combo/resource/getlist',
            combo: true,
            where: config.where,
            sort: 'id',
        }
    });
    PageBlocks.combo.Resource.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.combo.Resource, PageBlocks.combo.ComboBoxDefault);
Ext.reg('pb-combo-resource', PageBlocks.combo.Resource);

PageBlocks.combo.FieldRender = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 'value',
            fields: ['display','value'],
            data: [
                ['',''],
                [_('block_render_image'),'renderImage'],
                [_('block_render_date'),'renderDate'],
                [_('block_render_boolean'),'renderBoolean'],
                [_('block_render_resource'),'renderResource'],
            ]
        }),
        mode: 'local',
        displayField: 'display',
        valueField: 'value',
    });
    PageBlocks.combo.FieldRender.superclass.constructor.call(this,config);
};
Ext.extend(PageBlocks.combo.FieldRender,MODx.combo.ComboBox);
Ext.reg('pb-combo-field-render',PageBlocks.combo.FieldRender);

PageBlocks.combo.Getlist = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        editable: true,
        pageSize: 10,
        emptyText: _('pb_combo_empty'),
        fields: ['id', 'name'],
        displayField: 'name',
        valueField: 'id',
        hiddenName: config.name,
        mode: 'remote',
        // hideMode: 'offsets',
        url: PageBlocks.config['connector_url'],
        width: '100%',
        anchor: '100%',
        allowBlank: false,
    });
    PageBlocks.combo.Getlist.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.combo.Getlist, PageBlocks.combo.ComboBoxDefault);
Ext.reg('pb-combo-getlist', PageBlocks.combo.Getlist);

PageBlocks.combo.Languages = function(config) {
    config = config || {};

    var store = [];
    if (!Ext.isEmpty(MODx.config.pageblocks_languages)) {
        var languages = MODx.config.pageblocks_languages.split('||');
        languages.forEach(function (language){
            language = language.split('==');
            store.push([
                language[0],
                language[1] || language[0]
            ]);
        });
    }

    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 'value',
            fields: ['display','value'],
            data: store
        }),
        mode: 'local',
        displayField: 'display',
        valueField: 'value',
    });
    PageBlocks.combo.Languages.superclass.constructor.call(this,config);
};
Ext.extend(PageBlocks.combo.Languages,MODx.combo.ComboBox);
Ext.reg('pb-combo-language', PageBlocks.combo.Languages);