<?php
/**************************************************
  Coppermine 1.6.x Plugin - picture_navigation
  *************************************************
  Copyright (c) 2010-2019 eenemeenemuu
  **************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

if (defined('DISPLAYIMAGE_PHP')) {
    $thisplugin->add_action('page_start', 'picture_navigation_page_start');
}

function picture_navigation_page_start() {
    $superCage = Inspekt::makeSuperCage();
    if (!$superCage->get->keyExists('slideshow')) {
        js_include('plugins/picture_navigation/picture_navigation.js');
    }
}

//EOF