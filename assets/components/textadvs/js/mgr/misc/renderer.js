textAdvs.renderer.Boolean = function (val) {
    return val
        ? String.format('<span class="green">{0}</span>', _('yes'))
        : String.format('<span class="red">{0}</span>', _('no'));
};

textAdvs.renderer.Actions = function (value, props, row) {
    var res = [];
    var cls, icon, title, action, item;
    if (typeof(value) == 'object') {
        for (var i in value) {
            if (!value.hasOwnProperty(i)) {
                continue;
            }
            var a = value[i];
            if (!a['button']) {
                continue;
            }

            icon = a['icon'] ? a['icon'] : '';
            if (typeof(a['cls']) == 'object') {
                if (typeof(a['cls']['button']) != 'undefined') {
                    icon += ' ' + a['cls']['button'];
                }
            } else {
                cls = a['cls'] ? a['cls'] : '';
            }
            action = a['action'] ? a['action'] : '';
            title = a['title'] ? a['title'] : '';

            item = String.format(
                '<li class="{0}"><button class="btn btn-default {1}" action="{2}" title="{3}"></button></li>',
                cls, icon, action, title
            );

            res.push(item);
        }
    }

    return String.format(
        '<ul class="txa-grid__row-actions">{0}</ul>',
        res.join('')
    );
};

textAdvs.renderer.Template = function (val, props, row) {
    var rec = row['json'];
    if (!!rec['template']) {
        return String.format(
            '<div class="txa-grid__row-template">' +
            '<a href="?a=element/template/update&id={0}" target="_blank">{1}</a>' +
            '</div>',
            rec['template'],
            rec['template_formatted']
        );
    } else {
        return String.format(
            '<div class="txa-grid__row-template">{0}</div>',
            rec['template_formatted']
        );
    }
};

textAdvs.renderer.Position = function (val, props, row) {
    var rec = row['json'];
    return String.format(
        '<div class="txa-grid__row-position">{0}</div>',
        _('txa_position_' + rec['position'])
    );
};

textAdvs.renderer.Tag = function (val, props, row) {
    var rec = row['json'];
    return String.format(
        '<div class="txa-grid__row-tag">{0}</div>',
        rec['tag_formatted']
    );
};