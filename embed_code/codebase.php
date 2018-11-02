<?php
/**************************************************
  Coppermine 1.5.x Plugin - embed_code
  *************************************************
  Copyright (c) 2011 eenemeenemuu
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  ********************************************
  $HeadURL$
  $Revision$
  $LastChangedBy$
  $Date$
  **************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

function plugin_embed_code_config_options() {
    return array (
        'plugin_embed_code_fullsized_view' => 'Open all links in fullsized view',
        'plugin_embed_code_bb_thumb' => 'BBCode (thumb)',
        'plugin_embed_code_bb_normal' => 'BBCode (normal)',
        'plugin_embed_code_bb_fullsize' => 'BBCode (fullsize)',
        'plugin_embed_code_html_thumb' => 'HTML (thumb)',
        'plugin_embed_code_html_normal' => 'HTML (normal)',
        'plugin_embed_code_html_fullsize' => 'HTML (fullsize)'
    );
}

$thisplugin->add_action('plugin_install', 'embed_code_install');
function embed_code_install() {
    global $CONFIG;
    foreach (plugin_embed_code_config_options() as $option => $text) {
        cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (name, value) VALUES ('{$option}', '0')");
    }
    return true;
}

$thisplugin->add_action('plugin_uninstall', 'embed_code_uninstall');
function embed_code_uninstall() {
    global $CONFIG;
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name LIKE 'plugin_embed_code_%'");
    return true;
}

$thisplugin->add_filter('file_info', 'embed_code_file_info');
function embed_code_file_info($info) {
    global $CONFIG, $CURRENT_PIC_DATA;

    // The weird comparision is because only picture_width is stored
    $resize_method = $CONFIG['picture_use'] == "thumb" ? ($CONFIG['thumb_use'] == "ex" ? "any" : $CONFIG['thumb_use']) : $CONFIG['picture_use'];
    if ($resize_method == 'ht' && $CURRENT_PIC_DATA['pheight'] > $CONFIG['picture_width']) {
        $use_intermediate = true;
    } elseif ($resize_method == 'wd' && $CURRENT_PIC_DATA['pwidth'] > $CONFIG['picture_width']) {
        $use_intermediate = true;
    } elseif ($resize_method == 'any' && max($CURRENT_PIC_DATA['pwidth'], $CURRENT_PIC_DATA['pheight']) > $CONFIG['picture_width']) {
        $use_intermediate = true;
    } else {
        $use_intermediate = false;
    }

    $file['thumb'] = $CONFIG['ecards_more_pic_target'].get_pic_url($CURRENT_PIC_DATA, 'thumb');
    $file['fullsize'] = $CONFIG['ecards_more_pic_target'].get_pic_url($CURRENT_PIC_DATA, 'fullsize');
    if ($use_intermediate) {
        $file['normal'] = $CONFIG['ecards_more_pic_target'].get_pic_url($CURRENT_PIC_DATA, 'normal');
        if (strpos($normal, 'images/thumbs/thumb_nopic.png')){
            $file['normal'] = $file['fullsize'];
        }
    } else {
        $file['normal'] = $file['fullsize'];
    }
    
    $url = $CONFIG['ecards_more_pic_target'].'displayimage.php?pid='.$CURRENT_PIC_DATA['pid'];
    if ($CONFIG['plugin_embed_code_fullsized_view'] == 1) {
        $url .= "&amp;fullsize=1";
    }

    foreach (plugin_embed_code_config_options() as $option => $text) {
        if ($CONFIG[$option] == 1 && $option != 'plugin_embed_code_fullsized_view') {
            $option_parts = explode("_", $option);
            $textarea = '<textarea onfocus="this.select();" onclick="this.select();" class="textinput" rows="1" cols="64" wrap="off" style="overflow:hidden; height:15px;">';
            if ($option_parts[3] == 'bb') {
                $textarea .= '[url='.$url.'][img]'.$file[$option_parts[4]].'[/img][/url]</textarea>';
            } elseif ($option_parts[3] == 'html') {
                $textarea .= '&lt;a href="'.$url.'"&gt;&lt;img src="'.$file[$option_parts[4]].'" /&gt;&lt;/a&gt;</textarea>';
            }
            $info[$text] = $textarea;
        }
    }

    return $info;
}

//EOF