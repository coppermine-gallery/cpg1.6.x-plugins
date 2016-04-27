#/**************************************************
#  Coppermine 1.5.x Plugin - external_edit
#  *************************************************
#  Copyright (c) 2010 Joachim Müller
#  *************************************************
#  This program is free software; you can redistribute it and/or modify
#  it under the terms of the GNU General Public License as published by
#  the Free Software Foundation; either version 3 of the License, or
#  (at your option) any later version.
#  ********************************************
#  $HeadURL: https://coppermine.svn.sourceforge.net/svnroot/coppermine/branches/cpg1.5.x/plugins/external_edit/schema.sql $
#  $Revision: 7977 $
#  $LastChangedBy: gaugau $
#  $Date: 2010-10-15 17:08:34 +0200 (Fr, 15 Okt 2010) $
#
#  Prepared for CPG 1.6 by ron4mac, 2016-04-26
#  **************************************************/

CREATE TABLE IF NOT EXISTS CPG_plugin_external_edit (
  token_id varchar(80) NOT NULL default '',
  user_id int(11) default '0',
  pid int(11) default NULL,
  aid int(11) default NULL,
  time int(11) default NULL,
  PRIMARY KEY (token_id)
) COMMENT='Used to authenticate users from one page to the other';
