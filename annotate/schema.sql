#/**************************************************
#  Coppermine 1.6.x Plugin - Picture Annotation (annotate)
#  *************************************************
#  Copyright (c) 2003-2019 Coppermine Dev Team
#  *************************************************
#  This program is free software; you can redistribute it and/or modify
#  it under the terms of the GNU General Public License as published by
#  the Free Software Foundation; either version 3 of the License, or
#  (at your option) any later version.
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
