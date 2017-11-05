#/**************************************************
#  Coppermine 1.6.x Plugin - xfeed
#  *************************************************
#  Copyright (c) 2008 lee (www.mininoteuser.com)
#  Plugin for CPG 1.4 created by Lee
#  Ported to CPG 1.5.x by Aditya Mooley <adityamooley@sanisoft.com>
#  Ported to CPG 1.6.x by ron4mac
#  *************************************************
#  This program is free software; you can redistribute it and/or modify
#  it under the terms of the GNU General Public License as published by
#  the Free Software Foundation; either version 3 of the License, or
#  (at your option) any later version.
#  **************************************************/
  
  CREATE TABLE IF NOT EXISTS `CPG_plugin_xfeeds` (
  	`xfd_rss_button` int(2) NOT NULL default '1',
  	`xfd_rss_button_position` int(2) NOT NULL default '0',
	`xfd_standard` int(2) NOT NULL default '1',
	`xfd_google` int(2) NOT NULL default '1',
	`xfd_yahoo` int(2) NOT NULL default '1',
	`xfd_msn` int(2) NOT NULL default '1',
	`xfd_lines` int(2) NOT NULL default '1',
	`xfd_aol` int(2) NOT NULL default '1',
	`xfd_feedburn` int(2) NOT NULL default '0',
	`xfd_feedburnuname` varchar(255) default 'undefined',
	`xfd_feedroute` int(2) NOT NULL default '0',
	`xfd_customenable1` int(2) NOT NULL default '0',
	`xfd_customenable2` int(2) NOT NULL default '0',
	`xfd_customenable3` int(2) NOT NULL default '0',
	`xfd_customenable4` int(2) NOT NULL default '0',
	`xfd_customenable5` int(2) NOT NULL default '0',
	`xfd_customtitle1` varchar(255) default 'Link Title 1',
	`xfd_customtitle2` varchar(255) default 'Link Title 2',
	`xfd_customtitle3` varchar(255) default 'Link Title 3',
	`xfd_customtitle4` varchar(255) default 'Link Title 4',
	`xfd_customtitle5` varchar(255) default 'Link Title 5',
	`xfd_customurl1` varchar(255) default 'http://www.example.com',
	`xfd_customurl2` varchar(255) default 'http://www.example.com',
	`xfd_customurl3` varchar(255) default 'http://www.example.com',
	`xfd_customurl4` varchar(255) default 'http://www.example.com',
	`xfd_customurl5` varchar(255) default 'http://www.example.com',
	`xfd_theme` int(2) NOT NULL default '3',
    `xfd_feed_items` int NOT NULL default '10'
);
