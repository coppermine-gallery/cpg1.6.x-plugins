<?php
/**************************************************
  Coppermine 1.6.x Plugin - Theme switch
  *************************************************
  Copyright (c) 2010-2019 eenemeenemuu
**************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$thisplugin->add_action('page_start', 'theme_switch_page_start');

function theme_switch_page_start() {
    global $CONFIG, $USER, $REFERER;

    $superCage = Inspekt::makeSuperCage();

    $mobile_browser = '0';
 
    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i', strtolower($superCage->server->getRaw('HTTP_USER_AGENT')))) {
        $mobile_browser++;
    }

    if ((strpos(strtolower($superCage->server->getRaw('HTTP_ACCEPT')), 'application/vnd.wap.xhtml+xml') > 0) or (($superCage->server->keyExists('HTTP_X_WAP_PROFILE') or $superCage->server->keyExists('HTTP_PROFILE')))) {
        $mobile_browser++;
    }

    $mobile_ua = strtolower(substr($superCage->server->getRaw('HTTP_USER_AGENT'), 0, 4));
    $mobile_agents = array(
        'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
        'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
        'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
        'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
        'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
        'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
        'wapr','webc','winw','winw','xda ','xda-');

    if (in_array($mobile_ua, $mobile_agents)) {
        $mobile_browser++;
    }

    if (strpos(strtolower($superCage->server->getRaw('ALL_HTTP'), 'operamini') > 0)) {
        $mobile_browser++;
    }

    if (strpos(strtolower($superCage->server->getRaw('HTTP_USER_AGENT')), ' ppc;') > 0) {
        $mobile_browser++;
    }

    if (strpos(strtolower($superCage->server->getRaw('HTTP_USER_AGENT')), 'windows ce') > 0) {
        $mobile_browser++;
    } elseif (strpos(strtolower($superCage->server->getRaw('HTTP_USER_AGENT')), 'windows') > 0) {
        $mobile_browser = 0;
    }

    if (strpos(strtolower($superCage->server->getRaw('HTTP_USER_AGENT')), 'iemobile') > 0) {
        $mobile_browser++;
    }

    if ($mobile_browser > 0) {
        define('MOBILE_BROWSER', TRUE);
        if (!$superCage->cookie->keyExists($CONFIG['cookie_name'].'_mobile_theme')) {
            define('MOBILE_VIEW', TRUE);
            if ($CONFIG['theme'] != $CONFIG['theme_switch_mobile_theme'] && !$superCage->get->keyExists('theme')) {
                $USER['theme'] = $CONFIG['theme_switch_mobile_theme'];
                user_save_profile();
                header('Location: '.urldecode($REFERER));
            }
        }
    }

}


$thisplugin->add_filter('admin_menu', 'theme_switch_admin_menu');

function theme_switch_admin_menu($html) {
    global $CONFIG, $REFERER;

    require_once "./plugins/theme_switch/lang/english.php";
    if ($CONFIG['lang'] != 'english' && file_exists("./plugins/theme_switch/lang/{$CONFIG['lang']}.php")) {
        require_once "./plugins/theme_switch/lang/{$CONFIG['lang']}.php";
    }

    $display_button = false;
    if (defined('MOBILE_BROWSER')) {
        $display_button = true;
        if (defined('MOBILE_VIEW')) {
            $button['text'] = $lang_plugin_theme_switch['normal_view'];
            $button['href'] = 'normal';
        } else {
            $button['text'] = $lang_plugin_theme_switch['mobile_view'];
            $button['href'] = 'mobile';
        }
        $button['href'] = 'index.php?file=theme_switch/'.$button['href'].'&amp;ref='.urlencode($REFERER);
    } elseif ($CONFIG['theme'] == $CONFIG['theme_switch_mobile_theme']) {
        $display_button = true;
        $button['text'] = $lang_plugin_theme_switch['normal_view'];
        $button['href'] = stripos(urldecode($REFERER), '?') ? urldecode($REFERER).'&theme=xxx' : urldecode($REFERER).'?theme=xxx';
    }

    if ($display_button) {
        if ($html == '') {
            if (stripos($CONFIG['theme'], 'mobile') !== FALSE) {
                $html = '<optgroup label="----------"></optgroup>';
            } else {
                $html = '<ul class="dropmenu"></ul>';
            }
        }

        if (stripos($html, $search = '</ul>')) {
            $html = str_replace($search, '<li><a href="'.$button['href'].'" class="firstlevel"><span class="firstlevel">'.cpg_fetch_icon('web', 0).$button['text'].'</span></a></li>'.$search, $html);
        } elseif (stripos($html, $search = '</optgroup>')) {
            $html = str_replace($search, '<option value="'.$button['href'].'">'.$button['text'].'</option>'.$search, $html);
        } elseif (stripos($html, $search = '<div style="clear:left;">')) {
            $html = str_replace($search, '<div class="admin_menu admin_float"><a href="'.$button['href'].'">'.cpg_fetch_icon('web', 0).$button['text'].'</a></div>'.$search, $html);
        } else {
            $html .= '<div class="admin_menu admin_float"><a href="'.$button['href'].'">'.cpg_fetch_icon('web', 0).$button['text'].'</a></div>';
        }
    }

    return $html;
}


$thisplugin->add_action('plugin_install', 'theme_switch_install');

function theme_switch_install () {
    global $CONFIG;
    cpg_db_query("INSERT INTO {$CONFIG['TABLE_CONFIG']} (name, value) VALUES ('theme_switch_mobile_theme', 'water_drop')");

    return true;
}


$thisplugin->add_action('plugin_uninstall', 'theme_switch_uninstall');

function theme_switch_uninstall () {
    global $CONFIG;
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'theme_switch_mobile_theme'");

    return true;
}

//EOF