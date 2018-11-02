<?php
/**************************************************
  CPG MiniCMS Plugin for Coppermine Photo Gallery
  *************************************************
  CPGMiniCMS
  Copyright (c) 2005-2006 Donovan Bray <donnoman@donovanbray.com>
  *************************************************
  1.3.0  eXtended miniCMS
  Copyright (C) 2004 Michael Trojacher <m.trojacher@webtips.at>
  Original miniCMS Code (c) 2004 by Tarique Sani <tarique@sanisoft.com>,
  Amit Badkas <amit@sanisoft.com>
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.
  *************************************************
  Coppermine version: 1.5.x
  $HeadURL: http://svn.code.sf.net/p/coppermine/code/branches/cpg1.5.x/plugins/minicms/configuration.php $
  $Revision: 8633 $
  $Author: eenemeenemuu $
  $Date: 2014-01-02 07:27:32 -0500 (Thu, 02 Jan 2014) $
***************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$name='MiniCMS';
$description='MiniCMS provides a small content management system within the Coppermine Picture Gallery application that enables the admin to add textual content to existing coppermine pages and to add new pages with the look and feel of the existing ones.';
$author='Created for cpg1.4.x by Donnoman@donovanbray.com';
$author.='<br />Initial release for cpg1.5.x by <a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=41609" rel="external" class="external">halnat</a>.';
$author.='<br />Made fully compatible to cpg1.5.x by <a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=24278" rel="external" class="external">eenemeenemuu</a>';
$author.='<br />Ported/refitted to cpg1.6.x by <a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=24075" rel="external" class="external">gmc</a>';
$version='2.4';
$plugin_cpg_version = array('min' => '1.6.1');

$lang = isset($CONFIG['lang']) ? $CONFIG['lang'] : 'english';
include('plugins/minicms/lang/english.php');
if (in_array($lang, $enabled_languages_array) == TRUE && file_exists('plugins/minicms/lang/'.$lang.'.php')) {
    include('plugins/minicms/lang/'.$lang.'.php');
}

$extra_info = $install_info = '<a href="http://forum.coppermine-gallery.net/index.php/topic,79514.0.html" rel="external" class="admin_menu">'.cpg_fetch_icon('announcement', 1).'Announcement thread</a>';

?>