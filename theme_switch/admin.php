<?php
/**************************************************
  Coppermine 1.6.x Plugin - Theme switch
  *************************************************
  Copyright (c) 2010-2019 eenemeenemuu
**************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');
  
if (!GALLERY_ADMIN_MODE) {
    cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);
}

require_once "./plugins/theme_switch/lang/english.php";
if ($CONFIG['lang'] != 'english' && file_exists("./plugins/theme_switch/lang/{$CONFIG['lang']}.php")) {
    require_once "./plugins/theme_switch/lang/{$CONFIG['lang']}.php";
}

pageheader($lang_plugin_theme_switch['theme_switch']." - ".$lang_gallery_admin_menu['admin_lnk']);
$superCage = Inspekt::makeSuperCage();
global $lang_common;

if ($superCage->post->keyExists('submit')) {
    if (!checkFormToken()) {
        global $lang_errors;
        cpg_die(ERROR, $lang_errors['invalid_form_token'], __FILE__, __LINE__);
    }

    if ($superCage->post->keyExists('theme')) {
        cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '".$superCage->post->getEscaped('theme')."' WHERE name = 'theme_switch_mobile_theme'");
    }

    starttable("100%", $lang_common['information']);
    echo <<< EOT
        <tr>
            <td class="tableb" width="200">
                {$lang_plugin_theme_switch['saved']}
            </td>
        </tr>
EOT;
    endtable();
    echo '<br />';
}

echo '<form action="index.php?file=theme_switch/admin" method="post">';

starttable("100%", $lang_plugin_theme_switch['theme_switch']." - ".$lang_gallery_admin_menu['admin_lnk'], 3);
$theme = cpg_db_result(cpg_db_query("SELECT value FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'theme_switch_mobile_theme'"), 0);
foreach (form_get_foldercontent('themes/', 'folder', '', array('sample', '.svn')) as $value) {
    $selected = $theme == $value ? 'selected="selected"' : '';
    $themes .= "<option value=\"$value\" $selected>$value</option>";
}
$submit_icon = cpg_fetch_icon('ok', 1);
echo <<<EOT
    <tr>
        <td class="tableb">
            {$lang_plugin_theme_switch['select']}
        </td>
        <td class="tableb">
            <select class="listbox" name="theme">$themes</select>
        </td>
        <td class="tableb">
            <button value="{$lang_common['apply_changes']}" name="submit" class="button" type="submit">{$submit_icon}{$lang_common['apply_changes']}</button>
        </td>
    </tr>
EOT;
endtable();

list($timestamp, $form_token) = getFormToken();
echo "<input type=\"hidden\" name=\"form_token\" value=\"{$form_token}\" />";
echo "<input type=\"hidden\" name=\"timestamp\" value=\"{$timestamp}\" />";
pagefooter();

//EOF