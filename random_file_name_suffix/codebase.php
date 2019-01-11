<?php
/**************************************************
  Coppermine 1.6.x Plugin - Random File Name Suffix
  *************************************************
  Copyright (c) 2011-2019 eenemeenemuu
**************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$thisplugin->add_filter('upload_file_name', 'rfns_upload_file_name');

function rfns_upload_file_name($picture_name) {

    $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $suffix = '_';
    for ($i = 0; $i < 8; $i++) {
        $suffix .= $characters[mt_rand(0, strlen($characters)-1)];
    }

    $picture_name_parts = explode(".", $picture_name);
    $count = count($picture_name_parts);
    $picture_name_parts[$count] = $picture_name_parts[$count-1];
    $picture_name_parts[$count-1] = $suffix;
    $picture_name = implode(".", $picture_name_parts);

    return $picture_name;
}

//EOF