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
  $HeadURL: http://svn.code.sf.net/p/coppermine/code/branches/cpg1.5.x/plugins/minicms/codebase.php $
  $Revision: 8400 $
  $Author: eenemeenemuu $
  $Date: 2012-05-09 04:36:53 -0400 (Wed, 09 May 2012) $
***************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$superCage = Inspekt::makeSuperCage();

// Add an install action
$thisplugin->add_action('plugin_install','minicms_install');
$thisplugin->add_action('plugin_configure','minicms_configure');

// Add a action
$thisplugin->add_action('page_start','minicms_page_start');

// Add a  NEW filter
//$thisplugin->add_filter('template_html','minicms_template_html');
//$thisplugin->add_filter('page_html','minicms_page_html');


// Add a filter
$thisplugin->add_action('post_breadcrumb','minicms_print'); //below the breadcrumb
$thisplugin->add_filter('plugin_block','minicms_plugin_block');


function minicms_template_html ()
{
    //place additional minicms tags in the templates.
    //search page
}

function minicms_page_html ()
{
    //extract all minicms tags
    //render them to string or array
    //replace them in the stream
}

function minicms_plugin_block($content)
{
    
    if (!strcasecmp($content[1],'minicms')) {
        print(minicms());
    }
    //return $content;
    if ($content[0]=='minicms') $content ="";
    
    return $content;
}

function minicms_print()
{
    global $CURRENT_PIC_DATA, $MINICMS;
    if (defined('DISPLAYIMAGE_PHP')) {  //$CURRENT_PIC_DATA isn't populated until the post_breadcrumb filter is called.
        $MINICMS['conid']=$CURRENT_PIC_DATA['pid'];
    }
    print(minicms());
}

function minicms($content='')
{
    global $MINICMS, $CONFIG, $cat, $album, $REFERER, $lang_minicms, $HTML_SUBST_DECODE, $cms_array;

    if ($MINICMS['dbver']!=MINICMS_DBVER) {
        echo "<h2>{$lang_minicms['minicms_full']} {$MINICMS['dbver']}</h2><br />{$lang_minicms['dbver_nomatch']}: ".MINICMS_DBVER."<br />";
        minicms_configure(false); //auto-updater and dont print the "go" button
    }

    $where = (isset($MINICMS['ID'])) ?  "ID='{$MINICMS['ID']}'" : "conid='{$MINICMS['conid']}' AND type='{$MINICMS['type']}'";
    $query = "SELECT * FROM {$CONFIG['TABLE_CMS']} WHERE $where ORDER BY cpos";

    $result = cpg_db_query($query);
    $cms_array = cpg_db_fetch_rowset($result);

    $counter=0;
    foreach ($cms_array as $key => $cms) {
        $cms_array[$key]['next_ID']=($counter<count($cms_array)-1 && $cms['type']==$cms_array[$counter+1]['type'] && $cms['conid']==$cms_array[$counter+1]['conid'] ) ? '&amp;id2='.$cms_array[$counter+1]['ID'] : '';
        $cms_array[$key]['prev_ID']=($counter>0 && $cms['type']==$cms_array[$counter-1]['type'] && $cms['conid']==$cms_array[$counter-1]['conid']) ? '&amp;id2='.$cms_array[$counter-1]['ID'] : '';
        $cms_array[$key]['content'] = html_entity_decode(stripslashes($cms['content']));
        $counter++;
    }

    ob_start();
    theme_minicms($cms_array);
    //$content.=ob_get_clean();
    $content =ob_get_clean();
    return $content;
}

function minicms_add_admin_button($href,$title,$target,$link)
{
  global $template_gallery_admin_menu;

  $new_template=$template_gallery_admin_menu;
  $button=template_extract_block($new_template,'documentation');
  $params = array(
      '{DOCUMENTATION_HREF}' => $href,
      '{DOCUMENTATION_TITLE}' => $title,
      'target="cpg_documentation"' => $target,
      '{DOCUMENTATION_LNK}' => $link,
   );
   $new_button="<!-- BEGIN $link -->".template_eval($button,$params)."<!-- END $link -->\n";
   template_extract_block($template_gallery_admin_menu,'documentation',"<!-- BEGIN documentation -->" . $button . "<!-- END documentation -->\n" . $new_button);
}

function minicms_page_start()
{
  global $lang_minicms, $lang_minicms_config, $lang_minicms_config_related_size, $lang_minicms_config_editor;
  global $CONFIG, $MINICMS, $album, $cat;
  global $HTML_SUBST, $HTML_SUBST_DECODE, $template_minicms, $REFERER, $CURRENT_PIC_DATA;
  require 'plugins/minicms/include/init.inc.php';
     
  /*if ($MINICMS['redirect_index_php'] && empty($_SERVER["QUERY_STRING"]) && strstr($_SERVER["PHP_SELF"],'index.php')) {
      header('Location: '.html_entity_decode($MINICMS['redirect_index_php']));
      exit();
  } */

  if (GALLERY_ADMIN_MODE) {
      minicms_add_admin_button('index.php?file=minicms/cms_admin',$lang_minicms['admin_title'],'',$lang_minicms['admin_title']);
      //minicms_add_admin_button('index.php?file=minicms/cms_config',$lang_minicms['config_title'],'',$lang_minicms['config_title']);
  }
}

// Install function
function minicms_install()
{
    // Install
    //if ($_REQUEST['submit']=='Go!') {
    $superCage = Inspekt::makeSuperCage();
    $action = $superCage->post->getRaw('submit');
    if ($action == 'Go!') {
        return true;

    // Loop again
    } else {
        return 1;
    }
}

/**
 * custom query for minicms_configure to avoid Coppermine from aborting out on a failed query.
 *
 * @param string $q
 * @return object mysql result
 */
function minicms_configure_query($query)
{
        global $CONFIG, $query_stats, $queries;
        global $CPGDB;                                                          // GMC updated for CPG 1.6.x
 
        $query_start = cpgGetMicroTime();
//GMC        $result = mysql_query($query, $CONFIG['LINK_ID']);                 //GMC updated for PHP7 and CPG 1.6.x. mysql_* and CONFIG['LINK_ID'] no longer exists
        $result = $CPGDB->query($query);                                        //GMC updated for PHP7 and CPG 1.6.x.
        $query_end = cpgGetMicroTime();
        if (isset($CONFIG['debug_mode']) && (($CONFIG['debug_mode']==1) || ($CONFIG['debug_mode']==2) )) {
                $duration = round($query_end - $query_start, 3);
                $query_stats[] = $duration;
                $queries[] = "$query ({$duration}s)";
        }
        return $result;
}

// Configure function
// Displays the form
function minicms_configure($stop=true)
{
    global $errors, $CONFIG, $CPG_PHP_SELF;
    global $CPGDB;                                                              // GMC updated for CPG 1.6.x
    require ('include/sql_parse.php');
     
    $db_update = 'plugins/minicms/sql/basic.sql';
    $sql_query = fread(fopen($db_update, 'r'), filesize($db_update));
    // Update table prefix
    $sql_query = preg_replace('/CPG_/', $CONFIG['TABLE_PREFIX'], $sql_query);

    $sql_query = remove_remarks($sql_query);
    $sql_query = split_sql_file($sql_query, ';');
    if(!stristr($CONFIG['main_page_layout'],'minicms')){
        $sql_query[] = "UPDATE {$CONFIG['TABLE_CONFIG']} SET value = 'minicms/".$CONFIG['main_page_layout']."'  WHERE name = 'main_page_layout'";
    }

    echo '
        <h2>Performing Database Updates<h2>
        <table class="maintable">
    ';

    foreach($sql_query as $q) {
        echo "<tr><td class='tableb'>$q</td>";
        if (minicms_configure_query($q)) {
            echo "<td class='updatesOK'>OK</td></tr>";
        } else {
            echo "<td class='updatesFail'>Already Done</td></tr>";
            echo "<tr><td class='tablef'>";
//GMC            echo mysql_errno($CONFIG['LINK_ID']) . ": " . mysql_error($CONFIG['LINK_ID']);  //GMC updated for PHP7 and CPG1.6.x. mysql_* and $CONFIG['LINK_ID'] no longer exists
            echo $CPGDB->getError();                                            //GMC updated for PHP7 and CPG1.6.x.. direct call to object - no equiv CPG wrapper function
            echo "</td><td class='tableh2_compact'>MySQL Said</td></tr>";
        }
    }

    echo "</table>";

    if ($stop) {
        $superCage = Inspekt::makeSuperCage();
        $request_uri = $superCage->server->getEscaped('REQUEST_URI');
        echo <<< EOT

        <form action="{$request_uri}" method="post">
            <input type="submit" value="Go!" name="submit" />
        </form>
EOT;
    }

}

?>