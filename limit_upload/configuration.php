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

require_once "./plugins/limit_upload/lang/english.php";
if ($CONFIG['lang'] != 'english' && file_exists("./plugins/limit_upload/lang/{$CONFIG['lang']}.php")) {
    require_once "./plugins/limit_upload/lang/{$CONFIG['lang']}.php";
}

global $lang_gallery_admin_menu;

$name = $lang_plugin_limit_upload['limit_upload'];
$description = $lang_plugin_limit_upload['description'];
$author = '<a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=24278" rel="external" class="external">eenemeenemuu</a>';
$version = '1.1';
$plugin_cpg_version = array('min' => '1.5.42');
$extra_info = $install_info = '<a href="http://forum.coppermine-gallery.net/index.php/topic,79547.0.html" rel="external" class="admin_menu">'.cpg_fetch_icon('announcement', 1).$lang_plugin_limit_upload['announcement_thread'].'</a>';
$extra_info = '<a href="index.php?file=limit_upload/admin" class="admin_menu">'.cpg_fetch_icon('config', 1)."$name {$lang_gallery_admin_menu['admin_lnk']}</a>".$extra_info;

//EOF