<?php
/**************************************************
  Coppermine 1.6.x Plugin - panorama_viewer
  *************************************************
  Copyright (c) 2009-2019 eenemeenemuu
  **************************************************/

if (!GALLERY_ADMIN_MODE) {
    cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);
}

pageheader("Panorama Viewer - ".$lang_gallery_admin_menu['admin_lnk']);
$superCage = Inspekt::makeSuperCage();
global $lang_common;


if ($superCage->post->keyExists('submit')) {
    if (!checkFormToken()) {
        global $lang_errors;
        cpg_die(ERROR, $lang_errors['invalid_form_token'], __FILE__, __LINE__);
    }

    function panorama_viewer_save_config_value($name) {
        global $CONFIG;
        $superCage = Inspekt::makeSuperCage();
        $new_value = $superCage->post->getRaw($name);

        if (!isset($CONFIG[$name])) {
            cpg_db_query("INSERT INTO {$CONFIG['TABLE_CONFIG']} (name, value) VALUES('$name', '$new_value')");
            $CONFIG[$name] = $new_value;
        } elseif ($new_value != $CONFIG[$name]) {
            cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '$new_value' WHERE name = '$name'");
            $CONFIG[$name] = $new_value;
        }
    }
    panorama_viewer_save_config_value('plugin_panorama_viewer_use_method');
    panorama_viewer_save_config_value('plugin_panorama_viewer_use_value');
    panorama_viewer_save_config_value('plugin_panorama_viewer_360_degree');

    starttable("100%", $lang_common['information']);
    echo "
        <tr>
            <td class=\"tableb\" width=\"200\">
                Settings saved
            </td>
        </tr>
    ";
    endtable();
    echo "<br />";
}


switch($CONFIG['plugin_panorama_viewer_use_method']) {
    case 'width':    $option_width_selected     = 'selected="selected"'; break;
    case 'ratio':    $option_ratio_selected     = 'selected="selected"'; break;
    case 'filename': $option_filename_selected  = 'selected="selected"'; break;
    default:         $option_all_selected       = 'selected="selected"'; break;
}
echo "<form action=\"index.php?file=panorama_viewer/admin\" method=\"post\" name=\"custform\">";
starttable("100%", "Panorama Viewer - ".$lang_gallery_admin_menu['admin_lnk'], 2);
echo <<<EOT
    <tr>
        <td class="tableb" width="200">
            Panorama detection
        </td>
        <td class="tableb">
            <select class="listbox" name="plugin_panorama_viewer_use_method">
                <option value="width" $option_width_selected>By picture width (set minimum pixel value in next line)</option>
                <option value="ratio" $option_ratio_selected>By picture ratio (set minimum width multiplier in next line)</option>
                <option value="filename" $option_filename_selected>By file name (set string in next line)</option>
                <option value="all" $option_all_selected>Apply panorama viewer code to all pictures (ignore next line)</option>
            </select>
        </td>
    </tr>
    <tr>
        <td class="tableb" width="200">
            Value
        </td>
        <td class="tableb">
            <input type="input" class="textinput" size="50" name="plugin_panorama_viewer_use_value" value="{$CONFIG['plugin_panorama_viewer_use_value']}" />
        </td>
    </tr>
    <tr>
        <td class="tableb" width="200">
            360&deg; panorama file name string
        </td>
        <td class="tableb">
            <input type="input" class="textinput" size="50" name="plugin_panorama_viewer_360_degree" value="{$CONFIG['plugin_panorama_viewer_360_degree']}" />
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

//EOF