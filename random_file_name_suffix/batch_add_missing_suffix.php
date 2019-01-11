<?php
/**************************************************
  Coppermine 1.6.x Plugin - Random File Name Suffix
  *************************************************
  Copyright (c) 2011-2019 eenemeenemuu
**************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

pageheader('Batch add missing suffix');

$result = cpg_db_query("
    SELECT pid, filepath, filename, RIGHT(SUBSTRING_INDEX(filename, '.', 1), 10) AS filename_right 
    FROM {$CONFIG['TABLE_PICTURES']} 
    WHERE filename NOT LIKE '%.quote%'
    HAVING filename_right NOT LIKE '\_\_%' 
    OR filename_right LIKE '\_\_%' AND filename_right LIKE '\__%\_%'
");

if (!cpg_db_num_rows($result)) {
    echo "nothing to rename";
    pagefooter();
    die();
} else {
    echo cpg_db_num_rows($result)." files to rename<br /><br />";
    flush();
}

$loop_count = 0;
while ($row = cpg_db_fetch_assoc($result)) {
    if ($loop_count++ == 100) {
        echo '<meta http-equiv="refresh" content="0; URL=index.php?file=random_file_name_suffix/batch_add_missing_suffix">';
        pagefooter();
        die();
    }

    $path_to_file = $CONFIG['fullpath'].$row['filepath'];

    $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $suffix = '_';
    for ($i = 0; $i < 8; $i++) {
        $suffix .= $characters[mt_rand(0, strlen($characters)-1)];
    }

    $picture_name_parts = explode(".", $row['filename']);
    $count = count($picture_name_parts);
    $picture_name_parts[$count] = $picture_name_parts[$count-1];
    $picture_name_parts[$count-1] = $suffix;
    $picture_name = implode(".", $picture_name_parts);

    $filename_new = str_replace("._", "__", $picture_name);

    // rename full-sized (required)
    if (!file_exists($path_to_file.$row['filename'])) {
        echo "Missing file: ".$path_to_file.$row['filename'];
        pagefooter();
        die();
    } elseif(is_image($row['filename']) && !file_exists($path_to_file.$CONFIG['thumb_pfx'].$row['filename'])) {
        echo "Missing thumb: ".$path_to_file.$CONFIG['thumb_pfx'].$row['filename'];
        pagefooter();
        die();
    } else {
        if (!rename($path_to_file.$row['filename'], $path_to_file.$filename_new)) {
            echo "Failed to rename file '".$path_to_file.$row['filename']."' to '".$path_to_file.$filename_new."'.";
            pagefooter();
            die();
        }
    }

    // rename intermediate-sized (optional)
    if (file_exists($path_to_file.$CONFIG['normal_pfx'].$row['filename'])) {
        if (!rename($path_to_file.$CONFIG['normal_pfx'].$row['filename'], $path_to_file.$CONFIG['normal_pfx'].$filename_new)) {
            echo "Failed to rename file '".$path_to_file.$CONFIG['normal_pfx'].$row['filename']."' to '".$path_to_file.$CONFIG['normal_pfx'].$filename_new."'.";
            pagefooter();
            die();
        }
    }

    // rename original (optional)
    if (file_exists($path_to_file.$CONFIG['orig_pfx'].$row['filename'])) {
        if (!rename($path_to_file.$CONFIG['orig_pfx'].$row['filename'], $path_to_file.$CONFIG['orig_pfx'].$filename_new)) {
            echo "Failed to rename file '".$path_to_file.$CONFIG['orig_pfx'].$row['filename']."' to '".$path_to_file.$CONFIG['orig_pfx'].$filename_new."'.";
            pagefooter();
            die();
        }
    }

    // rename thumb (required for images, optional for other file types)
    if (is_image($row['filename'])) {
        // already checked if file exists
        if (!rename($path_to_file.$CONFIG['thumb_pfx'].$row['filename'], $path_to_file.$CONFIG['thumb_pfx'].$filename_new)) {
            echo "Failed to rename thumb '".$path_to_file.$CONFIG['thumb_pfx'].$row['filename']."' to '".$path_to_file.$CONFIG['thumb_pfx'].$filename_new."'.";
            pagefooter();
            die();
        }
    } else {
        $extension = ltrim(substr($row['filename'], strrpos($row['filename'], '.')), '.');
        $filenameWithoutExtension = str_replace('.' . $extension, '', $row['filename']);
        $thumb_filename_new = str_replace('.', '_', $filenameWithoutExtension) . '_' . $suffix . '.jpg';
        if (file_exists($path_to_file.$CONFIG['thumb_pfx'].$filenameWithoutExtension.".jpg")) {
            if (!rename($path_to_file.$CONFIG['thumb_pfx'].$filenameWithoutExtension.".jpg", $path_to_file.$CONFIG['thumb_pfx'].$thumb_filename_new)) {
                echo "Failed to rename custom thumb '".$path_to_file.$CONFIG['thumb_pfx'].$filenameWithoutExtension.".jpg"."' to '".$path_to_file.$CONFIG['thumb_pfx'].$thumb_filename_new."'.";
                pagefooter();
                die();
            }
        }
    }

    cpg_db_query("UPDATE {$CONFIG['TABLE_PICTURES']} SET filename = '{$filename_new}' WHERE pid = {$row['pid']}");
    if (!cpg_db_affected_rows() || cpg_db_error()) {
        echo "Failed updating the database";
        pagefooter();
        die();
    }
}

echo '<meta http-equiv="refresh" content="0; URL=index.php?file=random_file_name_suffix/batch_add_missing_suffix">';
pagefooter();
die();

//EOF