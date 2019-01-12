<?php
/**************************************************
  Coppermine 1.6.x Plugin - Theme switch
  *************************************************
  Copyright (c) 2010-2019 eenemeenemuu
**************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

setcookie($CONFIG['cookie_name'].'_mobile_theme', '', time() - CPG_WEEK, $CONFIG['cookie_path']);

header('Location: '.urldecode($superCage->get->getRaw('ref')));

//EOF