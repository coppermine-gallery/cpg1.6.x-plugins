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

$lang_plugin_limit_upload['limit_upload'] = 'Limit upload';
$lang_plugin_limit_upload['description'] = 'Limit user uploads to a total number or a set amount per period';
$lang_plugin_limit_upload['announcement_thread'] = 'Announcement thread';
$lang_plugin_limit_upload['limit_reached_x'] = 'You\'ve reached the upload limit of %s files %s.';
$lang_plugin_limit_upload['limit_reached_wait'] = 'You have to wait %s %s before uploading another file.';
$lang_plugin_limit_upload['saved'] = 'Your settings have been saved.';
$lang_plugin_limit_upload['upload_limit'] = 'Upload limit (files total or per period of time)';
$lang_plugin_limit_upload['upload_limit_values'] = array (
    'total' => 'total',
    'hour' => 'per hour',
    'day' => 'per day (24 hours)',
    'week' => 'per week (7 days)',
    'month' => 'per month (30 days)',
    'year' => 'per year (365 days)'
);
$lang_plugin_limit_upload['time_units'] = array('minute(s)', 'hour(s)', 'day(s)', 'week(s)');

//EOF