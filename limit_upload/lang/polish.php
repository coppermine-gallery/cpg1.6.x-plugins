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

$lang_plugin_limit_upload['limit_upload'] = 'Limit zdjęć';
$lang_plugin_limit_upload['description'] = 'Limit zdjęć wgranych przez użytkownika w okresie czasu';
$lang_plugin_limit_upload['announcement_thread'] = 'Wątek na forum';
$lang_plugin_limit_upload['limit_reached_x'] = 'Osiągnąłeś limit %s zdjęć %s.';
$lang_plugin_limit_upload['limit_reached_wait'] = 'Musisz poczekać %s %s zanim wgrasz następne zdjęcie.';
$lang_plugin_limit_upload['saved'] = 'Ustawienia zostały zapisane.';
$lang_plugin_limit_upload['upload_limit'] = 'Limit uploadu (ilość zdjęć calkowita lub w okresie czasu)';
$lang_plugin_limit_upload['upload_limit_values'] = array (
    'total' => 'w sumie',
    'hour' => 'na godzinę',
    'day' => 'na dzień (24 godziny)',
    'week' => 'na tydzień (7 dni)',
    'month' => 'na miesiąc (30 dni)',
    'year' => 'na rok (365 dni)'
);
$lang_plugin_limit_upload['time_units'] = array('minuty', 'godziny', 'dni', 'tygodnie');

//EOF