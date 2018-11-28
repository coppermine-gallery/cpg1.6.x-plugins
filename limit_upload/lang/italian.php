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

$lang_plugin_limit_upload['limit_upload'] = 'Limite di upload';
$lang_plugin_limit_upload['description'] = 'Limita gli upload degli utenti ad un numero massimo totale o ad un determinato numero per periodo di tempo';
$lang_plugin_limit_upload['announcement_thread'] = 'Thread di presentazione';
$lang_plugin_limit_upload['limit_reached_x'] = 'Hai raggiunto il limite di upload di %s files %s.';
$lang_plugin_limit_upload['limit_reached_wait'] = 'Devi aspettare %s %s prima di poter caricare un altro file.';
$lang_plugin_limit_upload['saved'] = 'Le tue impostazioni sono state salvate.';
$lang_plugin_limit_upload['upload_limit'] = 'Limite di upload (files totali o per intervallo di tempo)';
$lang_plugin_limit_upload['upload_limit_values'] = array (
    'total' => 'totale',
    'hour' => 'all\'ora',
    'day' => 'al giorno (24 ore)',
    'week' => 'alla settimana (7 giorni)',
    'month' => 'al mese (30 giorni)',
    'year' => 'all\'anno (365 giorni)'
);
$lang_plugin_limit_upload['time_units'] = array('minute(s)', 'hour(s)', 'day(s)', 'week(s)');

//EOF