<?php
/**************************************************
  Coppermine 1.6.x Plugin - quick_tag
  *************************************************
  Copyright (c) 2014-2020 eenemeenemuu
  **************************************************/

$name = 'Quick tag';
$description = 'Adds a clickable list of the most frequent keywords next to the keyword edit fields.';
$author = '<a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=24278" rel="external" class="external">eenemeenemuu</a>';
$version = '1.1';
$plugin_cpg_version = array('min' => '1.6');

$announcement_icon = cpg_fetch_icon('announcement', 1);

$extra_info = $install_info = <<<EOT
    <a href="http://forum.coppermine-gallery.net/index.php/topic,80279.0.html" rel="external" class="admin_menu">{$announcement_icon}Announcement thread</a>
EOT;

//EOF