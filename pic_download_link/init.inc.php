<?php
/**
 * Coppermine Photo Gallery
 * Coppermine version: 1.5.xx
 *
 * Picture Download Link
 * Version 1.2
 *  
 * Plugin Written by Joe Carver - http://photos-by.joe-carver.com/ - http://gallery.josephcarver.com/natural/ - http://i-imagine.net/artists/
 * 08 August 2010
*/
    require_once('include/init.inc.php');
    if (!defined('IN_COPPERMINE')) { 
    die('Not in Coppermine...');
    }

// Define the default language array (English)
require_once ("./plugins/pic_download_link/lang/english.php");
// submit your lang file for this plugin on the coppermine forums
// plugin will try to use the configured language if it is available.
if (file_exists("./plugins/pic_download_link/lang/{$CONFIG['lang']}.php")) {
    require_once ("./plugins/pic_download_link/lang/{$CONFIG['lang']}.php");
} 

    // Determine the help file link
    if (file_exists("./plugins/pic_download_link/docs/{$CONFIG['lang']}.htm")) {
    $documentation_file = $CONFIG['lang'];
    } else {
    $documentation_file = 'english';
    }

    $pic_link_icon_array['ok'] = cpg_fetch_icon('ok', 0);
    $pic_link_icon_array['announcement'] = cpg_fetch_icon('announcement', 1);
    $pic_link_icon_array['documentation'] = cpg_fetch_icon('documentation', 1);
    $pic_link_icon_array['configure'] = cpg_fetch_icon('config', 1)
?>