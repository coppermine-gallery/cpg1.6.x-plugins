<?php
/**************************************************
  Coppermine 1.5.x Plugin - Image manipulation
  *************************************************
  Copyright (c) 2010 Timo Schewe (www.timos-welt.de)
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  ********************************************
  $HeadURL$
  $Revision$
  $LastChangedBy$
  $Date$
  **************************************************/
  
if (!defined('IN_COPPERMINE')) { 
    die('Not in Coppermine...');
}

// Define the default language array (English)
require ("./plugins/image_manipulation/lang/english.php");
// submit your lang file for this plugin on the coppermine forums
// plugin will try to use the configured language if it is available.
if (file_exists("./plugins/image_manipulation/lang/{$CONFIG['lang']}.php")) {
    require ("./plugins/image_manipulation/lang/{$CONFIG['lang']}.php");
} 

// Determine the help file link
if (file_exists("./plugins/image_manipulation/docs/{$CONFIG['lang']}.htm")) {
    $documentation_file = $CONFIG['lang'];
} else {
    $documentation_file = 'english';
}

if ($CONFIG['enable_menu_icons'] >= 1) {
    $image_manipulation_icon_array['reset'] = '<img src="./plugins/image_manipulation/images/icons/reset.png" border="0" width="16" height="16" alt="" class="icon" />';
    $image_manipulation_icon_array['sepia'] = '<img src="./plugins/image_manipulation/images/icons/sepia.png" border="0" width="16" height="16" alt="" class="icon" />';
    $image_manipulation_icon_array['black_and_white'] = '<img src="./plugins/image_manipulation/images/icons/bw.png" border="0" width="16" height="16" alt="" class="icon" />';
    $image_manipulation_icon_array['flip_horizontally'] = '<img src="./plugins/image_manipulation/images/icons/fliph.png" border="0" width="16" height="16" alt="" class="icon" />';
    $image_manipulation_icon_array['flip_vertically'] = '<img src="./plugins/image_manipulation/images/icons/flipv.png" border="0" width="16" height="16" alt="" class="icon" />';
    $image_manipulation_icon_array['invert'] = '<img src="./plugins/image_manipulation/images/icons/invert.png" border="0" width="16" height="16" alt="" class="icon" />';
    $image_manipulation_icon_array['emboss'] = '<img src="./plugins/image_manipulation/images/icons/emboss.png" border="0" width="16" height="16" alt="" class="icon" />';
    $image_manipulation_icon_array['blur'] = '<img src="./plugins/image_manipulation/images/icons/blur.png" border="0" width="16" height="16" alt="" class="icon" />';
    $image_manipulation_icon_array['brightness'] = '<img src="./plugins/image_manipulation/images/icons/brightness.png" border="0" width="16" height="16" alt="" class="icon" />';
    $image_manipulation_icon_array['contrast'] = '<img src="./plugins/image_manipulation/images/icons/contrast.png" border="0" width="16" height="16" alt="" class="icon" />';
    $image_manipulation_icon_array['saturation'] = '<img src="./plugins/image_manipulation/images/icons/saturation.png" border="0" width="16" height="16" alt="" class="icon" />';
    $image_manipulation_icon_array['sharpness'] = '<img src="./plugins/image_manipulation/images/icons/sharpness.png" border="0" width="16" height="16" alt="" class="icon" />';
} else {
    $image_manipulation_icon_array['reset'] = '';
    $image_manipulation_icon_array['sepia'] = '';
    $image_manipulation_icon_array['black_and_white'] = '';
    $image_manipulation_icon_array['flip_horizontally'] = '';
    $image_manipulation_icon_array['flip_vertically'] = '';
    $image_manipulation_icon_array['invert'] = '';
    $image_manipulation_icon_array['emboss'] = '';
    $image_manipulation_icon_array['blur'] = '';
    $image_manipulation_icon_array['brightness'] = '';
    $image_manipulation_icon_array['contrast'] = '';
    $image_manipulation_icon_array['saturation'] = '';
    $image_manipulation_icon_array['sharpness'] = '';
}

$image_manipulation_icon_array['submit'] = cpg_fetch_icon('ok', 1);
$image_manipulation_icon_array['announcement'] = cpg_fetch_icon('announcement', 1);
$image_manipulation_icon_array['documentation'] = cpg_fetch_icon('documentation', 1);
$image_manipulation_icon_array['config'] = cpg_fetch_icon('config', 1);


?>