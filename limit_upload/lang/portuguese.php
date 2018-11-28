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

$lang_plugin_limit_upload['limit_upload'] = 'Limite de envios';
$lang_plugin_limit_upload['description'] = 'Limita os envios do utilizador para um número máximo ou para um determinado período';
$lang_plugin_limit_upload['announcement_thread'] = 'Announcement thread';
$lang_plugin_limit_upload['limit_reached_x'] = 'Atingiu o limite máximo de envios - %s fotografias %s.';
$lang_plugin_limit_upload['limit_reached_wait'] = 'Deverá esperar %s %s antes de enviar outra fotografia.';
$lang_plugin_limit_upload['saved'] = 'Configuração guardada.';
$lang_plugin_limit_upload['upload_limit'] = 'Limite de envios (total de ficheiros ou período de tempo)';
$lang_plugin_limit_upload['upload_limit_values'] = array (
    'total' => 'total',
    'hour' => 'por hora',
    'day' => 'por dia (24 horas)',
    'week' => 'por semana (7 dias)',
    'month' => 'por mês (30 dias)',
    'year' => 'por ano (365 dias)'
);
$lang_plugin_limit_upload['time_units'] = array('minuto(s)', 'hora(s)', 'dia(s)', 'semana(s)');

//EOF