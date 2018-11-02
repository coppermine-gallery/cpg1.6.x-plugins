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
  $HeadURL: http://svn.code.sf.net/p/coppermine/code/branches/cpg1.5.x/plugins/minicms/cms_edit.php $
  $Revision: 8633 $
  $Author: eenemeenemuu $
  $Date: 2014-01-02 07:27:32 -0500 (Thu, 02 Jan 2014) $
***************************************************/

require_once('include/init.inc.php');
$superCage = Inspekt::makeSuperCage($strict);

$req_array=array('referer','id','submit','conid','type','title','minicms_content');

foreach ($req_array as $cnf_item) {
    if ($superCage->get->keyExists($cnf_item)) {
        $request[$cnf_item] = $superCage->get->getRaw($cnf_item);
    }
    if ($superCage->post->keyExists($cnf_item)) {
        $request[$cnf_item] = $superCage->post->getRaw($cnf_item);
    }
}


if (!(GALLERY_ADMIN_MODE))
    cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);

if (isset($request['referer'])) {
    $referer = urlencode(html_entity_decode($request['referer']));
    if (strpos($referer, "http") !== false) {
      $referer = urlencode("index.php?file=minicms/cms_edit");
    }
} else {
    $referer = urlencode("index.php?file=minicms/cms_edit");
}

if (isset($request['id'])) {
    $id = (int)$request['id'];
} else {
    $id = -1;
}

if(isset($request['submit']) && $request['submit']==$lang_minicms['submit'] && $request['id'] > -1){
    $MINICMS['conid']=(int)$request['conid'];
    $MINICMS['type']=(int)$request['type'];
//GMC    $title=mysql_real_escape_string($request['title']);                    //GMC updated for PHP7 - mysql_* no longer exists
    $title=cpg_db_real_escape_string($request['title']);                        //GMC updated for PHP7
//GMC    $content=mysql_real_escape_string($request['minicms_content']);        //GMC updated for PHP7 - mysql_* no longer exists
    $content=cpg_db_real_escape_string($request['minicms_content']);            //GMC updated for PHP7
    $query = "UPDATE {$CONFIG['TABLE_CMS']} SET title = '$title', content = '$content', type = '{$MINICMS['type']}' WHERE ID = '$id'";
    $result = cpg_db_query($query);
    if ($result) {
        $redirect=urldecode($referer);
        pageheader($superCage->post->getRaw('title'), "<meta http-equiv=\"refresh\" content=\"3;url=$redirect\" />");
        msg_box($lang_minicms['minicms'], $lang_minicms['page_success'], $lang_common['continue'], $redirect);
        pagefooter();
        exit;
    }
}

if(isset($request['conid']) && isset($request['id']) && $request['id']=='-1' && $request['submit']==$lang_minicms['submit']) {
    $MINICMS['conid']=(int)$request['conid'];
    $MINICMS['type']=(int)$request['type'];
//GMC    $title = (isset($request['title'])) ? mysql_real_escape_string($request['title']) : $lang_minicms['article'];  //GMC updated for PHP7 - mysql_* no longer exists
    $title = (isset($request['title'])) ? cpg_db_real_escape_string($request['title']) : $lang_minicms['article'];
//GMC    $content=mysql_real_escape_string($request['minicms_content']);        //GMC updated for PHP7 - mysql_* no longer exists
    $content=cpg_db_real_escape_string($request['minicms_content']);            //GMC updated for PHP7
    $query="SELECT cpos FROM {$CONFIG['TABLE_CMS']} WHERE conid='{$MINICMS['conid']}' ORDER BY cpos DESC LIMIT 1";
    $result = cpg_db_query($query);
    if ($result) {
//GMC        $cms=mysql_fetch_array($result);                                   //GMC updated for PHP7 - mysql_* no longer exists
        $cms=cpg_db_fetch_assoc($result);                                       //GMC updated for PHP7
//GMC        mysql_free_result($result);                                        //GMC updated for PHP7 - mysql_* no longer exists
        cpg_db_free_result($result);                                            //GMC updated for PHP7
        $cms['cpos']+=1;
    } else {
        $cms['cpos']=0;
    }
    $query="INSERT INTO {$CONFIG['TABLE_CMS']} SET title = '$title',conid='{$MINICMS['conid']}',type='{$MINICMS['type']}',cpos='{$cms['cpos']}', content = '$content';";
    $result = cpg_db_query($query);
    if ($result) {
        $message = $lang_minicms['page_success'];
    } else {
        $message = $lang_minicms['page_fail'];
    }
//GMC    $id=mysql_insert_id();                                                 //GMC updated for PHP7 - mysql_* no longer exists
    $id=cpg_db_last_insert_id();                                                //GMC updated for PHP7
//GMC    mysql_free_result($result);                                            //GMC updated for PHP7 - mysql_* no longer exists
    cpg_db_free_result($result);                                                //GMC updated for PHP7
}

if(isset($request['submit']) && $request['submit'] == $lang_minicms['preview']){
    $cms['ID'] = $request['id'];
    $cms['conid'] = $request['conid'];
    $cms['title'] = $request['title'];
    $cms['content'] = $request['minicms_content'];
    $cms['type'] = $request['type'];
    //$message = $lang_minicms['preview'];
} elseif ($request['id']=='new') {
    $cms['ID'] = -1;
    $cms['conid'] = $request['conid'];
    $cms['title'] = $lang_minicms['new_content'];
    $cms['content'] = '';
    $cms['type'] = $request['type'];
    //$message = $lang_minicms['new_content'];
}else {
    $query = "SELECT * FROM {$CONFIG['TABLE_CMS']} WHERE ID=$id";
    $result = cpg_db_query($query);
//GMC    if (!mysql_num_rows($result))                                          //GMC updated for PHP7 - mysql_* no longer exists
    if (!cpg_db_num_rows($result))                                              //GMC updated for PHP7
        cpg_die(CRITICAL_ERROR, $lang_minicms['non_exist'], __FILE__, __LINE__);
//GMC    $cms=mysql_fetch_array($result);                                       //GMC updated for PHP7 - mysql_* no longer exists
    $cms=cpg_db_fetch_assoc($result);                                           //GMC updated for PHP7
//GMC    mysql_free_result($result);                                            //GMC updated for PHP7 - mysql_* no longer exists
    cpg_db_free_result($result);                                                //GMC updated for PHP7
}

$cms['content'] = html_entity_decode(stripslashes($cms['content']));
$cms['message'] = (isset($message)) ? $message : '';

theme_minicms_edit($cms);

?>