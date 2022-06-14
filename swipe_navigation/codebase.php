<?php
/*********************************************
  Coppermine Plugin - Swipe Navigation
  ********************************************
  Copyright (c) 2022 eenemeenemuu
**********************************************/


if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

if (defined('DISPLAYIMAGE_PHP')) {
    $thisplugin->add_action('page_start', 'swipe_navigation_displayimage');
}

if (defined('THUMBNAILS_PHP')) {
    $thisplugin->add_action('page_start', 'swipe_navigation_thumbnails');
}

function swipe_navigation_displayimage() {
    js_include('plugins/swipe_navigation/swipe.js');
    js_include('plugins/swipe_navigation/swipe_displayimage.js');
}

function swipe_navigation_thumbnails() {
    js_include('plugins/swipe_navigation/swipe.js');
    js_include('plugins/swipe_navigation/swipe_thumbnails.js');
}

//EOF
