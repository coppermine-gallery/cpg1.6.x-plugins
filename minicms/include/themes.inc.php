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
  $HeadURL: http://svn.code.sf.net/p/coppermine/code/branches/cpg1.5.x/plugins/minicms/include/themes.inc.php $
  $Revision: 8400 $
  $Author: eenemeenemuu $
  $Date: 2012-05-09 04:36:53 -0400 (Wed, 09 May 2012) $
***************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

// define('HTML_EDITOR','htmlarea'); //no longer supported by the htmlarea community
// define('HTML_EDITOR','tinymce'); //only limited functionality
// define('HTML_EDITOR','fckeditor'); //default
define('HTML_EDITOR',$MINICMS['editor']); //use the configured editor

if (isset($request['file'])&& stristr($request['file'],'minicms/cms_edit')) {
    require 'plugins/minicms/include/'.HTML_EDITOR.'_edit.inc.php';
}

// begin examples for pages

/* Example template variable
 * if (!isset($template_minicms['item']))
 *     $template_minicms['item'] = <<<EOT
 * EOT;
 */

/* Example template function
 * if (!function_exists('theme_minicms_item')) {
 *     function theme_minicms_item($data)
 *     {
 *         $params = array(
 *             '{ITEM1}'     => $data[0],
 *             '{ITEM2}'   => $data[1],
 *             '{ITEM3}'   => $data[2],
 *             );
 *        return template_eval($template_minicms_item, $params);
 *     }
 * }
 */

// end examples for pages

// begin cms_edit page

// adds output to the <head> section
if (!isset($template_minicms['edit_meta']))
    $template_minicms['edit_meta'] = <<<EOT
EOT;

// outputs the preview
if (!function_exists('theme_minicms_edit_preview'))
{
    function theme_minicms_edit_preview(&$cms)
    {
        global $lang_minicms;

        //echo '<h1>' . $lang_minicms['preview'] . '</h1>';

        //show content title if it exists; show placeholder text if it does not
        $content_title = $cms['title'];
        if ($content_title != NULL) {
            starttable("100%", $cms['title']);
        } else {
            starttable("100%", "{$lang_minicms['new_content']}");
        }
        print <<<EOT
            <tr>
                <td class="tableb">
                    {$cms['content']}
                </td>
            </tr>
EOT;
        endtable();
    }
}

// outputs the main editor area
if (!function_exists('theme_minicms_edit_editor'))
{
    function theme_minicms_edit_editor(&$cms)
    {
        global $MINICMS,$referer,$lang_minicms;
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
                    <textarea style="width:100%;" rows="24" cols="80" name="minicms_content" id="minicms_content" tabindex="4">{$cms['content']}</textarea>
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
}

// outputs the cms_edit page
if (!function_exists('theme_minicms_edit'))
{
    function theme_minicms_edit(&$cms)
    {
        global $template_minicms, $lang_minicms;
        $superCage = Inspekt::makeSuperCage();
        pageheader($cms['title'], $template_minicms['edit_meta']);
        if ($superCage->post->getRaw('submit') == $lang_minicms['preview']) theme_minicms_edit_preview($cms);
        theme_minicms_edit_editor($cms);
        pagefooter();
    }
}

// end cms_edit page

// begin article display
if (!isset($template_minicms['title_admin']))
$template_minicms['title_admin'] =<<<EOT
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%">
                            {CMS_TITLE}
                        </td>
                        <td>
                                 <img src="images/spacer.gif" width="85" height="1" style="display:block" alt="" />
                                 <a title="{$lang_minicms['delete']}" href="index.php?file=minicms/cms_admin&amp;delete&amp;id={CMS_ID}&amp;referer={$REFERER}"><img src="images/icons/delete.png" border="0" alt="{$lang_minicms['delete']}" style="display:inline" /></a>
                                 <a title="{$lang_minicms['pos_up']}" href="index.php?file=minicms/cms_admin&amp;up&amp;id={CMS_ID}{CMS_PREV_ID}&amp;cpos={CMS_CPOS}&amp;referer={$REFERER}"><img src="images/icons/up.png" border="0" alt="{$lang_minicms['pos_up']}" style="display:inline" /></a>
                                 <a title="{$lang_minicms['pos_down']}" href="index.php?file=minicms/cms_admin&amp;down&amp;id={CMS_ID}{CMS_NEXT_ID}&amp;cpos={CMS_CPOS}&amp;referer={$REFERER}"><img src="images/icons/down.png" border="0" alt="{$lang_minicms['pos_down']}" style="display:inline" /></a>
                                 <a title="{$lang_minicms['edit']}" href="index.php?file=minicms/cms_edit&amp;id={CMS_ID}&amp;referer={$REFERER}"><img src="images/icons/edit.png" border="0" alt="{$lang_minicms['edit']}" style="display:inline" /></a>
                        </td>
                    </tr>
                </table>

EOT;

// template for the actual cms article content
if (!isset($template_minicms['content']))
$template_minicms['content']=<<<EOT
        <tr><td colspan="2" class="tableb">
        {CMS_CONTENT}
        </td></tr>
EOT;

// template for the placeholder to allow the admin to add new articles attached to current coppermine object
if (!isset($template_minicms['addnew']))
$template_minicms['addnew']=<<<EOT
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="100%">
                                         {$lang_minicms['minicms']}
                                </td>
                                <td>
                                         <img src="images/spacer.gif" width="20" height="1" style="display:block" alt="" />
                                             <a title="{$lang_minicms['edit']}" href="index.php?file=minicms/cms_edit&amp;id=new&amp;conid={CONID}&amp;type={TYPE}&amp;referer={$REFERER}"><img src="images/icons/edit.png" border="0" alt="{$lang_minicms['edit']}" style="display:inline" /></a>
                                </td>
                            </tr>
            </table>
EOT;

// outputs a cms article
if (!function_exists('theme_minicms'))
{
    function theme_minicms(&$cms_array)
    {
        global $template_minicms, $MINICMS;

        foreach ($cms_array as $cms) {

            if (GALLERY_ADMIN_MODE) {
                $params = array(
                    '{CMS_ID}' => $cms['ID'],
                    '{CMS_TITLE}' => $cms['title'],
                    '{CMS_CPOS}' => $cms['cpos'],
                    '{CMS_NEXT_ID}' => $cms['next_ID'],
                    '{CMS_PREV_ID}' => $cms['prev_ID'],
                );
                $title_bar = template_eval($template_minicms['title_admin'], $params);
            } else {
                $title_bar = $cms['title'];
            }

            starttable("100%", $title_bar, 2);
            $params = array(
                '{CMS_CONTENT}' => $cms['content'],
            );
            echo template_eval($template_minicms['content'],$params);

            endtable();
        }

        if (GALLERY_ADMIN_MODE && $MINICMS['conid'] !== '' && $MINICMS['type'] !== '') {
            $params=array(
                '{CONID}' => $MINICMS['conid'],
                '{TYPE}' => $MINICMS['type'],
            );
            $title_bar = template_eval($template_minicms['addnew'],$params);
            starttable("100%", $title_bar, 2);
            endtable();
        }
    }
}
// end article display


?>