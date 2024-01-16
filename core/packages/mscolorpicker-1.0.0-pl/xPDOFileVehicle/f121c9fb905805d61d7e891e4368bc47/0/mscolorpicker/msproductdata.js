// загружаем дополнительные скрипты
function loadScript(path, callback) {
    let done = false,
        scr = document.createElement('script');

    scr.onload = handleLoad;
    scr.onreadystatechange = handleReadyStateChange;
    scr.onerror = handleError;
    scr.src = path;
    document.body.appendChild(scr);

    function handleLoad() {
        if (!done) {
            done = true;
            callback(path, "ok");
        }
    }

    function handleReadyStateChange() {
        let state;

        if (!done) {
            state = scr.readyState;
            if (state === "complete") {
                handleLoad();
            }
        }
    }

    function handleError() {
        if (!done) {
            done = true;
            callback(path, "error");
        }
    }
}

miniShop2.plugin.color = {
    getFields: function () {
        return {
            color: {
                xtype: 'textfield',
                description: '<b>[[+color]]</b><br />' + _('ms2_product_color_help'),
                listeners: {
                    afterrender:function(){
                        document.getElementById(this.id).classList.add('coloris');
                        document.getElementById(this.id).setAttribute('autocomplete', 'off');
                        const colorPickerStyles = document.createElement('link');
                        colorPickerStyles.href = window.location.origin + '/assets/components/mscolorpicker/coloris.css';
                        colorPickerStyles.rel='stylesheet';
                        document.head.appendChild(colorPickerStyles);
                        loadScript(window.location.origin + '/assets/components/mscolorpicker/coloris.js', () => {
                            Coloris({
                                el: '.coloris'
                            });
                        });
                    }
                },
            }
        }
    },
    getColumns: function () {
        return {
            color: {
                width: 50,
                sortable: false,
                editor: {
                    xtype: 'textfield',
                    name: 'color'
                }
            }
        }
    }
};