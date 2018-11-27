<?php
/**************************************************
  Coppermine 1.5.x Plugin - Limit upload
  *************************************************
  Copyright (c) 2010-2018 eenemeenemuu
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

$lang_plugin_limit_upload['limit_upload'] = 'Upload begrenzen';
$lang_plugin_limit_upload['description'] = 'Begrenzt den Benutzerupload auf eine bestimmte Anzahl insgesamt oder pro Zeitraum';
$lang_plugin_limit_upload['announcement_thread'] = 'Ankündigungs-Thema';
$lang_plugin_limit_upload['limit_reached_x'] = 'Du hast das Uploadlimit von %s Dateien %s erreicht.';
$lang_plugin_limit_upload['limit_reached_wait'] = 'Du musst %s %s warten, bevor du weitere Dateien hochladen darfst.';
$lang_plugin_limit_upload['saved'] = 'Deine Einstellungen wurden gespeichert.';
$lang_plugin_limit_upload['upload_limit'] = 'Uploadlimit (Dateien insgesamt oder pro Zeitspanne)';
$lang_plugin_limit_upload['upload_limit_values'] = array (
    'total' => 'insgesamt',
    'hour' => 'pro Stunde',
    'day' => 'pro Tag (24 Stunden)',
    'week' => 'pro Woche (7 Tage)',
    'month' => 'pro Monat (30 Tage)',
    'year' => 'pro Jahr (365 Tage)'
);
$lang_plugin_limit_upload['time_units'] = array('Minute(n)', 'Stunde(n)', 'Tag(e)', 'Woche(n)');

//EOF