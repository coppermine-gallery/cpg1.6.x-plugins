<?php
/**************************************************
  Coppermine 1.6.x Plugin - Picture Annotation (annotate)
  *************************************************
  Copyright (c) 2003-2019 Coppermine Dev Team
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  **************************************************/

  if (!defined('IN_COPPERMINE')) {
    die('Not in Coppermine...');
}

if (annotate_get_level('permissions') < 2) {
    die('Access denied'); // Nobody will see that, as it's only for debugging purposes, so we can leave that string untranslated
}

$superCage = Inspekt::makeSuperCage();

if ($superCage->post->keyExists('add')) {
    $pid = $superCage->post->getInt('add');
    $nid = $superCage->post->getInt('nid');
    $posx = $superCage->post->getInt('posx');
    $posy = $superCage->post->getInt('posy');
    $width = $superCage->post->getInt('width');
    $height = $superCage->post->getInt('height');
    $note = addslashes(addslashes(urldecode(trim(str_replace('"', '\'', $superCage->post->getRaw('note'))))));
    $time = time();
    if ($nid){
        $sql = "UPDATE {$CONFIG['TABLE_PREFIX']}plugin_annotate SET posx = $posx, posy = $posy, width = $width, height = $height, note = '$note' WHERE nid = $nid";
        if (!GALLERY_ADMIN_MODE) {
            $sql .= " AND user_id = " . USER_ID . " LIMIT 1";
        }
        cpg_db_query($sql);
        die("$nid");
    } else {
        $sql = "INSERT INTO {$CONFIG['TABLE_PREFIX']}plugin_annotate (pid, posx, posy, width, height, note, user_id, user_time) VALUES ($pid, $posx, $posy, $width, $height, '$note', " . USER_ID . ", '$time')";
        cpg_db_query($sql);
        $nid = cpg_db_insert_id($CONFIG['LINK_ID']);
        die("$nid");
    }
} elseif ($superCage->post->keyExists('remove')) {
    $nid = $superCage->post->getInt('remove');
    $sql = "DELETE FROM {$CONFIG['TABLE_PREFIX']}plugin_annotate WHERE nid = $nid";
    if (!GALLERY_ADMIN_MODE) {
        $sql .= " AND user_id = " . USER_ID . " LIMIT 1";
    }
    cpg_db_query($sql);
    die("$nid");
} elseif ($superCage->post->keyExists('livesearch')) {
    header("Content-Type: text/html; charset={$CONFIG['charset']}");
    $q = $superCage->post->getRaw('q');
    $tablename = $CONFIG['plugin_annotate_type'] > 0 ? 'plugin_annotate' : 'users';
    $fieldname = $CONFIG['plugin_annotate_type'] > 0 ? 'note' : 'user_name';
    if (strlen(trim($q)) > 0) {
        $searchword = explode(" ", $q);
        for( $i = 0; $i < sizeof($searchword); $i++ ) {
            $searchword[$i] = "$fieldname LIKE '%" .$searchword[$i]. "%'";
        }
        $ready = implode(" AND ", $searchword);

        $result = cpg_db_query("
            SELECT DISTINCT $fieldname
            FROM {$CONFIG['TABLE_PREFIX']}{$tablename}
            WHERE $ready
            ORDER BY $fieldname ASC
        ");
        $hint = "<option selected=\"selected\" disabled=\"disabled\">-- {$lang_plugin_annotate['search_results']} (".cpg_db_num_rows($result)."): $q --</option>";
        while ($row = cpg_db_fetch_assoc($result)) {
            $hint .= "<option value=\"{$row[$fieldname]}\">{$row[$fieldname]}</option>";
        }
        cpg_db_free_result($result);
    } else {
        $result = cpg_db_query("
            SELECT DISTINCT $fieldname
            FROM {$CONFIG['TABLE_PREFIX']}{$tablename}
            ORDER BY $fieldname ASC
        ");
        $hint = "<option selected=\"selected\" disabled=\"disabled\">-- {$lang_plugin_annotate['annotate']} --</option>";
        while ($row = cpg_db_fetch_assoc($result)) {
            $hint .= "<option value=\"{$row[$fieldname]}\">{$row[$fieldname]}</option>";
        }
        cpg_db_free_result($result);
    }

    if (!$hint) {
        $response = "-";
    } else {
        $response = $hint;
    }
    echo $response;
    die();
}

die("0"); // Just a precaution

//EOF