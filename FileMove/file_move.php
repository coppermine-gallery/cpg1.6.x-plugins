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

$titre = $lang_plugin_FileMove['folder_ar'];

$Drep = path_name($dfolder);

// Display page header
filemoveHeader();

if ($superCage->post->keyExists('file_name')) {
	$directory = './'.$CONFIG['fullpath'];
	$Drep=path_name($dfolder);
	$selection = 'ok';
//	starttable('100%',$titre);
	echo '</td></tr>';
	echo "<tr><td class='tableh2' align='left'>{$lang_plugin_FileMove['DFolder']}<b>{$Drep}</b></td></tr>";
	echo "<tr><td class='tableh2' align='left'>{$lang_plugin_FileMove['confirm_files']}</td></tr>";
	echo '<tr><td class="tableh2">';
	$filename = $superCage->post->getRaw('file_name');
	setcookie($CONFIG['cookie_name'].'_filemove', base64_encode(serialize($filename)), 0, $CONFIG['cookie_path']);
	foreach  ($filename as $n => $name) {
		echo $name.'&nbsp;&nbsp;';
	}
	echo '</td></tr>';
	echo "<tr><td class='tableh1' align='center'><b>{$lang_plugin_FileMove['folder_ar']}</b></td></tr>";
	//choix du répertoire d'arrivée
	echo '<tr><td>';
	list_dir($directory, 1, $dfolder, $selection, $selection1, $Drep);
	echo '</td></tr>';
//	endtable();
	echo '<tr><td>';
} else {
	//affichage du contenu du répertoire
	$nb = 2;	//Change this value according the column number you will display
	echo '<form name="file" action="" method="post">';
	starttable('100%', $lang_plugin_FileMove['DFolder'].$Drep, $nb);
	echo '<tr class="fm-frow">';
	echo "<td  colspan='{$nb}'>";
	echo '<input type="button" onclick="$(\'.fm-fchkb\').attr(\'checked\', true)" value="'.$lang_plugin_FileMove['selectAll'].'" />';
	echo ' &nbsp;<input type="button" onclick="$(\'.fm-fchkb\').attr(\'checked\', false)" value="'.$lang_plugin_FileMove['selectNone'].'" />';
	echo '</td></tr><tr class="fm-frow">';
	file_dir($dfolder,$nb);
	echo "<td align='center' colspan='{$nb}'><input type='submit' value='{$lang_plugin_FileMove['valid']}' />"
		.' &nbsp;<a href="index.php?file=FileMove/plugin_config"><input type="button" name="ok" value="'.$lang_plugin_FileMove['back'].'" /></a></td></tr>';
	endtable();
	echo '<input type="hidden" name="dfolder" value="'.$dfolder.'" /></form>';
}

filemoveFooter();
