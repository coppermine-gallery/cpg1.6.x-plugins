<?php
/**************************************************
  Coppermine 1.5.x Plugin - Picture Annotation (annotate)
  *************************************************
  Copyright (c) 2003-2009 Coppermine Dev Team
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  ********************************************
  $HeadURL: https://coppermine.svn.sourceforge.net/svnroot/coppermine/branches/cpg1.5.x/plugins/better_tooltip/configuration.php $
  $Revision: 7117 $
  $LastChangedBy: eenemeenemuu $
  $Date: 2010-01-23 18:19:46 +0100 (Sa, 23. Jan 2010) $
  **************************************************/

if (!defined('IN_COPPERMINE')) {
    die('Not in Coppermine...');
}
// Initialize language and icons
require_once './plugins/annotate/init.inc.php';
$annotate_init_array = annotate_initialize();
$lang_plugin_annotate = $annotate_init_array['language']; 
$annotate_icon_array = $annotate_init_array['icon'];
// Configuration
pageheader($lang_plugin_annotate['configure_plugin']);
annotate_configure();
pagefooter();
die;
?>