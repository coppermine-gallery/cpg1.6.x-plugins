<?php
/**************************************************
  Coppermine 1.5.x Plugin - Limit upload
  *************************************************
  Copyright (c) 2010-2018 eenemeenemuu
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

if (!defined('IN_COPPERMINE')) {
    die('Not in Coppermine...');
}

if (defined('DB_INPUT_PHP')) {
    $thisplugin->add_action('page_start', 'limit_upload_page_start');
}

function limit_upload_page_start() {
    $superCage = Inspekt::makeSuperCage();
    if ($matches = $superCage->post->getMatched('event', '/^[a-z_]+$/')) {
        $event = $matches[0];
    } elseif ($matches = $superCage->get->getMatched('event', '/^[a-z_]+$/')) {
        $event = $matches[0];
    } else {
        $event = '';
    }
    $allowed_events = array('comment_update', 'comment', 'album_update', 'album_reset');
    if (!GALLERY_ADMIN_MODE && $CONFIG['limit_upload_upload_limit'] >= 0 && !in_array($event, $allowed_events)) {
        global $CONFIG;

        switch($CONFIG['limit_upload_time_limit']) {
            // TODO: determine beginning of current hour/day/week/month/year and adjust the calculation
            case 'total': $multiplicator = -1; break;
            case 'hour': $multiplicator = 1; break;
            case 'day': $multiplicator = 24; break;
            case 'week': $multiplicator = 7*24; break;
            case 'month': $multiplicator = 30*24; break;
            case 'year': $multiplicator = 365*24; break;
            default: $multiplicator = false; break;
        }

        $sql_and = $multiplicator > 0 ? ' AND ctime > '. (time() - $multiplicator * 60*60) : '';

        $count = cpg_db_result(cpg_db_query("SELECT COUNT(*) FROM {$CONFIG['TABLE_PICTURES']} WHERE owner_id = ".USER_ID.$sql_and), 0);
        if ($count >= $CONFIG['limit_upload_upload_limit']) {
            $superCage = Inspekt::makeSuperCage();
            require_once "./plugins/limit_upload/lang/english.php";
            if ($CONFIG['lang'] != 'english' && file_exists("./plugins/limit_upload/lang/{$CONFIG['lang']}.php")) {
                require_once "./plugins/limit_upload/lang/{$CONFIG['lang']}.php";
            }

            $error = sprintf($lang_plugin_limit_upload['limit_reached_x'], $CONFIG['limit_upload_upload_limit'], $lang_plugin_limit_upload['upload_limit_values'][$CONFIG['limit_upload_time_limit']]);

            if ($multiplicator > 0) {
                // TODO: determine end of current hour/day/week/month/year and adjust the query
                $last_upload = cpg_db_result(cpg_db_query("SELECT ctime FROM {$CONFIG['TABLE_PICTURES']} WHERE owner_id = ".USER_ID." ORDER BY ctime DESC LIMIT ".($CONFIG['limit_upload_upload_limit']-1).", 1"), 0);
                $wait_time = ($last_upload + $multiplicator * 60*60 - time()) / 60; // minutes

                $unit_helper = array(60, 24, 7, 1);

                $i = 0;
                foreach ($lang_plugin_limit_upload['time_units'] as $unit) {
                    if (ceil($wait_time) < $unit_helper[$i]) {
                        break;
                    }
                    $wait_time /= $unit_helper[$i++];
                }

                $error .= '<br /> ';
                $error .= sprintf($lang_plugin_limit_upload['limit_reached_wait'], ceil($wait_time), $unit);
            }

            if ($superCage->post->keyExists('process')) {
                die($error);
            } else {
                load_template();
                cpg_die(ERROR, $error, __FILE__, __LINE__);
            }
        }
    }
}


$thisplugin->add_action('plugin_install', 'limit_upload_install');

function limit_upload_install () {
    global $CONFIG;
    cpg_db_query("INSERT INTO {$CONFIG['TABLE_CONFIG']} (name, value) VALUES ('limit_upload_upload_limit', '-1')");
    cpg_db_query("INSERT INTO {$CONFIG['TABLE_CONFIG']} (name, value) VALUES ('limit_upload_time_limit', 'total')");

    return true;
}


$thisplugin->add_action('plugin_uninstall', 'limit_upload_uninstall');

function limit_upload_uninstall () {
    global $CONFIG;
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'limit_upload_upload_limit'");
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'limit_upload_time_limit'");

    return true;
}

//EOF