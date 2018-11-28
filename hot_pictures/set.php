<?php
/**************************************************
  Coppermine 1.6.x Plugin - Hot pictures
  *************************************************
  Copyright (c) 2012-2018 eenemeenemuu
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
**************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$pid = $superCage->get->getInt('pid');
if (hot_pictures_config('groups')) {
    $days = $superCage->get->getInt('hot');
    if ($days === 0) {
        cpg_db_query("UPDATE {$CONFIG['TABLE_PICTURES']} SET hot_expire = 0 WHERE pid = $pid");
        $set = 0;
    } elseif (in_array($days, hot_pictures_config('buttons'))) {
        cpg_db_query("UPDATE {$CONFIG['TABLE_PICTURES']} SET hot_expire = ".(time()+60*60*24*$days)." WHERE pid = $pid");
        $set = $days;
    } else {
        $set = -1;
    }
    header("Location: displayimage.php?pid=$pid&set=$set#top_display_media");
} else {
    header("Location: displayimage.php?pid=$pid#top_display_media");
}

//EOF