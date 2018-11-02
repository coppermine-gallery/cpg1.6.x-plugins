#/**************************************************
#  Coppermine 1.5.x Plugin - Picture Annotation (annotate)
#  *************************************************
#  Copyright (c) 2003-2009 Coppermine Dev Team
#  *************************************************
#  This program is free software; you can redistribute it and/or modify
#  it under the terms of the GNU General Public License as published by
#  the Free Software Foundation; either version 3 of the License, or
#  (at your option) any later version.
#  ********************************************
#  $HeadURL: https://coppermine.svn.sourceforge.net/svnroot/coppermine/branches/cpg1.5.x/plugins/better_tooltip/configuration.php $
#  $Revision: 7117 $
#  $LastChangedBy: eenemeenemuu $
#  $Date: 2010-01-23 18:19:46 +0100 (Sa, 23. Jan 2010) $
#  **************************************************/

CREATE TABLE IF NOT EXISTS `CPG_plugin_annotate` (
  nid smallint(5) unsigned NOT NULL auto_increment,
  pid mediumint(8) unsigned NOT NULL,
  posx smallint(5) unsigned NOT NULL,
  posy smallint(5) unsigned NOT NULL,
  width smallint(5) unsigned NOT NULL,
  height smallint(5) unsigned NOT NULL,
  note text NOT NULL,
  user_id smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (nid)
);
