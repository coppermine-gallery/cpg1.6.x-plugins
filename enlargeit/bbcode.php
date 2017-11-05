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

if (!USER_ID && $CONFIG['allow_unlogged_access'] == 0) {
	cpg_die(ERROR, $lang_errors['access_none'], __FILE__, __LINE__);
}


$pid = $superCage->get->getInt('pid');
$pos = $superCage->get->getInt('pos');
$cat = $superCage->get->getInt('cat');
$album = $superCage->get->getInt('album');


//get_meta_album_set in functions.inc.php will populate the $ALBUM_SET instead; matches $META_ALBUM_SET.
get_meta_album_set($cat,$ALBUM_SET);
$META_ALBUM_SET = $ALBUM_SET; //displayimage uses $ALBUM_SET but get_pic_data in functions now uses $META_ALBUM_SET


// Retrieve data for the current picture
if ($pos < 0 || $pid > 0) {
    $pid = ($pos < 0) ? -$pos : $pid;
    $result = cpg_db_query("SELECT aid from {$CONFIG['TABLE_PICTURES']} WHERE pid='$pid' $ALBUM_SET LIMIT 1");
    if (cpg_db_num_rows($result) == 0) cpg_die(ERROR, $lang_errors['non_exist_ap'], __FILE__, __LINE__);
    $row = cpg_db_fetch_array($result,true);
    $album = $row['aid'];
    $pic_data = get_pic_data($album, $pic_count, $album_name, -1, -1, false);
    for($pos = 0; $pic_data[$pos]['pid'] != $pid && $pos < $pic_count; $pos++);
    $pic_data = get_pic_data($album, $pic_count, $album_name, $pos, 1, false);
    $CURRENT_PIC_DATA = $pic_data[0];

} elseif (isset($pos) && $superCage->get->keyExists('pos')) {
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

	$fullsize_url = get_pic_url($CURRENT_PIC_DATA);  //here we grab the url to the fullsized pic
	$thumb_url = get_pic_url($CURRENT_PIC_DATA, 'thumb'); //thumb url

  $CURRENT_PIC_DATA['title'] ? $name = $CURRENT_PIC_DATA['title'] : $name = 'No Title'; //chcking if the pic has a title, if not we set it to 'No title'
	$img_url = '[url='.$CONFIG['ecards_more_pic_target'].$fullsize_url.'][IMG]'.$CONFIG['ecards_more_pic_target'].$thumb_url.'[/IMG][/url]';
	$name_url = '[url='.$CONFIG['ecards_more_pic_target'].$fullsize_url.']'.$name.'[/url]';

$client_array = cpg_determine_client();
if (in_array($client_array['browser'], array('IE8', 'IE7', 'IE6', 'IE5.5', 'IE5')) == TRUE) { // Browsers that are capable to use the 'copy to clipboard' script.
	$copy_image_string = '<br /><button type="button" class="button" name="copy_img" value="'.$lang_plugin_enlargeit['copy_to_clipboard'].'" onclick="window.clipboardData.setData(\'Text\', \''.$img_url.'\');">'.$enlargeit_icon_array['copy'].$lang_plugin_enlargeit['copy_to_clipboard'].'</button>';
	$copy_url_string = '<br /><button type="button" class="button" name="copy_url" value="'.$lang_plugin_enlargeit['copy_to_clipboard'].'" onclick="window.clipboardData.setData(\'Text\', \''.$name_url.'\');">'.$enlargeit_icon_array['copy'].$lang_plugin_enlargeit['copy_to_clipboard'].'</button>';
	
} else {
	$copy_image_string = '';
	$copy_url_string = '';
}

echo <<< EOT
<table cellspacing="1" style="width:100%;height:100%">
	<tr>
		<td colspan="2" class="tableh1" align="center">
			<h2>{$lang_plugin_enlargeit['bbcode']}</h2>
		</td>
	</tr>
	<tr>
		<td class="tableb" align="center">
			<h5 style="margin:0px;padding:0px;line-height:0.8em;">[url][img][/url]</h5>
			<textarea rows="5" cols="40" class="textinput" style="overflow:off;">{$img_url}</textarea>
			{$copy_image_string}
		</td>
	</tr>
	<tr>
		<td class="tableb" align="center">
			<h5 style="margin:0px;padding:0px;line-height:0.8em;">[url]title[/url]</h5>
			<textarea rows="3" cols="40" class="textinput" style="overflow:off;">{$name_url}</textarea>
			{$copy_url_string}
		</td>
	</tr>
</table>
EOT;
