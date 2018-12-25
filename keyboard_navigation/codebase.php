<?php
/*********************************************
  Coppermine Plugin - Keyboard Navigation
  ********************************************
  Copyright (c) 2009-2018 eenemeenemuu
**********************************************/


if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

if (defined('DISPLAYIMAGE_PHP')) {
    $thisplugin->add_action('page_start', 'keyboard_navigation_displayimage');
}

if (defined('THUMBNAILS_PHP')) {
    $thisplugin->add_action('page_start', 'keyboard_navigation_thumbnails');
}

function keyboard_navigation_displayimage() {
    js_include('plugins/keyboard_navigation/keydown_displayimage.js');
}

function keyboard_navigation_thumbnails() {
    js_include('plugins/keyboard_navigation/keydown_thumbnails.js');
}

//EOF