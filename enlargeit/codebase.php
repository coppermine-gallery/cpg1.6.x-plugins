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
  
if (!defined('IN_COPPERMINE')) {
    die('Not in Coppermine...');
}

// Add plugin_install action
$thisplugin->add_action('plugin_install','enlargeit_install');

// Add plugin_uninstall action
$thisplugin->add_action('plugin_uninstall','enlargeit_uninstall');

// Add page start action for change thumb template
$thisplugin->add_action('page_start','enl_thumb');

// Add filter for page head
$thisplugin->add_filter('page_meta','enlargeit_head');

// Add filter for thumb
$thisplugin->add_filter('theme_display_thumbnails_params','enlargeit_addparams');

if ('GALLERY_ADMIN_MODE' && $CONFIG['plugin_enlargeit_adminmenu'] == '1') {
    $thisplugin->add_filter('admin_menu','enlargeit_add_admin_button');
}

// Set some constants that are needed for i18n
if ($CONFIG['plugin_enlargeit_buttoninfo'] == '1') {
	if (!defined('DISPLAYIMAGE_PHP')) {
		define('DISPLAYIMAGE_PHP', true);
	}
}

function enlargeit_add_admin_button($admin_menu) {
    global $lang_plugin_enlargeit, $enlargeit_icon_array, $template_gallery_admin_menu, $CONFIG;
	require './plugins/enlargeit/init.inc.php';
//	var_dump(template_extract_block($template_gallery_admin_menu, 'admin_approval'));
    $new_button = '<div class="admin_menu admin_float"><a href="index.php?file=enlargeit/admin" title="' . $lang_plugin_enlargeit['description'] . '">'. $enlargeit_icon_array['table'] . $lang_plugin_enlargeit['enlargeit_configuration'] . '</a></div>';
    $look_for = '<!-- END plugin_manager -->';
    $admin_menu = str_replace($look_for, $look_for . $new_button, $admin_menu);
    return $admin_menu;
}

// add neccessary parameters
function enlargeit_addparams($params) {
    global $thumb, $CONFIG, $template_thumbnail_view, $CURRENT_PIC_DATA, $enlargeit_supported_image_file_array, $enlargeit_supported_video_file_array;

	// don't do anything if no pid
	if (empty($thumb['pid'])) return $params;

    // enabled for current user type?
    if (GALLERY_ADMIN_MODE && !$CONFIG['plugin_enlargeit_adminmode']) {
        return $params;
    }
    if (USER_ID && !$CONFIG['plugin_enlargeit_registeredmode']) {
        return $params;
    }
    if (!USER_ID && !$CONFIG['plugin_enlargeit_guestmode']) {
        return $params;
    }
    
    // Populate the list of files that this plugin should be used with in the first place
    $image_array = explode('/', $CONFIG['plugin_enlargeit_img_types']);
    $movie_array = explode('/', $CONFIG['plugin_enlargeit_mov_types']);    

    $enl_filetyplower = strtolower(ltrim(substr($thumb['filename'], strrpos($thumb['filename'], '.')), '.'));
    if (substr($thumb['filename'],0,8) == 'youtube_') {
      $enl_filetyplower = 'ytb';
    }
    
    // get file path depending if normal size pic exists and config setting enl_pictype
    if ($CONFIG['plugin_enlargeit_pictype'] == '1') {
        $enl_path = $CONFIG['fullpath'] . $thumb['filepath'] . $thumb['filename'];
    } elseif ($CONFIG['plugin_enlargeit_pictype'] == '2') {
        $enl_path = $CONFIG['fullpath'] . $thumb['filepath'] . $CONFIG['normal_pfx'] . $thumb['filename'];
    } elseif ($CONFIG['plugin_enlargeit_pictype'] == '0' && is_file($CONFIG['fullpath'] . $thumb['filepath'] . $CONFIG['normal_pfx'] . $thumb['filename'])) {
        $enl_path = $CONFIG['fullpath'] . $thumb['filepath'] . $CONFIG['normal_pfx'] . $thumb['filename'];
    } else {
        $enl_path = $CONFIG['fullpath'] . $thumb['filepath'] . $thumb['filename'];
    } 
    
    // CASE 1: images
    if (in_array($enl_filetyplower, $image_array) == TRUE) {
       $enl_newthumb  = '<img src="' . $CONFIG['fullpath'] . $thumb['filepath'] . $CONFIG['thumb_pfx'] . $thumb['filename'] . '" ';
       $enl_newthumb .= 'class="enlargeimg" ';
       if (($CONFIG['thumb_use'] == 'any' && $thumb['pwidth'] >= $thumb['pheight']) || $CONFIG['thumb_use'] == 'wd') {
       	 $enl_thumbheight = round($thumb['pheight'] / $thumb['pwidth'] * $CONFIG['thumb_width']);
       	 $enl_newthumb  .= 'width="' . $CONFIG['thumb_width'] . '" height="' . $enl_thumbheight . '" ';
       } elseif (($CONFIG['thumb_use'] == 'any' && $thumb['pwidth'] < $thumb['pheight']) || $CONFIG['thumb_use'] == 'ht') {
       	 $enl_thumbwidth = round($thumb['pwidth'] / $thumb['pheight'] * $CONFIG['thumb_width']);
       	 $enl_newthumb  .= 'width="' . $enl_thumbwidth . '" height="' . $CONFIG['thumb_width'] . '" ';
       }
       $enl_newthumb .= 'border="0" onclick="enlarge(this);" longdesc="' . path2url($enl_path) . '" name="' . $thumb['pid'] . '" ';
       $enl_newthumb .= 'alt="' . $thumb['title'] . '" />';
       $more_params = array(
        '{LINK_ONCLICK}'  => 'onclick="return false;"',
        '{THUMB}'  => $enl_newthumb,
       );
    }
    
    // CASE 2: flash or movie
    elseif (in_array($enl_filetyplower, $movie_array) == TRUE) {
      $pid = $thumb['pid'];
      
      // For flash or movie files we need some more data from the database
      $result = cpg_db_query("SELECT aid from {$CONFIG['TABLE_PICTURES']} WHERE pid='$pid' LIMIT 1");
      $row = cpg_db_fetch_array($result, true);
      $album = $row['aid'];
      $pic_data = get_pic_data($album, $pic_count, $album_name, -1, -1, false);
      for($pos = 0; $pic_data[$pos]['pid'] != $pid && $pos < $pic_count; $pos++) {
          $pic_data = get_pic_data($album, $pic_count, $album_name, $pos, 1, false);
      }
      $CURRENT_PIC_DATA = $pic_data[0];
      if ($CURRENT_PIC_DATA['pwidth'] == 0) {
          $CURRENT_PIC_DATA['pwidth'] = 500;
      }
      if ($CURRENT_PIC_DATA['pheight'] == 0) {
          $CURRENT_PIC_DATA['pheight'] = 410;
      }
      
      if ($enl_filetyplower == 'swf') {
      	$enl_newthumb  = '<img src="images/thumbs/thumb_swf.png" class="enlargeimg" width="'.$thumb['pwidth'].'" height="'.$thumb['pheight'].'" ';
      } else {
      	$enl_newthumb  = '<img src="images/thumbs/thumb_movie.png" class="enlargeimg" width="'.$thumb['pwidth'].'" height="'.$thumb['pheight'].'" ';
      }
      $enl_newthumb .= 'border="0" onclick="enlarge(this);" ';
      if ($enl_filetyplower == 'swf') {
      	$enl_newthumb .= 'longdesc="swf::'.path2url($enl_path).'::'.$CURRENT_PIC_DATA['pwidth'].'::'.$CURRENT_PIC_DATA['pheight'].'" ';
      } elseif ($enl_filetyplower == 'flv') {
      	if ($CONFIG['plugin_enlargeit_flvplayer'] == '0') {
      	    $enl_newthumb .= 'longdesc="fl2::../../../../'.path2url($enl_path).'::'.$CURRENT_PIC_DATA['pwidth'].'::'.$CURRENT_PIC_DATA['pheight'].'" ';
      	} else {
      	    $enl_newthumb .= 'longdesc="flv::../../../../'.path2url($enl_path).'::'.$CURRENT_PIC_DATA['pwidth'].'::'.$CURRENT_PIC_DATA['pheight'].'" ';
      	}
      } elseif ($enl_filetyplower == 'dvx') {
      	$enl_newthumb .= 'longdesc="dvx::'.path2url($enl_path).'::'.$CURRENT_PIC_DATA['pwidth'].'::'.$CURRENT_PIC_DATA['pheight'].'" ';
      }
      $enl_newthumb .= 'name="'.$thumb['pid'].'" alt="" title="'.$thumb['title'].'" />';
      $more_params = array(
       '{LINK_ONCLICK}'  => 'onclick="return false;"',
       '{THUMB}'  => $enl_newthumb,
      );
    }

    // CASE 3: format not supported by enlargeit
    else 
    {
      $more_params = array(
        '{LINK_ONCLICK}'  => '',
      );
    }

    return array_merge($params,$more_params);

}


// include some stuff in page header
function enlargeit_head($meta) {        
	global $template_header, $lang_plugin_enlargeit, $CONFIG, $CPG_PHP_SELF, $LINEBREAK, $JS, $THEME_DIR;
	require './plugins/enlargeit/init.inc.php';
	$enlargeit_pages_array = array('displayimage.php', 'index.php', 'thumbnails.php');
	if (in_array($CPG_PHP_SELF, $enlargeit_pages_array) == TRUE) {
	    if ($CONFIG['plugin_enlargeit_brdbck'] != '' && $CONFIG['plugin_enlargeit_brdbck'] != '0') {
	        $temp_brdbck = 'backgrounds/' . $CONFIG['plugin_enlargeit_brdbck'] . '.png';
	    } else {
	        $temp_brdbck = '';
	    }
	    if ($CONFIG['plugin_enlargeit_brdsize'] > 0) {
	        $temp_border = 1;
	    } else {
	        $temp_border = 0;
	    }
	    if ($CONFIG['plugin_enlargeit_shadowsize'] > 0) {
	        $temp_shadow = 1;
	    } else {
	        $temp_shadow = 0;
	    }
	    if (defined('THEME_HAS_PROGRESS_GRAPHICS')) {
	        $temp_loader = $THEME_DIR . 'images/loader.gif';
	    } else {
	        $temp_loader = 'images/loader.gif';
	    }
		$meta  .= <<< EOT
    <script type="text/javascript" src="plugins/enlargeit/js/enlargeit.js"></script>
    <link rel="stylesheet" href="plugins/enlargeit/style.css" type="text/css" />
    <script type="text/javascript">
        //<!--
        var enl_brd = {$temp_border};
        var enl_ani = {$CONFIG['plugin_enlargeit_ani']};
        var enl_opaglide = {$CONFIG['plugin_enlargeit_opaglide']};
        var enl_titlebar = {$CONFIG['plugin_enlargeit_titlebar']};
        var enl_brdsize = {$CONFIG['plugin_enlargeit_brdsize']};
        var enl_brdcolor = '{$CONFIG['plugin_enlargeit_brdcolor']}';
        var enl_titletxtcol = '{$CONFIG['plugin_enlargeit_titletxtcol']}';
        var enl_ajaxcolor = '{$CONFIG['plugin_enlargeit_ajaxcolor']}';
        var enl_brdround = {$CONFIG['plugin_enlargeit_brdround']};
        var enl_maxstep = {$CONFIG['plugin_enlargeit_maxstep']};
        var enl_shadow = {$temp_shadow};
        var enl_shadowsize = {$CONFIG['plugin_enlargeit_shadowsize']};
        var enl_shadowintens = {$CONFIG['plugin_enlargeit_shadowintens']};
		var enl_shadowcolor = '{$CONFIG['plugin_enlargeit_shadowcolor']}';
        var enl_gifpath = 'plugins/enlargeit/images/';
        var enl_swfpath = 'plugins/enlargeit/images/flash/';
        var enl_histogramurl = 'index.php?file=enlargeit/histogram&amp;action=file&amp;pid=';
		var enl_bbcodeurl = 'index.php?file=enlargeit/bbcode.php?pos=-';
        var enl_loaderpathfile = '{$temp_loader}';
        var enl_usecounter = 1;
        var enl_counterurl = 'index.php?file=enlargeit/counter&a=';
        var enl_btnact = 'icons/bact_transp.png';
        var enl_btninact = 'icons/binact_transp.png';
        var enl_minuscur = 'cursors/minuscur.cur';
        var enl_pluscur = 'cursors/pluscur.cur';
        var enl_speed = {$CONFIG['plugin_enlargeit_speed']};
        var enl_dark = {$CONFIG['plugin_enlargeit_dark']};
        var enl_darkprct = {$CONFIG['plugin_enlargeit_darkprct']};
        var enl_center = {$CONFIG['plugin_enlargeit_center']};
        var enl_wheelnav = {$CONFIG['plugin_enlargeit_wheelnav']};
        var enl_drgdrop = {$CONFIG['plugin_enlargeit_dragdrop']};
        var enl_brdbck = '{$temp_brdbck}';
        var enl_darksteps = {$CONFIG['plugin_enlargeit_darkensteps']};
        var enl_canceltext = '{$lang_plugin_enlargeit['cancel_loading']}';
        var enl_noflash = '{$lang_plugin_enlargeit['no_flash_found']}';

EOT;
		$loopCounter = 0;
		// Button "Show picture"
		if ($CONFIG['plugin_enlargeit_buttonpic'] == '1') {
		    $meta  .= <<< EOT
        enl_buttonurl[{$loopCounter}] = 'pic';
        enl_buttontxt[{$loopCounter}] = '{$lang_plugin_enlargeit['show_picture']}';
        enl_buttonoff[{$loopCounter}] = 0;

EOT;
            $loopCounter++;
        }
        // Button "Pic Info"
        if ($CONFIG['plugin_enlargeit_buttoninfo'] == '1') {
		    $meta  .= <<< EOT
        enl_buttonurl[{$loopCounter}] = 'index.php?file=enlargeit/info&pid=';
        enl_buttontxt[{$loopCounter}] = '{$lang_plugin_enlargeit['show_info']}';
        enl_buttonoff[{$loopCounter}] = -16;

EOT;
            $loopCounter++;
        } elseif ($CONFIG['plugin_enlargeit_buttoninfo'] == '2') {
		    $meta  .= <<< EOT
        enl_buttonurl[{$loopCounter}] = 'site:displayimage.php?pid=';
        enl_buttontxt[{$loopCounter}] = '{$lang_plugin_enlargeit['show_info']}';
        enl_buttonoff[{$loopCounter}] = -16;

EOT;
            $loopCounter++;
        }
        // Button "Favorites"
        if ($CONFIG['plugin_enlargeit_buttonfav'] == '1') {
		    $meta  .= <<< EOT
        enl_buttonurl[{$loopCounter}] = 'index.php?file=enlargeit/addfav&pid=';
        enl_buttontxt[{$loopCounter}] = '{$lang_plugin_enlargeit['favorites']}';
        enl_buttonoff[{$loopCounter}] = -32;

EOT;
            $loopCounter++;
        }
        // Button "Download"
        if ($CONFIG['plugin_enlargeit_buttondownload'] == '1' || ($CONFIG['plugin_enlargeit_buttondownload'] == 2 && USER_ID)) {
		    $meta  .= <<< EOT
        enl_buttonurl[{$loopCounter}] = 'index.php?file=enlargeit/download&pid=';
        enl_buttontxt[{$loopCounter}] = '{$lang_plugin_enlargeit['download_this_file']}';
        enl_buttonoff[{$loopCounter}] = -208;

EOT;
            $loopCounter++;
        }
        // Button "BBcode"
        if ($CONFIG['plugin_enlargeit_buttonbbcode'] == '1') {
		    $meta  .= <<< EOT
        enl_buttonurl[{$loopCounter}] = 'index.php?file=enlargeit/bbcode&pos=-';
        enl_buttontxt[{$loopCounter}] = '{$lang_plugin_enlargeit['bbcode']}';
        enl_buttonoff[{$loopCounter}] = -192;

EOT;
            $loopCounter++;
        }
        // Button "Histogram"
        if ($CONFIG['plugin_enlargeit_buttonhist'] == '1' && (version_compare($enlargeit_gd_version, '2', '>') || $CONFIG['thumb_method'] != 'gd2')) { // Only allow the histogramm feature if GD2 is available
		    $meta  .= <<< EOT
        enl_buttonurl[{$loopCounter}] = 'index.php?file=enlargeit/histogram&action=file&pid=';
        enl_buttontxt[{$loopCounter}] = '{$lang_plugin_enlargeit['histogram']}';
        enl_buttonoff[{$loopCounter}] = -160;

EOT;
            $loopCounter++;
        }
        // Button "Expand"
        if ($CONFIG['plugin_enlargeit_maximizemethod'] == '1') {
		    if ((USER_ID && isset($USER_DATA['access_level']) == TRUE && $USER_DATA['access_level'] == '3') || (!USER_ID && $CONFIG['allow_unlogged_access'] == '3')) {
				$meta  .= <<< EOT
        enl_buttonurl[{$loopCounter}] = 'max';
        enl_buttontxt[{$loopCounter}] = '{$lang_plugin_enlargeit['full_size']}';
        enl_buttonoff[{$loopCounter}] = -144;
EOT;
				$loopCounter++;
			}
        } elseif ($CONFIG['plugin_enlargeit_maximizemethod'] == '0') {
		    if ((USER_ID && $USER_DATA['access_level'] == '3') || (!USER_ID && $CONFIG['allow_unlogged_access'] == '3')) {
				$meta  .= <<< EOT
        enl_buttonurl[{$loopCounter}] = 'maxpop';
        enl_buttontxt[{$loopCounter}] = '{$lang_plugin_enlargeit['full_size']}';
        enl_buttonoff[{$loopCounter}] = -144;
EOT;
				$loopCounter++;
			}
        }
        // Buttons "Previous" + "Next" (Navigation)
        if ($CONFIG['plugin_enlargeit_buttonnav'] == '1') {
		    $meta  .= <<< EOT
        enl_buttonurl[{$loopCounter}] = 'prev';
        enl_buttontxt[{$loopCounter}] = '{$lang_plugin_enlargeit['previous_left']}';
        enl_buttonoff[{$loopCounter}] = -96;

EOT;
            $loopCounter++;
		    $meta  .= <<< EOT
        enl_buttonurl[{$loopCounter}] = 'next';
        enl_buttontxt[{$loopCounter}] = '{$lang_plugin_enlargeit['next_right']}';
        enl_buttonoff[{$loopCounter}] = -80;

EOT;
            $loopCounter++;
        }
        // Button "Close"
        if ($CONFIG['plugin_enlargeit_buttonclose'] == '1') {
		    $meta  .= <<< EOT
        enl_buttonurl[{$loopCounter}] = 'close';
        enl_buttontxt[{$loopCounter}] = '{$lang_plugin_enlargeit['close_esc']}';
        enl_buttonoff[{$loopCounter}] = -128;

EOT;
            $loopCounter++;
        }
		$meta  .= <<< EOT
	    //-->
	</script>

EOT;
	}
	return $meta;
}


// Change thumbnail template
function enl_thumb() 
{
	global $CONFIG, $template_thumbnail_view, $lang_plugin_enlargeit;
	// get language
	require_once './plugins/enlargeit/init.inc.php';
	// change thumb template if enlargeit is active for current user
	if ((GALLERY_ADMIN_MODE && !$CONFIG['plugin_enlargeit_adminmode']) || (USER_ID && !$CONFIG['plugin_enlargeit_registeredmode']) || (!USER_ID && !$CONFIG['plugin_enlargeit_guestmode'])) {
		// do nothing
	} else {
		$template_thumbnail_view = <<<EOT

<!-- BEGIN header -->
        <tr>
<!-- END header -->
<!-- BEGIN thumb_cell -->
        <td valign="top" class="thumbnails" width ="{CELL_WIDTH}" align="center">
                <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                                <td align="center">
                                        <a {LINK_ONCLICK} href="{LINK_TGT}">{THUMB}<br /></a>
                                        {CAPTION}
                                        {ADMIN_MENU}
                                </td>
                        </tr>
                </table>
        </td>
<!-- END thumb_cell -->
<!-- BEGIN empty_cell -->
                <td valign="top" class="thumbnails" align="center">&nbsp;</td>
<!-- END empty_cell -->
<!-- BEGIN row_separator -->
        </tr>
        <tr>
<!-- END row_separator -->
<!-- BEGIN footer -->
        </tr>
<!-- END footer -->
<!-- BEGIN tabs -->
        <tr>
                <td colspan="{THUMB_COLS}" style="padding: 0px;">
                        <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                       {TABS}
                                </tr>
                        </table>
                </td>
        </tr>
<!-- END tabs -->
<!-- BEGIN spacer -->
        <img src="images/spacer.gif" width="1" height="7" border="" alt="" /><br />
<!-- END spacer -->

EOT;

  }
}


// install
function enlargeit_install() {
    global $CONFIG;
    // register file types FLV and DivX
    cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_FILETYPES']} (`extension`,`mime`,`content`,`player`) VALUES ('divx','video/divx','movie','')");
    cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_FILETYPES']} (`extension`,`mime`,`content`,`player`) VALUES ('flv','application/x-shockwave-flash','movie','Flash Player')");
	// Add the config options for the plugin
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_brdsize', '22')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_brdround', '1')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_brdcolor', '#FFFFFF')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_shadow', '1')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_shadowsize', '1')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_shadowintens', '20')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_shadowcolor', '#000000')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_ani', '5')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_maxstep', '18')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_speed', '12')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_titlebar', '1')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_titletxtcol', '#445544')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_ajaxcolor', '#666677')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_center', '1')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_dark', '1')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_darkprct', '20')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_buttonpic', '0')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_buttoninfo', '0')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_buttonfav', '0')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_buttoncomment', '0')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_buttondownload', '0')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_buttonbbcode', '0')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_buttonhist', '0')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_buttonvote', '0')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_buttonclose', '1')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_buttonnav', '1')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_adminmode', '1')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_registeredmode', '1')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_guestmode', '1')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_sefmode', '0')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_pictype', '0')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_dragdrop', '0')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_wheelnav', '1')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_flvplayer', '1')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_opaglide', '0')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_brdbck', '0')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_darkensteps', '20')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_adminmenu', '1')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_cachecontrol', '0')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_cachemaxage', '30')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_cachemaxsizemb', '10')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_maximizemethod', '1')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_img_types', 'jpg/jpeg/png/gif/bmp')");
	cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_enlargeit_mov_types', '')");
	cpg_db_query("ALTER TABLE {$CONFIG['TABLE_PICTURES']} ADD histogram_filesize int(11) NOT NULL default '0'");
	cpg_db_query("ALTER TABLE {$CONFIG['TABLE_PICTURES']} ADD histogram_timestamp int(11) NOT NULL default '0'");
    return true;
}


// uninstall and drop settings table
function enlargeit_uninstall() {
    global $CONFIG;
	$superCage = Inspekt::makeSuperCage();
    if (!checkFormToken()) {
        global $lang_errors;
        cpg_die(ERROR, $lang_errors['invalid_form_token'], __FILE__, __LINE__);
    }
	// Delete the histogram cache
	$result = cpg_db_query("SELECT filepath, filename FROM {$CONFIG['TABLE_PICTURES']} WHERE histogram_filesize<>'0'");
	if (cpg_db_num_rows($result)) {
		while ( ($data = cpg_db_fetch_assoc($result)) ) {
			$delete = cpg_folder_file_delete($CONFIG['fullpath'] . $data['filepath'] . 'histogram_' . str_replace('.' . ltrim(substr($data['filename'], strrpos($data['filename'], '.')), '.'), '', $data['filename']) . '.png');
			print $CONFIG['fullpath'] . $data['filepath'] . 'histogram_' . str_replace('.' . ltrim(substr($data['filename'], strrpos($data['filename'], '.')), '.'), '', $data['filename']) . '.png<br />';
		}
	}
	cpg_db_free_result($result);

    // Delete the plugin config records
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_brdsize'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_brdround'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_brdcolor'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_shadow'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_shadowsize'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_shadowintens'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_shadowcolor'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_ani'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_maxstep'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_speed'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_titlebar'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_titletxtcol'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_ajaxcolor'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_center'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_dark'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_darkprct'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_buttonpic'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_buttoninfo'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_buttonfav'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_buttoncomment'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_buttondownload'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_buttonbbcode'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_buttonhist'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_buttonvote'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_buttonclose'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_buttonnav'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_adminmode'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_registeredmode'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_guestmode'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_sefmode'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_pictype'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_dragdrop'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_wheelnav'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_flvplayer'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_opaglide'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_brdbck'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_darkensteps'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_adminmenu'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_cachecontrol'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_cachemaxage'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_cachemaxsizemb'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_maximizemethod'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_img_types'");
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_enlargeit_mov_types'");
	cpg_db_query("ALTER TABLE `{$CONFIG['TABLE_PICTURES']}` DROP `histogram_filesize`");
	cpg_db_query("ALTER TABLE `{$CONFIG['TABLE_PICTURES']}` DROP `histogram_timestamp`");
    return true;
}
