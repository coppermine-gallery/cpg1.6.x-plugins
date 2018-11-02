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
  3.0 Migrated to Coppermine 1.5 by Hallvard Natvik <hallvard@natvik.com>
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.
  *************************************************
  Coppermine version: 1.5.x
  $HeadURL: http://svn.code.sf.net/p/coppermine/code/branches/cpg1.5.x/plugins/minicms/cms_config.php $
  $Revision: 8021 $
  $Author: eenemeenemuu $
  $Date: 2010-11-09 04:55:00 -0500 (Tue, 09 Nov 2010) $
***************************************************/

//require_once('include/init.inc.php');
require_once('plugins/minicms/include/init.inc.php');
$superCage = Inspekt::makeSuperCage();
$post=array();

if (!GALLERY_ADMIN_MODE) cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);



foreach ($lang_minicms_config as $cnf_item) {
    if ($val=$superCage->post->getRaw($cnf_item[1])) {
        $post[$cnf_item[1]]=$val;
    }
}
if ($val=$superCage->post->getRaw('update_config')) {
        $post['update_config']=$val;
    }

/*echo "hallvard";
print_r($lang_minicms_config);
echo "(val)<br />\n";
print_r($post);
die("death");*/

if (count($post) > 0) {
    if (isset($post['update_config'])) {
        $need_to_be_positive = array();

        foreach ($need_to_be_positive as $parameter)
        $post[$parameter] = max(1, (int)$post[$parameter]);

        foreach($lang_minicms_config as $element) {
            if ((is_array($element))) {
                if (!isset($post[$element[1]])) /*cpg_die(CRITICAL_ERROR, "Missing admin value for '{$element[1]}'", __FILE__, __LINE__);*/ continue;
                $value = addslashes($post[$element[1]]);
                if ($MINICMS[$element[1]] !== stripslashes($value))
                     {
                        cpg_db_query("UPDATE {$CONFIG['TABLE_CMS_CONFIG']} SET value = '$value' WHERE name = '{$element[1]}'");
                        if ($CONFIG['log_mode'] == CPG_LOG_ALL) {
                                log_write('CONFIG UPDATE SQL: '.
                                          "UPDATE {$CONFIG['TABLE_CMS_CONFIG']} SET value = '$value' WHERE name = '{$element[1]}'\n".
                                          'TIME: '.date("F j, Y, g:i a")."\n".
                                          'USER: '.$USER_DATA['user_name'],
                                          CPG_DATABASE_LOG
                                          );
                        }
                }
            }
        }
        pageheader($lang_minicms['minicms']);
        msg_box($lang_minicms['minicms'], $lang_minicms['page_success'], $lang_common['continue'], 'index.php');

    }

        pagefooter();
        exit;
} 



pageheader($lang_minicms['minicms']);

$signature = 'Coppermine Photo Gallery ' . COPPERMINE_VERSION . ' ('. COPPERMINE_VERSION_STATUS . ')';

//echo "<form action=\"$PHP_SELF\" method=\"post\">";
echo "<form action=\"".$CPG_PHP_SELF.'?file=minicms/cms_config'."\" method=\"post\">";
starttable('100%', "{$lang_minicms['minicms']} - $signature", 2);

create_form($lang_minicms_config);

echo '</table></td></tr>';

echo <<<EOT
                <tr>
                        <td align="left" class="tablef">
                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                <tr>
                                    <td width="67%" align="center">
                                        <input type="submit" class="button" name="update_config" value="{$lang_common['continue']}" />
                                &nbsp;&nbsp;
                                    </td>
                                </tr>
                            </table>
                        </td>
                </tr>
EOT;
endtable();
echo '</form>';
pagefooter();
ob_end_flush();


//=================Functions


function form_label($text)
{
        global $lang_admin_php;

        static $cmi = 0;
        static $open = false;

        if ($open){
        echo <<< EOT
                                </table>
                        </td>
                </tr>
EOT;
        }
        echo <<< EOT
                <tr>
                        <td class="tableh2" colspan="2">
                                <b>$text</b>
                        </td>
                </tr>
                <tr>
                        <td>
                                <table align="center" width="100%" cellspacing="1" cellpadding="0" class="maintable" id="section{$cmi}" border="0">
EOT;

        $open = true;
        $cmi++;
}

function form_input($text, $name, $help = '')
{
    global $MINICMS;

    $value = $MINICMS[$name];
    $help = cpg_display_help($help);

    $type = ($name == 'smtp_password') ? 'password' : 'text';


    echo <<<EOT
                <tr>
                        <td width="60%" class="tableb">
                                $text
                        </td>
                        <td width="50%" class="tableb" valign="top">
                            <input type="$type" class="textinput" style="width: 100%" name="$name" value="$value"/>
                        </td>
                        <!-- td class="tableb" width="10%">
                                $help
                        </td -->
        </tr>

EOT;
}

function form_yes_no($text, $name, $help = '')
{
    //global $MINICMS, $lang_yes, $lang_no;
    global $MINICMS, $lang_common;
    $lang_yes =$lang_common['yes'] ;
    $lang_no =$lang_common['no'] ;
    $help = cpg_display_help($help);

    $value = $MINICMS[$name];
    $yes_selected = $value ? 'checked="checked"' : '';
    $no_selected = !$value ? 'checked="checked"' : '';

    echo <<<EOT
        <tr>
                        <td class="tableb" width="60%">
                                $text
                        </td>
                        <td class="tableb" valign="top" width="50%">
                                <input type="radio" id="{$name}1" name="$name" value="1" $yes_selected/><label for="{$name}1" class="clickable_option">$lang_yes</label>
                                &nbsp;&nbsp;
                                <input type="radio" id="{$name}0" name="$name" value="0" $no_selected/><label for="{$name}0" class="clickable_option">$lang_no</label>
                        </td>
                        <!-- td class="tableb" width="10%">
                                $help
                        </td -->
        </tr>

EOT;
}


function form_listbox($text, $name, $help = '', $options)
{
    global $MINICMS;
    // I left this one in as an example

    $help = cpg_display_help($help);

    $value = strtolower($MINICMS[$name]);

    echo <<<EOT
        <tr>
            <td class="tableb" width="60%">
                        $text
        </td>
        <td class="tableb" valign="top" width="50%">
                        <select name="$name" class="listbox">

EOT;
    foreach ($options as $key => $option) {
        echo "                                <option value=\"$key\" " . ($value == $option ? 'selected="selected"' : '') . ">$option</option>\n";
    }
    echo <<<EOT
                        </select>
                </td>
					<!-- td class="tableb" width="10%">
                $help
					</td -->
        </tr>

EOT;
}


function form_number_dropdown($text, $name, $help = '')
{
   global $MINICMS, $lang_admin_php ;
   $help = cpg_display_help($help);
   //left this one in as an example

    echo <<<EOT
        <tr>
            <td class="tableb" width="60%">
                        $text
        </td>
        <td class="tableb" valign="top" width="50%">
                        <select name="$name" class="listbox">
EOT;
        for ($i = 5; $i <= 25; $i++) {
        echo "<option value=\"".$i."\"";
        if ($i == $MINICMS[$name]) { echo " selected=\"selected\"";}
        echo ">".$i."</option>\n";
        }
     echo <<<EOT
     </select>
                </td>
					<!-- td class="tableb" width="10%">
                $help
					</td -->
        </tr>
EOT;
}


function create_form(&$data)
{
        global $options_to_disable, $MINICMS;

    foreach($data as $element) {
        if ((is_array($element))) {
                $element[3] = (isset($element[3])) ? $element[3] : '';
            switch ($element[2]) {
                case 0 :
                    form_input($element[0], $element[1], $element[3]);
                    break;
                case 1 :
                    form_yes_no($element[0], $element[1], $element[3]);
                    break;
                case 3 :
                    form_listbox($element[0],$element[1], $element[3],$element[4]);
                    break;
                default:
                    die('Invalid action');
            } // switch
        } else {
                form_label($element);
        }
    }
}

?>
