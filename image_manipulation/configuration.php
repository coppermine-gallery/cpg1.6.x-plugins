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

require('./plugins/image_manipulation/init.inc.php');
  
$name = $lang_plugin_image_manipulation['display_name'];
$description = $lang_plugin_image_manipulation['description'];
$author = 'Timo Schewe (<a href="http://www.timos-welt.de/" rel="external" class="external">Timos-Welt</a>)';
$version = '2.3';
$plugin_cpg_version = array('min' => '1.5');
$install_info = $lang_plugin_image_manipulation['install_info'];
$extra_info = $lang_plugin_image_manipulation['extra_info'];
$announcement_thread = '<a href="http://forum.coppermine-gallery.net/index.php/topic,79597.0.html" rel="external" class="admin_menu">' . $image_manipulation_icon_array['announcement'] . $lang_plugin_image_manipulation['announcement_thread'] . '</a>';
$configuration_link = '<a href="index.php?file=image_manipulation/admin" class="admin_menu">' . $image_manipulation_icon_array['config'] . $lang_plugin_image_manipulation['im_configuration'] . '</a>';
$documentation_link = '<a href="plugins/image_manipulation/docs/' . $documentation_file  . '.htm" class="admin_menu">' . $image_manipulation_icon_array['documentation'] . $lang_plugin_image_manipulation['im_documentation'] . '</a>';
$install_info .= '<br />' . $announcement_thread . '&nbsp;' . $documentation_link;
$extra_info .= '<br />' . $configuration_link . '&nbsp;' . $announcement_thread . '&nbsp;' . $documentation_link;
?>