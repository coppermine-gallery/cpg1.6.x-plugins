<?php
/**************************************************
  Coppermine 1.5.x Plugin - Custom Thumbnail
  *************************************************
  Copyright (c) 2009 eenemeenemuu
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

require_once "./plugins/custom_thumb/lang/english.php";
if ($CONFIG['lang'] != 'english' && file_exists("./plugins/custom_thumb/lang/{$CONFIG['lang']}.php")) {
    require_once "./plugins/custom_thumb/lang/{$CONFIG['lang']}.php";
}

$name = $lang_plugin_custom_thumb['custom_thumbnail'];
$description = $lang_plugin_custom_thumb['description'];
$author = '<a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=24278" rel="external" class="external">eenemeenemuu</a>';
$version = '1.8';
$plugin_cpg_version = array('min' => '1.5.42');
$extra_info = $install_info = '<a href="http://forum.coppermine-gallery.net/index.php/topic,79519.0.html" rel="external" class="admin_menu">'.cpg_fetch_icon('announcement', 1).$lang_plugin_custom_thumb['announcement_thread'].'</a>';

//EOF