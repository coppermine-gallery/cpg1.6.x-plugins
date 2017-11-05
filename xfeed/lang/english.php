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

if (!defined('IN_COPPERMINE')) { die('Not in Coppermine...'); }
//language variables
$lang_xfeeds = array(
'display_name' => 'CPG Xfeed PlugIn',
'update_success' => 'Values have been updated successfully',
'main_title' => 'CPG Xfeed PlugIn',
'version' => 'v1.12',
'pluginmanager' => 'Plugin Manager',
'xfd_yes' => 'yes',
'xfd_no' => 'no',
'submit_button' => 'Submit',
'xfd_number' => 'Number of items to display in feed',
'xfd_rss_button' => 'Show RSS Button',
'xfd_standard' => 'Enable Standard Bookmark Link',
'xfd_google' => 'Enable Google Bookmark Link',
'xfd_yahoo' => 'Enable Yahoo! Bookmark Link',
'xfd_msn' => 'Enable MSN Bookmark Link',
'xfd_lines' => 'Enable Bloglines Bookmark Link',
'xfd_aol' => 'Enable AOL Bookmark Link',
'xfd_feedburn' => 'Enable Feedburner Bookmark Link',
'xfd_feedburnuname' => 'Enter your feedburner string (http://feeds.feedburner.com/&lt;string&gt;)',
'xfd_feedroute' => 'Route All feeds through feedburner',
'xfd_theme' => 'Select the theme that you wish to use',
'xfd_customenable' => 'Enable Custom link ',
'xfd_customtitle' => 'Enter the title for the custom link ',
'xfd_customurl' => 'Enter custom link ',
'orange' => 'Orange Button',
'azure' => 'Azure Button',
'red' => 'Red Button',
'blue' => 'Blue Button',
'transl' => 'Transparent Dark Button',
'transd' => 'Transparent Light Button',
'xfd_fe_opts' => 'Feed Options ---&gt;',
'xfd_fe_atom' => 'ATOM Feeds',
'xfd_fe_rss' => 'RSS Feeds',
'xfd_fe_links' => 'Links',
'xfd_fe_local_atom' => 'Subscribe to local ATOM feed',
'xfd_fe_standard' => 'Subscribe to local RSS feed',
'xfd_fe_google' => 'Subscribe to feed with Google',
'xfd_fe_yahoo' => 'Subscribe to feed with Yahoo!',
'xfd_fe_msn' => 'Subscribe to feed with MSN',
'xfd_fe_lines' => 'Subscribe to feed with Bloglines',
'xfd_fe_aol' => 'Subscribe to feed with AOL',
'xfd_fe_feedburn' => 'Subscribe to feed with Feed Burner',
'xfd_feed_items' => 'Number of items in feed',
'xx_s_gallery' => '%s\'s Gallery',
'xfd_rss_button_position' => 'RSS button position',
'xfd_rss_button_position_template' => 'Template',
'xfd_rss_button_position_gallery' => 'Gallery'
);
