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
  
  INSERT INTO `CPG_plugin_xfeeds` (
    xfd_rss_button,
	xfd_rss_button_position,
	xfd_standard,
	xfd_google,
	xfd_yahoo,
	xfd_msn,
	xfd_lines,
	xfd_aol,
	xfd_feedburn,
	xfd_feedburnuname,
	xfd_feedroute,
	xfd_customenable1,
	xfd_customenable2,
	xfd_customenable3,
	xfd_customenable4,
	xfd_customenable5,
	xfd_customtitle1,
	xfd_customtitle2,
	xfd_customtitle3,
	xfd_customtitle4,
	xfd_customtitle5,
	xfd_customurl1,
	xfd_customurl2,
	xfd_customurl3,
	xfd_customurl4,
	xfd_customurl5,
	xfd_theme,
    xfd_feed_items)
VALUES (
    1,
	0,
	1,
	1,
	1,
	1,
	1,
	1,
	0,
	'undefined',
	0,
	0,
	0,
	0,
	0,
	0,
	'Link Title 1',
	'Link Title 2',
	'Link Title 3',
	'Link Title 4',
	'Link Title 5',
	'http://www.example.com',
	'http://www.example.com',
	'http://www.example.com',
	'http://www.example.com',
	'http://www.example.com',
	3,
    10
);