PageBlocks.panel.Constructor = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('pageblocks') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            id: 'pageblocks-tabs',
            stateful: true,
            stateId: 'pageblocks-panel-constructor',
            stateEvents: ['tabchange'],
            getState: function () {
                return {
                    activeTab: this.items.indexOf(this.getActiveTab())
                };
            },
            items: [{
                title: _('block_constructor_title'),
                layout: 'anchor',
                items: [{
                    html: _('block_constructor_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'pb-grid-constructor',
                    cls: 'main-wrapper',
                }]
            }, {
                title: _('block_table_title'),
                layout: 'anchor',
                items: [{
                    html: _('block_table_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'pb-grid-table',
                    cls: 'main-wrapper',
                }]
            }, {
                title: _('block_collection_title'),
                layout: 'anchor',
                items: [{
                    html: _('block_collection_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'pb-grid-collection',
                    cls: 'main-wrapper',
                }]
            }, {
                title: _('block_resource_fields_title'),
                layout: 'anchor',
                cls: '',
                items: [{
                    html: _('block_resource_fields_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'pb-grid-resource-field',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    PageBlocks.panel.Constructor.superclass.constructor.call(this, config);
};
Ext.extend(PageBlocks.panel.Constructor, MODx.Panel);
Ext.reg('pageblocks-panel-constructor', PageBlocks.panel.Constructor);
