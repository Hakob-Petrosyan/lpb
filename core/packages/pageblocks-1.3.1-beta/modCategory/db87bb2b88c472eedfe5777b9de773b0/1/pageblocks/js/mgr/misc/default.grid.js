PageBlocks.grid.Default = function (config) {
    config = config || {};

    if (typeof(config['multi_select']) != 'undefined' && config['multi_select'] == true) {
        config.sm = new Ext.grid.CheckboxSelectionModel();
    }

    Ext.applyIf(config, {
        url: PageBlocks.config['connector_url'],
        baseParams: {},
        cls: 'main-wrapper pageblocks-grid',
        autoHeight: true,
        paging: true,
        remoteSort: true,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        listeners: this.getListeners(config),
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: -10,
            getRowClass: function (rec) {
                var rowClass = [];
                if (!rec.data.active && rec.data.active !== undefined) {
                    rowClass.push('pb-grid-row-disabled');
                }

                if (rec.data.baseblock && rec.data.resource > 0) {
                    rowClass.push('pb-grid-row-baseblock');
                }

                return rowClass.join(' ');
            }
        },
    });
    PageBlocks.grid.Default.superclass.constructor.call(this, config);

    if (config.enableDragDrop && config.ddAction) {
        this.on('render', function(grid) {
            grid._initDD(config);
        });
    }
};
Ext.extend(PageBlocks.grid.Default, MODx.grid.Grid, {

    getFields: function () {
        return [
            'id', 'actions', 'active'
        ];
    },

    getColumns: function () {
        return [{
            header: _('id'),
            dataIndex: 'id',
            width: 35,
            sortable: true,
        }, {
            header: _('pageblocks_actions'),
            dataIndex: 'actions',
            renderer: PageBlocks.utils.renderActions,
            sortable: false,
            width: 75,
            id: 'actions'
        }];
    },

    getTopBar: function () {
        return ['->', this.getSearchField()];
    },

    getSearchField: function (width) {
        return {
            xtype: 'pageblocks-field-search',
            width: width || 250,
            listeners: {
                search: {
                    fn: function (field) {
                        this._doSearch(field);
                    }, scope: this
                },
                clear: {
                    fn: function (field) {
                        field.setValue('');
                        this._clearSearch();
                    }, scope: this
                },
            }
        };
    },

    getListeners: function () {
        return {};
    },

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();
        var row = grid.getStore().getAt(rowIndex);
        var menu = PageBlocks.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    onClick: function (e) {
        var elem = e.getTarget();
        if (elem.nodeName == 'BUTTON') {
            var row = this.getSelectionModel().getSelected();
            if (typeof(row) != 'undefined') {
                var action = elem.getAttribute('action');
                if (action == 'showMenu') {
                    var ri = this.getStore().find('id', row.id);
                    return this._showMenu(this, ri, e);
                }
                else if (typeof this[action] === 'function') {
                    this.menu.record = row.data;
                    return this[action](this, e);
                }
            }
        }
        return this.processEvent('click', e);
    },

    refresh: function() {
        this.getStore().reload();
        if (this.config['enableDragDrop'] == true) {
            this.getSelectionModel().clearSelections(true);
        }
    },

    _doSearch: function (tf) {
        this.getStore().baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
    },

    _clearSearch: function () {
        this.getStore().baseParams.query = '';
        this.getBottomToolbar().changePage(1);
    },

    _getSelectedIds: function () {
        var ids = [];
        var selected = this.getSelectionModel().getSelections();

        for (var i in selected) {
            if (!selected.hasOwnProperty(i)) {
                continue;
            }
            ids.push(selected[i]['id']);
        }

        return ids;
    },

    _initDD: function (config) {
        var grid = this;
        var el = grid.getEl();

        new Ext.dd.DropTarget(el, {
            ddGroup: grid.ddGroup,
            notifyDrop: function (dd, e, data) {
                var store = grid.getStore();
                var target = store.getAt(dd.getDragData(e).rowIndex);
                var sources = [];
                if (data.selections.length < 1 || data.selections[0].id == target.id) {
                    return false;
                }
                for (var i in data.selections) {
                    if (!data.selections.hasOwnProperty(i)) {
                        continue;
                    }
                    var row = data.selections[i];
                    sources.push(row.id);
                }

                el.mask(_('loading'), 'x-mask-loading');
                MODx.Ajax.request({
                    url: config.url,
                    params: {
                        action: config.ddAction,
                        sources: Ext.util.JSON.encode(sources),
                        target: target.id,
                    },
                    listeners: {
                        success: {
                            fn: function () {
                                el.unmask();
                                grid.refresh();
                                if (typeof(grid.reloadTree) == 'function') {
                                    sources.push(target.id);
                                    grid.reloadTree(sources);
                                }
                            }, scope: grid
                        },
                        failure: {
                            fn: function () {
                                el.unmask();
                            }, scope: grid
                        },
                    }
                });
            },
        });
    },

    _loadStore: function () {
        this.store = new Ext.data.JsonStore({
            url: this.config.url,
            baseParams: this.config.baseParams || {action: this.config.action || 'getList'},
            fields: this.config.fields,
            root: 'results',
            totalProperty: 'total',
            remoteSort: this.config.remoteSort || false,
            storeId: this.config.storeId || Ext.id(),
            autoDestroy: true,
            listeners: {
                load: function (store, rows, data) {
                    store.sortInfo = {
                        field: data.params['sort'] || 'id',
                        direction: data.params['dir'] || 'ASC',
                    };
                    Ext.getCmp('modx-content').doLayout();
                }
            }
        });
    },

});
Ext.reg('pageblocks-grid-default', PageBlocks.grid.Default);