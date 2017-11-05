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

define('IN_COPPERMINE', true);

require_once 'init.inc.php';

if (!USER_ID && $CONFIG['allow_unlogged_access'] == 0) {
    $redirect = $redirect . "login.php";
    header("Location: $redirect");
    exit();
}

global $lang_plugin_enlargeit;
require './plugins/enlargeit/init.inc.php';


$pic = $superCage->get->getInt('pid');

if (empty($pic)) {
    cpg_die(CRITICAL_ERROR, $lang_errors['param_missing'], __FILE__, __LINE__);
}


// If user does not accept script's cookies, we don't accept the vote
if (!$superCage->cookie->keyExists($CONFIG['cookie_name'] . '_data')) {
    header("Location: $ref");
    exit;
}
// See if this picture is already present in the array
if (!in_array($pic, $FAVPICS)) {
    $FAVPICS[] = $pic;
    $enl_added = 1;
} else {
    $key = array_search($pic, $FAVPICS);
    unset ($FAVPICS[$key]);
    $enl_added = 0;
}

$data = base64_encode(serialize($FAVPICS));
setcookie($CONFIG['cookie_name'] . '_fav', $data, time() + 86400 * 30, $CONFIG['cookie_path']);
// If the user is logged in then put it in the DB
if (USER_ID > 0) {
    $sql = "UPDATE {$CONFIG['TABLE_FAVPICS']} SET user_favpics = '$data' WHERE user_id = " . USER_ID;
    cpg_db_query($sql);
    // User never stored a fav... so insert new row
    if (!cpg_db_affected_rows()) {
        $sql = "INSERT INTO {$CONFIG['TABLE_FAVPICS']} ( user_id, user_favpics) VALUES (" . USER_ID . ", '$data')";
        cpg_db_query($sql);
    }
}

echo <<< EOT
<table align="center" cellspacing="1" style="width:100%;height:100%">
    <tr>
        <td width="100%" align="center" class="tableh1">
            <h2>{$lang_plugin_enlargeit['favorites']}</h2>
        </td>
    </tr>
    <tr>
        <td width="100%" align="center" class="tableb">
            <strong>
EOT;
if ($enl_added == 1) {
	echo $lang_plugin_enlargeit['file_added_to_favorites'];
}
else
{
	echo $lang_plugin_enlargeit['file_removed_from_favorites'];
}
echo '            </strong><br />' . $LINEBREAK;
if ($CONFIG['plugin_enlargeit_sefmode']) {
    echo "<a href=\"thumbnails-favpics.html\">".$lang_plugin_enlargeit['button_favorites']."</a>";
} else {
    echo "<br /><a href=\"thumbnails.php?album=favpics\">".$lang_plugin_enlargeit['button_favorites']."</a>";
}

echo "</td></tr></table>";
ob_end_flush();
