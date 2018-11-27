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

$lang_plugin_limit_upload['limit_upload'] = 'Límite de subidas';
$lang_plugin_limit_upload['description'] = 'Limita las subidas por usuario a un número total o por un período de tiempo.';
$lang_plugin_limit_upload['announcement_thread'] = 'Hilo de la noticia';
$lang_plugin_limit_upload['limit_reached_x'] = 'Ha alcanzado el límite de subidas de %s imágenes %s.';
$lang_plugin_limit_upload['limit_reached_wait'] = 'Tiene que esperar %s %s antes de subir otra imagen.';
$lang_plugin_limit_upload['saved'] = 'Su configuración ha sido guardada.';
$lang_plugin_limit_upload['upload_limit'] = 'Límite de subidas( Total de imágenes o por período de tiempo).';
$lang_plugin_limit_upload['upload_limit_values'] = array (
    'total' => 'total',
    'hour' => 'por hora',
    'day' => 'por día (24 horas)',
    'week' => 'por semana (7 días)',
    'month' => 'por mes (30 días)',
    'year' => 'por año (365 días)'
);
$lang_plugin_limit_upload['time_units'] = array('minuto(s)', 'hora(s)', 'día(s)', 'semana(s)');

//EOF