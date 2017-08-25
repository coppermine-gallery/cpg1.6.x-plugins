<?php
/**************************************************
  Coppermine 1.6.x Plugin - file_replacer
  *************************************************
  Copyright (c) 2010-2017 Nibbler, eenemeenemuu
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  **************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$thisplugin->add_action('page_start', 'file_replacer_page_start');
$thisplugin->add_filter('file_data', 'file_replacer_id_data');


function file_replacer_page_start() {
    global $CONFIG, $lang_errors, $lang_plugin_file_replacer;
    $superCage = Inspekt::makeSuperCage();

    if ($superCage->get->keyExists('replacer_id')) {
        $pid = $superCage->get->getInt('replacer_id');
        $result = cpg_db_query("SELECT * FROM {$CONFIG['TABLE_PICTURES']} AS p INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS a ON a.aid = p.aid WHERE p.pid = '$pid' LIMIT 1");
        $row = cpg_db_fetch_assoc($result);

        if (!((USER_ADMIN_MODE && $row['category'] == FIRST_USER_CAT + USER_ID) || ($CONFIG['users_can_edit_pics'] && $row['owner_id'] == USER_ID && USER_ID != 0) || GALLERY_ADMIN_MODE)) {
            load_template();
            cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);
        }

        if ($superCage->files->keyExists('fileupload') && $row) {
            if (!checkFormToken()) {
                load_template();
                global $lang_errors;
                cpg_die(ERROR, $lang_errors['invalid_form_token'], __FILE__, __LINE__);
            }

            $fileupload = $superCage->files->_source['fileupload'];

            if ($fileupload['error']) {
                load_template();
                global $lang_errors;
                cpg_die(ERROR, $lang_errors['error'].' '.$fileupload['error'], __FILE__, __LINE__);
            }

            $image = $CONFIG['fullpath'] . $row['filepath'] . $row['filename'];
            $normal = $CONFIG['fullpath'] . $row['filepath'] . $CONFIG['normal_pfx'] . $row['filename'];
            $thumb = $CONFIG['fullpath'] . $row['filepath'] . $CONFIG['thumb_pfx'] . $row['filename'];
            $orig = $CONFIG['fullpath'] . $row['filepath'] . $CONFIG['orig_pfx'] . $row['filename'];
            $work_image = $image;

            if (!move_uploaded_file($fileupload['tmp_name'], $image)) {
                load_template();
                cpg_die(ERROR, sprintf($lang_plugin_file_replacer['error_move_file'], $fileupload['tmp_name'], $image), __FILE__, __LINE__);
            }
            chmod($image, octdec($CONFIG['default_file_mode']));

            if (is_known_filetype($image)) {

                if (is_image($image)) {

                    require('include/picmgmt.inc.php');

                    $imagesize = cpg_getimagesize($image);

                    if ($CONFIG['read_iptc_data']) {
                        // read IPTC data
                        $iptc = get_IPTC($image);
                        if ($superCage->post->keyExists('overwrite_metadata')) {
                            $title = (isset($iptc['Headline'])) ? $iptc['Headline'] : '';
                            $caption = (isset($iptc['Caption'])) ? $iptc['Caption'] : '';
                            $keywords = (isset($iptc['Keywords'])) ? implode($CONFIG['keyword_separator'], $iptc['Keywords']) : '';
                            $metadata_sql = ", title = '$title', caption = '$caption', keywords = '$keywords'";
                        }
                    }

                    // resize picture if it's bigger than the max width or height for uploaded pictures 
                    if (max($imagesize[0], $imagesize[1]) > $CONFIG['max_upl_width_height']) {
                        if ((USER_IS_ADMIN && $CONFIG['auto_resize'] == 1) || (!USER_IS_ADMIN && $CONFIG['auto_resize'] > 0)) {
                            resize_image($image, $image, $CONFIG['max_upl_width_height'], $CONFIG['thumb_method'], 'any', 'false'); // hard-coded 'any' according to configuration string 'Max width or height for uploaded pictures'
                            $imagesize = cpg_getimagesize($image);
                        } elseif (USER_IS_ADMIN) {
                            // skip resizing for admin
                            $picture_original_size = true;
                        } else {
                            @unlink($uploaded_pic);
                            $msg = sprintf($lang_db_input_php['err_fsize_too_large'], $CONFIG['max_upl_width_height'], $CONFIG['max_upl_width_height']);
                            return array('error' => $msg, 'halt_upload' => 1);
                        }
                    }

                    // create backup of full sized picture if watermark is enabled for full sized pictures
                    if (!file_exists($orig) && $CONFIG['enable_watermark'] == '1' && ($CONFIG['which_files_to_watermark'] == 'both' || $CONFIG['which_files_to_watermark'] == 'original'))  {
                        if (!copy($image, $orig)) {
                            return false;
                        } else {
                            $work_image = $orig;
                        }
                    }

                    //if (!file_exists($thumb)) {
                        // create thumbnail
                        if (($result = resize_image($work_image, $thumb, $CONFIG['thumb_width'], $CONFIG['thumb_method'], $CONFIG['thumb_use'], "false", 1)) !== true) {
                            return $result;
                        }
                    //}

                    if (max($imagesize[0], $imagesize[1]) > $CONFIG['picture_width'] && $CONFIG['make_intermediate'] /* && !file_exists($normal) */) {
                        // create intermediate sized picture
                        $resize_method = $CONFIG['picture_use'] == "thumb" ? ($CONFIG['thumb_use'] == "ex" ? "any" : $CONFIG['thumb_use']) : $CONFIG['picture_use'];
                        $watermark = ($CONFIG['enable_watermark'] == '1' && ($CONFIG['which_files_to_watermark'] == 'both' || $CONFIG['which_files_to_watermark'] == 'resized')) ? 'true' : 'false';
                        if (($result = resize_image($work_image, $normal, $CONFIG['picture_width'], $CONFIG['thumb_method'], $resize_method, $watermark)) !== true) {
                            return $result;
                        }
                    }

                    // watermark full sized picture
                    if ($CONFIG['enable_watermark'] == '1' && ($CONFIG['which_files_to_watermark'] == 'both' || $CONFIG['which_files_to_watermark'] == 'original')) {
                        $wm_max_upl_width_height = $picture_original_size ? max($imagesize[0], $imagesize[1]) : $CONFIG['max_upl_width_height']; // use max aspect of original image if it hasn't been resized earlier
                        if (($result = resize_image($work_image, $image, $wm_max_upl_width_height, $CONFIG['thumb_method'], 'any', 'true')) !== true) {
                            return $result;
                        }
                    }

                    list($width, $height) = getimagesize($image);

                } else {
                    $width = 0;
                    $height = 0;
                }

                $image_filesize = filesize($image);
                $total_filesize = is_image($row['filename']) ? ($image_filesize + (file_exists($normal) ? filesize($normal) : 0) + filesize($thumb)) : ($image_filesize);
    
                cpg_db_query("UPDATE {$CONFIG['TABLE_PICTURES']} SET filesize = '$image_filesize', total_filesize = '$total_filesize', pwidth = '$width', pheight = '$height' $metadata_sql WHERE pid = '$pid' LIMIT 1");

                if ($superCage->post->keyExists('update_timestamp')) {
                    cpg_db_query("UPDATE {$CONFIG['TABLE_PICTURES']} SET ctime = '".time()."' WHERE pid = '$pid' LIMIT 1");
                }

                cpg_db_query("DELETE FROM {$CONFIG['TABLE_EXIF']} WHERE pid = '$pid' LIMIT 1");

                if ($CONFIG['read_exif_data']) {
                    include("include/exif_php.inc.php");
                    exif_parse_file($image, $pid);
                }
    
                $CONFIG['site_url'] = rtrim($CONFIG['site_url'], '/');
            } else {
                if (is_image($image)) {
                    @unlink($normal);
                    @unlink($thumb);
                }
                @unlink($image);
            }
            header("Location: {$CONFIG['site_url']}/displayimage.php?pid=$pid");
            die();
            
            
        } else {
            load_template();
            pageheader($lang_plugin_file_replacer['file_replacer']);
            echo '<form method="post" enctype="multipart/form-data">';
            starttable('60%', $lang_plugin_file_replacer['upload_file'], 2);
            list($timestamp, $form_token) = getFormToken();
            echo <<< EOT
                <tr>
                    <td class="tableb" valign="top">
                        {$lang_plugin_file_replacer['browse']}
                    </td>
                    <td class="tableb" valign="top">
                        <input type="file" name="fileupload" size="40" class="listbox" />
                    </td>
                </tr>
                <tr>
                    <td class="tableb" valign="top">
                        {$lang_plugin_file_replacer['update_timestamp']}
                    </td>
                    <td class="tableb" valign="top">
                        <input type="checkbox" name="update_timestamp" />
                    </td>
                </tr>
                <tr>
                    <td class="tableb" valign="top">
                        {$lang_plugin_file_replacer['overwrite_metadata']}
                    </td>
                    <td class="tableb" valign="top">
                        <input type="checkbox" name="overwrite_metadata" />
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="2" class="tablef">
                        <input type="hidden" name="form_token" value="{$form_token}" />
                        <input type="hidden" name="timestamp" value="{$timestamp}" />
                        <input type="submit" name="commit" class="button" value="{$lang_plugin_file_replacer['upload']}"/>
                    </td>
                </tr>
EOT;
            endtable();
            echo '</form>';
            pagefooter();
            exit;
        }
    }
}


function file_replacer_id_data($data) {
    global $CONFIG, $CURRENT_ALBUM_DATA, $lang_plugin_file_replacer;

    if ((USER_ADMIN_MODE && $CURRENT_ALBUM_DATA['category'] == FIRST_USER_CAT + USER_ID) || ($CONFIG['users_can_edit_pics'] && $data['owner_id'] == USER_ID && USER_ID != 0) || GALLERY_ADMIN_MODE) {
        $file_replacer_menu_icon = ($CONFIG['enable_menu_icons'] > 0) ? '<img src="images/icons/alb_mgr.png" border="0" width="16" height="16" class="icon" /> ' : '';
        $menu_button = "<li><a href=\"displayimage.php?replacer_id={$data['pid']}\"><span>{$file_replacer_menu_icon}{$lang_plugin_file_replacer['replace_file']}</span></a></li>";
        $data['menu'] = str_replace('</ul>', $menu_button.'</ul>', $data['menu']);
    }
    return $data;
}

//EOF