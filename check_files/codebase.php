<?php
/**************************************************
  Coppermine 1.6.x Plugin - Check files
  *************************************************
  Copyright (c) 2012 eenemeenemuu
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  ********************************************
**************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$thisplugin->add_filter('admin_menu', 'check_files_admin_menu');
function check_files_admin_menu($admin_menu) {
    if (GALLERY_ADMIN_MODE) {
        $new_button = "
            <div class=\"admin_menu admin_float\"><a href=\"index.php?file=check_files/additional_files&amp;do=dashboard\">".cpg_fetch_icon('disk_usage', 2)."Search for additional files</a></div>
            <div class=\"admin_menu admin_float\"><a href=\"index.php?file=check_files/missing_files&amp;do=dashboard\">".cpg_fetch_icon('disk_usage', 2)."Search for missing files</a></div>
        ";
        $look_for = "<!-- END documentation -->";
        $admin_menu = str_replace($look_for, $look_for . $new_button, $admin_menu);
    }
    return $admin_menu;
}


$thisplugin->add_action('plugin_install', 'check_files_install');
function check_files_install() {
    global $CONFIG;
    check_files_uninstall();
    cpg_db_query("CREATE TABLE IF NOT EXISTS {$CONFIG['TABLE_PREFIX']}plugin_check_files_additional (
                    id int(11) NOT NULL auto_increment,
                    filepath varchar(255) NOT NULL,
                    filename varchar(255) NOT NULL,
                    PRIMARY KEY (id) )");
    cpg_db_query("CREATE TABLE IF NOT EXISTS {$CONFIG['TABLE_PREFIX']}plugin_check_files_dirs (
                    id int(11) NOT NULL auto_increment,
                    path varchar(255) NOT NULL,
                    PRIMARY KEY (id) )");
    cpg_db_query("CREATE TABLE IF NOT EXISTS {$CONFIG['TABLE_PREFIX']}plugin_check_files_missing (
                    id int(11) NOT NULL auto_increment,
                    pid int(11) NOT NULL,
                    filepath varchar(255) NOT NULL,
                    filename varchar(255) NOT NULL,
                    type varchar(8) NOT NULL,
                    PRIMARY KEY (id) )");
    cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (name, value) VALUES ('plugin_check_files_status_additional', ''), ('plugin_check_files_status_missing', '')");
    return true;
}


$thisplugin->add_action('plugin_uninstall', 'check_files_uninstall');
function check_files_uninstall() {
    global $CONFIG;
    cpg_db_query("DROP TABLE IF EXISTS {$CONFIG['TABLE_PREFIX']}plugin_check_files_additional");
    cpg_db_query("DROP TABLE IF EXISTS {$CONFIG['TABLE_PREFIX']}plugin_check_files_dirs");
    cpg_db_query("DROP TABLE IF EXISTS {$CONFIG['TABLE_PREFIX']}plugin_check_files_missing");
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name LIKE 'plugin_check_files_%'");
    return true;
}
