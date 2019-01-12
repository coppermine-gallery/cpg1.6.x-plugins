<?php
/**************************************************
  Coppermine 1.6.x Plugin - remote_videos
  *************************************************
  Copyright (c) 2009-2019 eenemeenemuu
  **************************************************/

if (!GALLERY_ADMIN_MODE) {
    cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);
}

pageheader("Remote Videos - ".$lang_gallery_admin_menu['admin_lnk']);
$superCage = Inspekt::makeSuperCage();
global $lang_common;

if ($superCage->post->keyExists('submit')) {
    if (!checkFormToken()) {
        global $lang_errors;
        cpg_die(ERROR, $lang_errors['invalid_form_token'], __FILE__, __LINE__);
    }

    foreach(remote_videos_get_hoster() as $filetype => $value) {
        global $CONFIG;
        if ($superCage->post->getInt($filetype) == 1) {
            if (strpos($CONFIG['allowed_mov_types'], $filetype) === FALSE) {
                $CONFIG['allowed_mov_types'] .= "/{$filetype}";
            }
            if (cpg_db_result(cpg_db_query("SELECT COUNT(*) FROM {$CONFIG['TABLE_FILETYPES']} WHERE extension = '{$filetype}'"),0) == "0") {
                cpg_db_query("INSERT INTO {$CONFIG['TABLE_FILETYPES']} (extension,mime,content,player) VALUES ('{$filetype}','application/x-shockwave-flash','movie','SWF')");
            }
        } else {
            $CONFIG['allowed_mov_types'] = str_replace("/{$filetype}", '', $CONFIG['allowed_mov_types']);
            $CONFIG['allowed_mov_types'] = str_replace("{$filetype}/", '', $CONFIG['allowed_mov_types']);
            $CONFIG['allowed_mov_types'] = str_replace("{$filetype}", '', $CONFIG['allowed_mov_types']);
        }
        cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '{$CONFIG['allowed_mov_types']}' WHERE name = 'allowed_mov_types'");
    }

    function remote_videos_save_value($name) {
        if (!GALLERY_ADMIN_MODE) {
            global $lang_errors;
            cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);
        }
        global $CONFIG;
        $superCage = Inspekt::makeSuperCage();
        if ($name == 'remote_video_vine_mode') {
            $new_value = $superCage->post->getAlpha($name);
        } else {
            $new_value = $superCage->post->getInt($name);
        }
        
        if ($new_value >= 0) {
            if (!isset($CONFIG[$name])) {
                cpg_db_query("INSERT INTO {$CONFIG['TABLE_CONFIG']} (name, value) VALUES('$name', '$new_value')");
                $CONFIG[$name] = $new_value;
            } elseif ($new_value != $CONFIG[$name]) {
                cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '$new_value' WHERE name = '$name'");
                $CONFIG[$name] = $new_value;
            }
        }
    }
    remote_videos_save_value('remote_video_movie_width');
    remote_videos_save_value('remote_video_movie_height');
    remote_videos_save_value('remote_video_vine_mode');
    remote_videos_save_value('remote_video_vine_autoaudio');

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


echo "<form action=\"index.php?file=remote_videos/admin\" method=\"post\" name=\"custform\">";
starttable("100%", "Remote Videos - ".$lang_gallery_admin_menu['admin_lnk'], 3);
echo "
    <tr>
        <td class=\"tableb\" width=\"200\">
            <strong>Hoster</strong>
        </td>
        <td class=\"tableb\" width=\"200\">
            <strong>Extension</strong>
        </td>
        <td class=\"tableb\">
            <strong>Allow new uploads</strong>
        </td>
    </tr>
";

foreach(remote_videos_get_hoster() as $key => $value) {
    global $CONFIG;
    $checked = is_numeric(strpos($CONFIG['allowed_mov_types'], $key)) ? "checked=\"checked\" " : "";
    echo "
        <tr>
            <td class=\"tableb\" width=\"200\">
                $value
            </td>
            <td class=\"tableb\" width=\"200\">
                .$key
            </td>
            <td class=\"tableb\">
                <input type=\"checkbox\" class=\"checkbox\" name=\"$key\" value=\"1\" {$checked}/>
            </td>
        </tr>
    ";
}

echo "
    <script type=\"text/javascript\">
    function selectall(el)
    {
        var checked = el.checked;
        var elements = el.form.elements;
        for(var i = 0; i < elements.length;i++)
            if(elements[i].type.toLowerCase() == 'checkbox') elements[i].checked = checked;
    }
    </script>

    <tr>
        <td class=\"tableb\" width=\"200\">
            
        </td>
        <td class=\"tableb\" width=\"200\">
            &nbsp;
        </td>
        <td class=\"tableb\">
            <input type=\"checkbox\" class=\"checkbox\" name=\"selectall\" onclick=\"window.selectall(this);\"> <i>select all</i>
        </td>
    </tr>
";
endtable();

$movie_width = $CONFIG['remote_video_movie_width'] ? $CONFIG['remote_video_movie_width'] : 0;
$movie_height = $CONFIG['remote_video_movie_height'] ? $CONFIG['remote_video_movie_height'] : 0;
starttable("100%", "Overwrite default video dimensions", 2);
echo <<<EOT
    <tr>
        <td class="tableb" width="200">
            Width (0 = use default)
        </td>
        <td class="tableb">
            <input type="input" class="textinput" size="5" name="remote_video_movie_width" value="$movie_width" /> px
        </td>
    </tr>
    <tr>
        <td class="tableb" width="200">
            Height (0 = use default) 
        </td>
        <td class="tableb">
            <input type="input" class="textinput" size="5" name="remote_video_movie_height" value="$movie_height" /> px
        </td>
    </tr>
EOT;
endtable();

$default_vine_mode = strlen($CONFIG['remote_video_vine_mode']) > 0 ? $CONFIG['remote_video_vine_mode'] : 'simple';
$default_vine_autoaudio = $CONFIG['remote_video_vine_autoaudio'] ? $CONFIG['remote_video_vine_autoaudio'] : 0;
starttable("100%", "Vine Options", 2);
echo <<<EOT
<tr>
        <td class="tableb" width="200">
            Mode (default = simple)
        </td>
        <td class="tableb">
            <select name="remote_video_vine_mode">
EOT;
echo '<option value="postcard" '.($default_vine_mode == 'postcard' ? 'selected="selected"' : '').'>Postcard</option>';
echo '<option value="simple" '.($default_vine_mode == 'simple' ? 'selected="selected"' : '').'>Simple</option>';
echo <<<EOT
<tr>
        <td class="tableb" width="200">
            Start with audio (default = off)
        </td>
        <td class="tableb">
            <select name="remote_video_vine_autoaudio">
EOT;
echo '<option value="0" '.($default_vine_autoaudio == 0 ? 'selected="selected"' : '').'>Off</option>';
echo '<option value="1" '.($default_vine_autoaudio == 1 ? 'selected="selected"' : '').'>On</option>';
echo <<<EOT
            </select>
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