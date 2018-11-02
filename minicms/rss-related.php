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
  $HeadURL: http://svn.code.sf.net/p/coppermine/code/branches/cpg1.5.x/plugins/minicms/rss-related.php $
  $Revision: 8400 $
  $Author: eenemeenemuu $
  $Date: 2012-05-09 04:36:53 -0400 (Wed, 09 May 2012) $
***************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

require('include/init.inc.php');

if ($MINICMS['rss_enabled']==0) die($lang_minicms['no_rss']);

$req_array=array('id', 'conid', 'type', 'keyword', 'size');
foreach ($req_array as $cnf_item) {
    if ($superCage->get->keyExists($cnf_item)) {
        $request[$cnf_item] = $superCage->get->getRaw($cnf_item);
    }
    if ($superCage->post->keyExists($cnf_item)) {
        $request[$cnf_item] = $superCage->post->getRaw($cnf_item);
    }
}

if (isset($request['id'])) {
    $ID = (int)$request['id'];
}
if (isset($request['conid'])) {
    $MINICMS['conid'] = (int)$request['conid'];
}
if (isset($request['type'])) {
    $MINICMS['type'] = (int)$request['type'];
}
if (!isset($cat)) { // makes sure we don't get in a loop and can't navigate the gallery when forwarding index.php
    $cat=0;
}
if (isset($request['keyword'])) {
    $keyword = addslashes($request['keyword']);
}
if (isset($request['size'])) {
    $MINICMS['related_size'] = (array_key_exists($request['size'],$lang_minicms_config_related_size)) ? $request['size'] : $MINICMS['related_size'];
}

if (isset($ID)) {
    $query[] = " ID='$ID'";
    $REFERER .= "&amp;ID='$ID'";
}
if (isset($conid)) {
    $query[] = " conid='{$MINICMS['conid']}' AND type='{$MINICMS['type']}'";
    $REFERER .= "&amp;conid={$MINICMS['conid']}&amp;type={$MINICMS['type']}";
}
if (isset($keyword) || !count($query)) {
    $keyword=($keyword) ? $keyword : 'BLOG'; // if nothing else related looks for keyword BLOG (config setting)
    $query[] = " keywords like '%$keyword%' AND type={$MINICMS['conTypebyName']['img']}";
    $REFERER .= "&amp;keyword=$keyword";
}

$query=implode(' AND',$query);

if(count($FORBIDDEN_SET_DATA) > 0 ){
    $forbidden_set_string =" AND aid NOT IN (".implode(",", $FORBIDDEN_SET_DATA).")";
} else {
    $forbidden_set_string = '';
}

$order ="ORDER BY modified DESC ";
$query = "SELECT *, C.title as title, unix_timestamp(modified) as modified FROM {$CONFIG['TABLE_CMS']} as C , {$CONFIG['TABLE_PICTURES']} as P WHERE conid=pid AND $query $forbidden_set_string $order;";
$result = cpg_db_query($query);
//GMC if (!mysql_num_rows($result))                                             //GMC updated for PHP7 - mysql_* no longer exists
if (!cpg_db_num_rows($result))                                                  //GMC updated for PHP7
    cpg_die(CRITICAL_ERROR, $lang_minicms['non_exist'], __FILE__, __LINE__);
//GMC $cms=mysql_fetch_array($result);                                          //GMC updated for PHP7 - mysql_* no longer exists
$cms=cpg_db_fetch_assoc($result);                                               //GMC updated for PHP7
//GMC mysql_data_seek($result,0); //put the pointer back to the first entry     //GMC updated for PHP7 - mysql_* no longer exists
$CPGDB->result(0);                //put the pointer back to the first entry     //GMC updated for PHP7 - direct call to object - no CPG wrapper function

header("Content-type: text/xml");
header("Pragma: public");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    print <<<EOT
<?xml version="1.0"?>
<rss version="2.0">
<channel>
<title>{$CONFIG['gallery_name']}</title>
<link>{$CONFIG['ecards_more_pic_target']}index.php?file=minicms/related</link>
<description>{$CONFIG['gallery_description']}</description>
EOT;

//GMC while ($cms=mysql_fetch_array($result)) {                                 //GMC Updated for PHP7 - mysql_* no longer exist
while ($cms=cpg_db_fetch_assoc($result)) {                                      //GMC Updated for PHP7
    $CURRENT_PIC_DATA=$cms; //send a copy to get_pic_url it messes with the vars

    if (stristr($MINICMS['related_size'],'thumb')) {
        $cms['thumb_url'] = get_pic_url($CURRENT_PIC_DATA, 'thumb');
    } else {
        if($CONFIG['thumb_use']=='ht' && $CURRENT_PIC_DATA['pheight'] > $CONFIG['picture_width'] ){ // The wierd comparision is because only picture_width is stored
          $condition = true;
        }elseif($CONFIG['thumb_use']=='wd' && $CURRENT_PIC_DATA['pwidth'] > $CONFIG['picture_width']){
          $condition = true;
        }elseif($CONFIG['thumb_use']=='any' && max($CURRENT_PIC_DATA['pwidth'], $CURRENT_PIC_DATA['pheight']) > $CONFIG['picture_width']){
          $condition = true;
        }else{
         $condition = false;
        }
        if ($CONFIG['make_intermediate'] && $condition ) {
            $cms['thumb_url'] = get_pic_url($CURRENT_PIC_DATA, 'normal');
        } else {
            $cms['thumb_url'] = get_pic_url($CURRENT_PIC_DATA, 'fullsize');
        }
    }

    $cms['thumb_link'] = 'displayimage.php?pos='.(-$cms['pid']);
    $RFC822 = '%a, %d %b %y %T %Z';
    $cms['modified'] = localised_date($cms['modified'], $RFC822);


        $title_bar = <<<EOT
                    {$cms['title']}
EOT;

    $cms['content'] = htmlentities(strip_tags(html_entity_decode(stripslashes($cms['content'])))); //used to reverse Coppermines init.inc.php gpc processing
        //if description is longer than setting, add elipses after truncating text
        if (strlen($cms['content']) > $MINICMS['rss_description_length']) {
            $cms['content'] = substr($cms['content'],0,$MINICMS['rss_description_length']).'...';
        }

        //if config allows, include image in rss feed
      if ($MINICMS['rss_include_image']==1) {
            $rss_image = "&lt;img src=&quot;{$CONFIG['ecards_more_pic_target']}{$cms['thumb_url']}&quot; border=&quot;0&quot; align=&quot;left&quot;  alt=&quot;&quot; &gt;";
            }

    print <<<EOT

<item>
<title>{$cms['title']}</title>
<link>{$CONFIG['ecards_more_pic_target']}index.php?file=minicms/related&amp;id={$cms['ID']}</link>
<description>{$cms['content']} &lt;a href=&quot;{$CONFIG['ecards_more_pic_target']}{$cms['thumb_link']}&quot; target=&quot;_blank&quot;&gt;[{$lang_minicms['rss_more_lnk']}]$rss_image&lt;/a&gt;</description>
<pubDate>{$cms['modified']}</pubDate>
</item>
EOT;
}

//GMC mysql_free_result($result);                                               //GMC updated for PHP7 - mysql_* no longer exists
cpg_db_free_result($result);                                                    //GMC updated for PHP7


ob_end_flush();
?>
</channel>
</rss>