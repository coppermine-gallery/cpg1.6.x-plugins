<?php
/**************************************************
  Coppermine 1.6.x Plugin - xfeed
  *************************************************
  Copyright (c) 2008 lee (www.mininoteuser.com)
  Plugin for CPG 1.4 created by Lee
  Ported to CPG 1.5.x by Aditya Mooley <adityamooley@sanisoft.com>
  Ported to CPG 1.6.x by ron4mac
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  **************************************************/

if (!defined('IN_COPPERMINE')) {
    die('Not in Coppermine...');
}


// RSS Button in template
$thisplugin->add_filter('template_html','xfd_rss_button_template');

// RSS Button in gallery header
$thisplugin->add_filter('gallery_header','xfd_rss_button_gallery');


// Add page start action for admin button.
$thisplugin->add_filter('admin_menu','xfd_add_config_button');

// Add filter for page head
$thisplugin->add_filter('page_meta','xfd_head');

// Add plugin_install action
$thisplugin->add_action('plugin_install','xfd_install');

// Add plugin_uninstall action
$thisplugin->add_action('plugin_uninstall','xfd_uninstall');

// get settings
global $XFDSET,$lang_xfeeds;

require './plugins/xfeed/include/init.inc.php';
require './plugins/xfeed/include/load_xfdset.php';

function xfd_rss_button_template($template) {
  global $XFDSET;

    $gallery_pos = strpos($template, '{XFD_BUTTON}');
    if ($gallery_pos) {
      if ($XFDSET['xfd_rss_button_position'] != '1' || !$XFDSET['xfd_rss_button']) {
               $template    = str_replace('{XFD_BUTTON}', '', $template); // Remove the token from the output if the corresponding plugin config option hasn't been enabled
          } else {
               $template    = str_replace('{XFD_BUTTON}', xfd_rss_button(''), $template);
          }
    } else { // There's no placeholder token {XFD_BUTTON} inside $template
          if ($XFDSET['xfd_rss_button_position'] != '1') {
              return $template;
          } else {
            // fallback if no placeholder token {XFD_BUTTON}
              $template = str_replace('{GALLERY}', xfd_rss_button('') . '{GALLERY}', $template);
          }
    }
      return $template;
}

// rss button
function xfd_rss_button_gallery($template_header) {
    global $XFDSET;
    if (!$XFDSET['xfd_rss_button'] || !$XFDSET['xfd_rss_button_position'] == '0') {
        return $template_header;
    }
    return $template_header.xfd_rss_button();
}
// rss button
function xfd_rss_button() {
    global $XFDSET,$lang_xfeeds,$CONFIG, $album;

    $superCage = Inspekt::makeSuperCage();

    //require './plugins/xfeed/include/init.inc.php';

    if (!$XFDSET['xfd_rss_button']) {
        return '';	//$template_header;
    }

    $xfd_feed = "index.php?file=xfeed/xfeed";

    if ($superCage->get->keyExists('album')) {
        $album = $superCage->get->getRaw('album');
        $xfd_feed .= "&album=$album";
    }

    if ($superCage->get->keyExists('cat')) {
        $cat = $superCage->get->getRaw('cat');
        $cat = (int)$cat;
        $xfd_feed .= "&cat=$cat";
    }

    if ($XFDSET['xfd_feedroute'] == 1) {
        $xfeed_loc = "feeds.feedburner.com/".$XFDSET['xfd_feedburnuname'];
    } else {
        $xfeed_loc = "".str_replace("http://","",$CONFIG['ecards_more_pic_target']).$xfd_feed;
    }

    //static
    $xfeed_title_enc = urlencode($CONFIG['gallery_name']);
    $xfeed_author = "Admin"; // maybe get the first username in the future (gallery creator).

    $html = "
    <!-- BEGIN XFeeds Plugin -->
    <span class=\"xfeeds\">
    <form>
        <select onchange=\"if (this.selectedIndex > 0) location.href=this[this.selectedIndex].value;\">
        <option selected=\"selected\" value=\"\">".$lang_xfeeds['xfd_fe_opts']."</option>
    ";

    if ($XFDSET['xfd_standard'] == 1) {
        $html .= " <optgroup label=\"".$lang_xfeeds['xfd_fe_atom']."\">
        <option value=\"".$CONFIG['ecards_more_pic_target'].$xfd_feed."&amp;type=atom\">".$lang_xfeeds['xfd_fe_local_atom']."</option>
        </optgroup>
        ";
    }

    if ($XFDSET['xfd_standard'] == 1 || $XFDSET['xfd_google'] == 1 ||
        $XFDSET['xfd_yahoo'] == 1 || $XFDSET['xfd_msn'] == 1 ||
        $XFDSET['xfd_lines'] == 1 || $XFDSET['xfd_aol'] == 1 ||
        $XFDSET['xfd_feedburn'] == 1 || $XFDSET['xfd_google'] == 1) {

        $html .= " <optgroup label=\"".$lang_xfeeds['xfd_fe_rss']."\">\n";

        if ($XFDSET['xfd_standard'] == 1) {
            $html .= " <option value=\"".$CONFIG['ecards_more_pic_target'].$xfd_feed."\">".$lang_xfeeds['xfd_fe_standard']."</option>\n";
        }

        if ($XFDSET['xfd_google'] == 1) {
            $html .= " <option value=\"http://fusion.google.com/add?feedurl=http%3A//".$xfeed_loc."\">".$lang_xfeeds['xfd_fe_google']."</option>\n";
        }

        if ($XFDSET['xfd_yahoo'] == 1) {
            $html .= " <option value=\"http://us.rd.yahoo.com/my/atm/".$xfeed_author."/".$xfeed_title_enc."http%3A//".$xfeed_loc."\">".$lang_xfeeds['xfd_fe_yahoo']."</option>\n";
        }

        if ($XFDSET['xfd_msn'] == 1) {
            $html .= " <option value=\"http://my.msn.com/addtomymsn.armx?id=rss&amp;ut=http://".$xfeed_loc."\">".$lang_xfeeds['xfd_fe_msn']."</option>\n";
        }

        if ($XFDSET['xfd_lines'] == 1) {
            $html .= " <option value=\"http://www.bloglines.com/sub/http://".$xfeed_loc."\">".$lang_xfeeds['xfd_fe_lines']."</option>\n";
        }

        if ($XFDSET['xfd_aol'] == 1) {
            $html .= " <option value=\"http://feeds.my.aol.com/add.jsp?url=http://".$xfeed_loc."\">".$lang_xfeeds['xfd_fe_aol']."</option>\n";
        }

        if ($XFDSET['xfd_feedburn'] == 1) {
            $html .= " <option value=\"http://feeds.feedburner.com/".$xfeed_loc."\">".$lang_xfeeds['xfd_fe_feedburn']."</option>\n";
        }

        $html .= " </optgroup>\n";
    }

    $customRSSOpt = $customRSS = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($XFDSET['xfd_customenable'.$i] == 1) {
            if (empty($customRSSOpt)) {
                $customRSSOpt = "   <optgroup label=\"".$lang_xfeeds['xfd_fe_links']."\" />\n";
            }
            $customRSS .= "  <option value=\"".$XFDSET['xfd_customurl'.$i]."\">".$XFDSET['xfd_customtitle'.$i]."</option>\n";
        }
    }

    $html .= "  $customRSSOpt $customRSS </select>
        <noscript><input type=\"submit\" value=\"go\"></noscript>
    </form>
    </span>

    <!-- END XFeeds Plugin -->
    ";

    return /*$template_header.*/ $html;
}


// include header elements
function xfd_head()
{
    global $CONFIG, $thisplugin, $XFDSET, $album, $cat;
    $xfd_feed = "index.php?file=xfeed/xfeed";
    $superCage = Inspekt::makeSuperCage();

    switch ($XFDSET['xfd_theme']) {
        case 0:
            $color = "orange";
            break;
        case 1:
            $color = "azure";
            break;
        case 2:
            $color = "red";
            break;
        case 3:
            $color = "blue";
            break;
        case 4:
            $color = "trans_dark";
            break;
        case 5:
            $color = "trans_light";
            break;
    }

    $header = "
    <!-- Begin CPG XFeed Headcode -->
    ";

    if ($XFDSET['xfd_feedroute'] == 1) {
        $xfeed_loc = "feeds.feedburner.com/".$XFDSET['xfd_feedburnuname'];
        $header .= "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"".$CONFIG['gallery_name']." - Feedburner\" href=\"http://".$xfeed_loc."\" />\n";
    }

    $extra_header = $header_str = '';

    if ($superCage->get->keyExists('album')) {
        $album = $superCage->get->getRaw('album');
        $header_str .= "&album=$album";
    }

    if ($superCage->get->keyExists('cat')) {
        $cat = $superCage->get->getRaw('cat');
        $header_str .= "&cat=$cat";
    }

    // Code to show the proper title for various RSS and ATOM
    $extraTitle = '';

    if ($album) {
        if ((int)$album) {
            $albumDetails = get_album_name((int)$album);
            $album = $albumDetails['title'];
        } else {
            $album = ucwords($album);
        }
        $extraTitle .= " | $album";
    }

    if (!is_null($cat) && (int)$cat !== FALSE) {
        if ($cat < 0) {
            $album = -($cat);
            $query = "SELECT category FROM {$CONFIG['TABLE_ALBUMS']} WHERE aid = '$album'";
            $result = cpg_db_query($query);

            $row = cpg_db_fetch_rowset($result);
            $cat = $row[0]['category'];
        }

        $cat_name = populate_category_name($cat);
        $extraTitle .= " | $cat_name";
    }

    if ($header_str) {
        $extra_header = "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"{$CONFIG['gallery_name']}$extraTitle - RSS\" href=\"{$CONFIG['ecards_more_pic_target']}{$xfd_feed}{$header_str}\" />
        <link rel=\"alternate\" type=\"application/atom+xml\" title=\"".$CONFIG['gallery_name']."$extraTitle - Atom\" href=\"{$CONFIG['ecards_more_pic_target']}{$xfd_feed}&type=atom{$header_str}\" />";
    }

    $header .= "    <link rel=\"alternate\" type=\"application/rss+xml\" title=\"".$CONFIG['gallery_name']." - RSS\" href=\"".$CONFIG['ecards_more_pic_target'].$xfd_feed."\" />
    <link rel=\"alternate\" type=\"application/atom+xml\" title=\"".$CONFIG['gallery_name']." - Atom\" href=\"".$CONFIG['ecards_more_pic_target'].$xfd_feed."&amp;type=atom\" />
    $extra_header
    <style type=\"text/css\">
        .xfeeds{background-image: url(./plugins/xfeed/images/xfeeds_".$color.".png);}
    </style>
    <link rel=\"stylesheet\" href=\"plugins/xfeed/css/xfeeds.css\" type=\"text/css\" />
    <!-- END CPG XFeed Headcode -->
    ";

    return $header;
}

// add config button
function xfd_add_config_button($admin_menu)
{
    global $CONFIG;

    if ($CONFIG['enable_menu_icons'] > 0) {
        $xfeed_config_icon = '<img src="plugins/xfeed/images/xfeeds_admin_menu.png" border="0" alt="" width="16" height="16" class="icon" />';
    } else {
        $xfeed_config_icon = '';
    }

    $new_button = '<div class="admin_menu admin_float"><a href="index.php?file=xfeed/plugin_config" title="XFeeds Settings">'.$xfeed_config_icon.'XFeeds</a></div>';
    $look_for = '<!-- END export -->';
    $admin_menu = str_replace($look_for, $look_for . $new_button, $admin_menu); 
    
    return $admin_menu;
}

// Install
function xfd_install()
{
    global $CONFIG, $thisplugin;
    require 'include/sql_parse.php';

    // create table
    $db_schema = $thisplugin->fullpath . '/schema.sql';
    $sql_query = fread(fopen($db_schema, 'r'), filesize($db_schema));
    $sql_query = preg_replace('/CPG_/', $CONFIG['TABLE_PREFIX'], $sql_query);
    $sql_query = remove_remarks($sql_query);
    $sql_query = split_sql_file($sql_query, ';');
    echo $sqlquery;
    foreach($sql_query as $q) {
        cpg_db_query($q);
    }

    // insert default values
    $db_schema = $thisplugin->fullpath . '/basic.sql';
    $sql_query = fread(fopen($db_schema, 'r'), filesize($db_schema));
    $sql_query = preg_replace('/CPG_/', $CONFIG['TABLE_PREFIX'], $sql_query);
    $sql_query = remove_remarks($sql_query);
    $sql_query = split_sql_file($sql_query, ';');

    foreach($sql_query as $q) {
        cpg_db_query($q);
    }

    return true;
}

// Unnstall and drop settings table
function xfd_uninstall()
{
    global $CONFIG;
    cpg_db_query("DROP TABLE IF EXISTS {$CONFIG['TABLE_PREFIX']}plugin_xfeeds");
    return true;
}
