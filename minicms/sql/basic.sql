#/**************************************************
#  CPG MiniCMS Plugin for Coppermine Photo Gallery
#  *************************************************
#  CPGMiniCMS
#  Copyright (c) 2005-2006 Donovan Bray <donnoman@donovanbray.com>
#  *************************************************
#  1.3.0  eXtended miniCMS
#  Copyright (C) 2004 Michael Trojacher <m.trojacher@webtips.at>
#  Original miniCMS Code (c) 2004 by Tarique Sani <tarique@sanisoft.com>,
#  Amit Badkas <amit@sanisoft.com>
#  *************************************************
#  This program is free software; you can redistribute it and/or modify
#  it under the terms of the GNU General Public License as published by
#  the Free Software Foundation; either version 2 of the License, or
#  (at your option) any later version.
#  *************************************************
#  Coppermine version: 1.4.x
#  $Source: /cvsroot/cpg-contrib/minicms/sql/basic.sql,v $
#  $Revision: 8399 $
#  $Author: eenemeenemuu $
#  $Date: 2012-05-09 04:27:02 -0400 (Wed, 09 May 2012) $
#***************************************************/

#
# Table structure for table `CPG_cms`
#

CREATE TABLE `CPG_cms` (
  `ID` int(11) NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL default '',
  PRIMARY KEY  (`ID`, `catid`),
  FULLTEXT KEY `title` (`title`,`content`)
) AUTO_INCREMENT=1 ;

#
# Table structure for table `CPG_cms_config`
#

CREATE TABLE CPG_cms_config (
  name varchar(40) NOT NULL default '',
  value varchar(255) NOT NULL default '',
  PRIMARY KEY  (name)
);

ALTER TABLE `CPG_cms` ADD `pos` int(11) NOT NULL default '0';
ALTER TABLE `CPG_cms` ADD `type` int(11) NOT NULL default '0';
ALTER TABLE `CPG_cms` CHANGE `catid` `conid` int(11) NOT NULL default '0';
ALTER TABLE `CPG_cms` CHANGE `pos` `cpos` int(11) NOT NULL default '0';

ALTER TABLE `CPG_cms` ADD `modified` TIMESTAMP NOT NULL;
ALTER TABLE `CPG_cms` ADD `start` DATETIME;
ALTER TABLE `CPG_cms` ADD `end` DATETIME;

INSERT INTO `CPG_cms` (conid,title,content,type) VALUES ('0','Welcome to Coppermine', 'Simple test of CPG MiniCMS','0');
INSERT INTO `CPG_cms_config` VALUES ('dbver', '0.0');
INSERT INTO `CPG_cms_config` VALUES ('redirect_index_php', '');
INSERT INTO `CPG_cms_config` VALUES ('related_size', 'thumb');
INSERT INTO `CPG_cms_config` VALUES ('editor', 'fckeditor');
INSERT INTO `CPG_cms_config` VALUES ('rss_enabled', '0');
INSERT INTO `CPG_cms_config` VALUES ('rss_description_length', '50');
INSERT INTO `CPG_cms_config` VALUES ('rss_include_image', '0');
INSERT INTO `CPG_cms_config` VALUES ('rss_image_size', 'thumb');


UPDATE `CPG_cms` SET `modified`=NOW() WHERE `modified`='0000-00-00 00:00:00';

# Cleanup - Values that shouldn't exist anymore:
ALTER TABLE `CPG_cms` DROP `pos`;

# Write this dbver to the config table
# This should match the DBVER constant in init.inc.php
UPDATE CPG_cms_config SET value='1.5.20' WHERE name='dbver';

