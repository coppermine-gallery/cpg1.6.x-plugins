<?php
/*******************************************************
 Coppermine 1.6.x plugin - FileMove
 *******************************************************
 Copyright (c) 2003-2017 Coppermine Dev Team
 *******************************************************
 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 as published by the Free Software Foundation; either version 3
 of the License, or (at your option) any later version.
 *******************************************************
 Ported to CPG 1.6.x June 2017 {ron4mac}
 *******************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_FileMove['display_name'] = 'FileMove';		// Display Name
$lang_plugin_FileMove['description'] = 'Choose files or a folder to move and modify the database accordingly';
$lang_plugin_FileMove['author'] = 'Created by Frantz';
$lang_plugin_FileMove['ported'] = '<br />Ported to cpg1.5.x by eenemeenemuu<br />Ported to cpg1.6.x by ron4mac';
$lang_plugin_FileMove['config_title'] = 'Configure FileMove';		// Title of the button on the gallery config menu
$lang_plugin_FileMove['config_button'] = 'FileMove';		// Label of the button on the gallery config menu
$lang_plugin_FileMove['install_note'] = 'Configure plugin using button on Admin toolbar.';        // Note about configuring plugin
$lang_plugin_FileMove['install_click'] = 'Click button to install plugin.';		// Message to install plugin
$lang_plugin_FileMove['folder_name'] = 'Select the folder you will move';
$lang_plugin_FileMove['folder_ar'] = 'Select destination folder';
$lang_plugin_FileMove['some_files'] = 'Move SOME files in folder';
$lang_plugin_FileMove['choix'] = 'Choice of the operation';
$lang_plugin_FileMove['choix2'] = 'Choose what you wish to do';
$lang_plugin_FileMove['confirm'] = 'Confirm your choice';
$lang_plugin_FileMove['confirm_titre'] = '<b>You have selected the following folders:</b>';
$lang_plugin_FileMove['confirm_files'] = '<b>You have selected the following files:</b>';
$lang_plugin_FileMove['selectAll'] = 'Select All';
$lang_plugin_FileMove['selectNone'] = 'Select None';
$lang_plugin_FileMove['folder'] = 'Move ALL files in folder';
$lang_plugin_FileMove['DFolder'] = 'Starting folder: ';
$lang_plugin_FileMove['AFolder'] = 'Destination folder: ';
$lang_plugin_FileMove['to'] = ' to the ';
$lang_plugin_FileMove['error'] = 'ERROR!';
$lang_plugin_FileMove['file'] = 'File';
$lang_plugin_FileMove['files'] = 'Files';
$lang_plugin_FileMove['valid'] = 'Move Selected File(s)';
$lang_plugin_FileMove['continue'] = 'Continue';
$lang_plugin_FileMove['back'] = 'Back';
$lang_plugin_FileMove['transfer'] = 'Transfer of the contents of the ';
$lang_plugin_FileMove['transfer_file'] = 'Transferred some files from the ';
$lang_plugin_FileMove['folder2'] = 'folder ';
$lang_plugin_FileMove['folder_error'] = 'Error, the folder doesn\'t exist!';
$lang_plugin_FileMove['traitement'] = 'Files transferred';
$lang_plugin_FileMove['notmoved'] = 'Files NOT transferred';
$lang_plugin_FileMove['install_info'] = 'Add a menu item after Batch Add in the Files menu to access at the plugin page';
$lang_plugin_FileMove['extra_info'] = 'Click on the FileMove menu item in the Files menu to use the plugin';
