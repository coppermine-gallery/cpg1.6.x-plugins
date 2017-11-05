<?php
/**************************************************
  Coppermine 1.6.x Plugin - xfeed
  *************************************************
  Copyright (c) 2008 lee (www.mininoteuser.com)
  Plugin for CPG 1.4 created by Lee
  Ported to CPG 1.5.x by Aditya Mooley <adityamooley@sanisoft.com>
  Ported to CPG 1.6 by ron4mac
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  **************************************************/

if (!defined('IN_COPPERMINE')) {
    die('Not in Coppermine...');
}

// submit your lang file for this plugin on the coppermine forums
// plugin will try to use the configured language if it is available.

if (file_exists("./plugins/xfeed/lang/{$CONFIG['lang']}.php")) {
    require "./plugins/xfeed/lang/{$CONFIG['lang']}.php";
} else {
    require "./plugins/xfeed/lang/english.php";
}

function populate_category_name($cat = 0) {
    global $CONFIG, $lang_xfeeds;

     /**
     * Get the category name
     */
    if ($cat >= FIRST_USER_CAT) {
        $result = cpg_db_query("SELECT name FROM {$CONFIG['TABLE_CATEGORIES']} WHERE cid = " . USER_GAL_CAT);
        $row = cpg_db_fetch_assoc($result, true);
        $category_array[] = array(USER_GAL_CAT, $row['name']);
        $user_name = get_username($cat - FIRST_USER_CAT);

        if (!$user_name) {
            $user_name = $lang_common['username_if_blank'];
        }

        $category_array[] = array($cat, $user_name);
        return sprintf($lang_xfeeds['xx_s_gallery'], $user_name);
    } else {
        $result = cpg_db_query("SELECT p.cid, p.name FROM {$CONFIG['TABLE_CATEGORIES']} AS c,
            {$CONFIG['TABLE_CATEGORIES']} AS p
            WHERE c.lft BETWEEN p.lft AND p.rgt
            AND c.cid = $cat
            ORDER BY p.lft");

        while (($row = cpg_db_fetch_assoc($result))) {
            $category_array[] = array($row['cid'], $row['name']);
            return $row['name'];
        }
        cpg_db_free_result($result);
    }
}
