<?php
/**************************************************
  Coppermine 1.6.x Plugin - Check files
  *************************************************
  Copyright (c) 2012 eenemeenemuu
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  ********************************************
**************************************************/

/* Change log
2016-10-25 by gmc
- Added delete support for additional files - choice of all or 'duplicate' (same filename elsewhere in gallery) - and just main file or all related.
- Added support for cleaning up favpics when deleting missing files from CPG.
  (favpics stored as base64 encoded serialized array that each need to be retrieved, reviewed, and updated if needed...)
- Changed all mysql references to CPG functions for 1.6 compatibility (raised MIN level of CPG required to 1.5.42 where these were added)
- Updated version to 0.3
2019-10-17 by ron4mac
- Corrected incompatibilities with CPG 1.6.x
- Updated version to 0.3.1
*/

$name = 'Check files';
$description = 'Adds 2 options to the admin menu:<ol><li>Check if all files in the database exist in the albums directory (with the possibility to delete the affected entries from the database)</li><li>Check if all files in the albums directory exist in the database</li></ol>';
$author = '<a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=24278" rel="external" class="external">eenemeenemuu</a>';
$version = '0.3.1';
$plugin_cpg_version = array('min' => '1.6.03');
