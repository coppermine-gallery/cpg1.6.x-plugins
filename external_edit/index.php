<?php
/**************************************************
  Coppermine 1.5.x Plugin - external_edit
  *************************************************
  Copyright (c) 2010 Joachim Mller
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  ********************************************
  $HeadURL: https://coppermine.svn.sourceforge.net/svnroot/coppermine/branches/cpg1.5.x/plugins/external_edit/index.php $
  $Revision: 7977 $
  $LastChangedBy: gaugau $
  $Date: 2010-10-15 17:08:34 +0200 (Fr, 15 Okt 2010) $

  Prepared for CPG 1.6 by ron4mac, 2016-04-26
  **************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

require_once './plugins/external_edit/init.inc.php';
require_once './include/picmgmt.inc.php';
require_once './include/plgcompat.inc.php';

//pageheader($lang_plugin_external_edit['plugin_name'] . ': ' . $lang_plugin_external_edit['importing_remote_image']);

$error_counter = 0;
$output = '';

if ($superCage->get->keyExists('image') == TRUE && $superCage->get->keyExists('t') == TRUE) {
	$token = $superCage->get->getRaw('t');
	$remote_image = $superCage->get->getRaw('image');
	if (strpos($remote_image, 'http://fotos.fotoflexer.com') != 0){
		cpgRedirectPage('index.php', $lang_plugin_external_edit['error_referer'], sprintf($lang_plugin_external_edit['referer_check'], $lang_plugin_external_edit['failed']), 0, 'error');
	} else {
		$output .= '<li>' . $external_edit_icon_array['ok'] . sprintf($lang_plugin_external_edit['referer_check'], $lang_plugin_external_edit['success']) . '</li>';
	}
	// Perform the lookup against the token
    $query = "SELECT * FROM {$CONFIG['TABLE_PREFIX']}plugin_external_edit "
            . " WHERE token_id = '$token' LIMIT 1";
    $result = cpg_db_query($query);
    if (Plg_Db::num_rows($result) > 0) {
        $row     = Plg_Db::fetch_assoc($result, true);
        $pid = $row['pid'];
        $aid = $row['aid'];
		$output .= '<li>' . $external_edit_icon_array['ok'] . sprintf($lang_plugin_external_edit['token_check'], $lang_plugin_external_edit['success']) . '</li>';
    } else {
		cpgRedirectPage('index.php', $lang_plugin_external_edit['error_token'], sprintf($lang_plugin_external_edit['token_check'], $lang_plugin_external_edit['failed']), 0, 'error');
    }
    if (USER_ID != $row['user_id']) {
    	cpgRedirectPage('displayimage.php?album='.$aid.'&pid='.$pid, $lang_plugin_external_edit['error_user'], sprintf($lang_plugin_external_edit['user_auth'], $lang_plugin_external_edit['failed']), 0, 'error');
    } else {
		$output .= '<li>' .$external_edit_icon_array['ok'] . sprintf($lang_plugin_external_edit['user_auth'], $lang_plugin_external_edit['success']) . '</li>';
	}

    // delete the token once fetched
    $query = "DELETE FROM {$CONFIG['TABLE_PREFIX']}plugin_external_edit WHERE token_id = '$token'";
    cpg_db_query($query);
    $query = "SELECT filepath, filename, pwidth, pheight FROM {$CONFIG['TABLE_PICTURES']} WHERE pid = '$pid'";
    $result = cpg_db_query($query);
    if (Plg_Db::num_rows($result) != 1) {
    	cpgRedirectPage('displayimage.php?album='.$aid.'&pid='.$pid, $lang_plugin_external_edit['error_lookup'], sprintf($lang_plugin_external_edit['database_record'], $lang_plugin_external_edit['failed']), 0, 'error');
    } else {
		$output .= '<li>' . $external_edit_icon_array['ok'] . sprintf($lang_plugin_external_edit['database_record'], $lang_plugin_external_edit['success']) . '</li>';
	}
    $row = Plg_Db::fetch_assoc($result, true);

	$image   = $CONFIG['fullpath'] . $row['filepath'] . $row['filename'];
	$renamed = $CONFIG['fullpath'] . $row['filepath'] . 'renamed_'.$row['filename'];
	$normal  = $CONFIG['fullpath'] . $row['filepath'] . $CONFIG['normal_pfx'] . $row['filename'];
	$thumb   = $CONFIG['fullpath'] . $row['filepath'] . $CONFIG['thumb_pfx'] . $row['filename'];
	$orig    = $CONFIG['fullpath'] . $row['filepath'] . $CONFIG['orig_pfx'] . $row['filename'];
    rename($image, $renamed);
    if (file_exists($renamed) != TRUE) {
    	cpgRedirectPage('displayimage.php?album='.$aid.'&pid='.$pid, $lang_common['error'], sprintf($lang_plugin_external_edit['create_backup'], $lang_plugin_external_edit['failed']) . '<br />' . $lang_plugin_external_edit['check_permissions'], 0, 'warning');
	} else {
		$output .= '<li>' . $external_edit_icon_array['ok'] . sprintf($lang_plugin_external_edit['create_backup'], $lang_plugin_external_edit['success']) . '</li>';
	}
	copy($remote_image, $image);
	if (file_exists($image) != TRUE) {
		// Go back to the renamed copy
		rename($renamed, $image);
		cpgRedirectPage('displayimage.php?album='.$aid.'&pid='.$pid, $lang_common['error'], sprintf($lang_plugin_external_edit['copy_remote_file'], $lang_plugin_external_edit['failed']), 0, 'warning');
	} else {
		$output .= '<li>' . $external_edit_icon_array['ok'] . sprintf($lang_plugin_external_edit['copy_remote_file'], $lang_plugin_external_edit['success']) . '</li>';
	}
	// Set mode of uploaded picture
    @chmod($image, octdec($CONFIG['default_file_mode'])); //silence the output in case chmod is disabled
    $imginfo = cpg_getimagesize($image);
    if ($imginfo == null) {
    	@unlink($CONFIG['fullpath'] . $row['filepath'] . $row['filename']);
		// Go back to the renamed copy
		rename($CONFIG['fullpath'] . $row['filepath'] . 'renamed_'.$row['filename'], $CONFIG['fullpath'] . $row['filepath'] . $row['filename']);
		cpgRedirectPage('displayimage.php?album='.$aid.'&pid='.$pid, $lang_common['error'], $lang_plugin_external_edit['error_broken'], 0, 'warning');
    }
    // The new file appears to be OK, so let's delete the backup
    @unlink($CONFIG['fullpath'] . $row['filepath'] . 'renamed_'.$row['filename']);
	$output .= '<li>' . $external_edit_icon_array['ok'] . sprintf($lang_plugin_external_edit['file_integrity'], $lang_common['ok']) . '</li>';
    if ($row['pwidth'] != $imginfo[0] || $row['pheight'] != $imginfo[1]) {
    	// The dimensions have changed - let's write back those changes into the db
    	cpg_db_query("UPDATE {$CONFIG['TABLE_PICTURES']} SET pwidth = '{$imginfo[0]}', pheight = '{$imginfo[1]}' WHERE pid = $pid");
    }

	$work_image = $image;
	
	$imagesize = cpg_getimagesize($work_image);
	if (resize_image($work_image, $thumb, $CONFIG['thumb_width'], $CONFIG['thumb_method'], $CONFIG['thumb_use'], "false", 1)) {
		$output .= '<li>' . $external_edit_icon_array['ok'] . sprintf($lang_plugin_external_edit['thumbnail'], $lang_plugin_external_edit['created']) . '</li>';
	} else {
		$output .= '<li>' . $external_edit_icon_array['cancel'] . sprintf($lang_plugin_external_edit['thumbnail'], $lang_plugin_external_edit['failure']) . '</li>';
	}
	($CONFIG['enable_watermark'] == '1' && $CONFIG['which_files_to_watermark'] == 'both' || $CONFIG['which_files_to_watermark'] == 'resized') ? $watermark = "true" : $watermark = "false";
	if (max($imagesize[0], $imagesize[1]) > $CONFIG['picture_width'] && $CONFIG['make_intermediate']) {
		if (resize_image($work_image, $normal, $CONFIG['picture_width'], $CONFIG['thumb_method'], $CONFIG['thumb_use'], $watermark)) {
			$output .= '<li>' . $external_edit_icon_array['ok'] . sprintf($lang_plugin_external_edit['intermediate'], $lang_plugin_external_edit['created']) . '</li>';
		} else {
			$output .= '<li>' . $external_edit_icon_array['cancel'] . sprintf($lang_plugin_external_edit['intermediate'], $lang_plugin_external_edit['failure']) . '</li>';
		}
	} else {
		$output .= '<li>' . $external_edit_icon_array['ignore'] . sprintf($lang_plugin_external_edit['intermediate'], $lang_plugin_external_edit['skipped']) . '</li>';
	}
	($CONFIG['thumb_use'] == "ex") ? $resize_method = "any" : $resize_method = $CONFIG['thumb_use'];
	if (((USER_IS_ADMIN && $CONFIG['auto_resize'] == 1) || (!USER_IS_ADMIN && $CONFIG['auto_resize'] > 0)) && max($imagesize[0], $imagesize[1]) > $CONFIG['max_upl_width_height']) {
		$max_size_size = $CONFIG['max_upl_width_height'];
	} else {
		$resize_method = "orig";
		$max_size_size = max($imagesize[0], $imagesize[1]);
	}
	
	if ($orig_true == false) {
		if (copy($image, $orig)) {
			if ($CONFIG['enable_watermark'] == '1' && $CONFIG['which_files_to_watermark'] == 'both' || $CONFIG['which_files_to_watermark'] == 'original') {
				if (resize_image($work_image, $image, $max_size_size, $CONFIG['thumb_method'], $resize_method, 'true')) {
					$output .= '<li>' . $external_edit_icon_array['ok'] . sprintf($lang_plugin_external_edit['unwatermarked_original'], $lang_plugin_external_edit['created']) . '</li>';
				} else {
					$output .= '<li>' . $external_edit_icon_array['cancel'] . sprintf($lang_plugin_external_edit['unwatermarked_original'], $lang_plugin_external_edit['failure']) . '</li>';
				}
			}
		}
	} else {
		if ($CONFIG['enable_watermark'] == '1' && $CONFIG['which_files_to_watermark'] == 'both' || $CONFIG['which_files_to_watermark'] == 'original') {
			if (resize_image($work_image, $image, $max_size_size, $CONFIG['thumb_method'], $resize_method, 'true')) {
				$output .= '<li>' . $external_edit_icon_array['ok'] . sprintf($lang_plugin_external_edit['watermarked_fullsize'], $lang_plugin_external_edit['created']) . '</li>';
			} else {
				$output .= '<li>' . $external_edit_icon_array['cancel'] . sprintf($lang_plugin_external_edit['watermarked_fullsize'], $lang_plugin_external_edit['failure']) . '</li>';
			}
		} else {
			if (((USER_IS_ADMIN && $CONFIG['auto_resize'] == 1) || (!USER_IS_ADMIN && $CONFIG['auto_resize'] > 0)) && max($imagesize[0], $imagesize[1]) > $CONFIG['max_upl_width_height']) {
				if (resize_image($work_image, $image, $max_size_size, $CONFIG['thumb_method'], $resize_method, 'false')) {
					$output .= '<li>' . $external_edit_icon_array['ok'] . sprintf($lang_plugin_external_edit['intermediate'], $lang_plugin_external_edit['created']) . '</li>';
				} else {
					$output .= '<li>' . $external_edit_icon_array['cancel'] . sprintf($lang_plugin_external_edit['intermediate'], $lang_plugin_external_edit['failure']) . '</li>';
				}
			} elseif (copy($orig, $image)) {
				$output .= '<li>' . $external_edit_icon_array['ok'] . sprintf($lang_plugin_external_edit['original'], $lang_plugin_external_edit['created']) . '</li>';
			} else {
				$output .= '<li>' . $external_edit_icon_array['cancel'] . sprintf($lang_plugin_external_edit['original'], $lang_plugin_external_edit['failure']) . '</li>';
			}
		}
	}

	$output = <<<EOT
	<ul>
	{$output}
	</ul>
EOT;

	
	if ($CONFIG['log_mode']) {
	  log_write('External Edit Plugin:' . $image . '|', CPG_GLOBAL_LOG);
	}
	
	cpgRedirectPage('displayimage.php?album='.$aid.'&pid='.$pid, $lang_plugin_external_edit['importing_remote_image'], $output, $countdown = 0, $type = 'info');
}
