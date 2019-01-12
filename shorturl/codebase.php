<?php
/**************************************************
  Coppermine 1.6.x Plugin - ShortURL
  *************************************************
  Copyright (c) 2009-2019 eenemeenemuu
  **************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$thisplugin->add_action('page_start', 'shorturl_page_start');

function shorturl_page_start() {
    if(defined('INDEX_PHP')) {
        global $CONFIG, $lang_common, $lang_errors, $cpg_udb, $lang_gallery_admin_menu;
        require "./plugins/shorturl/lang/english.php";
        if ($CONFIG['lang'] != 'english' && file_exists("./plugins/shorturl/lang/{$CONFIG['lang']}.php")) {
            require "./plugins/shorturl/lang/{$CONFIG['lang']}.php";
        }
        $superCage = Inspekt::MakeSuperCage();
        if ($superCage->get->keyExists('c')) header("Location: index.php?cat=".$superCage->get->getInt('c'));
        if ($superCage->get->keyExists('a')) header("Location: thumbnails.php?album=".$superCage->get->getInt('a'));
        if ($superCage->get->keyExists('p')) header("Location: displayimage.php?pid=".$superCage->get->getInt('p'));
        if ($superCage->get->keyExists('r')) {
            $result = cpg_db_query("SELECT url FROM {$CONFIG['TABLE_PREFIX']}plugin_shorturl WHERE rid = ".$superCage->get->getInt('r'));
            $url = cpg_db_result($result, 0);
            cpg_db_free_result($result);
            if ($CONFIG['plugin_shorturl_preview'] == 1 || $superCage->get->keyExists('preview')) {
                load_template();
                pageheader($lang_plugin_shorturl['redirection_preview']);
                starttable('100%', $lang_plugin_shorturl['redirection_preview']);
                echo <<<EOT
                    <tr>
                        <td class="tableb">
                            <a href="$url" class="external">$url</a>
                        </td>
                    </tr>
EOT;
                endtable();
                pagefooter();
                exit;
            } else {
                header("Location: $url");
            }
        }
        if ($superCage->get->keyExists('shorturl')) {
            if ($superCage->get->getAlpha('shorturl') == 'config') {
                if (!GALLERY_ADMIN_MODE) {
                    load_template();
                    cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);
                }

                if ($superCage->post->keyExists('submit') == TRUE) {
                    if(!checkFormToken()){
                        load_template();
                        cpg_die(ERROR, $lang_errors['invalid_form_token'], __FILE__, __LINE__);
                    }

                    $superCage = Inspekt::makeSuperCage();

                    if (!isset($CONFIG['plugin_shorturl_preview'])) {
                        cpg_db_query("INSERT INTO {$CONFIG['TABLE_CONFIG']} (name, value) VALUES('plugin_shorturl_preview', '".$superCage->post->getInt('plugin_shorturl_preview')."')");
                    } else {
                        cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '".$superCage->post->getInt('plugin_shorturl_preview')."' WHERE name = 'plugin_shorturl_preview'");
                    }
                    $CONFIG['plugin_shorturl_preview'] = $superCage->post->getInt('plugin_shorturl_preview');

                    $result = cpg_db_query("SELECT group_id FROM {$CONFIG['TABLE_USERGROUPS']} WHERE has_admin_access != '1'");
                    while($row = cpg_db_fetch_assoc($result)) {
                        if (!isset($CONFIG['plugin_shorturl_permissions_'.$row['group_id']])) {
                            cpg_db_query("INSERT INTO {$CONFIG['TABLE_CONFIG']} (name, value) VALUES('plugin_shorturl_permissions_{$row['group_id']}', '".$superCage->post->getInt('plugin_shorturl_permissions_'.$row['group_id'])."')");
                        } else {
                            cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '".$superCage->post->getInt('plugin_shorturl_permissions_'.$row['group_id'])."' WHERE name = 'plugin_shorturl_permissions_{$row['group_id']}'");
                        }
                        $CONFIG['plugin_shorturl_permissions_'.$row['group_id']] = $superCage->post->getInt('plugin_shorturl_permissions_'.$row['group_id']);
                    }
                    cpg_db_free_result($result);
                }

                load_template();
                pageheader($lang_plugin_shorturl['plugin_name'].' '.$lang_gallery_admin_menu['admin_lnk']);

                $permissions = "";
                $result = cpg_db_query("SELECT group_id, group_name FROM {$CONFIG['TABLE_USERGROUPS']} ORDER BY group_id ASC");
                while($row = cpg_db_fetch_assoc($result)) {
                    if (in_array($row['group_id'], $cpg_udb->admingroups)) {
                        $permissions .= <<< EOT
                            <tr>
                                <td valign="top" align="left" class="tableb">
                                    {$row['group_name']}
                                </td>
                                <td valign="top" align="center" class="tableb">
                                    <input type="radio" class="radio" disabled="disabled" />
                                </td>
                                <td valign="top" align="center" class="tableb">
                                    <input type="radio" class="radio" checked="checked" />
                                </td>
                            </tr>
EOT;
                    } else {
                        $row['permission'] = cpg_db_result(cpg_db_query("SELECT value FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_shorturl_permissions_{$row['group_id']}'"),0);
                        $permissions .= <<< EOT
                            <tr>
                                <td valign="top" align="left" class="tableb">
                                    {$row['group_name']}
                                </td>
EOT;
                        for ($i=0; $i <= 1; $i++) {
                            if (!is_numeric($row['permission']) && $i == 0) {
                                $checked = "checked=\"checked\"";
                            } else {
                                $checked = $row['permission'] == $i ? "checked=\"checked\"" : "";
                            }
                            $permissions .= <<< EOT
                                <td valign="top" align="center" class="tableb">
                                    <input type="radio" name="plugin_shorturl_permissions_{$row['group_id']}" id="plugin_shorturl_permissions_{$row['group_id']}_{$i}" class="radio" value="{$i}" $checked />
                                </td>
EOT;
                        }
                        $permissions .= <<< EOT
                            </tr>
EOT;
                    }
                }
                cpg_db_free_result($result);

                $preview = "";
                for ($i=0; $i <= 1; $i++) {
                    $checked = $CONFIG['plugin_shorturl_preview'] == $i ? "checked=\"checked\"" : "";
                    $preview .= <<< EOT
                        <td valign="top" align="center" class="tableb">
                            <input type="radio" name="plugin_shorturl_preview" id="plugin_shorturl_preview_{$i}" class="radio" value="{$i}" $checked />
                        </td>
EOT;
                }

                list($timestamp, $form_token) = getFormToken();

                echo <<< EOT
                    <form action="" method="post" name="shorturl_config" id="shorturl_config">
EOT;
                starttable('100%', $lang_plugin_shorturl['plugin_name'].' '.$lang_gallery_admin_menu['admin_lnk'], 3);
                echo <<<EOT
                    <tr>
                        <td valign="top" class="tableb">
                            {$lang_plugin_shorturl['display_menu_button']}
                        </td>
                        <td valign="top" class="tableb" colspan="2">
                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                <tr>
                                    <th valign="top" align="left" class="tableh2">
                                        {$lang_plugin_shorturl['group']}
                                    </th>
                                    <th valign="top" align="center" class="tableh2">
                                        {$lang_common['no']}
                                    </th>
                                    <th valign="top" align="center" class="tableh2">
                                        {$lang_common['yes']}
                                    </th>
                                </tr>
                                $permissions
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="tableb">
                            {$lang_plugin_shorturl['show_redirection_preview']}
                        </td>
                        <td class="tableb">
                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                <tr>
                                    <th valign="top" align="center" class="tableh2">
                                        {$lang_common['no']}
                                    </th>
                                    <th valign="top" align="center" class="tableh2">
                                        {$lang_common['yes']}
                                    </th>
                                </tr>
                                $preview
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle" class="tablef">
                        </td>
                        <td valign="middle" class="tablef" colspan="2">
                            <input type="hidden" name="form_token" value="{$form_token}" />
                            <input type="hidden" name="timestamp" value="{$timestamp}" />
                            <button type="submit" class="button" name="submit" value="{$lang_common['ok']}">{$annotate_icon_array['ok']}{$lang_common['ok']}</button>
                        </td>
                    </tr>
EOT;
                endtable();
                pagefooter();
                exit;
            }

            if ($superCage->get->getAlpha('shorturl') == 'add') {
                if (shorturl_get_permission() == 0) {
                    global $lang_errors;
                    load_template();
                    cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);
                }

                if ($superCage->post->keyExists('url')) {
                    js_include('plugins/shorturl/jquery.copy.js');
                    load_template();
                    pageheader($lang_plugin_shorturl['your_url']);
                    starttable('100%', $lang_plugin_shorturl['your_url'], 2);
                    echo <<< EOT
                        <tr>
                            <td class="tableb">
EOT;
                    $regex = '^'
                            .'(https?://){1,1}' // leading 'http://' or 'https://'
                            .'(([0-9a-z_!~*\'().&=+$%-]+: ){0,1}' //password, separated with a colon
                            .'[0-9a-z_!~*\'().&=+$%-]+@){0,1}' //username, separated with an @
                            .'(([0-9]{1,3}\.){3}[0-9]{1,3}' // IP- 199.194.52.184
                            .'|' // allows either IP or domain
                            .'(' // domain start
                            .'([0-9a-z_!~*\'()-]+\.)*' // tertiary domain(s)- www.
                            .'([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\.' // second level domain
                            .'[a-z]{2,6}' // first level domain- .com or .museum
                            .')' // domain end
                            .')' // end of domain / IP address
                            .'(:[0-9]{1,4}){0,1}' // port number- :80
                            .'((/?)|' // a slash isn't required if there is no file name
                            .'(/[0-9a-zA-Z_!~*\'().;?:@&=+$,%\#-]+)+/?)'
                            .'$';
                    $url = $superCage->post->getRaw('url');
                    if(!preg_match('#' . $regex . '#i', $url)) {
                        echo $lang_plugin_shorturl['invalid_url'].": <tt>$url</tt> <br/> <form action=\"javascript:history.back();\"><button type=\"submit\" class=\"button\">{$lang_common['back']}</button></form>";
                    } else {
                        $result = cpg_db_query("SELECT rid FROM {$CONFIG['TABLE_PREFIX']}plugin_shorturl WHERE url = '$url'");
                        if (cpg_db_num_rows($result) > 0) {
                            $rid = cpg_db_result($result, 0);
                        } else {
                            cpg_db_query("INSERT INTO {$CONFIG['TABLE_PREFIX']}plugin_shorturl (url) VALUES ('$url')");
                            $result = cpg_db_query("SELECT rid FROM {$CONFIG['TABLE_PREFIX']}plugin_shorturl WHERE url = '$url'");
                            $rid = cpg_db_result($result, 0);
                        }
                        cpg_db_free_result($result);
                        $length = strlen($CONFIG['ecards_more_pic_target']."?r=$rid") + 20;
                        $preview_status = sprintf($lang_plugin_shorturl['preview_status'], ($CONFIG['plugin_shorturl_preview'] == 1 ? $lang_plugin_shorturl['enabled'] : $lang_plugin_shorturl['disabled']));
                        echo <<< EOT
                            <input id="shorturl" type="text" name="url" size="$length" class="textinput" value="{$CONFIG['ecards_more_pic_target']}?r=$rid" readonly="readonly" onclick="$(this).select();" />
                            <span style="cursor:help;" title="$preview_status">{$lang_plugin_shorturl['immediate_redirection']}</span>
                            <br />
                            <input id="shorturl_p" type="text" name="url" size="$length" class="textinput" value="{$CONFIG['ecards_more_pic_target']}?r=$rid&amp;preview" readonly="readonly" onclick="$(this).select();" />
                            {$lang_plugin_shorturl['display_link']}
EOT;
                    }
                    echo <<< EOT
                            </td>
                        </tr>
EOT;
                    endtable();
                    pagefooter();
                    exit;
                } else {
                    load_template();
                    pageheader($lang_plugin_shorturl['create_url']);
                    echo '<form method="post">';
                    starttable('100%', $lang_plugin_shorturl['enter_url'], 2);
                    list($timestamp, $form_token) = getFormToken();
                    echo <<< EOT
                        <tr>
                            <td class="tableb">
                                <input type="text" id="url" name="url" size="40" class="textinput" style="width:90%;" />
                                <input type="hidden" name="form_token" value="{$form_token}" />
                                <input type="hidden" name="timestamp" value="{$timestamp}" />
                            </td>
                            <td class="tableb">
                                <input type="submit" name="commit" class="button" value="{$lang_plugin_shorturl['shorten']}" />
                            </td>
                        </tr>
EOT;
                    endtable();
                    echo '</form>';
                    echo '<script type="text/javascript">$(document).ready(function() { $("#url").select(); });</script>';
                    pagefooter();
                    exit;
                }
            }
        }
    }
}


$thisplugin->add_filter('sys_menu', 'shorturl_sys_menu');

function shorturl_sys_menu($menu) {
    if (shorturl_get_permission() == 0) {
        return $menu;
    }

    global $CONFIG, $template_sys_menu_spacer;

    require "./plugins/shorturl/lang/english.php";
    if ($CONFIG['lang'] != 'english' && file_exists("./plugins/shorturl/lang/{$CONFIG['lang']}.php")) {
        require "./plugins/shorturl/lang/{$CONFIG['lang']}.php";
    }

    $icon = $CONFIG['enable_menu_icons'] > 0 ? '<img class="icon" src="images/icons/hide_table_row.png" />' : '';

    $new_button = array();
    $new_button[0][0] = $icon.$lang_plugin_shorturl['menu_link'];
    $new_button[0][1] = $lang_plugin_shorturl['title'];
    $new_button[0][2] = './?shorturl=add';
    $new_button[0][3] = '';
    $new_button[0][5] = '';
    $new_button[0][4] = $template_sys_menu_spacer;

    array_splice($menu, count($menu)-2, 0, $new_button);

    return $menu;
}


function shorturl_get_permission() {
    global $CONFIG, $cpg_udb;

    if (GALLERY_ADMIN_MODE) {
        return 1;
    } elseif (!USER_ID) {
        return $CONFIG["plugin_shorturl_permissions_".$cpg_udb->guestgroup];
    } else {
        $result = cpg_db_query("SELECT user_group, user_group_list FROM {$CONFIG['TABLE_USERS']} WHERE user_id = ".USER_ID);
        $user = cpg_db_fetch_assoc($result);
        cpg_db_free_result($result);
        if ($user['user_group_list'] != "") {
            $user_group_list = explode(",", $user['user_group_list']);
        }
        $user_group_list[] = $user['user_group'];

        for($i=0; $i<count($user_group_list); $i++) {
            $list[$i] = "name = 'plugin_shorturl_permissions_{$user_group_list[$i]}'";
        }

        $result = cpg_db_query("SELECT MAX(value) FROM {$CONFIG['TABLE_CONFIG']} WHERE ".implode(" OR ", $list));
        $permission = cpg_db_result($result, 0);
        cpg_db_free_result($result);

        return $permission;
    }
}


$thisplugin->add_action('plugin_install', 'shorturl_install');

function shorturl_install() {
    global $CONFIG;
    return cpg_db_query("CREATE TABLE IF NOT EXISTS {$CONFIG['TABLE_PREFIX']}plugin_shorturl (rid int(11) unsigned NOT NULL auto_increment PRIMARY KEY, url text NOT NULL)");
}


$thisplugin->add_action('plugin_uninstall', 'shorturl_uninstall');

function shorturl_uninstall() {
    $superCage = Inspekt::makeSuperCage();

    if (!$superCage->post->keyExists('drop')) {
        return 1;
    }

    if (!checkFormToken()) {
        global $lang_errors;
        cpg_die(ERROR, $lang_errors['invalid_form_token'], __FILE__, __LINE__);
    }

    if ($superCage->post->getInt('drop') == 1) {
        global $CONFIG;
        return cpg_db_query("DROP TABLE IF EXISTS {$CONFIG['TABLE_PREFIX']}plugin_shorturl");
    } else {
        return true;
    }
}


$thisplugin->add_action('plugin_cleanup', 'shorturl_cleanup');

function shorturl_cleanup($action) {
    $superCage = Inspekt::makeSuperCage();
    $cleanup = $superCage->server->getEscaped('REQUEST_URI');
    if ($action == 1) {
        global $CONFIG, $lang_common;

        require "./plugins/shorturl/lang/english.php";
        if ($CONFIG['lang'] != 'english' && file_exists("./plugins/shorturl/lang/{$CONFIG['lang']}.php")) {
            require "./plugins/shorturl/lang/{$CONFIG['lang']}.php";
        }

        list($timestamp, $form_token) = getFormToken();
        echo <<< EOT
            <form action="{$cleanup}" method="post">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="tableb">
                            {$lang_plugin_shorturl['drop_db']}?
                        </td>
                        <td class="tableb">
                            <input type="radio" name="drop" id="drop_yes" value="1" checked="checked" />
                            <label for="drop_yes" class="clickable_option">{$lang_common['yes']}</label>
                        </td>
                        <td class="tableb">
                            <input type="radio" name="drop" id="drop_no"  value="0" />
                            <label for="drop_no" class="clickable_option">{$lang_common['no']}</label>
                        </td>
                        <td class="tableb">
                            <input type="hidden" name="form_token" value="{$form_token}" />
                            <input type="hidden" name="timestamp" value="{$timestamp}" />
                            <input type="submit" name="submit" value="{$lang_common['go']}" class="button" />
                        </td>
                    </tr>
                </table>
            </form>
EOT;
    }
}

//EOF