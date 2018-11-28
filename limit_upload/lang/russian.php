<?php
/**************************************************
  Coppermine 1.6.x Plugin - Limit upload
  *************************************************
  Copyright (c) 2010-2018 eenemeenemuu
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
**************************************************/

if (!defined('IN_COPPERMINE')) {
    die('Not in Coppermine...');
}

$lang_plugin_limit_upload['limit_upload'] = '';
$lang_plugin_limit_upload['description'] = 'Плагин позволяет ограничевать пользовательские закачки общим количеством или количеством за пириод.</LI><LI>Перевод <a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=57421" rel="external" class="external">MISHA</a>.';
$lang_plugin_limit_upload['announcement_thread'] = 'Тема обсуждения плагина';
$lang_plugin_limit_upload['limit_reached_x'] = 'Вы достигли предела закачки %s файлов %s.';
$lang_plugin_limit_upload['limit_reached_wait'] = 'Вы должны ещё жать %s %s прежде, чем загрузить другой файл.';
$lang_plugin_limit_upload['saved'] = 'Ваши настройки были сохранены..';
$lang_plugin_limit_upload['upload_limit'] = 'Предел закачки (общее количество файлов или в промежуток времени';
$lang_plugin_limit_upload['upload_limit_values'] = array (
    'total' => 'Всего',
    'hour' => 'В час',
    'day' => 'в день (24 часа)',
    'week' => 'в неделю (7 дней)',
    'month' => 'в месяц (30 дней)',
    'year' => 'В год (365 дней)'
);
$lang_plugin_limit_upload['time_units'] = array('Минут(s)', 'Часов(s)', 'Дней(s)', 'Недель(s)');

//EOF