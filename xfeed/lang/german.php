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
'display_name' => 'Xfeed',
'update_success' => 'Werte wurden erfolgreich aktualisiert',
'main_title' => 'Xfeed PlugIn für Coppermine',
'version' => 'v1.12',
'pluginmanager' => 'Plugin-Verwaltung',
'xfd_yes' => 'ja',
'xfd_no' => 'nein',
'submit_button' => 'Senden',
'xfd_number' => 'Anzahl der im Feed anzuzeigenden Elemente',
'xfd_rss_button' => 'RSS-Button anzeigen',
'xfd_standard' => 'Lesezeichen-Link aktivieren',
'xfd_google' => 'Google-Link aktivieren',
'xfd_yahoo' => 'Yahoo-Link aktivieren',
'xfd_msn' => 'MSN-Link aktivieren',
'xfd_lines' => 'Blogmarks-Link aktivieren',
'xfd_aol' => 'AOL-Link aktivieren',
'xfd_feedburn' => 'Feedburner-Link aktivieren',
'xfd_feedburnuname' => 'Gib Deinen Feedburner-String ein (http://feeds.feedburner.com/&lt;string&gt;)',
'xfd_feedroute' => 'Alle Feeds über Feedburner routen',
'xfd_theme' => 'Wähle Design',
'xfd_customenable' => 'Aktiviere benutzerdefinierten Link ',
'xfd_customtitle' => 'Titel des benutzerdefinierten Links ',
'xfd_customurl' => 'Benutzerdefinierter Link ',
'orange' => 'Orangener Button',
'azure' => 'Hellblauer Button',
'red' => 'Roter Button',
'blue' => 'Dunkelblauer Button',
'transl' => 'Transparenter dunkler Button',
'transd' => 'Transparenter heller Button',
'xfd_fe_opts' => 'Feed Optionen ---&gt;',
'xfd_fe_atom' => 'ATOM Feeds',
'xfd_fe_rss' => 'RSS Feeds',
'xfd_fe_links' => 'Links',
'xfd_fe_local_atom' => 'Abonniere lokalen ATOM feed',
'xfd_fe_standard' => 'Abonniere lokalen RSS feed',
'xfd_fe_google' => 'Abonniere lokalen Feed mit Google',
'xfd_fe_yahoo' => 'Abonniere Feed mit Yahoo!',
'xfd_fe_msn' => 'Abonniere Feed mit MSN',
'xfd_fe_lines' => 'Abonniere Feed mit Bloglines',
'xfd_fe_aol' => 'Abonniere Feed mit AOL',
'xfd_fe_feedburn' => 'Abonniere Feed mit Feed Burner',
'xfd_feed_items' => 'Anzahl der Elemente im Feed',
'xx_s_gallery' => 'Galerie von %s',
'xfd_rss_button_position' => 'RSS button position',
'xfd_rss_button_position_template' => 'Template',
'xfd_rss_button_position_gallery' => 'Gallery'
);
