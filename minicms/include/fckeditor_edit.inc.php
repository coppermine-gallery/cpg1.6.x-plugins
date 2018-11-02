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
  $HeadURL: http://svn.code.sf.net/p/coppermine/code/branches/cpg1.5.x/plugins/minicms/include/fckeditor_edit.inc.php $
  $Revision: 8021 $
  $Author: eenemeenemuu $
  $Date: 2010-11-09 04:55:00 -0500 (Tue, 09 Nov 2010) $
***************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

include("plugins/minicms/fckeditor/fckeditor.php") ;
include('include/smilies.inc.php');

function theme_minicms_edit_editor(&$cms)
{
    global $MINICMS,$referer,$lang_minicms, $CONFIG, $THEME_DIR;
    ob_start();
        echo '<SELECT name="type">';
           foreach ($MINICMS['conType'] as $key => $conType) {
             if ($key==$cms['type']) {
                echo "<OPTION selected value=\"$key\">$conType</OPTION>";
             } else {
                echo "<OPTION value=\"$key\">$conType</OPTION>";
             }
           }
        echo '</SELECT>';
    $cms['select_type']=ob_get_clean();

    print <<<EOT
        <form name="post" method="post" action="index.php?file=minicms/cms_edit&amp;referer=$referer">
EOT;
    starttable("100%", $cms['title'] , 3);
    print <<<EOT
        <tr>
            <td colspan="3" align="center">
                <h2>{$cms['message']}</h2>
            </td>
        </tr>
        <tr>
            <td>{$lang_minicms['title']}</td>
            <td>{$lang_minicms['type']}</td>
            <td>{$lang_minicms['content']}</td>
        </tr>
        <tr valign="top">
            <td class="row2">
                <input value="{$cms['ID']}" type="hidden" name="id" >
                <input type="text" value="{$cms['title']}" class="post" tabindex="1" style="width: 450px;" maxlength="60" size="45" name="title" />
            </td>
            <td class="row2">
                {$cms['select_type']}
            </td>
            <td class="row2">
                <input type="text" value="{$cms['conid']}" class="post" tabindex="3" style="width: 50px;" maxlength="5" name="conid" />
            </td>
        </tr>
        <tr valign="top">
            <td class="row2" colspan="3">
EOT;

    foreach (get_smilies_table2() as $smiley) {
        $smilies[]=$smiley[1];
    }

//$smilies="['".implode("','",$smilies)."']";
//$smilies=implode(",",$smilies);
//echo "<br>$smilies";

    $superCage = Inspekt::makeSuperCage();
    $cmpath = str_replace('index.php','', $superCage->server->getRaw('PHP_SELF'));
    $userfilespath = $cmpath . $CONFIG['fullpath'] ;
    $basepath = $cmpath . 'plugins/minicms/fckeditor/' ;

    $oFCKeditor = new FCKeditor('minicms_content') ;
    $oFCKeditor->BasePath	= $basepath;
    $oFCKeditor->Width      = '100%';
    $oFCKeditor->Height     = '350';
    $oFCKeditor->Value		= $cms['content'];
    $oFCKeditor->Config['BaseHref']        = $CONFIG['ecards_more_pic_target'];
    $oFCKeditor->Config['CustomConfigurationsPath'] = $basepath . 'minicms_config.js';
//  $oFCKeditor->Config['SmileyPath']      = $cmpath . 'images/smiles/';  //couldn't get the smilies to work
//  $oFCKeditor->Config['SmileyImages']    = $smilies;          //I posted the problem of FCK's project site
    $oFCKeditor->Config['EditorAreaCSS']     = $cmpath . $THEME_DIR . 'style.css';
    $oFCKeditor->Config['StylesXmlPath']     = $basepath . 'style.xml';
//  $oFCKeditor->Config['UseBROnCarriageReturn'] = true;  I don't think we wan't this option.
//  $oFCKeditor->Config['LinkBrowserURL']  = $basepath . 'editor/filemanager/browser/default/browser.html?Connector=connectors/php/connector.php&ServerPath='.$userfilespath;
//  $oFCKeditor->Config['ImageBrowserURL'] = $basepath . 'editor/filemanager/browser/default/browser.html?Type=Image&Connector=connectors/php/connector.php&ServerPath='.$userfilespath;
//  $oFCKeditor->Config['FlashBrowserURL'] = $basepath . 'editor/filemanager/browser/default/browser.html?Type=Flash&Connector=connectors/php/connector.php&ServerPath='.$userfilespath;
// 	$oFCKeditor->Config['MediaBrowserURL'] = $basepath . 'editor/filemanager/browser/default/browser.html?Type=Media&Connector=connectors/php/connector.php&ServerPath='.$userfilespath;
//	$oFCKeditor->Config['LinkUploadURL']   = $basepath . 'editor/filemanager/upload/php/upload.php&ServerPath='.$userfilespath;
//	$oFCKeditor->Config['ImageUploadURL']  = $basepath . 'editor/filemanager/upload/php/upload.php?Type=Image&ServerPath='.$userfilespath;
//	$oFCKeditor->Config['FlashUploadURL']  = $basepath . 'editor/filemanager/upload/php/upload.php?Type=Flash&ServerPath='.$userfilespath;
//	$oFCKeditor->Config['MediaUploadURL']  = $basepath . 'editor/filemanager/upload/php/upload.php?Type=Media&ServerPath='.$userfilespath;
//  $oFCKeditor->Config['PluginsPath'] = $basepath . 'editor/plugins/';
//  $oFCKeditor->Config['SkinPath'] = $basepath . 'editor/skins/silver/';
//  $oFCKeditor->Config['Debug'] = true;
//  $oFCKeditor->Config['UserFilesPath'] = $userfilespath;

    $oFCKeditor->Create() ;

    print <<<EOT
            </td>
        </tr>
        <tr>
            <td align="center" colspan="3" class="catBottom">
                <input value="{$lang_minicms['preview']}" class="mainoption" name="submit" tabindex="5" type="submit">&nbsp;
                <input value="{$lang_minicms['submit']}" class="mainoption" name="submit" tabindex="6" accesskey="s" type="submit">
            </td>
        </tr>
    </form>
EOT;
    endtable();

}

?>
