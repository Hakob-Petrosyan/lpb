PageBlocks.utils.renderBoolean = function (value) {
    return +value
        ? String.format('<span class="green">{0}</span>', _('yes'))
        : String.format('<span class="red">{0}</span>', _('no'));
};

PageBlocks.utils.renderImage = function (value) {

    if (!Ext.isEmpty(value)) {
        if (!/\/\//.test(value)) {
            if (!/^\//.test(value)) {
                value = '/' + value;
            }
        }
    }
    if (!value.indexOf('.svg')) {
        value = MODx.config.connectors_url+'system/phpthumb.php?h=200&f=png&src='+value+'&source=1';
    }

    return String.format('<img src="{0}" style="max-width:100%;height:auto;margin:10px auto"/>', value);
};

PageBlocks.utils.renderVideoPreview = function (value, width, height) {
    return String.format('<img src="{0}" style="max-width:100%;height:auto;margin:10px auto" width="{1}" height="{2}"/>', value, width, height);
};

PageBlocks.utils.renderVideo = function (url, title) {
    return String.format('<iframe width="720" height="405" style="max-width:100%;margin:10px auto" src="{0}" title="{1}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>', url, title);
};

PageBlocks.utils.renderDate = function(a) {
    if (Ext.isEmpty(a)) {
        return '—';
    }
    return a;
}

PageBlocks.utils.getMenu = function (actions, grid, selected) {
    var menu = [];
    var cls, icon, title, action;

    var has_delete = false;
    for (var i in actions) {
        if (!actions.hasOwnProperty(i)) {
            continue;
        }

        var a = actions[i];
        if (!a['menu']) {
            if (a == '-') {
                menu.push('-');
            }
            continue;
        }
        else if (menu.length > 0 && !has_delete && (/^remove/i.test(a['action']) || /^delete/i.test(a['action']))) {
            menu.push('-');
            has_delete = true;
        }

        if (selected.length > 1) {
            if (!a['multiple']) {
                continue;
            }
            else if (typeof(a['multiple']) == 'string') {
                a['title'] = a['multiple'];
            }
        }

        icon = a['icon'] ? a['icon'] : '';
        if (typeof(a['cls']) == 'object') {
            if (typeof(a['cls']['menu']) != 'undefined') {
                icon += ' ' + a['cls']['menu'];
            }
        }
        else {
            cls = a['cls'] ? a['cls'] : '';
        }
        title = a['title'] ? a['title'] : a['title'];
        action = a['action'] ? grid[a['action']] : '';

        menu.push({
            handler: action,
            text: String.format(
                '<span class="{0}"><i class="x-menu-item-icon {1}"></i>{2}</span>',
                cls, icon, title
            ),
            scope: grid
        });
    }

    return menu;
};

PageBlocks.utils.renderActions = function (value, props, row) {
    var res = [];
    var cls, icon, title, action, item;
    for (var i in row.data.actions) {
        if (!row.data.actions.hasOwnProperty(i)) {
            continue;
        }
        var a = row.data.actions[i];
        if (!a['button']) {
            continue;
        }

        icon = a['icon'] ? a['icon'] : '';
        if (typeof(a['cls']) == 'object') {
            if (typeof(a['cls']['button']) != 'undefined') {
                icon += ' ' + a['cls']['button'];
            }
        }
        else {
            cls = a['cls'] ? a['cls'] : '';
        }
        action = a['action'] ? a['action'] : '';
        title = a['title'] ? a['title'] : '';

        item = String.format(
            '<li class="{0}"><button class="pb-btn pb-btn-default {1}" action="{2}" title="{3}"></button></li>',
            cls, icon, action, title
        );

        res.push(item);
    }

    return String.format(
        '<ul class="pageblocks-row-actions">{0}</ul>',
        res.join('')
    );
};

PageBlocks.utils.createField = function (field, record, config) {
    var values = record.values ? JSON.parse(record.values)[field.name] : '';
    var xtype = {
        xtype: field.xtype,
        fieldLabel: field.caption,
        name: field.name,
        id: config.id + '-' + field.name,
        anchor: '99%',
        width: '100%',
        allowBlank: !field.required,
        source: field.source,
        block_id: record.block_id || (record.constructor_id ? record.id : 0),
        grid_id: record.constructor_id ? 0 : record.id,
        source_path: field.source_path || MODx.config.pageblocks_source_path,
        help: field.help,
        listeners: {
            render: function(el) {
                if(!Ext.isEmpty(field.default) && Ext.isEmpty(el.value)) {
                    if(typeof el.setValue == 'function') {
                        el.setValue(field.default);
                    }
                }
            }
        }
    }

    switch(field.xtype) {
        case 'richtext':
            xtype.xtype = 'textarea';
            xtype.height = 300;
            xtype.richtext = 1;
            xtype.listeners = {
                render: function (el) {
                    if(!Ext.isEmpty(field.default) && Ext.isEmpty(el.value)) {
                        el.setValue(field.default);
                    }

                    if (MODx.loadRTE) {
                        window.setTimeout(function() {
                            MODx.loadRTE(el.id);
                        }, 300);
                    }
                }
            };
            break;
        case 'listbox':
            xtype.xtype = 'pb-combo-listbox';
            xtype.fields = ['display','value'];
            xtype.data = field.values;
            xtype.hiddenName = field.name;
            break;
        case 'listbox-multiple':
            xtype.xtype = 'pb-combo-listbox-multiple';
            xtype.data = field.values;
            xtype.listeners = {
                render: function (el) {
                    el.setValue(values);
                }
            }
            break;
        case 'pb-combo-boolean':
            xtype.hiddenName = field.name;
            break;
        // https://docs.sencha.com/extjs/4.2.6/#!/api/Ext.form.field.Number
        case 'numberfield':
            xtype.inputType = 'number';
            xtype.cls = 'x-form-text';
            if(!field.number_allownegative) {
                xtype.minValue = 0;
            }
            if(!Ext.isEmpty(field.number_minvalue)) {
                xtype.minValue = field.number_minvalue;
            }
            if(!Ext.isEmpty(field.number_maxvalue)) {
                xtype.maxValue = field.number_maxvalue;
            }
            break;
        // https://docs.sencha.com/extjs/4.2.6/#!/api/Ext.form.CheckboxGroup
        case 'checkboxgroup':
            xtype.columns = field.columns || 1;
            xtype.items = [];
            xtype.name = '';
            field.values.split('||').forEach(function (value){
                var val = value.split('==');
                xtype.items.push({
                    xtype: 'xcheckbox',
                    boxLabel: val[0],
                    inputValue: val[1] || val[0],
                    name: field.name + '[]',
                    id: config.id + '-' + Ext.id(),
                    checked: values ? values.includes(val[1] || val[0]) : false,
                    listeners: {
                        render: function(el) {
                            if(!Ext.isEmpty(field.default) && Ext.isEmpty(el.inputValue)) {
                                el.setValue(field.default);
                            }
                        }
                    }
                });
            });
            break;
        case 'checkbox-bool':
            xtype.hideLabel = true;
            xtype.xtype = 'xcheckbox';
            xtype.boxLabel = field.caption;
            xtype.inputValue = +field.default || 0;
            xtype.name = field.name;
            xtype.checked = +values;
            xtype.listeners = {
                afterrender: function(el) {
                    if(!Ext.isEmpty(field.default) && Ext.isEmpty(values)) {
                        el.setValue(+field.default);
                    }
                    if(values) {
                        el.setValue(+values);
                    }
                }
            };
            break;
        // https://docs.sencha.com/extjs/4.2.6/#!/api/Ext.form.RadioGroup
        case 'radiogroup':
            // xtype.hideLabel = true;
            xtype.columns = field.columns || 1;
            xtype.items = [];
            xtype.name = '';
            xtype.listeners = {};
            field.values.split('||').forEach(function (value){
                var val = value.split('==');
                xtype.items.push({
                    boxLabel: val[0],
                    inputValue: val[1] || val[0],
                    name: field.name,
                    id: config.id + '-' + Ext.id(),
                    checked: values ? values.includes(val[1] || val[0]) : (field.default == (val[1] || val[0]) ? true : false),
                });
            });
            break;
        case 'modx-combo-browser':
            xtype.rootVisible = field.rootVisible || false;
            xtype.allowedFileTypes = field.allowedFileTypes || '';
            xtype.wctx = field.wctx || 'web';
            xtype.openTo = field.openTo || '';
            xtype.rootId = field.source_path || '/';
            xtype.hideSourceCombo = field.hideSourceCombo || true;
            xtype.hideFiles = field.hideFiles || true;
            xtype.listeners = Object.assign(xtype.listeners, {
                select: function (data) {
                    this.setValue('/' + data.fullRelativeUrl);
                }
            });
            break;
        case 'pb-panel-image':
            if(field.table_id) {
                xtype.block_id = record.block_id || 0;
            }
            xtype.field_id = field.id;
            xtype.table_id = field.table_id || 0;
            xtype.help = '';
            xtype.img_help = field.help;
            break;
        case 'pb-image-gallery':
            xtype.baseblock = record.baseblock;
            xtype.unique = +record.unique;
            xtype.table_id = field.table_id;
            if(field.table_id) {
                xtype.block_id = record.block_id || 0;
            }
            xtype.field_id = field.id;
            xtype.width = 100;
            xtype.listeners = {};
            xtype.help = '';
            xtype.gallery_help = field.help;
            break;
        case 'pb-panel-video':
            if(field.table_id) {
                xtype.block_id = record.block_id || 0;
            }
            xtype.field_id = field.id;
            xtype.table_id = field.table_id || 0;
            xtype.listeners = {};
            xtype.help = '';
            xtype.video_help = field.help;
            break;
        case 'pb-video-gallery':
            xtype.baseblock = record.baseblock;
            xtype.unique = +record.unique;
            xtype.table_id = field.table_id;
            if(field.table_id) {
                xtype.block_id = record.block_id || 0;
            }
            xtype.field_id = field.id;
            xtype.width = 100;
            xtype.listeners = {};
            xtype.help = '';
            xtype.gallery_help = field.help;
            break;
        case 'datefield':
            xtype.format = MODx.config.manager_date_format;
            break;
        case 'timefield':
            xtype.format = MODx.config.manager_time_format;
            // all[field['name']].increment = 30;
            break;
        case 'pb-combo-resource':
            xtype.hiddenName =  field.name;
            xtype.where = field.where;
            break;
        case 'pb-grid-table':
            // xtype.block_id = record.block_id || 0;
            xtype.table_id = field.table_id;
            xtype.field_table_id = field.field_table_id;
            xtype.baseblock = record.baseblock;
            xtype.unique = record.unique;
            xtype.field_id = field.id;
            xtype.table_columns = field.table_columns;
            // xtype.grid_id = record.grid_id || 0;
            break;
        case 'pb-xtype':
            xtype.xtype = field.combo;
            if(field.combo == 'xdatetime') {
                xtype.format = MODx.config.manager_time_format;
            }
            if(field.combo == 'modx-description') {
                xtype.listeners = {};
                xtype.html = field.default;
            }
            break;
        case 'modx-texteditor':
            xtype.height = 200;
            xtype.mimeType = 'text/x-smarty';
            xtype.modxTags = true;
            xtype.listeners = {
                render: function (el) {
                    if(el.getValue() == 'undefined') {
                        el.setValue('');
                    }
                }
            };

            break;
    }

    field.field = xtype;

    return field;
}