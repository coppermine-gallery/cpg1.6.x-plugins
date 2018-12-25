<?php
/*********************************************
  Coppermine Plugin - More meta albums
  ********************************************
  Copyright (c) 2010-2018 eenemeenemuu
**********************************************/

require "./plugins/more_meta_albums/lang/english.php";
if ($CONFIG['lang'] != 'english' && file_exists("./plugins/more_meta_albums/lang/{$CONFIG['lang']}.php")) {
    require "./plugins/more_meta_albums/lang/{$CONFIG['lang']}.php";
}

$name = $lang_plugin_more_meta_albums['more_meta_albums'];
$description = $lang_plugin_more_meta_albums['description'];
$author = '<a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=24278" rel="external" class="external">eenemeenemuu</a>';
$version = '1.11';
$plugin_cpg_version = array('min' => '1.5.42');
$extra_info = $install_info = '<a href="http://forum.coppermine-gallery.net/index.php/topic,79584.0.html" rel="external" class="admin_menu">'.cpg_fetch_icon('announcement', 1).$lang_plugin_more_meta_albums['announcement_thread'].'</a>';

//EOF