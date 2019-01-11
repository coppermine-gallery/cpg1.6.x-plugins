<?php
/**************************************************
  Coppermine 1.5.x Plugin - Image manipulation
  *************************************************
  Copyright (c) 2010 Timo Schewe (www.timos-welt.de)
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

$thisplugin->add_action('plugin_install','image_manipulation_install'); // Add plugin_install action
$thisplugin->add_action('plugin_uninstall','image_manipulation_uninstall'); // Add plugin_uninstall action
$thisplugin->add_action('plugin_configure','image_manipulation_configure');

if (defined('DISPLAYIMAGE_PHP')) {
    $thisplugin->add_action('page_start','image_manipulation_include_js'); // Add js files
}

function image_manipulation_include_js() 
{
    global $JS, $CONFIG, $lang_plugin_image_manipulation;
    require_once('./plugins/image_manipulation/init.inc.php');

    if ($CONFIG['transparent_overlay'] != '1') {
        if ($CONFIG['plugin_image_manipulation_reset'] == '1') {
            set_js_var('im_strreset', $lang_plugin_image_manipulation['reset']);
        } else {
            set_js_var('im_strreset', '');
        }
        if ($CONFIG['plugin_image_manipulation_bw_sepia'] == '1') {
            set_js_var('im_strbw', $lang_plugin_image_manipulation['black_and_white']);
            set_js_var('im_strsepia', $lang_plugin_image_manipulation['sepia']);
        } else {
            set_js_var('im_strbw', '');
            set_js_var('im_strsepia', '');
        }
        if ($CONFIG['plugin_image_manipulation_flip_v'] == '1') {
            set_js_var('im_strflipv', $lang_plugin_image_manipulation['flip_vertically']);
        } else {
            set_js_var('im_strflipv', '');
        }
        if ($CONFIG['plugin_image_manipulation_flip_h'] == '1') {
            set_js_var('im_strfliph', $lang_plugin_image_manipulation['flip_horizontally']);
        } else {
            set_js_var('im_strfliph', '');
        }
        if ($CONFIG['plugin_image_manipulation_invert'] == '1') {
            set_js_var('im_strinvert', $lang_plugin_image_manipulation['invert']);
        } else {
            set_js_var('im_strinvert', '');
        }
        if ($CONFIG['plugin_image_manipulation_emboss'] == '1') {
            set_js_var('im_stremboss', $lang_plugin_image_manipulation['emboss']);
        } else {
            set_js_var('im_stremboss', '');
        }
        if ($CONFIG['plugin_image_manipulation_blur'] == '1') {
            set_js_var('im_strblur', $lang_plugin_image_manipulation['blur']);
        } else {
            set_js_var('im_strblur', '');
        }
        if ($CONFIG['plugin_image_manipulation_brightness'] == '1') {
            set_js_var('im_strlightness', $lang_plugin_image_manipulation['brightness']);
        } else {
            set_js_var('im_strlightness', '');
        }
        if ($CONFIG['plugin_image_manipulation_contrast'] == '1') {
            set_js_var('im_strcontrast', $lang_plugin_image_manipulation['contrast']);
        } else {
            set_js_var('im_strcontrast', '');
        }
        if ($CONFIG['plugin_image_manipulation_saturation'] == '1') {
            set_js_var('im_strsatur', $lang_plugin_image_manipulation['saturation']);
        } else {
            set_js_var('im_strsatur', '');
        }
        if ($CONFIG['plugin_image_manipulation_sharpness'] == '1') {
            set_js_var('im_strsharpen', $lang_plugin_image_manipulation['sharpness']);
        } else {
            set_js_var('im_strsharpen', '');
        }
        set_js_var('im_useurlvalues', $CONFIG['plugin_image_manipulation_urlvalues']);
        set_js_var('im_usecookies', $CONFIG['plugin_image_manipulation_cookies']);
        set_js_var('im_icon_reset', $image_manipulation_icon_array['reset']);
        set_js_var('im_icon_bw', $image_manipulation_icon_array['black_and_white']);
        set_js_var('im_icon_sepia', $image_manipulation_icon_array['sepia']);
        set_js_var('im_icon_flipv', $image_manipulation_icon_array['flip_vertically']);
        set_js_var('im_icon_fliph', $image_manipulation_icon_array['flip_horizontally']);
        set_js_var('im_icon_invert', $image_manipulation_icon_array['invert']);
        set_js_var('im_icon_emboss', $image_manipulation_icon_array['emboss']);
        set_js_var('im_icon_blur', $image_manipulation_icon_array['blur']);
        set_js_var('im_icon_brightness', $image_manipulation_icon_array['brightness']);
        set_js_var('im_icon_contrast', $image_manipulation_icon_array['contrast']);
        set_js_var('im_icon_saturation', $image_manipulation_icon_array['saturation']);
        set_js_var('im_icon_sharpness', $image_manipulation_icon_array['sharpness']);

        $client_array = cpg_determine_client();

        if (in_array($client_array['browser'], array('IE8', 'IE7', 'IE6', 'IE5.5', 'IE5')) == TRUE) {
            $JS['includes'][] = "./plugins/image_manipulation/js/pixastic_compatible.js";
        } elseif ($CONFIG['plugin_image_manipulation_contrast'] != '1' &&
                  $CONFIG['plugin_image_manipulation_saturation'] != '1' &&
                  $CONFIG['plugin_image_manipulation_sharpness'] != '1'
                  ) {
                    $JS['includes'][] = "./plugins/image_manipulation/js/pixastic_compatible.js";
        } else {
            $JS['includes'][] = "./plugins/image_manipulation/js/pixastic.js";
        }
        $JS['includes'][] = "./plugins/image_manipulation/js/image_manipulation.js";
    }
}


// install
function image_manipulation_install() {
    global $CONFIG;
    $superCage = Inspekt::makeSuperCage();
    
    // Check for the mirror plugin
    if (($plugin_id = CPGPluginAPI::installed('mirror')) !== false) {
         return 1;
    }
    
    // Check for the transparent overlay
    if ($CONFIG['transparent_overlay'] == '1') {
         if ($superCage->post->keyExists('image_manipulation_continue_anyway') == TRUE && $superCage->post->getInt('image_manipulation_continue_anyway') == '1') {
            // The pre-install status of the transparent overlay setting is being stored inside another field and get's restored on uninstall	        
            cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_image_manipulation_overlay', '1')");
            // This plugin only works if image_overlay is off, so let's turn it off if it's on
             $CONFIG['transparent_overlay'] = '0';
            cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value='0' WHERE name='transparent_overlay'");
         } else {
            return 1;
        }
    }
    
    // Add the config options for the plugin
    cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_image_manipulation_cookies', '1')");
    cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_image_manipulation_urlvalues', '1')");
    cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_image_manipulation_reset', '1')");
    cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_image_manipulation_bw_sepia', '1')");
    cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_image_manipulation_flip_v', '1')");
    cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_image_manipulation_flip_h', '1')");
    cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_image_manipulation_invert', '1')");
    cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_image_manipulation_emboss', '1')");
    cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_image_manipulation_blur', '1')");
    cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_image_manipulation_brightness', '1')");
    cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_image_manipulation_contrast', '0')");
    cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_image_manipulation_saturation', '0')");
    cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('plugin_image_manipulation_sharpness', '0')");
    
    return true;
}


// uninstall and drop settings table
function image_manipulation_uninstall() {
    global $CONFIG;
    // Restore the state of the transparent overlay if needed
    if ($CONFIG['plugin_image_manipulation_overlay'] == '1') {
        cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value='1' WHERE name='transparent_overlay'");
    }
    // Delete the plugin config records
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_image_manipulation_cookies'");
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_image_manipulation_urlvalues'");
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_image_manipulation_overlay'");
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_image_manipulation_reset'");
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_image_manipulation_bw_sepia'");
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_image_manipulation_flip_v'");
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_image_manipulation_flip_h'");
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_image_manipulation_invert'");
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_image_manipulation_emboss'");
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_image_manipulation_blur'");
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_image_manipulation_brightness'");
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_image_manipulation_contrast'");
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_image_manipulation_saturation'");
    cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'plugin_image_manipulation_sharpness'");
    return true;
}

function image_manipulation_configure() {
    global $CONFIG, $CPG_PLUGINS, $lang_plugin_image_manipulation;
    require('./plugins/image_manipulation/init.inc.php');
    $icon_array['ok'] = cpg_fetch_icon('ok', 1);
    $icon_array['cancel'] = cpg_fetch_icon('cancel', 1);
    $allow_continue = 1;
    echo <<< EOT
    <form action="" method="post" name="image_manipulation_config" id="image_manipulation_config">
        <ul>
EOT;
    if ($CONFIG['transparent_overlay'] != '0') {
        echo <<< EOT
            <li>{$lang_plugin_image_manipulation['transparent_overlay_warning']}
            {$lang_plugin_image_manipulation['continue_will_disable_warning']}
            {$lang_plugin_image_manipulation['do_not_turn_on_again']}</li>
EOT;
    }
    if (($plugin_id = CPGPluginAPI::installed('mirror')) !== false) {
        $warning_coexist = sprintf($lang_plugin_image_manipulation['plugins_cant_coexist'], '<em>Mirror</em>');
        echo <<< EOT
            <li>{$warning_coexist}</li>
EOT;
        $allow_continue = 0;
    }
    echo <<< EOT
        </ul>
EOT;
    if ($allow_continue == 1) {
        echo <<< EOT
        <input type="hidden" name="image_manipulation_continue_anyway" id="image_manipulation_continue_anyway" value="1" />
        <button type="submit" class="button" name="submit" value="{$lang_plugin_image_manipulation['continue_anyway']}">{$icon_array['ok']}{$lang_plugin_image_manipulation['continue_anyway']}</button>
EOT;
    }
    echo <<< EOT
        <a href="pluginmgr.php" class="admin_menu">{$icon_array['cancel']}{$lang_plugin_image_manipulation['cancel']}</a>
EOT;
    echo <<< EOT
    </form>
EOT;
}

?>