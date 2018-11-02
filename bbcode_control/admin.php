<?php
/**************************************************
  Coppermine 1.5.x Plugin - bbcode_control
  *************************************************
  Copyright (c) 2010 eenemeenemuu
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

pageheader("BBCode Control - ".$lang_gallery_admin_menu['admin_lnk']);
$superCage = Inspekt::makeSuperCage();
global $lang_common;

// language detection
$lang = isset($CONFIG['lang']) ? $CONFIG['lang'] : 'english';
include('plugins/bbcode_control/lang/english.php');
if (in_array($lang, $enabled_languages_array) == TRUE && file_exists('plugins/bbcode_control/lang/'.$lang.'.php')) {
    include('plugins/bbcode_control/lang/'.$lang.'.php');
}

// add recently added BBCodes to database
$bbcode_tags = get_bbcode_tags('available');
foreach ($bbcode_tags as $tag) {
    insert_into_config('bbcode_control_tag_'.$tag.'_show', '1');
    insert_into_config('bbcode_control_tag_'.$tag.'_process', '1');
}

if ($superCage->post->keyExists('submit')) {
    if (!checkFormToken()) {
        global $lang_errors;
        cpg_die(ERROR, $lang_errors['invalid_form_token'], __FILE__, __LINE__);
    }

    foreach ($bbcode_tags as $tag) {
        if ($superCage->post->keyExists('show_'.$tag)) {
            cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '".$superCage->post->getInt('show_'.$tag)."' WHERE name = 'bbcode_control_tag_{$tag}_show'");
        }
        cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '".$superCage->post->getInt('process_'.$tag)."' WHERE name = 'bbcode_control_tag_{$tag}_process'");
    }

    if (is_numeric($superCage->post->getInt('limit_image_width'))) {
        if ($superCage->post->getInt('limit_image_width') >= 0) {
            cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '".$superCage->post->getInt('limit_image_width')."' WHERE name = 'bbcode_control_tag_img_max_width'");
        }
    }
    if (is_numeric($superCage->post->getInt('limit_image_height'))) {
        if ($superCage->post->getInt('limit_image_height') >= 0) {
            cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '".$superCage->post->getInt('limit_image_height')."' WHERE name = 'bbcode_control_tag_img_max_height'");
        }
    }
    cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '".$superCage->post->getInt('local_images')."' WHERE name = 'bbcode_control_tag_img_localhost_only'");

    cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '".$superCage->post->getInt('embed_code')."' WHERE name = 'bbcode_control_tag_img_embed_code'");

    starttable("100%", $lang_common['information']);
    echo "
        <tr>
            <td class=\"tableb\" width=\"200\">
                {$lang_plugin_bbcode_control['saved']}
            </td>
        </tr>
    ";
    endtable();
    echo "<br />";
}

$result = cpg_db_query("SELECT * FROM {$CONFIG['TABLE_CONFIG']} WHERE name LIKE 'bbcode_control_tag_%_show'");
while ($row = cpg_db_fetch_assoc($result)) {
    $tag = str_replace("bbcode_control_tag_", "", $row['name']);
    $tag = str_replace("_show", "", $tag);
    $bbcode_show[$tag] = $row['value'];
}


$result = cpg_db_query("SELECT * FROM {$CONFIG['TABLE_CONFIG']} WHERE name LIKE 'bbcode_control_tag_%_process'");
while ($row = cpg_db_fetch_assoc($result)) {
    $tag = str_replace("bbcode_control_tag_", "", $row['name']);
    $tag = str_replace("_process", "", $tag);
    $bbcode_process[$tag] = $row['value'];
}

echo '<form action="'.$superCage->server->getEscaped('REQUEST_URI').'" method="post">';

starttable("100%", "BBCode Control - ".$lang_gallery_admin_menu['admin_lnk'], 3);

echo "
    <tr>
        <td class=\"tableb\" width=\"200\">
            &nbsp;
        </td>
        <td class=\"tableb\">
            {$lang_plugin_bbcode_control['process_bbcode']}
        </td>
        <td class=\"tableb\">
            {$lang_plugin_bbcode_control['display_buttons']}
        </td>
    </tr>
";

$bbcode_tags = get_bbcode_tags('available');
foreach ($bbcode_tags as $tag) {
    $selected_show[0] = $selected_show[1] = $selected_show[2] = "";
    $selected_show[$bbcode_show[$tag]] = "checked=\"checked\"";
    $disabled = $bbcode_process[$tag] == 0 ? "disabled=\"disabled\"" : "";

    $selected_process[0] = $selected_process[1] = $selected_process[2] = "";
    $selected_process[$bbcode_process[$tag]] = "checked=\"checked\"";

    echo <<<EOT
        <tr>
            <td class="tableb" width="200">
                <img src="plugins/bbcode_control/images/$tag.png" class="button" /> $lang_plugin_bbcode_control[$tag]
            </td>
            <td class="tableb">
                <input type="radio" name="process_$tag" value="0" {$selected_process[0]} id="process_{$tag}0" onClick="document.getElementById('show_{$tag}0').disabled = true; document.getElementById('show_{$tag}1').disabled = true; document.getElementById('show_{$tag}2').disabled = true;" />
                <label for="process_{$tag}0" class="clickable_option">{$lang_common['no']}</label>
                <input type="radio" name="process_$tag" value="1" {$selected_process[1]} id="process_{$tag}1" onClick="document.getElementById('show_{$tag}0').disabled = false;document.getElementById('show_{$tag}1').disabled = false;document.getElementById('show_{$tag}2').disabled = false;" />
                <label for="process_{$tag}1" class="clickable_option">{$lang_common['yes']}</label>
            </td>
            <td class="tableb">
                <input type="radio" name="show_$tag" value="0" {$selected_show[0]} $disabled id="show_{$tag}0" />
                <label for="show_{$tag}0" class="clickable_option">{$lang_common['no']}</label>
                <input type="radio" name="show_$tag" value="1" {$selected_show[1]} $disabled id="show_{$tag}1" />
                <label for="show_{$tag}1" class="clickable_option">{$lang_common['yes']}: {$lang_plugin_bbcode_control['enable_admin']}</label>
                <input type="radio" name="show_$tag" value="2" {$selected_show[2]} $disabled id="show_{$tag}2" />
                <label for="show_{$tag}2" class="clickable_option">{$lang_common['yes']}: {$lang_plugin_bbcode_control['enable_all']}</label>
            </td>
        </tr>
EOT;
    $tag_all_buttons['process'][0] .= "document.getElementById('process_{$tag}0').click(); ";
    $tag_all_buttons['process'][1] .= "document.getElementById('process_{$tag}1').click(); ";
    $tag_all_buttons['show'][0] .= "document.getElementById('show_{$tag}0').checked = true; ";
    $tag_all_buttons['show'][1] .= "document.getElementById('show_{$tag}1').checked = true; ";
    $tag_all_buttons['show'][2] .= "document.getElementById('show_{$tag}2').checked = true; ";
}

echo <<<EOT
    <tr>
        <td class="tableb" width="200">
            <i>{$lang_plugin_bbcode_control['all_buttons']}</i>
        </td>
        <td class="tableb">
            <input type="radio" name="process_all_buttons" id="process_all_buttons0" onClick="{$tag_all_buttons['process'][0]}" />
            <label for="process_all_buttons0" class="clickable_option">{$lang_common['no']}</label>
            <input type="radio" name="process_all_buttons" id="process_all_buttons1" onClick="{$tag_all_buttons['process'][1]}" />
            <label for="process_all_buttons1" class="clickable_option">{$lang_common['yes']}</label>
        </td>
        <td class="tableb">
            <input type="radio" name="show_all_buttons" id="show_all_buttons0" onClick="{$tag_all_buttons['show'][0]}" />
            <label for="show_all_buttons0" class="clickable_option">{$lang_common['no']}</label>
            <input type="radio" name="show_all_buttons" id="show_all_buttons1" onClick="{$tag_all_buttons['show'][1]}" />
            <label for="show_all_buttons1" class="clickable_option">{$lang_common['yes']}: {$lang_plugin_bbcode_control['enable_admin']}</label>
            <input type="radio" name="show_all_buttons" id="show_all_buttons2" onClick="{$tag_all_buttons['show'][2]}" />
            <label for="show_all_buttons2" class="clickable_option">{$lang_common['yes']}: {$lang_plugin_bbcode_control['enable_all']}</label>
        </td>
    </tr>
EOT;

endtable();

starttable("100%", "[img] - ".$lang_gallery_admin_menu['admin_lnk'], 2);
$local_images = cpg_db_result(cpg_db_query("SELECT value FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'bbcode_control_tag_img_localhost_only'"),0);
$selected_local[0] = $selected_local[1] = "";
$selected_local[$local_images] = "checked=\"checked\"";
$max_width = cpg_db_result(cpg_db_query("SELECT value FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'bbcode_control_tag_img_max_width'"),0);
$max_height = cpg_db_result(cpg_db_query("SELECT value FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'bbcode_control_tag_img_max_height'"),0);
$embed_code = cpg_db_result(cpg_db_query("SELECT value FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'bbcode_control_tag_img_embed_code'"),0);
$selected_embed[0] = $selected_embed[1] = "";
$selected_embed[$embed_code] = "checked=\"checked\"";
echo <<<EOT
    <tr>
        <td class="tableb">
            {$lang_plugin_bbcode_control['local_images']}
        </td>
        <td class="tableb">
            <input type="radio" name="local_images" value="0" id="local_images0" {$selected_local[0]} />
            <label for="local_images0" class="clickable_option">{$lang_common['no']}</label>
            <input type="radio" name="local_images" value="1" id="local_images1" {$selected_local[1]} />
            <label for="local_images1" class="clickable_option">{$lang_common['yes']}</label>
        </td>
    </tr>
    <tr>
        <td class="tableb">
            {$lang_plugin_bbcode_control['limit_image_width']}
        </td>
        <td class="tableb">
            <input type="input" class="textinput" size="5" name="limit_image_width" value="$max_width" /> px
        </td>
    </tr>
    <tr>
        <td class="tableb">
            {$lang_plugin_bbcode_control['limit_image_height']}
        </td>
        <td class="tableb">
            <input type="input" class="textinput" size="5" name="limit_image_height" value="$max_height" /> px
        </td>
    </tr>
EOT;
endtable();

list($timestamp, $form_token) = getFormToken();
echo "<input type=\"hidden\" name=\"form_token\" value=\"{$form_token}\" />";
echo "<input type=\"hidden\" name=\"timestamp\" value=\"{$timestamp}\" />";
echo "<input type=\"submit\" value=\"{$lang_common['apply_changes']}\" name=\"submit\" class=\"button\" /> ";
echo "<input type=\"reset\" value=\"reset\" name=\"reset\" class=\"button\" /> </form>";
pagefooter();
?>
