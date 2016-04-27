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
  $HeadURL: https://coppermine.svn.sourceforge.net/svnroot/coppermine/branches/cpg1.5.x/plugins/external_edit/init.inc.php $
  $Revision: 7977 $
  $LastChangedBy: gaugau $
  $Date: 2010-10-15 17:08:34 +0200 (Fr, 15 Okt 2010) $

  Prepared for CPG 1.6 by ron4mac, 2016-04-26
  **************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

function external_edit_init() {
    global $CONFIG, $lang_plugin_external_edit, $external_edit_icon_array;
    if (version_compare(COPPERMINE_VERSION, '1.6', '<')) {
		require "./plugins/external_edit/lang/english.php";
		if ($CONFIG['lang'] != 'english' && file_exists("./plugins/external_edit/lang/{$CONFIG['lang']}.php")) {
			require "./plugins/external_edit/lang/{$CONFIG['lang']}.php";
		}
    }
    if ($CONFIG['enable_menu_icons'] > 0) {
        $external_edit_icon_array['fotoflexer'] = '<img src="./plugins/external_edit/images/icons/fotoflexer.png" width="16" height="16" border="0" alt="" class="icon" />';
    } else {
        $external_edit_icon_array['fotoflexer'] = '';
    }
    $external_edit_icon_array['announcement'] = cpg_fetch_icon('announcement', 1);
    $external_edit_icon_array['ok'] = cpg_fetch_icon('ok',2);
    $external_edit_icon_array['cancel'] = cpg_fetch_icon('cancel',2);
    $external_edit_icon_array['none'] = cpg_fetch_icon('cancel',2);
    $external_edit_icon_array['ignore'] = cpg_fetch_icon('ignore',2);
    $return['language'] = $lang_plugin_external_edit;
    $return['icon'] = $external_edit_icon_array;
    return $return;
}