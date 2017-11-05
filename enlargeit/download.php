<?php
/**************************************************
  Coppermine 1.6.x Plugin - EnlargeIt!
  *************************************************
  Copyright (c) 2010 Timos-Welt (www.timos-welt.de)
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
 **************************************************/

require './plugins/enlargeit/init.inc.php';

if (!USER_ID ) {
	// We have a guest here
	if ($CONFIG['allow_unlogged_access'] == 0 || $CONFIG['plugin_enlargeit_guestmode'] != '1' || $CONFIG['plugin_enlargeit_buttondownload'] != '1') {
		$redirect = $redirect . "login.php";
		header("Location: $redirect");
		exit();
	}
} elseif (GALLERY_ADMIN_MODE) {
	// We have an admin here
	if ($CONFIG['plugin_enlargeit_adminmode'] != '1') {
		die('Downloads are disabled for the admin group');;
	}
} else {
	// We have a registered user (but not an admin) here
	if ($CONFIG['plugin_enlargeit_registeredmode'] != '1') {
		die('Downloads are disabled for the registered group');;
	}
}

if ($CONFIG['plugin_enlargeit_buttondownload'] == '0') {
	// Downloads are disabled entirely, so someone has tried to access the file manually
	die('Downloads are disabled entirely');;
}



$pid = $superCage->get->getInt('pid');
$pos = $superCage->get->getInt('pos');
$cat = $superCage->get->getInt('cat');
$album = $superCage->get->getInt('album');
$action = $superCage->get->getAlpha('action');

//get_meta_album_set in functions.inc.php will populate the $ALBUM_SET instead; matches $META_ALBUM_SET.
get_meta_album_set($cat,$ALBUM_SET);
$META_ALBUM_SET = $ALBUM_SET; //displayimage uses $ALBUM_SET but get_pic_data in functions now uses $META_ALBUM_SET


// Retrieve data for the current picture
if ($pos < 0 || $pid > 0) {
    $pid = ($pos < 0) ? -$pos : $pid;
    $result = cpg_db_query("SELECT aid from {$CONFIG['TABLE_PICTURES']} WHERE pid='$pid' $ALBUM_SET LIMIT 1");
    if (cpg_db_num_rows($result) == 0) cpg_die(ERROR, $lang_errors['non_exist_ap'], __FILE__, __LINE__);
    $row = cpg_db_fetch_array($result, true);
    $album = $row['aid'];
    $pic_data = get_pic_data($album, $pic_count, $album_name, -1, -1, false);
    for($pos = 0; $pic_data[$pos]['pid'] != $pid && $pos < $pic_count; $pos++);
    $pic_data = get_pic_data($album, $pic_count, $album_name, $pos, 1, false);
    $CURRENT_PIC_DATA = $pic_data[0];

} elseif (isset($_GET['pos'])) {
    $pic_data = get_pic_data($album, $pic_count, $album_name, $pos, 1, false);
    if ($pic_count == 0) {
        cpg_die(INFORMATION, $lang_errors['no_img_to_display'], __FILE__, __LINE__);
    } elseif (count($pic_data) == 0 && $pos >= $pic_count) {
        $pos = $pic_count - 1;
        $human_pos = $pos + 1;
        $pic_data = get_pic_data($album, $pic_count, $album_name, $pos, 1, false);
    }
    $CURRENT_PIC_DATA = $pic_data[0];
}

if ($action == 'download' && $CURRENT_PIC_DATA['filename'] != '') {
	$mypath = $CONFIG['fullpath'].$CURRENT_PIC_DATA['filepath'].$CURRENT_PIC_DATA['filename'];


	header('Content-type: image/jpeg');
	header('Content-Disposition: attachment; filename="'.$CURRENT_PIC_DATA['filename'].'"');

	ob_end_flush();
	readfile ($mypath);
} elseif ($CURRENT_PIC_DATA['filename'] != '') {
	$client_array = cpg_determine_client();
	if (in_array($client_array['browser'], array('IE8', 'IE7', 'IE6', 'IE5.5', 'IE5', 'Opera', 'Chrome')) == TRUE) {
		// if IE, Opera or Chrome, open download file in same browser window because they detect 
		// that it's a download. else open in new window, cause mozilla needs this to not stop animated GIFs
		$download_link = "window.location='index.php?file=enlargeit/download&action=download&pid=".$pid."'";
	} else {
		$download_link = "window.open('index.php?file=enlargeit/download&action=download&pid=".$pid."'); return false;";
	}
	echo <<< EOT
<table cellspacing="1" style="width:100%;height:100%">
	<tr>
		<td align="center" class="tableh1">
			<h2>{$lang_plugin_enlargeit['download']}</h2>
		</td>
	</tr>
	<tr>
		<td align="center" class="tableb">
			<strong><a href="index.php?file=enlargeit/download&action=download&pid={$pid}" onclick="{$download_link}">{$lang_plugin_enlargeit['download_explain']}</a></strong>
		</td>
	</tr>
</table>
EOT;
} else {
	echo 'The script has made a boo or you have done something that you\'re not allowed to do. Sorry, can\'t help you now. Trying downloading the file the "usual" way.';
}
