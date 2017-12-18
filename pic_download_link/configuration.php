<?php
/**
 * Coppermine Photo Gallery
 * Coppermine version: 1.5.xx
 *
 * Picture Download Link
 * Version 1.4
 *  
 * Plugin Written by Joe Carver - http://photos-by.joe-carver.com/ - http://gallery.josephcarver.com/natural/ - http://i-imagine.net/artists/
 * 08 August 2010
*/

    if (!defined('IN_COPPERMINE')) { 
    die('Not in Coppermine...');
    }
    require_once('plugins/pic_download_link/init.inc.php');

    $name = $pic_link['display_name'];
    $configuration_link = '<a href="index.php?file=pic_download_link/admin" class="admin_menu">' . $pic_link_icon_array['configure'] . sprintf($pic_link['configure_plugin_x'], $pic_link['display_name']) . '</a> ';	
    $documentation_link = '<a href="plugins/pic_download_link/docs/' . $documentation_file . '.htm" class="admin_menu">' . $pic_link_icon_array['documentation'] . $pic_link['plugin_documentation'] . '</a> ';
    $announcement_thread = '<a href="http://forum.coppermine-gallery.net/index.php/topic,65849.0.html" class="admin_menu">' . $pic_link_icon_array['announcement'] . $pic_link['announcement_thread'] . '</a>';
    $extra_info =  $configuration_link . $documentation_link . $announcement_thread;
    $install_info = $documentation_link . $announcement_thread;
    $author  = <<<EOT
<a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=65237">Joe Carver aka i-imagine.</a>
EOT;
    $version='1.4';
    $plugin_cpg_version = array('min' => '1.5');
    $description = $pic_link['description'];	

?>