<?php

$_lang['seofilter_prop_outputSeparator'] = 'Разделитель вывода результатов.';
$_lang['seofilter_prop_sortBy'] = 'Поле сортировки.';
$_lang['seofilter_prop_sortDir'] = 'Направление сортировки.';

$_lang['seofilter_prop_urls'] = 'Список ссылок из таблицы URL для вывода в результатах. Если id ссылки начинается с дефиса, то ссылка исключается из выборки';
$_lang['seofilter_prop_rules'] = 'Список правил для поиска (несколько через запятую).';
$_lang['seofilter_prop_parents'] = 'Список прямых родителей, через запятую, для поиска результатов. Без учёта их потомков. По умолчанию выборка не ограничивается. Если id родителя начинается с дефиса, он исключается из выборки.';
$_lang['seofilter_prop_depth'] = 'Глубина поиска по родительским ресурсам';
$_lang['seofilter_prop_sortby'] = 'Любое поле ссылки для сортировки. Для случайной сортировки укажите "RAND()"';
$_lang['seofilter_prop_sortdir'] = 'Направление сортировки: по убыванию или возрастанию.';
$_lang['seofilter_prop_sortcount'] = 'Сортировать по количеству ресурсов на страницах? (отрабатывает после первой сортировки)';
$_lang['seofilter_prop_countChildren'] = 'Вывести точное количество ресурсов для каждой ссылки в плейсхолдер [[+total]].';
$_lang['seofilter_prop_count_where'] = 'Условие в JSON формате для подсчёта ресурсов. Объединяется с условием, указанном в правиле';
$_lang['seofilter_prop_mincount'] = 'Минимальное количество ресурсов для ссылок, которые нужно оставить, а остальные исключить.Только при подсчётах потомков.';
$_lang['seofilter_prop_scheme'] = 'Схема формирования ссылок: параметр для modX::makeUrl()';
$_lang['seofilter_prop_userank'] = 'Учитывать приоритет правила при вложенности ссылок или группировке. Позволяет более точно управлять сортировкой.';
$_lang['seofilter_prop_context'] = 'Можно задать принудительно контекст (несколько через запятую), для которого будут сформированы ссылки. По умолчанию все ссылки выводятся.';
$_lang['seofilter_prop_cache'] = 'Кэширование результатов работы сниппета. Не влияет на классы текущих или активных ссылок.';
$_lang['seofilter_prop_level'] = 'Максимальный уровень вложенности меню, где 1 - это правила, состоящие из одного поля, а 0 без ограничений';
$_lang['seofilter_prop_nesting'] = 'Использовать вложенность ссылок. Виртуально вкладывать ссылки из двух полей в ту ссылку, где есть первое поле и т.д.';
$_lang['seofilter_prop_double'] = 'Разрешить дублирование ссылок при вложенности. Ссылка из двух полей будет вставлена в две ссылки из одного поля и т.д.';
$_lang['seofilter_prop_relative'] = 'Перестраивать меню относительно выбранного пункта. Применять, когда есть правила из одного и двух или более полей.';
$_lang['seofilter_prop_onlyrelative'] = 'Выводит меню только на виртуальной странице. Работает совместно с настройкой relative.';
$_lang['seofilter_prop_groupbyrule'] = 'Группировать по правилам. Задействует чанк tplGroup.';
$_lang['seofilter_prop_groupsort'] = 'Сортировать правила. "level" для сортировки по количеству составляющих полей';
$_lang['seofilter_prop_groupdir'] = 'Направление сортировки для группы: по убыванию или возрастанию.';
$_lang['seofilter_prop_showHidden'] = 'Показывать ссылки скрытые в меню.';
$_lang['seofilter_prop_cacheTime'] = 'Время актуальности кэша в секундах.';
$_lang['seofilter_prop_fastMode'] = 'Быстрый режим обработки чанков. Все необработанные теги (условия, сниппеты и т.п.) будут вырезаны.';
$_lang['seofilter_prop_limit'] = 'Ограничение вывода результатов на странице.';
$_lang['seofilter_prop_offset'] = 'Пропуск результатов от начала.';

$_lang['seofilter_prop_firstClass'] = 'Класс для первого пункта меню.';
$_lang['seofilter_prop_hereClass'] = 'Класс для активного пункта меню.';
$_lang['seofilter_prop_innerClass'] = 'Класс внутренних ссылок меню.';
$_lang['seofilter_prop_lastClass'] = 'Класс последнего пункта меню.';
$_lang['seofilter_prop_levelClass'] = 'Класс уровня меню. Например, если укажите "level", то будет "level1", "level2" и т.д.';
$_lang['seofilter_prop_outerClass'] = 'Класс обертки меню.';
$_lang['seofilter_prop_parentClass'] = 'Класс категории меню.';
$_lang['seofilter_prop_rowClass'] = 'Класс одной строки меню.';
$_lang['seofilter_prop_selfClass'] = 'Класс текущего документа в меню.';

$_lang['seofilter_prop_hideSubMenus'] = 'Не выводить неактивные ветки меню, то есть вложенные ссылки если в них нет активных.';

$_lang['seofilter_prop_where'] = 'Массив дополнительных параметров выборки, закодированный в JSON.';

$_lang['seofilter_prop_tpl'] = 'Название чанка для оформления результата (можно и INLINE).';
$_lang['seofilter_prop_tplGroup'] = 'Чанк оформления группы при включённой группировке по правилам.';
$_lang['seofilter_prop_tplHere'] = 'Чанк текущей страницы в меню';
$_lang['seofilter_prop_tplInner'] = 'Чанк-обёртка вложенных пунктов меню. Если пуст - будет использовать "tplOuter".';
$_lang['seofilter_prop_tplInnerHere'] = 'Чанк-обёртка текущей страницы для вложенного пункта меню.';
$_lang['seofilter_prop_tplInnerRow'] = 'Чанк-обёртка активного пункта для вложенного меню.';
$_lang['seofilter_prop_tplOuter'] = 'Чанк-обёртка всего блока меню.';
$_lang['seofilter_prop_tplParentRow'] = 'Чанк оформления ссылки, в которой есть вложенные меню.';
$_lang['seofilter_prop_tplParentRowActive'] = 'Чанк оформления активной ссылки, в которой есть вложенные меню.';
$_lang['seofilter_prop_tplParentRowHere'] = 'Чанк оформления текущей ссылки, в которой есть вложенные меню.';
$_lang['seofilter_prop_toPlaceholder'] = 'Если не пусто, сниппет сохранит все данные в плейсхолдер с этим именем, вместо вывода не экран.';
$_lang['seofilter_prop_tplWrapper'] = 'Чанк-обёртка, для заворачивания всех результатов. Понимает один плейсхолдер: [[+output]]. Не работает вместе с параметром "toSeparatePlaceholders".';

$_lang['seofilter_prop_forceXML'] = 'Принудительно выводить страницу как xml.';
$_lang['seofilter_prop_sitemapSchema'] = 'Схема карты сайта.';
$_lang['seofilter_prop_cacheTime'] = 'Время актуальности кэша в секундах.';
$_lang['seofilter_prop_cacheKey'] = 'Ключ кэширования. Сохраняется в "core/cache/default/вашключ"';
$_lang['seofilter_prop_fast'] = 'Быстрый режим работы сниппета. Использует значения из базы вместо подсчёта на лету.';
$_lang['seofilter_prop_input'] = 'Запрос, по которому нужно найти значение в словаре SeoFilter';
$_lang['seofilter_prop_field_id'] = 'ID поля, для уточнения поиска значения';
$_lang['seofilter_prop_pages'] = 'Список id страниц для поиска - поиск идёт в таком порядке, как переданы значения (можно не указывать список правил).';
$_lang['seofilter_prop_as_name'] = 'Значение, которое подставитсчя вместо оригинального названия ссылки.';
$_lang['seofilter_prop_link_classes'] = 'Класс или несколько через пробел, которые нужно добавить к ссылке.';
