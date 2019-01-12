<?php
/**************************************************
  Coppermine 1.6.x Plugin - Theme switch
  *************************************************
  Copyright (c) 2010-2019 eenemeenemuu
**************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

setcookie($CONFIG['cookie_name'].'_mobile_theme', 'false', time() + (CPG_WEEK*2), $CONFIG['cookie_path']);

$USER['theme'] = cpg_db_result(cpg_db_query("SELECT value FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'theme'"), 0);
user_save_profile();

header('Location: '.urldecode($superCage->get->getRaw('ref')));

//EOF