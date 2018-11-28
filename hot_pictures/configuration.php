<?php
/**************************************************
  Coppermine 1.6.x Plugin - Hot pictures
  *************************************************
  Copyright (c) 2012-2018 eenemeenemuu
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
**************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

require "./plugins/hot_pictures/lang/english.php";
if ($CONFIG['lang'] != 'english' && file_exists("./plugins/hot_pictures/lang/{$CONFIG['lang']}.php")) {
    require "./plugins/hot_pictures/lang/{$CONFIG['lang']}.php";
}

$name = $lang_plugin_hot_pictures['hot_pictures'];
$description = $lang_plugin_hot_pictures['description'];
$author = '<a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=24278" rel="external" class="external">eenemeenemuu</a>';
$version = '1.5';
$plugin_cpg_version = array('min' => '1.5.42');
$extra_info = $install_info = '<a href="http://forum.coppermine-gallery.net/index.php/topic,79549.0.html" rel="external" class="admin_menu">'.cpg_fetch_icon('announcement', 1).$lang_plugin_hot_pictures['announcement_thread'].'</a>';

//EOF