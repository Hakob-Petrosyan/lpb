<?php
include_once 'constructor.inc.php';
include_once 'setting.inc.php';
include_once 'version.inc.php';

$_lang['pageblocks'] = 'PageBlocks';
$_lang['pb_menu_desc'] = 'База заполненных блоков';
$_lang['pb_intro_msg'] = 'Вы можете выделять сразу несколько предметов при помощи Shift или Ctrl.';

$_lang['pb_render'] = 'Рендер';
$_lang['pb_table'] = 'Таблица';

$_lang['pb_blocks'] = 'Блоки';
$_lang['pb_baseblocks'] = 'Готовые блоки';
$_lang['pb_id'] = 'Id';
$_lang['pb_name'] = 'Название';
$_lang['pb_template'] = 'Шаблон';
$_lang['pb_block_name'] = 'Название блока';
$_lang['pb_chunk'] = 'Имя чанка';
$_lang['pb_values'] = 'Значение';
$_lang['pb_group'] = 'Группа';
$_lang['pb_groups'] = 'Группы';
$_lang['pb_fields'] = 'Поля';
$_lang['pb_added'] = 'Добавить';
$_lang['pb_columns'] = 'Cтолбцы сетки';
$_lang['pb_resource'] = 'Ресурс';

$_lang['pb_block_create'] = 'Создать блок';
$_lang['pb_baseblock_added'] = 'Добавить готовый блок';
$_lang['pb_block_update'] = 'Изменить блок';
$_lang['pb_block_update_chunk'] = 'Обновить чанк';
$_lang['pb_block_enable'] = 'Включить блок';
$_lang['pb_blocks_enable'] = 'Включить выбранные блоки';
$_lang['pb_block_disable'] = 'Отключить блок';
$_lang['pb_blocks_disable'] = 'Отключить выбранные блоки';
$_lang['pb_block_copy'] = 'Копировать блок';
$_lang['pb_block_copy_confirm'] = 'Вы уверены, что хотите сделать дубликат этого блока?';
$_lang['pb_block_copy_resource'] = 'Скопировать блоки из ресурса';
$_lang['pb_block_copy_resource_desc'] = 'Ресурс из которого будут скопированы блоки';
$_lang['pb_block_copy_language_desc'] = 'Язык из которого будут скопированы блоки';
$_lang['pb_block_copy_id'] = 'Скопировать блок по id';
$_lang['pb_block_copy_id_desc'] = 'Id блока, который будет скопирован';
$_lang['pb_block_remove'] = 'Удалить блок';
$_lang['pb_block_remove_confirm'] = 'Вы уверены, что хотите удалить этот блок?';
$_lang['pb_blocks_remove'] = 'Удалить выбранные блоки';
$_lang['pb_blocks_remove_confirm'] = 'Вы уверены, что хотите удалить выбранные блоки?';
$_lang['pb_block_page_view'] = 'Открыть страницу';
$_lang['pb_block_resource_view'] = 'Открыть ресурс';
$_lang['pb_block_unique'] = 'Уникальный блок';
$_lang['pb_block_unique_desc'] = 'Если отмечено, то блок не будет перезаписан при обновлении базового блока';
$_lang['pb_err_nfs'] = 'Блок не найден';
$_lang['pb_block_err_ns'] = 'Блок не найден';
$_lang['pb_block_err_copy'] = 'Не удалось скопировать блок';
$_lang['pb_resource_err_copy'] = 'Не удалось скопировать ресурс';

$_lang['pb_grid_search'] = 'Поиск';
$_lang['pb_grid_active'] = 'Активно';
$_lang['pb_grid_actions'] = 'Действия';
$_lang['pb_grid_remove'] = 'Удалить';

$_lang['pb_import'] = 'Импорт';
$_lang['pb_import_failed'] = 'Произошла ошибка при импорте, пожалуйста, попробуйте еще раз.';
$_lang['pb_import_file'] = 'Файл импорта';
$_lang['pb_import_file_type_error'] = 'Не правильный формат файла. Допустимо только .csv';
$_lang['pb_import_delimiter'] = 'Разделитель данных';
$_lang['pb_import_success'] = 'Импорт завершен';

$_lang['pb_export'] = 'Экспорт';
$_lang['pb_export_dir_failed'] = 'Произошла ошибка, не удалось создать папку экспорта.';
$_lang['pb_export_failed'] = 'Произошла ошибка при экспорте, пожалуйста, попробуйте еще раз.';
$_lang['pb_export_all'] = 'Все';

$_lang['pb_language_duplicate'] = 'Копировать язык';
$_lang['pb_language'] = 'Язык';
$_lang['pb_language_old'] = 'Старый язык';
$_lang['pb_language_new'] = 'Новый язык';
$_lang['pb_identical_languages'] = 'Языки должны отличаться';

$_lang['pb_msg_error_title'] = 'Ошибка!';
$_lang['pb_msg_error_text'] = 'У вас есть открытые окна. Если продолжить то данные будут потеряны. Продолжить?';
$_lang['pb_combo_empty'] = 'Нажмите для выбора';


// Table
$_lang['pb_create'] = 'Создать';
$_lang['pb_update'] = 'Изменить';
$_lang['pb_enable'] = 'Включить';
$_lang['pb_select_enable'] = 'Включить выбранные элементы';
$_lang['pb_disable'] = 'Отключить';
$_lang['pb_select_disable'] = 'Отключить выбранные элементы';
$_lang['pb_remove'] = 'Удалить';
$_lang['pb_select_remove'] = 'Удалить выбранные элементы';
$_lang['pb_copy'] = 'Копировать';
$_lang['pb_copy_confirm'] = 'Вы уверены, что хотите сделать дубликат этого элемента?';
$_lang['pb_remove_confirm'] = 'Вы уверены, что хотите удалить?';
$_lang['pb_grid_err_ns'] = 'Таблица не найдена';

// Video
$_lang['pb_video_title'] = 'Название';
$_lang['pb_video_preview'] = 'Превью';
$_lang['pb_video_description'] = 'Описание';
$_lang['pb_video_embed'] = 'Ссылка для iframe';
$_lang['pb_video_url_empty'] = 'Вы не указали ссылку на видео!';
$_lang['pb_video_url_invalid'] = 'Не удалось получить видео!';
$_lang['pb_video_err_ae'] = 'Данное видео уже загружено';
$_lang['pb_video_err_ns'] = 'Видео не найдено';
$_lang['pb_video_provider_no_support'] = 'Провайдер [[+name]] не поддерживается';
$_lang['pb_video_refresh_title'] = 'Сброс данных';
$_lang['pb_video_refresh_desc'] = 'Вы действительно хотите вернуть все данные по умолчанию?';

// Video gallery
$_lang['pb_video_upload_title'] = 'Загрузка видео';
$_lang['pb_video_upload_url'] = 'Ссылка';
$_lang['pb_video_upload_url_desc'] = 'Поддерживается Youtube и Vimeo';
$_lang['pb_video_gallery_upload_btn'] = 'Добавить видео';
$_lang['pb_video_update_data'] = 'Изменить данные';
$_lang['pb_video_remove'] = 'Удалить видео';
$_lang['pb_video_remove_confirm'] = 'Вы действительно хотите удалить данное видео?';
$_lang['pb_video_remove_multiple'] = 'Удалить выбранные видео';
$_lang['pb_video_remove_multiple_confirm'] = 'Вы действительно хотите удалить выбранные видео?';
$_lang['pb_video_url_arr_ae'] = 'Данное видео уже загружено';

// Gallery
$_lang['pb_tab_source_title'] = 'Источник файлов';
$_lang['pb_tab_source_intro_msg'] = 'Источник файлов для полей: галерея, изображение и файл';
$_lang['pb_gallery_upload_btn'] = 'Выбрать файлы';
$_lang['pb_gallery_emptytext'] = '<p style="padding: 20px;text-align:center;border: 1px solid #ccc;">Нет данных для отображения</p>';
$_lang['pb_gallery_err_no_source'] = 'Не удалось загрузить источник файлов ([[+source]])';
$_lang['pb_gallery_name'] = 'Имя файла (name)';
$_lang['pb_gallery_name_desc'] = 'Можно использовать как alt';
$_lang['pb_gallery_title'] = 'Заголовок (title)';
$_lang['pb_gallery_desc'] = 'Описание (description)';
$_lang['pb_gallery_file_rename'] = 'Переименовать';
$_lang['pb_gallery_filename_err_ae'] = 'Файл с таким именем уже существует';
$_lang['pb_gallery_file_err_upload'] = 'Не удалось загрузить файл [[+name]]';
$_lang['pb_gallery_filename_err_upload'] = 'Файл с именем [[+name]] уже загружен';
$_lang['pb_gallery_file_delete'] = 'Удалить файл';
$_lang['pb_gallery_file_delete_confirm'] = 'Вы действительно хотите удалить этот файл?';
$_lang['pb_gallery_file_delete_multiple'] = 'Удалить файлы';
$_lang['pb_gallery_file_delete_multiple_confirm'] = 'Вы действительно хотите удалить эти файлы?';
$_lang['pb_gallery_file_err_delete'] = 'Не удалось удалить файл [[+name]]';
$_lang['pb_gallery_err_rename_dir'] = 'Не удалось переименовать папку [[+path]]';
$_lang['pb_gallery_err_update_files'] = 'Не удалось обновить файлы в папке [[+path]]';
$_lang['pb_gallery_err_copy_files'] = 'Не удалось скопировать файлы блока с id [[+id]]';