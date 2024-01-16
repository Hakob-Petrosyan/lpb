CKEDITOR.plugins.add( 'gr_justify', {
    icons: 'justifyleft',
    requires: 'justify,menubutton',
    init: function( editor ) {
        var items = {};

        editor.addMenuGroup( 'justify_group' );

        items.justifyleft = {
            label: editor.lang.common.alignLeft,
            group: 'justify_group',
            onClick: function(){
                editor.execCommand('justifyleft');
            },
            order: 1
        };

        items.justifycenter = {
            label: editor.lang.common.alignCenter,
            group: 'justify_group',
            onClick: function(){
                editor.execCommand('justifycenter');
            },
            order: 2
        };

        items.justifyright = {
            label: editor.lang.common.alignRight,
            group: 'justify_group',
            onClick: function(){
                editor.execCommand('justifyright');
            },
            order: 3
        };

        items.justifyblock = {
            label: editor.lang.common.alignJustify,
            group: 'justify_group',
            onClick: function(){
                editor.execCommand('justifyblock');
            },
            order: 4
        };

        editor.addMenuItems( items );
        editor.ui.add( 'gr_justify', CKEDITOR.UI_MENUBUTTON, {
            label: 'Выравнивание',
            // Disable in source mode.
            modes: {
                wysiwyg: 1
            },
            command: 'justifyleft',
            icon: 'justifyleft',
            onMenu: function() {
                var active = {};

                // Make all items active.
                for ( var p in items )
                    active[ p ] = CKEDITOR.TRISTATE_OFF;

                return active;
            }
        } );
    }
});