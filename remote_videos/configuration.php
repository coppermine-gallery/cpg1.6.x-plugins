<?php
/**************************************************
  Coppermine 1.5.x Plugin - remote_videos
  *************************************************
  Copyright (c) 2009-2016 eenemeenemuu
  *************************************************
  $HeadURL: https://svn.code.sf.net/p/coppermine/code/branches/cpg1.5.x/plugins/remote_videos/configuration.php $
  $Revision: 8843 $
  $LastChangedBy: eenemeenemuu $
  $Date: 2016-03-23 12:11:09 +0100 (Wed, 23 Mar 2016) $
  **************************************************/

$name = 'Remote Videos';
$description = 'Upload videos from video file hosters to your gallery (YouTube, Google, Yahoo!, ...)';
$author = '<a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=24278" rel="external" class="external">eenemeenemuu</a>';
$version = '1.11';
$plugin_cpg_version = array('min' => '1.5.10');

global $lang_gallery_admin_menu;
$announcement_icon = cpg_fetch_icon('announcement', 1);
$config_icon = cpg_fetch_icon('config', 1);

$extra_info = <<<EOT
    <a href="index.php?file=remote_videos/admin" class="admin_menu">{$config_icon}$name {$lang_gallery_admin_menu['admin_lnk']}</a>
    <a href="http://forum.coppermine-gallery.net/index.php/topic,60195.0.html" rel="external" class="admin_menu">{$announcement_icon}Announcement thread</a>
EOT;

$install_info = <<<EOT
    <a href="http://forum.coppermine-gallery.net/index.php/topic,60195.0.html" rel="external" class="admin_menu">{$announcement_icon}Announcement thread</a>
    <strong>Please consider your country's law, if you are liable when embedding content.</strong>
EOT;

?>