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

$thisplugin->add_action('page_start', 'FileMove_page_start');

// Add config button
function FileMove_config_button ($href, $title, $target, $link)
{
	global $template_gallery_admin_menu;

	$new_template = $template_gallery_admin_menu;
	$button = template_extract_block($new_template, 'batch_add');
	$params = array(
		'searchnew.php' => $href,
		'{SEARCHNEW_TITLE}' => $title,
		'target="cpg_documentation"' => $target,
		'{SEARCHNEW_LNK}' => $link,
		'{SEARCHNEW_ICO}' => cpg_fetch_icon('download', 1),
	);
	$new_button="<!-- BEGIN $link -->" . template_eval($button,$params) . "<!-- END $link -->\n";
	template_extract_block($template_gallery_admin_menu, 'batch_add', "<!-- BEGIN batch_add -->" . $button . "<!-- END batch_add -->\n" . $new_button);
}

// Add admin button to start of each page
function FileMove_page_start ()
{
	global $CONFIG, $lang_plugin_FileMove ;
	$icon = cpg_fetch_icon('download', 1);

	if (GALLERY_ADMIN_MODE) {
		FileMove_config_button('index.php?file=FileMove/plugin_config', $lang_plugin_FileMove['config_title'], '', $lang_plugin_FileMove['config_button']);
	}
}
