<?php
/**************************************************
  Coppermine 1.6.x Plugin - panorama_viewer
  *************************************************
  Copyright (c) 2009-2019 eenemeenemuu
  **************************************************/

global $lang_gallery_admin_menu;
$name = 'Panorama Viewer';
$description = 'Simple panorama image viewer';
$author = '<a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=24278" rel="external" class="external">eenemeenemuu</a>';
$version = '1.4';
$plugin_cpg_version = array('min' => '1.5');
$extra_info = $install_info = '<a href="http://forum.coppermine-gallery.net/index.php/topic,79599.0.html" rel="external" class="admin_menu">'.cpg_fetch_icon('announcement', 1).'Announcement thread</a>';
$extra_info = '<a href="index.php?file=panorama_viewer/admin" class="admin_menu">'.cpg_fetch_icon('config', 1).$name.' '.$lang_gallery_admin_menu['admin_lnk'].'</a>'.$extra_info;

//EOF