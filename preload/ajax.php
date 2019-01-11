<?php
/**************************************************
  Coppermine 1.6.x Plugin - image preloader
  *************************************************
  Copyright (c) 2009-2019 eenemeenemuu
  **************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

preg_match_all('/pid=([0-9]+)/', $superCage->get->getRaw('urls'), $matches);

if (count($matches[1]) > 0) {
    $pids = implode(", ", array_unique($matches[1]));

    $result = cpg_db_query("SELECT filepath, filename FROM {$CONFIG['TABLE_PICTURES']} WHERE pid IN ($pids)");
    while($row = cpg_db_fetch_assoc($result)) {
        if (is_image($row['filename'])) {
            $normal_pfx = file_exists($CONFIG['fullpath'].$row['filepath'].$CONFIG['normal_pfx'].$row['filename']) ? $CONFIG['normal_pfx'] : "";
            $preload .= "<img src=\"{$CONFIG['fullpath']}{$row['filepath']}{$normal_pfx}{$row['filename']}\" /> ";
        }
    }

    echo $preload;
}

//EOF