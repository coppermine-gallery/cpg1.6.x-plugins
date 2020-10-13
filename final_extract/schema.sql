# 
# * Coppermine 1.6.x Plugin - final_extract
# *
# * @copyright	Copyright (c) 2009 Donnovan Bray
# * @license	GNU General Public License version 3 or later; see LICENSE
# *
# * @author		Donnovan Bray (original)
# * @author		ron4mac (23 Dec 2018); version for CPG 1.6.x
# 

#
# Table structure for table `CPG_final_extract_config`
#
CREATE TABLE IF NOT EXISTS `CPG_final_extract_config` (
  `Group_Id` varchar(40) NOT NULL default '',
  `home` varchar(255) NOT NULL default '',
  `login` varchar(255) NOT NULL default '',
  `my_gallery` varchar(255) NOT NULL default '',
  `upload_pic` varchar(255) NOT NULL default '',
  `album_list` varchar(255) NOT NULL default '',
  `lastup` varchar(255) NOT NULL default '',
  `lastcom` varchar(255) NOT NULL default '',
  `topn` varchar(255) NOT NULL default '',
  `toprated` varchar(255) NOT NULL default '',
  `favpics` varchar(255) NOT NULL default '',
  `search` varchar(255) NOT NULL default '',
  `my_profile` varchar(255) NOT NULL default '',
  `register` varchar(255) NOT NULL default '',

  PRIMARY KEY  (`Group_Id`)
);
