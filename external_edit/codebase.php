<?php
/**************************************************
  Coppermine 1.5.x Plugin - external_edit
  *************************************************
  Copyright (c) 2010 Joachim Müller
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  ********************************************
  $HeadURL: https://coppermine.svn.sourceforge.net/svnroot/coppermine/branches/cpg1.5.x/plugins/external_edit/codebase.php $
  $Revision: 7977 $
  $LastChangedBy: gaugau $
  $Date: 2010-10-15 17:08:34 +0200 (Fr, 15 Okt 2010) $

  Prepared for CPG 1.6 by ron4mac, 2016-04-26
  **************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

require_once "./plugins/external_edit/init.inc.php";

$thisplugin->add_action('page_start','external_edit_init');
$thisplugin->add_action('plugin_install','external_edit_install');
$thisplugin->add_action('plugin_uninstall','external_edit_uninstall');
$thisplugin->add_filter('file_data','external_edit_menu_file');

function external_edit_install() {
    global $CONFIG, $thisplugin;
    require 'include/sql_parse.php';
    // Perform the database changes
    $db_schema = $thisplugin->fullpath . '/schema.sql';
    $sql_query = fread(fopen($db_schema, 'r'), filesize($db_schema));
    $sql_query = preg_replace('/CPG_/', $CONFIG['TABLE_PREFIX'], $sql_query);
    $sql_query = remove_remarks($sql_query);
    $sql_query = split_sql_file($sql_query, ';');	//echo'<xmp>';var_dump($sql_query);exit();
    foreach($sql_query as $q) {
        cpg_db_query(trim($q));
    }	
    return true;
}

function external_edit_uninstall() {
    global $CONFIG;
    cpg_db_query("DROP TABLE IF EXISTS {$CONFIG['TABLE_PREFIX']}plugin_external_edit");
    return true;
}

function external_edit_menu_file($data)
{
    global $CONFIG, $CURRENT_ALBUM_DATA, $USER_DATA, $CPG_PHP_SELF, $lang_plugin_external_edit, $external_edit_icon_array;
    $valid_extension_array = array('jpg', 'jpeg', 'png');
    $locale_array = array('english' => 'en-US', 'danish' => 'da-DK', 'german' => 'de-DE', 'spanish' => 'es-ES', 'argentinian' => 'es-LA', 'finnish' => 'fi-FI', 'french' => 'fr-FR', 'italian' => 'it-IT', 'japanese' => 'ja-JP', 'korean' => 'ko-KR', 'norwegian' => 'nb-NO', 'belgian' => 'nl-BE', 'dutch' => 'nl-NL', 'polish' => 'pl-PL', 'brazilian_portuguese' => 'pt-BR', 'portuguese' => 'pt-PT', 'russian' => 'ru-RU', 'swedish' => 'sv-SE', 'turkish' => 'tu-TR', 'vietnamese' => 'vi-VN', 'chinese_big5' => 'zh-CN', 'chinese_gb' => 'zh-TW');
    
    $current_page = cpgGetScriptNameParams(array('message_id', 'message_icon'));
    //print_r($foo);
    if ((USER_ADMIN_MODE && $CURRENT_ALBUM_DATA['category'] == FIRST_USER_CAT + USER_ID) || ($CONFIG['users_can_edit_pics'] && $data['owner_id'] == USER_ID && USER_ID != 0) || GALLERY_ADMIN_MODE) {
        // Determine the file type
        if (!in_array(strtolower($data['extension']), $valid_extension_array) == TRUE) {
            // We don't have a bitmap - let's leave
            return $data;
        }
        // Create the database record
        $token = external_edit_create_token($data);
        if (array_key_exists($CONFIG['lang'], $locale_array) == TRUE) {
            $locale = $locale_array[$CONFIG['lang']];
        } else {
            $locale = 'en-US';
        }
        $menu_button = ' <a href="';
        $menu_button .= 'http://fotoflexer.com/API/API_Loader_v1_01.php';
        $menu_button .= '?ff_image_url=' . urlencode($CONFIG['site_url'].$CONFIG['fullpath'].$data['filepath'].$data['filename']);
        //$menu_button .= '?ff_image_url=' . urlencode('http://osterburken.net/galerie/albums/konzert/05/just_rock/gg02.jpg'); // Comment out the line above and uncomment this line for testing purposes
        $menu_button .= '&amp;ff_callback_url=' . urlencode($CONFIG['site_url'] . 'index.php?file=external_edit/index') . '%26t=' . $token;
        $menu_button .= '&amp;ff_cancel_url=' . urlencode($CONFIG['site_url'] . 'displayimage.php?pid=' . $data['pid']);
        $menu_button .= '&amp;ff_lang=' . $locale;
        $menu_button .= '"  class="admin_menu greyboxfull" title="'.$lang_plugin_external_edit['edit_file_explain'].'">';
        $menu_button .= $external_edit_icon_array['fotoflexer'];
        $menu_button .= $lang_plugin_external_edit['edit_file'];
        $menu_button .= '</a>';
        $data['menu'] = str_replace('</ul>', $menu_button.'</ul>', $data['menu']);
    }
    return $data;
}

function external_edit_create_token($data) {
    global $CONFIG;
    // Clean up the temporary tokens table (garbage collection)
    $seconds = 86400; // Token remains active for one day (60 seconds x 60 minutes x 24 hours)
    $time = time() - (int) $seconds;
    // delete the records older than the specified amount
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_PREFIX']}plugin_external_edit WHERE time < $time");
    
    // come up with a unique message id
    $token_id = md5(uniqid(mt_rand(), true));

    // write the message to the database
    $user_id = USER_ID;
    $time    = time();
    $pid     = $data['pid'];
    $aid     = $data['aid'];

    // Insert the record in database
    $query = "INSERT INTO {$CONFIG['TABLE_PREFIX']}plugin_external_edit "
                ." SET "
                    ." token_id = '$token_id', "
                    ." user_id = '$user_id', "
                    ." pid = '$pid', "
                    ." aid = '$aid', "
                    ." time   = '$time' ";
    cpg_db_query($query);
    // return the token_id
    return $token_id;
}
