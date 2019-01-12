<?php
/**************************************************
  Coppermine 1.6.x Plugin - Theme switch
  *************************************************
  Copyright (c) 2010-2019 eenemeenemuu
**************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

require "./plugins/theme_switch/lang/english.php";
if ($CONFIG['lang'] != 'english' && file_exists("./plugins/theme_switch/lang/{$CONFIG['lang']}.php")) {
    require "./plugins/theme_switch/lang/{$CONFIG['lang']}.php";
}

global $lang_gallery_admin_menu;

$name = $lang_plugin_theme_switch['theme_switch'];
$description = $lang_plugin_theme_switch['description'];
$author = '<a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=24278" rel="external" class="external">eenemeenemuu</a>';
$version = '1.0';
$plugin_cpg_version = array('min' => '1.5.42');
$extra_info = $install_info = '<a href="http://forum.coppermine-gallery.net/index.php/topic,79604.0.html" rel="external" class="admin_menu">'.cpg_fetch_icon('announcement', 1).$lang_plugin_theme_switch['announcement_thread'].'</a>';
$extra_info = '<a href="index.php?file=theme_switch/admin" class="admin_menu">'.cpg_fetch_icon('config', 1)."$name {$lang_gallery_admin_menu['admin_lnk']}</a>".$extra_info;

//EOF