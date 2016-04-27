<?php
/*************************
  Coppermine Photo Gallery
  ************************
  Copyright (c) 2003-2016 Coppermine Dev Team
  v1.0 originally written by Gregory Demar

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License version 3
  as published by the Free Software Foundation.

  ********************************************
  Coppermine version: 1.6.01
  $HeadURL: https://svn.code.sf.net/p/coppermine/code/trunk/cpg1.6.x/plugins/link_target/configuration.php $
  $Revision: 8634M $

  Prepared for CPG 1.6 by ron4mac, 2016-04-26
**********************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$name = $lang_plugin_link_target['name'];
$description = $lang_plugin_link_target['description'];

$author='Coppermine dev team';
$version='1.3';
$plugin_cpg_version = array('min' => '1.6');
$install_info = $extra_info = $lang_plugin_link_target['extra'] . '<br />' . $lang_plugin_link_target['recommendation'];
