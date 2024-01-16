<?php  return array (
  'dirres2_log' => 'Создает файл лога.',
  'dirres2_opacity' => 'Прозрачность',
  'dirres2_slide_duration' => 'Длительность показа слайда',
  'dirres2_exclude_dirs' => 'Путь к директориям разделенных запятыми, в которых плагин работать не будет',
  'dirres2_exclude_dirs_children' => 'При "ДА" распространяет действие исключения родителя на дочерние директории',
  'dirres2_exclude_dirs_suffix' => 'Cуффикс папки исключения, при наличии, которого дочерние папки исключаются. При этом exclude_dirs_children должен быть равен false',
  'dirres2_exclude_extensions' => 'Перечисляются через запятую расширения файлов, которые не попадут под действие плагина',
  'dirres2_exclude_text_in_elements' => 'Исключает из проверки изображения которые содержат данный текст в элементах alt, class, id, tittle',
  'dirres2_templates' => 'Перечислять через запятую ID шаблонов, в которых данный плагин работает',
  'dirres2_exclude_templates' => 'Перечислять через запятую ID шаблонов, в которых данный плагин НЕ работает',
  'dirres2_insert_expander_js' => 'Вставить в код файлы jquery.js, colorbox.js и т.д. необходимые для работы компонента',
  'dirres2_insert_expander_css' => 'Вставить файлы стилей для работы компонента',
  'dirres2_insert_expander' => 'Вставить вспомогательные код JS для работы компонента',
  'dirres2_expander' => 'Выберите тип Lightbox-а',
  'dirres2_max_height' => 'Высота окна',
  'dirres2_max_width' => 'Ширина окна',
  'dirres2_min_height' => 'Минимальная высота окна',
  'dirres2_min_width' => 'Минимальная ширина окна',
  'dirres2_slideshow' => 'Включить слайдшоу?',
  'dirres2_style' => 'Файл стилей css модуля colorbox. Вы можете использовать style1 по style5',
  'dirres2_transition' => 'Тип перехода. Can be set to "elastic", "fade", or "none".',
  'dirres2_caption_position' => 'Положение описания',
  'dirres2_caption_source' => 'Источник описания',
  'dirres2_large_caption' => 'Размер описания',
  'dirres2_outline_type' => 'Тип внешней линии',
  'dirres2_theme' => 'Тема',
  'dirres2_fb2_padding' => 'Свободное расстояние внутри fancyBox вокруг содержимого. Может быть установлен как массив в виде: [top, right, bottom, left].',
  'dirres2_fb2_openSpeed' => 'Время открытия в мс. или принимает значения ("slow", "normal", "fast") для завершения перехода.',
  'dirres2_fb2_closeSpeed' => 'Время закрытия в мс. или принимает значения ("slow", "normal", "fast") для завершения перехода.',
  'dirres2_fb2_openEffect' => 'Эфект открытия окна ("elastic", "fade" or "none") for each transition type',
  'dirres2_fb2_closeEffect' => 'Эфект закрытия окна ("elastic", "fade" or "none") for each transition type',
  'dirres2_fb2_closeClick' => 'If set to true, fancyBox will be closed when user clicks the content.',
  'dirres2_fb2_playSpeed' => 'Slideshow speed in milliseconds.',
  'dirres2_fb2_autoPlay' => 'If set to true, slideshow will start after opening the first gallery item.',
  'dirres2_default_thumb_path' => 'Путь расположения файлов превью, если он указан, то параметр "thumbnail_dir" игнорируется',
  'dirres2_rewrite_image_on_exist' => 'Переписывать файлы эскизов если они существуют',
  'dirres2_thumb_key' => 'Текст добавляется в имя файла предпросмотра',
  'dirres2_thumb_param' => 'Параметры создания превью на основе phpThumbOf, пример: \'zc\'=1,\'bg\'=\'#fff\',\'q\'=80
Основные параметры:
<ul>
	<li>w - ширина превью, по-умолчанию берется из ширины измененного изображения,</li>
	<li>h - высота превью, по-умолчанию берется из высоты измененного изображения,</li>
	<li>q - качество сжатия изображения (100 - наилучшее)</li>
	<li>zc=1 - обрезка изображения с точными размерами (w=120&h=120&zc=1)</li>
	<li>fltr[]=blur|10 - размытие</li>
	<li>fltr[]=gray - градация серого и т.д.</li>
</ul>
',
  'dirres2_thumbnail_dir' => 'Создает папку превью с данным именем в папке из которой берется файл. При условии что параметр "default_thumb_path" не указан.',
);