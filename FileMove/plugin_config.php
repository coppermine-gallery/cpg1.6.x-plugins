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

require_once 'plugins/FileMove/include/function.inc.php';

//global $CONFIG, $titre, $Drep;
if (!GALLERY_ADMIN_MODE) cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);

// Get input variables
$dfolder = $superCage->get->getRaw('dfolder');
$selection = $superCage->get->getRaw('selection');
$selection1 = $superCage->get->getRaw('selection1');

if ($selection1 == 'ok') {
	$titre = $lang_plugin_FileMove['folder_ar'];
} else {
	$titre = $lang_plugin_FileMove['folder_name'];
}

$Drep = '';

// Display page header
filemoveHeader();

$directory = './'.$CONFIG['fullpath'];

switch ($selection) {
	case 'ok':
		// Display the source directory tree
		if ($selection1 == 'ok') {
			$Drep = path_name($dfolder);
			$RepD = $Drep;
			starttable('100%', $titre);
			echo '<tr><td align="left">'.$lang_plugin_FileMove['DFolder'].'<b>'.$Drep.'</b></td></tr>';
			echo '<tr><td>';
			list_dir($directory, 1, $dfolder, $selection, $selection1, $RepD);
			echo '</td></tr>';
			endtable();
		} else {
			$selection = 'ok';
			// Display the choice of action (move all files in the directory or just some files)
			action_select($dfolder, $selection);
		}
		break;
	case 'oui':
		$Arep = path_name($dfolder);
		$RepD = $superCage->get->getRaw('RepD');
		// Display the two directories to be moved and confirmation for processing
		confirm_choix($RepD, $Arep);
		break;
	default:
		starttable('100%', $titre);
		echo '<tr><td class="fm-dlst">';
		list_dir($directory, 1, $dfolder, $selection, $selection1, $Drep);
		echo '</td></tr>';
		endtable();
}

filemoveFooter();
