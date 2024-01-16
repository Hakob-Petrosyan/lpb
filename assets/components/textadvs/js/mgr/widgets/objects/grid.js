textAdvs.grid.Objects = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'txa-grid-objects';
    }
    config['actionPrefix'] = 'mgr/object/';
    Ext.applyIf(config, {
        baseParams: {
            action: config['actionPrefix'] + 'getlist',
            sort: 'id',
            dir: 'DESC',
        },
        multi_select: true,
        // pageSize: Math.round(MODx.config['default_per_page'] / 2),
        // enableDragDrop: true,
        // ddGroup: config['id'],
        // ddAction: config['actionPrefix'] + 'sort',
    });
    textAdvs.grid.Objects.superclass.constructor.call(this, config);
};
Ext.extend(textAdvs.grid.Objects, textAdvs.grid.Default, {
    getFields: function (config) {
        return [
            'id',
            'name',
            'content_formatted',
            'position',
            'tag',
            'index',
            'template',
            'template_formatted',
            'active',
            'actions',
        ];
    },

    getColumns: function (config) {
        return [{
            header: _('txa_grid_id'),
            dataIndex: 'id',
            width: 70,
            sortable: true,
            fixed: true,
            resizable: false,
            hidden: true,
        }, {
            header: _('txa_grid_name'),
            dataIndex: 'name',
            width: 200,
            sortable: true,
        }, {
            header: _('txa_grid_content'),
            dataIndex: 'content_formatted',
            width: 400,
            sortable: false,
            hidden: true,
        }, {
            header: _('txa_grid_position'),
            dataIndex: 'position',
            width: 80,
            sortable: false,
            fixed: true,
            resizable: false,
            renderer: textAdvs.renderer['Position'],
        }, {
            header: _('txa_grid_tag'),
            dataIndex: 'tag',
            width: 200,
            renderer: textAdvs.renderer['Tag'],
        }, {
            header: _('txa_grid_index'),
            dataIndex: 'index',
            width: 80,
            sortable: false,
            fixed: true,
            resizable: false,
        }, {
            header: _('txa_grid_template'),
            dataIndex: 'template_formatted',
            width: 150,
            sortable: true,
            renderer: textAdvs.renderer['Template'],
        }, {
            header: _('txa_grid_active'),
            dataIndex: 'active',
            width: 70,
            sortable: true,
            fixed: true,
            resizable: false,
            renderer: textAdvs.renderer['Boolean'],
            hidden: true,
        }, {
            header: _('txa_grid_actions'),
            dataIndex: 'actions',
            id: 'actions',
            width: 150,
            sortable: false,
            fixed: true,
            resizable: false,
            renderer: textAdvs.renderer['Actions'],
        }];
    },

    getTopBar: function (config) {
        return [{
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('txa_button_create'),
            cls: 'primary-button',
            handler: this.createObject,
            scope: this,
        }, '->', this.getSearchField(config)];
    },

    getListeners: function (config) {
        return {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateObject(grid, e, row);
            },
        };
    },

    createObject: function (btn, e) {
        var w = MODx.load({
            xtype: 'txa-window-object-create',
            id: Ext.id(),
            listeners: {
                success: {
                    fn: function (r) {
                        var w = this;
                        w._listenerRefresh(r, function (r) {
                            if (r.a.result['object']) {
                                w.updateObject('', '', {
                                    data: r.a.result['object'],
                                });
                            }
                        });
                    },
                    scope: this
                },
                // hide: {fn: this._listenerRefresh, scope: this},
                failure: {fn: this._listenerHandler, scope: this},
            },
        });
        w.reset();
        w.setValues({
            position: 'before',
            index: 1,
            template: '_',
            content: '',
            active: true,
        });
        w.show(e['target']);
    },

    updateObject: function (btn, e, row, activeTab) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        } else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        if (typeof(activeTab) == 'undefined') {
            activeTab = 0;
        }

        MODx.Ajax.request({
            url: this.config['url'],
            params: {
                action: this['actionPrefix'] + 'get',
                id: id,
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var values = r['object'];
                        values['template'] = values['template'] === null ? '_' : values['template'];

                        var w = MODx.load({
                            xtype: 'txa-window-object-update',
                            id: Ext.id(),
                            record: r,
                            activeTab: activeTab,
                            listeners: {
                                success: {fn: this._listenerRefresh, scope: this},
                                // hide: {fn: this._listenerRefresh, scope: this},
                                failure: {fn: this._listenerHandler, scope: this},
                            },
                        });
                        w.reset();
                        w.setValues(values);
                        w.show(e['target']);
                    }, scope: this
                },
                failure: {fn: this._listenerHandler, scope: this},
            }
        });
    },

    enableObject: function () {
        this.loadMask.show();
        return this._doAction('enable');
    },

    disableObject: function () {
        this.loadMask.show();
        return this._doAction('disable');
    },

    removeObject: function () {
        return this._doAction('remove', null, true);
    },
});
Ext.reg('txa-grid-objects', textAdvs.grid.Objects);