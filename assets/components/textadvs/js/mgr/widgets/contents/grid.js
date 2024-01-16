textAdvs.grid.Contents = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'txa-grid-contents';
    }
    config['actionPrefix'] = 'mgr/content/';
    Ext.applyIf(config, {
        baseParams: {
            action: config['actionPrefix'] + 'getlist',
            object: config['object_id'] || 0,
        },
        multi_select: true,
        pageSize: 5,
        // enableDragDrop: true,
        // ddGroup: config['id'],
        // ddAction: config['actionPrefix'] + 'sort',
        cls: ' ',
    });
    textAdvs.grid.Contents.superclass.constructor.call(this, config);
};
Ext.extend(textAdvs.grid.Contents, textAdvs.grid.Default, {
    getFields: function (config) {
        return [
            'id',
            'object',
            'name',
            'content',
            'content_formatted',
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
            header: _('txa_grid_object'),
            dataIndex: 'object',
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
            hidden: false,
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
            xtype: 'txa-window-content-create',
            id: Ext.id(),
            listeners: {
                success: {fn: this._listenerRefresh, scope: this},
                // hide: {fn: this._listenerRefresh, scope: this},
                failure: {fn: this._listenerHandler, scope: this},
            },
        });
        w.reset();
        w.setValues({
            object: this.config['object_id'],
            content: '',
            active: true,
        });
        w.show(e['target']);
    },

    updateObject: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        } else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

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

                        var w = MODx.load({
                            xtype: 'txa-window-content-update',
                            id: Ext.id(),
                            record: r,
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
Ext.reg('txa-grid-contents', textAdvs.grid.Contents);