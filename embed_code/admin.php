<?php
/**************************************************
  Coppermine 1.5.x Plugin - embed_code
  *************************************************
  Copyright (c) 2011 eenemeenemuu
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  ********************************************
  $HeadURL$
  $Revision$
  $LastChangedBy$
  $Date$
  **************************************************/

if (!GALLERY_ADMIN_MODE) {
    cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);
}

pageheader("Embed Code - ".$lang_gallery_admin_menu['admin_lnk']);
$superCage = Inspekt::makeSuperCage();
global $lang_common;

if ($superCage->post->keyExists('submit')) {
    if (!checkFormToken()) {
        global $lang_errors;
        cpg_die(ERROR, $lang_errors['invalid_form_token'], __FILE__, __LINE__);
    }
    foreach (plugin_embed_code_config_options() as $option => $text) {
        $val = $superCage->post->keyExists($option) ? 1 : 0;
        cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = {$val} WHERE name = '{$option}'");
        $CONFIG[$option] = $val;
    }

    starttable("100%", $lang_common['information']);
    echo "
        <tr>
            <td class=\"tableb\">
                {$lang_common['done']}
            </td>
        </tr>
    ";
    endtable();
    echo "<br />";
}

echo "<form action=\"index.php?file=embed_code/admin\" method=\"post\">";

starttable("100%", "Embed Code - ".$lang_gallery_admin_menu['admin_lnk'], 3);
foreach (plugin_embed_code_config_options() as $option => $text) {
    $checked = $CONFIG[$option] == 1 ? ' checked="checked"' : '';
    echo <<<EOT
        <tr>
            <td class="tableb" width="200">
                {$text}
            </td>
            <td class="tableb">
                <input type="checkbox" name="{$option}" value="{$CONFIG[$option]}" {$checked} />
            </td>
        </tr>
EOT;
}
endtable();

list($timestamp, $form_token) = getFormToken();
echo "<input type=\"hidden\" name=\"form_token\" value=\"{$form_token}\" />";
echo "<input type=\"hidden\" name=\"timestamp\" value=\"{$timestamp}\" />";
echo "<input type=\"submit\" value=\"{$lang_common['apply_changes']}\" name=\"submit\" class=\"button\" /> ";
echo "</form>";
pagefooter();

//EOF