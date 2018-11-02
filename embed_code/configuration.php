<?php
/**************************************************
  Coppermine 1.5.x Plugin - embed_code
  *************************************************
  Copyright (c) 2011 eenemeenemuu
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

$name = 'Embed Code';
$description = "Adds pre-built BBCode / HTML embed code(s) to the file information box";
$author = '<a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=24278" rel="external" class="external">eenemeenemuu</a>';
$version = '1.1';
$plugin_cpg_version = array('min' => '1.5');

global $lang_gallery_admin_menu;
$announcement_icon = cpg_fetch_icon('announcement', 1);
$config_icon = cpg_fetch_icon('config', 1);
$install_info = <<< EOT
    <a href="http://forum.coppermine-gallery.net/index.php/topic,79516.0.html" rel="external" class="admin_menu">{$announcement_icon}Announcement thread</a>
EOT;
$extra_info = <<< EOT
    <a href="index.php?file=embed_code/admin" class="admin_menu">{$config_icon}$name {$lang_gallery_admin_menu['admin_lnk']}</a>
EOT;
$extra_info .= $install_info;

//EOF