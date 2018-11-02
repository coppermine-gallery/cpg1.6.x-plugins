<?php
/**************************************************
  Coppermine 1.5.x Plugin - Picture Annotation (annotate)
  *************************************************
  Copyright (c) 2003-2009 Coppermine Dev Team
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  ********************************************
  $HeadURL$
  $Revision$
  $LastChangedBy$
  $Date$
  **************************************************/

if (!defined('IN_COPPERMINE')) {
    die('Not in Coppermine...');
}

$lang_plugin_annotate['annotate'] = 'Отметить';
$lang_plugin_annotate['plugin_name'] = 'Отметки на изображениях (Picture Annotation)';
$lang_plugin_annotate['plugin_description'] = 'Добавляет отметки на ваши изображения';
$lang_plugin_annotate['plugin_credit_creator'] = 'Создан %s для cpg1.4.x';
$lang_plugin_annotate['plugin_credit_porter'] = 'Портирован %s на cpg1.5.x';
$lang_plugin_annotate['plugin_credit_js'] = 'Использованы библиотеки JavaScript от %s и %s';
$lang_plugin_annotate['plugin_credit_i18n'] = 'Интернационализации %s.</LI><LI>Перевод <a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=57421" rel="external" class="external">MISHA</a>. Помощь в переводе <a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=5943" rel="external" class="external">Makc666</a>.';
$lang_plugin_annotate['submit_to_install'] = 'Заполните форму, чтобы установить плагин';
$lang_plugin_annotate['configure_plugin'] = 'Настроить плагин';
$lang_plugin_annotate['changes_saved'] = 'Ваши изменения были сохранены';
$lang_plugin_annotate['no_changes'] = 'Не было никаких изменений или введенные вами данные были неверены';
$lang_plugin_annotate['guests_more_permissions_than_registered'] = 'Предоставление гостям больше разрешений, чем зарегистрированным пользователям, не имеет смысла. Пожалуйста, просмотрите ваши настройки!';
$lang_plugin_annotate['prune_database'] = 'Вы действительно хотите удалить все отметки из базы данных?';
$lang_plugin_annotate['announcement_thread'] = 'Тема обсуждения плагина';
$lang_plugin_annotate['delete_orphaned_entries'] = 'Удалить осиротевшие записи';
$lang_plugin_annotate['x_orphaned_entries_deleted'] = 'Удалено %s осиротевших записей';
$lang_plugin_annotate['1_orphaned_entry_deleted'] = 'Удалена 1 осиротевшая запись';
$lang_plugin_annotate['save'] = 'Сохранить';
$lang_plugin_annotate['cancel'] = 'Отменить';
$lang_plugin_annotate['error_saving_note'] = 'Ошибка сохранения записи'; // JS-alert
$lang_plugin_annotate['onsave_not_implemented'] = 'onsave должно быть внедрено, чтобы *реально* сохранять'; // JS-alert
$lang_plugin_annotate['permissions'] = 'Разрешения';
$lang_plugin_annotate['group'] = 'Группа';
$lang_plugin_annotate['guests'] = 'Гости';
$lang_plugin_annotate['registered_users'] = 'Зарегистрированные пользователи';
$lang_plugin_annotate['administrators'] = 'Администраторы';
$lang_plugin_annotate['read_annotations'] = 'Просмотр отметок';
$lang_plugin_annotate['read_write_annotations'] = 'Просмотр и создание отметок';
$lang_plugin_annotate['read_write_delete_annotations'] = 'Просмотр, создание и удаление отметок';
$lang_plugin_annotate['no_access'] = 'Нет доступа';
$lang_plugin_annotate['lastnotes'] = 'Последние изображения с отметками';
$lang_plugin_annotate['shownotes'] = 'Изображения с';
$lang_plugin_annotate['x_annotations_for_file'] = 'У этого файла есть отметки в количестве %s.';
$lang_plugin_annotate['1_annotation_for_file'] = 'У этого файла есть одна отметка.';
$lang_plugin_annotate['registration_promotion'] = 'Для просмотра отметок %sВойдите%s или %sЗарегистрируйтесь%s.'; // Do not translate the %s placeholders
$lang_plugin_annotate['update_database'] = 'Обновить базу данных';
$lang_plugin_annotate['update_database_success'] = 'Обновление базы данных прошло успешно';
$lang_plugin_annotate['rapid_annotation'] = 'Быстрая отметка';
$lang_plugin_annotate['annotate_x_on_this_pic'] = 'Отметить \'%s\' на этом изображении';
$lang_plugin_annotate['on_this_pic'] = 'На этом изображении';
$lang_plugin_annotate['all_pics_of'] = 'Показать все фото с отметкой &quot;%s&quot;';
$lang_plugin_annotate['annotation_type'] = 'Тип отметок';
$lang_plugin_annotate['free_text'] = 'Свободный текст';
$lang_plugin_annotate['drop_down_existing_annotations'] = 'Выпадающий список уже существующих отметок';
$lang_plugin_annotate['drop_down_registered_users'] = 'Выпадающий список зарегистрированных пользователей';
$lang_plugin_annotate['display_notes'] = 'Отображать кнопки быстрых отметок';
$lang_plugin_annotate['display_notes_title'] = 'Отображает кнопки для уже существующих отметок в текущем просматриваемом альбоме (для более легкой/быстрой отметки)';
$lang_plugin_annotate['display_links'] = 'Отображать отметки над изображениями';
$lang_plugin_annotate['note_empty'] = 'Отметки не могут быть пустыми!'; // JS-alert
$lang_plugin_annotate['manage'] = 'Управление отметками';
$lang_plugin_annotate['batch_rename'] = 'Массовое переименование';
$lang_plugin_annotate['batch_delete'] = 'Массовое удаление';
$lang_plugin_annotate['rename_to'] = 'переименовать в';
$lang_plugin_annotate['sure_rename'] = 'Вы действительно хотите переименовать \'%s\' в \'%s\'?';
$lang_plugin_annotate['rename_success'] = '\'%s\' была переименована в \'%s\'';
$lang_plugin_annotate['rename_fail'] = '\'%s\' <b>не</b> была переименована в \'%s\'';
$lang_plugin_annotate['sure_delete'] = 'Вы действительно хотите удалить \'%s\'?';
$lang_plugin_annotate['delete_success'] = '\'%s\' была успешно удалена';
$lang_plugin_annotate['import'] = 'Импорт отметок';
$lang_plugin_annotate['import_found'] = 'Найдено %s отметок';
$lang_plugin_annotate['imported_already'] = 'Импорт уже был выполнен';
$lang_plugin_annotate['import_success'] = 'Импортировано %s отметок';
$lang_plugin_annotate['annotated_by'] = 'Отметил';
$lang_plugin_annotate['view_profile'] = 'Посмотреть профиль \'%s\'';
$lang_plugin_annotate['display_stats'] = 'Отображать статистику';
$lang_plugin_annotate['display_stats_title'] = 'Отображает \'%s\', \'%s\' и \'%s\' рядом с кнопкой отметок';
$lang_plugin_annotate['annotations_pic'] = 'Отметок на этом изображении';
$lang_plugin_annotate['annotations_album'] = 'Отметок в этом альбоме';
$lang_plugin_annotate['annotated_pics'] = 'Изображений с отметками в этом альбоме';
$lang_plugin_annotate['filter_annotations'] = 'Фильтр отметок';
$lang_plugin_annotate['search_results'] = 'Результаты поиска';
?>