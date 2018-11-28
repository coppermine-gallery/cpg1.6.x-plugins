<?php
/**************************************************
  Coppermine 1.6.x Plugin - Limit upload
  *************************************************
  Copyright (c) 2010-2018 eenemeenemuu
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
**************************************************/

if (!GALLERY_ADMIN_MODE) {
    cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);
}

require_once "./plugins/limit_upload/lang/english.php";
if ($CONFIG['lang'] != 'english' && file_exists("./plugins/limit_upload/lang/{$CONFIG['lang']}.php")) {
    require_once "./plugins/limit_upload/lang/{$CONFIG['lang']}.php";
}

$plugin_limit_upload_icon_array['submit'] = cpg_fetch_icon('ok', 1);

if (in_array('js/jquery.spinbutton.js', $JS['includes']) != TRUE) {
    $JS['includes'][] = 'js/jquery.spinbutton.js';
}

$JS['includes'][] = 'plugins/limit_upload/script.js';


pageheader($lang_plugin_limit_upload['limit_upload']." - ".$lang_gallery_admin_menu['admin_lnk']);
$superCage = Inspekt::makeSuperCage();
global $lang_common;

if ($superCage->post->keyExists('submit')) {
    if (!checkFormToken()) {
        global $lang_errors;
        cpg_die(ERROR, $lang_errors['invalid_form_token'], __FILE__, __LINE__);
    }

    if (is_numeric($superCage->post->getInt('upload_limit'))) {
        if ($superCage->post->getInt('upload_limit') >= 0) {
            cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '".$superCage->post->getInt('upload_limit')."' WHERE name = 'limit_upload_upload_limit'");
        }
    }

    if (array_key_exists($superCage->post->getAlpha('time_limit'), $lang_plugin_limit_upload['upload_limit_values'])) {
        cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '".$superCage->post->getAlpha('time_limit')."' WHERE name = 'limit_upload_time_limit'");
    }

    starttable("100%", $lang_common['information']);
    echo <<< EOT
        <tr>
            <td class="tableb" width="200">
                {$lang_plugin_limit_upload['saved']}
            </td>
        </tr>
EOT;
    endtable();
    echo '<br />';
}

echo '<form action="index.php?file=limit_upload/admin" method="post">';

starttable("100%", $lang_plugin_limit_upload['limit_upload']." - ".$lang_gallery_admin_menu['admin_lnk'], 3);

$upload_limit = cpg_db_result(cpg_db_query("SELECT value FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'limit_upload_upload_limit'"), 0);
$time_limit = cpg_db_result(cpg_db_query("SELECT value FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'limit_upload_time_limit'"), 0);
foreach ($lang_plugin_limit_upload['upload_limit_values'] as $key => $value) {
    $selected = $time_limit == $key ? 'selected="selected"' : '';
    $time_limit_options .= "<option value=\"$key\" $selected>$value</option>";
}
$submit_icon = cpg_fetch_icon('ok', 1);
echo <<<EOT
    <tr>
        <td class="tableb">
            {$lang_plugin_limit_upload['upload_limit']}
        </td>
        <td class="tableb">
            <input type="input" class="listbox" size="5" name="upload_limit" id="plugin_limit_upload_files" value="$upload_limit" /> <select class="listbox" name="time_limit">$time_limit_options</select>
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