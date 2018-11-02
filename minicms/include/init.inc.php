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
  $HeadURL: http://svn.code.sf.net/p/coppermine/code/branches/cpg1.5.x/plugins/minicms/include/init.inc.php $
  $Revision: 8400 $
  $Author: eenemeenemuu $
  $Date: 2012-05-09 04:36:53 -0400 (Wed, 09 May 2012) $
***************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

define('MINICMS_DBVER','1.5.20');

// submit your lang file for this plugin on the coppermine forums
// plugin will try to use the configured language if it is available.

global $enabled_languages_array;
$lang = isset($CONFIG['lang']) ? $CONFIG['lang'] : 'english';
include('plugins/minicms/lang/english.php');
if (in_array($lang, $enabled_languages_array) == TRUE && file_exists('plugins/minicms/lang/'.$lang.'.php')) {
    include('plugins/minicms/lang/'.$lang.'.php');
}

$superCage = Inspekt::makeSuperCage();

$req_array=array('album', 'file', 'id', 'conid', 'type', 'cat');
foreach ($req_array as $cnf_item) {
    if ($superCage->get->keyExists($cnf_item)) {
        $request[$cnf_item] = $superCage->get->getRaw($cnf_item);
    }
    if ($superCage->post->keyExists($cnf_item)) {
        $request[$cnf_item] = $superCage->post->getRaw($cnf_item);
    }
}

$CONFIG['TABLE_CMS'] = $CONFIG['TABLE_PREFIX'] . "cms";
$CONFIG['TABLE_CMS_CONFIG'] = $CONFIG['TABLE_PREFIX'] . "cms_config";

$results=cpg_db_query("SHOW TABLES LIKE '{$CONFIG['TABLE_CMS_CONFIG']}'");
//GMC if (!$row=mysql_fetch_row($results)) minicms_configure(false);            //GMC updated for PHP7 - mysql_* no longer exists
if (!$row=cpg_db_fetch_row($results)) minicms_configure(false);                 //GMC updated for PHP7
//GMC mysql_free_result($results);                                              //GMC updated for PHP7 - mysql_* no longer exists
cpg_db_free_result($results);                                                   //GMC updated for PHP7

$results = cpg_db_query("SELECT * FROM {$CONFIG['TABLE_CMS_CONFIG']}");
//GMC while ($row = mysql_fetch_array($results)) {                              //GMC updated for PHP7 - mysql_* no longer exists
while ($row = cpg_db_fetch_assoc($results)) {                                   //GMC updated for PHP7
    $MINICMS[$row['name']] = $row['value'];
} // while
//GMC mysql_free_result($results);                                              //GMC updated for PHP7 - mysql_* no longer exists
cpg_db_free_result($results);                                                   //GMC updated for PHP7

$HTML_SUBST_DECODE = array_flip($HTML_SUBST); //used to reverse Coppermines init.inc.php gpc processing

$MINICMS['conType']=array('cat','thumb','img','section');
$MINICMS['conTypebyName']=array_flip($MINICMS['conType']);

if (defined('DISPLAYIMAGE_PHP')) {
    $MINICMS['type']=$MINICMS['conTypebyName']['img'];
} elseif (defined('THUMBNAILS_PHP')) {
    $MINICMS['conid']=isset($request['album']) ? (int)$request['album'] : -1;
    $MINICMS['type']=$MINICMS['conTypebyName']['thumb'];
} elseif (isset($request['file']) && $request['file'] =='minicms/cms') {
    if (isset($request['id'])) {
        $MINICMS['ID']=(int)$request['id'];
        $MINICMS['conid']='';
        $MINICMS['type']='';
    } else {
      $MINICMS['conid']=(int)$request['conid'];
      $MINICMS['type']=(int)$request['type'];
    }
} else {
    $MINICMS['conid']=isset($request['cat']) ? (int)$request['cat'] : 0;
    $MINICMS['type']=$MINICMS['conTypebyName']['cat'];
}

require 'plugins/minicms/include/themes.inc.php';