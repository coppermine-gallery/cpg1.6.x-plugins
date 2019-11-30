<?php
/**************************************************
  Coppermine 1.6.x Plugin - Check files
  *************************************************
  Copyright (c) 2012 eenemeenemuu
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  ********************************************
**************************************************/

if (!GALLERY_ADMIN_MODE) {
    cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);
}

if ($superCage->get->getAlpha('do') == 'dashboard') {
    if ($CONFIG['plugin_check_files_status_missing'] == '') {
        header("Location: index.php?file=check_files/missing_files&do=new");
    }
    pageheader("Search for missing files - Dashboard");
    starttable("100%", "Search for missing files", 2);
    $view_continue = $CONFIG['plugin_check_files_status_missing'] == 'complete' ? 'View results of last run' : 'Continue incomplete run';
    echo <<< EOT
        <tr>
            <td class="tableb">
                <ul>
                    <li><a href="index.php?file=check_files/missing_files&amp;do=continue">$view_continue</a></li>
                    <li><a href="index.php?file=check_files/missing_files&amp;do=new">Delete results of last run and start new run</a></li>
                </ul>
            </td>
        </tr>
EOT;
	endtable();
    pagefooter();
}

if ($superCage->get->getAlpha('do') == 'continue') {
    if ($CONFIG['plugin_check_files_status_missing'] == 'complete') {
        header("Location: index.php?file=check_files/missing_files&do=view");
    }
    if (is_numeric($CONFIG['plugin_check_files_status_missing'])) {
        header("Location: index.php?file=check_files/missing_files&do=search#check_files_top");
    }
}

if ($superCage->get->getAlpha('do') == 'new') {
//    cpg_db_query("DELETE FROM {$CONFIG['TABLE_PREFIX']}plugin_check_files_missing");
//    cpg_db_query("ALTER TABLE {$CONFIG['TABLE_PREFIX']}plugin_check_files_missing AUTO_INCREMENT = 1");
    cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '0' WHERE name = 'plugin_check_files_status_missing'");
    header("Location: index.php?file=check_files/missing_files&do=search#check_files_top");
}

if ($superCage->get->getAlpha('do') == 'search') {
    if (!is_numeric($CONFIG['plugin_check_files_status_missing'])) {
        header("Location: index.php?file=check_files/missing_files&do=continue");
    }
    $CONFIG['debug_mode'] = 0;

    $limit_offset = $CONFIG['plugin_check_files_status_missing'];
    $limit_row_count = $superCage->get->getInt('row_count') ? $superCage->get->getInt('row_count') : 500;
    $starttime = $superCage->get->getInt('starttime') ? $superCage->get->getInt('starttime') : time();
    $numpics = $superCage->get->getInt('numpics') ? $superCage->get->getInt('numpics') : cpg_db_result(cpg_db_query("SELECT COUNT(*) FROM {$CONFIG['TABLE_PICTURES']}"),0);   //*GMC 1.6 compat
    $found = $superCage->get->getInt('found') ? $superCage->get->getInt('found') : 0;

    if (!$superCage->get->keyExists('offset')) {
        cpg_db_query("DROP TABLE IF EXISTS {$CONFIG['TABLE_PREFIX']}plugin_check_files_missing");
        cpg_db_query("CREATE TABLE {$CONFIG['TABLE_PREFIX']}plugin_check_files_missing (
                        id int(11) NOT NULL auto_increment,
                        pid int(11) NOT NULL,
                        filepath varchar(255) NOT NULL,
                        filename varchar(255) NOT NULL,
                        type varchar(8) NOT NULL,
                        PRIMARY KEY (id) )");
    }

    $filetype = array();
    $result = cpg_db_query("SELECT extension FROM {$CONFIG['TABLE_FILETYPES']} WHERE content = 'image'");
    while ($row = cpg_db_fetch_array($result)) {
        $filetype[] = $row[0];
    }

    $result = cpg_db_query("SELECT pid, filepath, filename, pwidth, pheight FROM {$CONFIG['TABLE_PICTURES']} ORDER BY filepath LIMIT $limit_offset, $limit_row_count");
    while ($file = cpg_db_fetch_assoc($result)) {                                                                                                                 //*GMC 1.6 compat
        if (!file_exists($CONFIG['fullpath'].$file['filepath'].$file['filename'])) {
            $query = "INSERT INTO {$CONFIG['TABLE_PREFIX']}plugin_check_files_missing (pid, filepath, filename, type) VALUES('{$file['pid']}', '{$file['filepath']}', '{$file['filename']}', 'fullsize')";
            cpg_db_query($query);
$rows = cpg_db_affected_rows();
echo $query.' - '.$rows.' affected.<br />';
            $found++;
        }

        if (is_image($file['filename'])) {
            if (!file_exists($CONFIG['fullpath'].$file['filepath'].$CONFIG['thumb_pfx'].$file['filename'])) {
                $query = "INSERT INTO {$CONFIG['TABLE_PREFIX']}plugin_check_files_missing (pid, filepath, filename, type) VALUES('{$file['pid']}', '{$file['filepath']}', '{$CONFIG['thumb_pfx']}{$file['filename']}', 'thumb')";
                cpg_db_query($query);
$rows = cpg_db_affected_rows();
echo $query.' - '.$rows.' affected.<br />';
                $found++;
            }

            if ($CONFIG['make_intermediate'] && cpg_picture_dimension_exceeds_intermediate_limit($file['pwidth'], $file['pheight'])) {
                if(!file_exists($CONFIG['fullpath'].$file['filepath'].$CONFIG['normal_pfx'].$file['filename'])) {
                    $QUERY_STRING = "INSERT INTO {$CONFIG['TABLE_PREFIX']}plugin_check_files_missing (pid, filepath, filename, type) VALUES('{$file['pid']}', '{$file['filepath']}', '{$CONFIG['normal_pfx']}{$file['filename']}', 'normal')";
                    cpg_db_query($query);
$rows = cpg_db_affected_rows();
echo $query.' - '.$rows.' affected.<br />';
                    $found++;
                }
            }

            /*
            if ($CONFIG['enable_watermark']) {
                if(!file_exists($CONFIG['fullpath'].$file['filepath'].$CONFIG['orig_pfx'].$file['filename'])) {
                    cpg_db_query("INSERT INTO {$CONFIG['TABLE_PREFIX']}plugin_check_files_missing (pid, filepath, filename, type) VALUES('{$file['pid']}', '{$file['filepath']}', '{$CONFIG['orig_pfx']}{$file['filename']}', 'orig')");
                    $found++;
                }
            }
            */
        }
    }
    $limit_offset += $limit_row_count;
    if ($limit_offset <= $numpics) {
        cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '$limit_offset' WHERE name = 'plugin_check_files_status_missing'");
        $progress = $limit_offset <= $numpics ? round($limit_offset / $numpics * 100, 2) : "100";
        $begin = date("H:i", $starttime);
        $elapsed = time() - $starttime;
        $remaining = round ($elapsed*100/$progress - $elapsed, 0);
        $end = date("H:i", time()+$remaining);
        pageheader("Search for missing files - {$progress}%");
        echo "<a name=\"check_files_top\"></a>";
        starttable("100%", "Search for missing files", 2);
        echo "
            <meta http-equiv=\"refresh\" content=\"0; URL=index.php?file=check_files/missing_files&amp;do=search&amp;found=$found&amp;row_count=$limit_row_count&amp;numpics=$numpics&amp;starttime=$starttime#check_files_top\">
            <tr><td class=\"tableb\">Progress:</td><td class=\"tableb\">{$progress}% (checking files ".($limit_offset - $limit_row_count)." - $limit_offset of $numpics)</td></tr>
            <tr><td class=\"tableb\">Start:</td><td class=\"tableb\">$begin</td></tr>
            <tr><td class=\"tableb\">Time elapsed:</td><td class=\"tableb\">$elapsed seconds</td></tr>
            <tr><td class=\"tableb\">Time remaining:</td><td class=\"tableb\">$remaining seconds</td></tr>
            <tr><td class=\"tableb\">End:</td><td class=\"tableb\">$end</td></tr>
            <tr><td class=\"tableb\">Missing&nbsp;files&nbsp;up&nbsp;to&nbsp;this&nbsp;point:</td><td class=\"tableb\" width=\"100%\">$found</td></tr>
        ";
        endtable();
        pagefooter();
    } else {
        cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = 'complete' WHERE name = 'plugin_check_files_status_missing'");
        header("Location: index.php?file=check_files/missing_files&do=view");
    }
}

if ($superCage->get->getAlpha('do') == 'view') {
    if ($CONFIG['plugin_check_files_status_missing'] != 'complete') {
        header("Location: index.php?file=check_files/missing_files&do=continue");
    }
    pageheader("Search for missing files - Results");
    starttable("100%", "Search for missing files", 2);
    $result = cpg_db_query("SELECT * FROM {$CONFIG['TABLE_PREFIX']}plugin_check_files_missing ORDER BY filepath ASC, filename ASC");
    while ($row = cpg_db_fetch_assoc($result)) {                                                                                                                  //*GMC 1.6 compat
        $missing[$row['filepath']][] = $row['filename'];
    }
    if (!$missing) {
        echo "<tr><td class=\"tableb\" colspan=\"2\">There are no missing files in the albums directory, hooray!</td></tr>";
    } else {
        echo "<tr><td class=\"tableb\" colspan=\"2\">The following files are missing in the albums directory (grouped by expandable paths):</td></tr>";
        foreach($missing as $dir => $files) {
            $id = "check_files_missing_".$i++;
            echo "<tr><td class=\"tableb\" colspan=\"2\"><span onclick=\"$('#{$id}').slideToggle();\" style=\"cursor:pointer;\">{$dir} [".count($files)."]</span></td></tr>";
            echo "<tr><td class=\"tableb\" colspan=\"2\"><div id=\"{$id}\" style=\"display:none;\"><table width=\"100%\" cellspacing=\"0\"><tr><td class=\"tableb\">";
            foreach($files as $file) {
                echo $CONFIG['fullpath'].$dir.$file."<br />";
            }
            echo "</td></tr></table></td></tr></div>";
        }
        echo "<tr><td class=\"tableb\" colspan=\"2\"><a href=\"index.php?file=check_files/missing_files&amp;do=delete&amp;missing=fullsize\" class=\"admin_menu\">Delete all files with missing full-sized picture from database</a></td></tr>";
    }
    endtable();
    pagefooter();
}

if ($superCage->get->getAlpha('do') == 'delete') {
    if ($CONFIG['plugin_check_files_status_missing'] != 'complete') {
        header("Location: index.php?file=check_files/missing_files&do=continue");
    }

    if ($superCage->get->getEscaped('missing') == 'fullsize') {
        $result = cpg_db_query("SELECT DISTINCT pid FROM {$CONFIG['TABLE_PREFIX']}plugin_check_files_missing WHERE type = 'fullsize'");
        while ($row = cpg_db_fetch_assoc($result)) {                                                                                                              //*GMC 1.6 compat
            $missing[$row['pid']] = $row['pid'];                                // added pid as array key for use below in favpics processing                     //*GMC
        }
        $missing_pids = implode(', ', $missing);

        cpg_db_query("DELETE FROM {$CONFIG['TABLE_PICTURES']} WHERE pid IN ($missing_pids)");
        cpg_db_query("DELETE FROM {$CONFIG['TABLE_COMMENTS']} WHERE pid IN ($missing_pids)");
        cpg_db_query("DELETE FROM {$CONFIG['TABLE_EXIF']} WHERE pid IN ($missing_pids)");
        cpg_db_query("DELETE FROM {$CONFIG['TABLE_HIT_STATS']} WHERE pid IN ($missing_pids)");
        cpg_db_query("DELETE FROM {$CONFIG['TABLE_VOTE_STATS']} WHERE pid IN ($missing_pids)");
        cpg_db_query("DELETE FROM {$CONFIG['TABLE_VOTES']} WHERE pic_id IN ($missing_pids)");
        cpg_db_query("UPDATE {$CONFIG['TABLE_ALBUMS']} SET thumb = '0' WHERE thumb IN ($missing_pids)");
        cpg_db_query("UPDATE {$CONFIG['TABLE_CATEGORIES']} SET thumb = '0' WHERE thumb IN ($missing_pids)");
        // and favpics (remove pid preserving other pics) references...
        //*GMC added code to process favpics                                                                                                                      //*GMC
        $resultf = cpg_db_query("SELECT * FROM {$CONFIG['TABLE_FAVPICS']}");               // select all favpics                                                  //*GMC
        while ($rowf = cpg_db_fetch_assoc($resultf)) {                                                                                                            //*GMC
            $favpics = $favpicssv = unserialize(base64_decode($rowf['user_favpics']));     // need 2 copies - 1 to traverse - 1 to update - convert to array      //*GMC
            $updatefav = FALSE;                                                            // default to no update                                                //*GMC
            foreach ($favpics as $favkey => $favpic) {                                                                                                            //*GMC
                if (key_exists($favpic, $missing)) {                                       // contain a deleted pid?                                              //*GMC
                    // favpics pid just deleted...                                                                                                                //*GMC
                    unset($favpicssv[$favkey]);                                            // unset in second copy...                                             //*GMC
                    $updatefav = TRUE;                                                     // show updaate made                                                   //*GMC
                }                                                                                                                                                 //*GMC
            }                                                                                                                                                     //*GMC
            if ($updatefav) {                                                              // update required?                                                    //*GMC
                $favupdate = base64_encode(serialize($favpicssv));                         // encode for db                                                       //*GMC
                cpg_db_query("UPDATE {$CONFIG['TABLE_FAVPICS']} SET user_favpics = '$favupdate' WHERE user_id = '{$rowf['user_id']}' LIMIT 1");                   //*GMC
            }                                                                              // and update row                                                      //*GMC
        }                                                                                                                                                         //*GMC
        //*GMC end additions                                                                                                                                      //*GMC
        cpg_db_query("DELETE FROM {$CONFIG['TABLE_PREFIX']}plugin_check_files_missing WHERE pid IN ($missing_pids)");
    }

    header("Location: index.php?file=check_files/missing_files&do=view");
}
