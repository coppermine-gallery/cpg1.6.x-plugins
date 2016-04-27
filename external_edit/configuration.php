<?php
/**************************************************
  Coppermine 1.5.x Plugin - external_edit
  *************************************************
  Copyright (c) 2010 Joachim Müller
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  ********************************************
  $HeadURL: https://coppermine.svn.sourceforge.net/svnroot/coppermine/branches/cpg1.5.x/plugins/external_edit/configuration.php $
  $Revision: 7977 $
  $LastChangedBy: gaugau $
  $Date: 2010-10-15 17:08:34 +0200 (Fr, 15 Okt 2010) $

  Prepared for CPG 1.6 by ron4mac, 2016-04-26
  **************************************************/

require_once "./plugins/external_edit/init.inc.php";
$external_edit_init_array = external_edit_init();
$lang_plugin_external_edit = $external_edit_init_array['language']; 
$external_edit_icon_array = $external_edit_init_array['icon'];
$name = $lang_plugin_external_edit['plugin_name'];
$description = sprintf($lang_plugin_external_edit['plugin_description'], '<a href="http://fotoflexer.com/" rel="external" class="external">Fotoflexer.com</a>');
$author = sprintf($lang_plugin_external_edit['author'], 
                  '<a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=2" rel="external" class="external">Joachim Müller</a>');
$version = '2.6';
$plugin_cpg_version = array('min' => '1.5');
$extra_info = <<<EOT
    <a href="http://forum.coppermine-gallery.net/index.php/topic,60173.0.html" title="&laquo;{$lang_plugin_external_edit['plugin_name']}&raquo; - {$lang_plugin_external_edit['announcement_thread']}" class="admin_menu">{$external_edit_icon_array['announcement']}{$lang_plugin_external_edit['announcement_thread']}</a>
EOT;

$install_info = <<<EOT
    {$lang_plugin_external_edit['plugin_description_detail']}<br />&nbsp;<br />
    <a href="http://forum.coppermine-gallery.net/index.php/topic,60173.0.html" title="&laquo;{$lang_plugin_external_edit['plugin_name']}&raquo; - {$lang_plugin_external_edit['announcement_thread']}" class="admin_menu">{$external_edit_icon_array['announcement']}{$lang_plugin_external_edit['announcement_thread']}</a>
EOT;
