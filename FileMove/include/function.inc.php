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

/*********************************************
*extension($file)
*fonction d'attribution d'une icone pour chaque type de fichiers
$file:nom du fichier
*********************************************/
function extension ($file)
{
	global $CONFIG;

	$ext = strtolower(substr(strrchr($file , '.'), 1));

	if ($file == 'folder') {
		$icon = 'folder.png';
		$alt = 'Folder';
	} elseif (in_array($ext, explode('/', $CONFIG['allowed_img_types']))) {
		$icon = 'image.png';
		$alt = 'Image';
	} elseif (in_array($ext, explode('/', $CONFIG['allowed_mov_types']))) {
		$icon = 'movie.png';
		$alt = 'Video';
	} elseif (in_array($ext, explode('/', $CONFIG['allowed_snd_types']))) {
		$icon = 'sound.png';
		$alt = 'Audio';
	} elseif (in_array($ext, explode('/', $CONFIG['allowed_doc_types']))) {
		$icon = 'docu.png';
		$alt = 'Document';
	} else {
		$icon = 'unknown.png';
		$alt = 'Unknown filetype';
	}

	return '<img src="plugins/FileMove/images/'.$icon.'" class="fm-ficon" alt="'.$alt.'" width="16" height="16" />';
}

/******************************************
*indent($max)
*fonction implmentant l'indentation de l'arborescence
*$max:niveau de dpart de l'indentation
******************************************/
function indent ($max)
{
	echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $max-1);
}

/******************************************
*notAltImg($entry)
*returns true if a file is not one of the generated image copies
*$entry:file name
******************************************/
function notAltImg ($entry)
{
	global $CONFIG;
	if (stripos($entry, $CONFIG['normal_pfx']) === 0 ||
		stripos($entry, $CONFIG['thumb_pfx']) === 0 ||
		stripos($entry, $CONFIG['orig_pfx']) === 0)
		return false;
	return true;
}

/******************************************
*count_files($dir)
*fonction de comptage des fichiers dansun rpertoire avec filtres sur certaines extensions
*$dir:cheminrelatif du rpertoire traiter
******************************************/
function count_files ($dir)
{
	global $CONFIG;
	$num = 0;
	$ignore = array('php','html','db','svn','txt','DS_Store','');
	$dir_handle = opendir($dir);
	while ($entry = readdir($dir_handle)) {
		$path_parts = pathinfo($entry);
		if (empty($path_parts['extension'])) $path_parts['extension'] = '';
		if ($entry == 'edit' || in_array($path_parts['extension'], $ignore)) continue;
		if (is_file($dir.'/'.$entry)) {
			if (notAltImg($entry)) {
				$num++;
			}
		}
	}
	closedir($dir_handle);
	return $num;
}

/*****************************************
*list_dir($path,$step,$dfolder)
*fonction d'affichage de l'arborescence
*$path: chemin relatif du rpertoire de dpart de l'arborescence
*$step: valeur de dpart pour l'indentation
*$dfolder: chemin du rpertoire slectionn au dpart
*****************************************/
function list_dir ($path, $step, $dfolder, $selection, $selection1, $Drep)
{
	global $num, $lang_plugin_FileMove, $filename;

	if ($selection1 == 'ok') {
		$select = 'oui';
	} else {
		$select = 'ok';
	}

	$dir = opendir($path);
	$ListFiles = array();
	while ($file = readdir($dir)) {
		if (in_array($file, array('.','..','.svn','edit'))) continue;
		if (is_dir($path.$file)) {
		// on passe les datas dans un tableau
			$ListFiles[] = $file;
		}
	}
	closedir($dir);
	natsort($ListFiles);

	$fldIcon = extension('folder');

	foreach ($ListFiles as $file) {
		indent($step);
		$folder_name = $path.$file;
		$nb = count_files($folder_name);
		if ($folder_name == $dfolder) {
			if ($nb==0) {
				echo $fldIcon."{$file}<br />";
			}
			if ($nb==1) {
				echo $fldIcon."{$file}({$nb} {$lang_plugin_FileMove['file']})<br />";
			}
			if ($nb > 1) {
				echo $fldIcon."{$file}({$nb} {$lang_plugin_FileMove['files']})<br />";
			}
		} else {
			if ($nb==0) {
				if (!$filename) {
					echo $fldIcon."<a href='index.php?file=FileMove/plugin_config&amp;dfolder=$folder_name&amp;selection=$select&amp;RepD=$Drep'>{$file}</a><br />";
				} else {
					echo $fldIcon."<a href='index.php?file=FileMove/move_file&amp;dfolder=$folder_name&amp;selection=$select&amp;RepD=$Drep'>{$file}</a><br />";
				}
			}
			if ($nb==1) {
				if (!$filename) {
					echo $fldIcon."<a href='index.php?file=FileMove/plugin_config&amp;dfolder=$folder_name&amp;selection=$select&amp;RepD=$Drep'>{$file} ({$nb} {$lang_plugin_FileMove['file']})</a><br />";
				} else {
					echo $fldIcon."<a href='index.php?file=FileMove/move_file&amp;dfolder=$folder_name&amp;selection=$select&amp;RepD=$Drep'>{$file} ({$nb} {$lang_plugin_FileMove['file']})</a><br />";
				}
			}
			if ($nb > 1) {
				if (!$filename) {
					echo $fldIcon."<a href='index.php?file=FileMove/plugin_config&amp;dfolder=$folder_name&amp;selection=$select&amp;RepD=$Drep'>{$file} ({$nb} {$lang_plugin_FileMove['files']})</a><br />";
				} else {
					echo $fldIcon."<a href='index.php?file=FileMove/move_file&amp;dfolder=$folder_name&amp;selection=$select&amp;RepD=$Drep'>{$file} ({$nb} {$lang_plugin_FileMove['files']})</a><br />";
				}
			}
		}
		list_dir($folder_name.'/', $step+1, $dfolder, $selection, $selection1, $Drep);
	}

}

/*********************************
*file_dir($dfolder)
*affichage du contenu du rpertoire avec checkbox devant les noms de fichiers
*$dfolder: chemin relatif du rpertoire traiter
*********************************/
function file_dir ($dfolder, $nb)
{
	global $num, $lang_plugin_FileMove, $CONFIG;
	$files = [];
	$n = 0;
	$ignore = array(
		'.',
		'..',
		'edit',
		'index.html',
		'Thumbs.db',
		'.DS_Store',
		'no_FTP-uploads_into_this_folder!.txt',
		'index.php'
		);
	if ($dir = @opendir($dfolder)) {
		while ($file = readdir($dir)) {
			if (in_array($file, $ignore)) continue;
			if (is_file($dfolder.'/'.$file)) {
				if (notAltImg($file)) {
					$files[] = $file;
				}
			}
		}
		closedir($dir);
		natcasesort($files);
		foreach ($files as $file) {
			if ($n < $nb) {
				echo '<td><input type="checkbox" class="fm-fchkb" name="file_name[]" value="'.$file.'" />'.extension($file).$file.'</td>';
				$n++;
				if ($n == $nb) {
					echo '</tr><tr class="fm-frow">';
					$n = 0;
				}
			}
		}
		if ($n) {
			echo str_repeat('<td></td>', $nb-$n);
			echo '</tr><tr class="fm-frow">';
		}
	}
}

/*********************************
*path_name($dfolder)
*Extrait le nom du rpertoire
*$dfolder: chemin relatif du rpertoire traiter
**********************************/
function path_name ($dfolder)
{
	global $CONFIG;
	$path_leng = strlen($CONFIG['fullpath'])+2;
	$Drep = substr($dfolder,$path_leng);
	return $Drep;
}

/********************************
*action_select($dfolder)
*fonction d'affichage du menu de choix de l'action a mener (dplacement de l'ensemble du contenu du rpertoire ou de certains fichiers)
*$dfolder: chemin relatif du rpertoire traiter
*********************************/
function action_select ($dfolder, $selection)
{
	global $lang_plugin_FileMove, $selection, $Drep;
	$Drep = path_name($dfolder);
//	starttable('100%', $lang_plugin_FileMove['choix'],2);
	$menu_action = <<<EOT
	</td></tr><tr><td class="tableh1" align="left"><b>{$lang_plugin_FileMove['choix2']}</b></td>
	<td class="tableh1" align="right">{$lang_plugin_FileMove['DFolder']}<b>{$Drep}</b></td></tr>
	<tr><td colspan="2" align="center">
	<a href="index.php?file=FileMove/plugin_config&amp;dfolder=$dfolder&amp;selection1=ok&amp;selection=ok"><input type="button" name="all" value="{$lang_plugin_FileMove['folder']}" /></a>
	<a href="index.php?file=FileMove/file_move&amp;dfolder=$dfolder"><input type="button" name="some" value="{$lang_plugin_FileMove['some_files']}" /></a>
	<a href="index.php?file=FileMove/plugin_config"><input type="button" name="back" value="{$lang_plugin_FileMove['back']}" /></a>
	</td></tr><tr><td>
EOT;
	echo $menu_action;
//	endtable();
}

/***********************************
*confirm_choix($RepD,$Arep)
*fonction affichant les rpertoires de dpart et d'arrive pour confirmation
*$ReD: rpertoire de dpart
*$Arep: rpertoire d'arrive
***********************************/
function confirm_choix ($RepD, $Arep)
{
	global $lang_plugin_FileMove;
	starttable('100%',$lang_plugin_FileMove['confirm']);
	$confirm = <<<EOT
	<tr><td align="center">{$lang_plugin_FileMove['confirm_titre']}</td></tr>
	<tr><td align="center">{$lang_plugin_FileMove['DFolder']}<b>{$RepD}</b>&nbsp;&nbsp;<img align="top" src="./plugins/FileMove/images/arrow.gif" alt="" />&nbsp;&nbsp; {$lang_plugin_FileMove['AFolder']}<b>{$Arep}</b> </td></tr>
	<tr><td align="center">
	<a href="index.php?file=FileMove/move_folder&amp;Drep=$RepD&amp;Arep=$Arep"><input type="button" name="ok" value="{$lang_plugin_FileMove['valid']}" /></a>
	<a href="index.php?file=FileMove/plugin_config"><input type="button" name="ok" value="{$lang_plugin_FileMove['back']}" /></a>
	</td></tr>
EOT;
	echo $confirm;
	endtable();
}

function file_move ($file_name, $DRep, $ARep)
{
	global $CONFIG;
	//Fichiers de dpart
	$Dpath = './'.$CONFIG['fullpath'].$DRep;
	$DFile = $Dpath.$file_name;
	$DFile_Thumb = $Dpath.$CONFIG['thumb_pfx'].$file_name;
	$DFile_Normal = $Dpath.$CONFIG['normal_pfx'].$file_name;
	//Fichiers d'arrive
	$Apath = './'.$CONFIG['fullpath'].$ARep;
	$AFile = $Apath.$file_name;
	$AFile_Thumb = $Apath.$CONFIG['thumb_pfx'].$file_name;
	$AFile_Normal = $Apath.$CONFIG['normal_pfx'].$file_name;
	//copie des fichiers,
	copy($DFile, $AFile);
	copy($DFile_Thumb, $AFile_Thumb);
	copy($DFile_Normal, $AFile_Normal);
	$DFile_Orig = $Dpath.$CONFIG['orig_pfx'].$file_name;
	$AFile_Orig = $Apath.$CONFIG['orig_pfx'].$file_name;
	if (file_exists($DFile_Orig)) {
		if (copy($DFile_Orig, $AFile_Orig)) {
			unlink($DFile_Orig);
		}
	}
	//modpack compatibility {Stramm}
	if (isset($CONFIG['mini_pfx'])) {
		$DFile_Mini = $Dpath.$CONFIG['mini_pfx'].$file_name;
		$AFile_Mini = $Apath.$CONFIG['mini_pfx'].$file_name;
		if (file_exists($DFile_Mini)) {
			if (copy($DFile_Mini, $AFile_Mini)) {
				unlink($DFile_Mini);
			}
		}
	}
	//effacement des fichiers d'origine
	unlink($DFile);
	unlink($DFile_Thumb);
	unlink($DFile_Normal);
}

function filemoveHeader ()
{
	global $lang_gallery_admin_menu, $lang_plugin_FileMove;
	include 'plugins/FileMove/configuration.php';
	pageheader($lang_plugin_FileMove['display_name'], '<link rel="stylesheet" href="plugins/FileMove/static/style.css" type="text/css" />');
	starttable('100%', $lang_plugin_FileMove['display_name'].' - '.$version.'<a href="pluginmgr.php" class="admin_menu fm-right">'.$lang_gallery_admin_menu['pluginmgr_lnk'].'</a>', 2);
	echo '<tr><td>';
}

function filemoveFooter ()
{
	echo '</td></tr>';
	endtable();
	pagefooter();
}