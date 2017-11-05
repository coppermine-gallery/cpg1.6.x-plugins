<?php
/**************************************************
  Coppermine 1.6.x Plugin - EnlargeIt!
  *************************************************
  Copyright (c) 2010 Timos-Welt (www.timos-welt.de)
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
 **************************************************/

require './plugins/enlargeit/configuration.php';
if (in_array('plugins/enlargeit/js/farbtastic.js', $JS['includes']) != TRUE) {
	$JS['includes'][] = 'plugins/enlargeit/js/farbtastic.js';
}
if (in_array('plugins/enlargeit/js/config.js', $JS['includes']) != TRUE) {
	$JS['includes'][] = 'plugins/enlargeit/js/admin.js';
}

// create Inspekt supercage
$superCage = Inspekt::makeSuperCage();

if (!GALLERY_ADMIN_MODE) {
    cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);
}

// text direction
if($lang_text_dir=='ltr') {
  $align="left";
  $direction="ltr";
}else {
  $align="right";
  $direction="rtl";
}

// get sanitized POST parameters
if ($superCage->post->keyExists('submit')) {
	//Check if the form token is valid
	if(!checkFormToken()){
		cpg_die(ERROR, $lang_errors['invalid_form_token'], __FILE__, __LINE__);
	}
  // Define the sanitization patterns
  $sanitization_array = array(
      'plugin_enlargeit_adminmode' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_registeredmode' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_guestmode' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_pictype' => array('type' => 'int', 'min' => '0', 'max' => '2'),
      'plugin_enlargeit_ani' => array('type' => 'int', 'min' => '0', 'max' => '8'),
      'plugin_enlargeit_speed' => array('type' => 'int', 'min' => '10', 'max' => '32'),
      'plugin_enlargeit_maxstep' => array('type' => 'int', 'min' => '4', 'max' => '30'),
      'plugin_enlargeit_opaglide' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_brdsize' => array('type' => 'int', 'min' => '0', 'max' => '40'),
      'plugin_enlargeit_brdcolor' => array('type' => 'raw', 'regex_ok' => '/^#(?:(?:[a-f\d]{3}){1,2})$/i'),
      'plugin_enlargeit_brdbck' => array('type' => 'raw', 'regex_ok' => '/^[a-z_]+$/'),
      'plugin_enlargeit_brdround' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_shadowsize' => array('type' => 'int', 'min' => '0', 'max' => '9'),
      'plugin_enlargeit_shadowintens' => array('type' => 'int', 'min' => '1', 'max' => '30'),
	  'plugin_enlargeit_shadowcolor' => array('type' => 'raw', 'regex_ok' => '/^#(?:(?:[a-f\d]{3}){1,2})$/i'),
      'plugin_enlargeit_titlebar' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_titletxtcol' => array('type' => 'raw', 'regex_ok' => '/^#(?:(?:[a-f\d]{3}){1,2})$/i'),
      'plugin_enlargeit_ajaxcolor' => array('type' => 'raw', 'regex_ok' => '/^#(?:(?:[a-f\d]{3}){1,2})$/i'),
      'plugin_enlargeit_center' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_dragdrop' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_wheelnav' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_dark' => array('type' => 'int', 'min' => '0', 'max' => '2'),
      'plugin_enlargeit_darkprct' => array('type' => 'int', 'min' => '0', 'max' => '100'),
      'plugin_enlargeit_darkensteps' => array('type' => 'int', 'min' => '1', 'max' => '20'),
      'plugin_enlargeit_buttonpic' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_buttoninfo' => array('type' => 'int', 'min' => '0', 'max' => '2'),
      'plugin_enlargeit_buttonfav' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_buttonvote' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_buttoncomment' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_buttondownload' => array('type' => 'int', 'min' => '0', 'max' => '2'),
      'plugin_enlargeit_buttonbbcode' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_buttonhist' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_buttonnav' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_buttonclose' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_flvplayer' => array('type' => 'int', 'min' => '0', 'max' => '1'),
      'plugin_enlargeit_adminmenu' => array('type' => 'checkbox', 'min' => '0', 'max' => '1'),
	  'plugin_enlargeit_cachecontrol' => array('type' => 'int', 'min' => '0', 'max' => '2'),
	  'plugin_enlargeit_cachemaxage' => array('type' => 'int', 'min' => '1', 'max' => '365'),
	  'plugin_enlargeit_cachemaxsizemb' => array('type' => 'int', 'min' => '1', 'max' => '99'),
	  'plugin_enlargeit_maximizemethod' => array('type' => 'int', 'min' => '0', 'max' => '1'),
	  'plugin_enlargeit_img_types' => array('type' => 'array', 'regex_ok' => '/^[a-z]+$/', 'delimiter' => '/'),
	  'plugin_enlargeit_mov_types' => array('type' => 'array', 'regex_ok' => '/^[a-z]+$/', 'delimiter' => '/'),
  );
  $config_changes_counter = 0;
  foreach ($sanitization_array as $san_key => $san_value) {
      if (isset($CONFIG[$san_key]) == TRUE) { // only loop if config value is set --- start
          if ($san_value['type'] == 'checkbox') { // type is checkbox --- start
            if ($superCage->post->getInt($san_key) == $san_value['max'] && $CONFIG[$san_key] != $san_value['max']) {
                $CONFIG[$san_key] = $san_value['max'];
                cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value='{$CONFIG[$san_key]}' WHERE name='$san_key'");
                $config_changes_counter++;
            } elseif($superCage->post->getInt($san_key) == $san_value['min'] && $CONFIG[$san_key] != $san_value['min']) {
                $CONFIG[$san_key] = $san_value['min'];
                cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value='{$CONFIG[$san_key]}' WHERE name='$san_key'");
                $config_changes_counter++;
            } elseif($superCage->post->keyExists($san_key) != TRUE && $CONFIG[$san_key] != '0') {
                $CONFIG[$san_key] = 0;
                cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value='{$CONFIG[$san_key]}' WHERE name='$san_key'");
                $config_changes_counter++;
            }
          } // type is checkbox --- end
          if ($san_value['type'] == 'int') { // type is integer --- start
              if ($superCage->post->getInt($san_key) <= $san_value['max'] && $superCage->post->getInt($san_key) >= $san_value['min'] && $superCage->post->getInt($san_key) != $CONFIG[$san_key]) {
                  $CONFIG[$san_key] = $superCage->post->getInt($san_key);
                  cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value='{$CONFIG[$san_key]}' WHERE name='$san_key'");
                  $config_changes_counter++;
              }
          } // type is integer --- end
          if ($san_value['type'] == 'raw') { // type is raw --- start
              if (isset($san_value['regex_ok']) == TRUE && preg_match($san_value['regex_ok'], $superCage->post->getRaw($san_key)) && $superCage->post->getRaw($san_key) != $CONFIG[$san_key]) {
                  $CONFIG[$san_key] = $superCage->post->getRaw($san_key);
				  if ($superCage->post->getRaw($san_key) == 'none') {
					$CONFIG[$san_key] = '';
				  }
                  cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value='{$CONFIG[$san_key]}' WHERE name='$san_key'");
                  $config_changes_counter++;
              }
          } // type is raw --- end
          if ($san_value['type'] == 'array') { // type is array --- start              
          $evaluate_value = $superCage->post->getRaw($san_key);
              //print_r($superCage->post->getRaw($san_key));
              if (is_array($evaluate_value) && isset($san_value['regex_ok']) == TRUE && isset($san_value['delimiter']) == TRUE) {
                  $temp = '';
                  for ($i = 0; $i <= count($evaluate_value); $i++) {
                      if (preg_match($san_value['regex_ok'], $evaluate_value[$i])) {
                          $temp .= $evaluate_value[$i] . $san_value['delimiter'];
                      }
                  }
                  unset($evaluate_value);
                  $evaluate_value = rtrim($temp, $san_value['delimiter']);
                  unset($temp);
              }
              if ($evaluate_value != $CONFIG[$san_key]) {
                  $CONFIG[$san_key] = $evaluate_value;
                  cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value='{$CONFIG[$san_key]}' WHERE name='$san_key'");
                  $config_changes_counter++;
              }
          } // type is array --- end
      } // only loop if config value is set --- end
  }
}


// display config page

// Set the option output stuff 
if ($CONFIG['plugin_enlargeit_adminmode'] == '1') {
	$option_output['plugin_enlargeit_adminmode'] = 'checked="checked"';
} else { 
	$option_output['plugin_enlargeit_adminmode'] = '';
}

if ($CONFIG['plugin_enlargeit_registeredmode'] == '1') {
	$option_output['plugin_enlargeit_registeredmode'] = 'checked="checked"';
} else { 
	$option_output['plugin_enlargeit_registeredmode'] = '';
}

if ($CONFIG['plugin_enlargeit_guestmode'] == '1') {
	$option_output['plugin_enlargeit_guestmode'] = 'checked="checked"';
} else { 
	$option_output['plugin_enlargeit_guestmode'] = '';
}

if ($CONFIG['plugin_enlargeit_pictype'] == '0') {
	$option_output['plugin_enlargeit_pictype_0'] = 'checked="checked"';
	$option_output['plugin_enlargeit_pictype_1'] = '';
	$option_output['plugin_enlargeit_pictype_2'] = '';
} elseif ($CONFIG['plugin_enlargeit_pictype'] == '1') { // 
	$option_output['plugin_enlargeit_pictype_0'] = '';
	$option_output['plugin_enlargeit_pictype_1'] = 'checked="checked"';
	$option_output['plugin_enlargeit_pictype_2'] = '';
} elseif ($CONFIG['plugin_enlargeit_pictype'] == '2') { // 
	$option_output['plugin_enlargeit_pictype_0'] = '';
	$option_output['plugin_enlargeit_pictype_1'] = '';
	$option_output['plugin_enlargeit_pictype_2'] = 'checked="checked"';
}

if ($CONFIG['plugin_enlargeit_maximizemethod'] == '0') {
	$option_output['plugin_enlargeit_maximizemethod_0'] = 'checked="checked"';
	$option_output['plugin_enlargeit_maximizemethod_1'] = '';
} elseif ($CONFIG['plugin_enlargeit_maximizemethod'] == '1') {
	$option_output['plugin_enlargeit_maximizemethod_0'] = '';
	$option_output['plugin_enlargeit_maximizemethod_1'] = 'checked="checked"';
}

for ($i = 0; $i <= 10; $i++) {
	if ($CONFIG['plugin_enlargeit_ani'] == $i) {
		$option_output['plugin_enlargeit_ani'][$i] = 'selected="selected"';
	} else {
		$option_output['plugin_enlargeit_ani'][$i] = '';
	}
}

$option_output['plugin_enlargeit_speed'] = '';
$option_output['plugin_enlargeit_maxstep'] = '';
$option_output['plugin_enlargeit_opaglide'] = '';


if ($CONFIG['plugin_enlargeit_ani'] == '0') {
	$option_output['plugin_enlargeit_speed'] .= 'disabled="disabled" ';
	$option_output['plugin_enlargeit_maxstep'] .= 'disabled="disabled" ';
	$option_output['plugin_enlargeit_opaglide'] .= 'disabled="disabled" ';
}

if ($CONFIG['plugin_enlargeit_opaglide'] == '1') {
	$option_output['plugin_enlargeit_opaglide'] .= 'checked="checked"';
}

$border_texture_options = '<option value="none">-</option>' . $LINEBREAK;
for ($i = 0; $i < count($border_texture_array); $i++) {
	if ($CONFIG['plugin_enlargeit_brdbck'] == $border_texture_array[$i]) {
		$option_output['plugin_enlargeit_brdbck'][$i] = 'selected="selected"';
	} else {
		$option_output['plugin_enlargeit_brdbck'][$i] = '';
	}
	$border_texture_options .= '				<option value="'.$border_texture_array[$i].'" '.$option_output['plugin_enlargeit_brdbck'][$i].' >'.$lang_plugin_enlargeit[$border_texture_array[$i]].'</option>'.$LINEBREAK;
}

if ($CONFIG['plugin_enlargeit_brdround'] == '1') {
	$option_output['plugin_enlargeit_brdround'] = 'checked="checked"';
} else { 
	$option_output['plugin_enlargeit_brdround'] = '';
}

if ($CONFIG['plugin_enlargeit_titlebar'] == '1') {
	$option_output['plugin_enlargeit_titlebar'] = 'checked="checked"';
} else { 
	$option_output['plugin_enlargeit_titlebar'] = '';
}

if ($CONFIG['plugin_enlargeit_center'] == '1') {
	$option_output['plugin_enlargeit_center'] = 'checked="checked"';
} else { 
	$option_output['plugin_enlargeit_center'] = '';
}

if ($CONFIG['plugin_enlargeit_dragdrop'] == '1') {
	$option_output['plugin_enlargeit_dragdrop'] = 'checked="checked"';
} else { 
	$option_output['plugin_enlargeit_dragdrop'] = '';
}

if ($CONFIG['plugin_enlargeit_wheelnav'] == '1') {
	$option_output['plugin_enlargeit_wheelnav'] = 'checked="checked"';
} else { 
	$option_output['plugin_enlargeit_wheelnav'] = '';
}

if ($CONFIG['plugin_enlargeit_dark'] == '0') {
	$option_output['plugin_enlargeit_dark_0'] = 'checked="checked"';
	$option_output['plugin_enlargeit_dark_1'] = '';
	$option_output['plugin_enlargeit_dark_2'] = '';
} elseif ($CONFIG['plugin_enlargeit_dark'] == '1') { // 
	$option_output['plugin_enlargeit_dark_0'] = '';
	$option_output['plugin_enlargeit_dark_1'] = 'checked="checked"';
	$option_output['plugin_enlargeit_dark_2'] = '';
} elseif ($CONFIG['plugin_enlargeit_dark'] == '2') { // 
	$option_output['plugin_enlargeit_dark_0'] = '';
	$option_output['plugin_enlargeit_dark_1'] = '';
	$option_output['plugin_enlargeit_dark_2'] = 'checked="checked"';
}

if ($CONFIG['plugin_enlargeit_buttonpic'] == '1') {
	$option_output['plugin_enlargeit_buttonpic'] = 'checked="checked"';
} else { 
	$option_output['plugin_enlargeit_buttonpic'] = '';
}

if ($CONFIG['plugin_enlargeit_buttoninfo'] == '0') {
	$option_output['plugin_enlargeit_buttoninfo_0'] = 'checked="checked"';
	$option_output['plugin_enlargeit_buttoninfo_1'] = '';
	$option_output['plugin_enlargeit_buttoninfo_2'] = '';
} elseif ($CONFIG['plugin_enlargeit_buttoninfo'] == '1') { // 
	$option_output['plugin_enlargeit_buttoninfo_0'] = '';
	$option_output['plugin_enlargeit_buttoninfo_1'] = 'checked="checked"';
	$option_output['plugin_enlargeit_buttoninfo_2'] = '';
} elseif ($CONFIG['plugin_enlargeit_buttoninfo'] == '2') { // 
	$option_output['plugin_enlargeit_buttoninfo_0'] = '';
	$option_output['plugin_enlargeit_buttoninfo_1'] = '';
	$option_output['plugin_enlargeit_buttoninfo_2'] = 'checked="checked"';
}

if ($CONFIG['plugin_enlargeit_buttonfav'] == '1') {
	$option_output['plugin_enlargeit_buttonfav'] = 'checked="checked"';
} else { 
	$option_output['plugin_enlargeit_buttonfav'] = '';
}

if ($CONFIG['plugin_enlargeit_buttonvote'] == '1') {
	$option_output['plugin_enlargeit_buttonvote'] = 'checked="checked"';
} else { 
	$option_output['plugin_enlargeit_buttonvote'] = '';
}

if ($CONFIG['plugin_enlargeit_buttoncomment'] == '1') {
	$option_output['plugin_enlargeit_buttoncomment'] = 'checked="checked"';
} else { 
	$option_output['plugin_enlargeit_buttoncomment'] = '';
}

if ($CONFIG['plugin_enlargeit_buttondownload'] == '0') {
	$option_output['plugin_enlargeit_buttondownload_0'] = 'checked="checked"';
	$option_output['plugin_enlargeit_buttondownload_1'] = '';
	$option_output['plugin_enlargeit_buttondownload_2'] = '';
} elseif ($CONFIG['plugin_enlargeit_buttondownload'] == '1') {
	$option_output['plugin_enlargeit_buttondownload_0'] = '';
	$option_output['plugin_enlargeit_buttondownload_1'] = 'checked="checked"';
	$option_output['plugin_enlargeit_buttondownload_2'] = '';
} elseif ($CONFIG['plugin_enlargeit_buttondownload'] == '2') {
	$option_output['plugin_enlargeit_buttondownload_0'] = '';
	$option_output['plugin_enlargeit_buttondownload_1'] = '';
	$option_output['plugin_enlargeit_buttondownload_2'] = 'checked="checked"';
}

if ($CONFIG['plugin_enlargeit_buttonbbcode'] == '1') {
	$option_output['plugin_enlargeit_buttonbbcode'] = 'checked="checked"';
} else { 
	$option_output['plugin_enlargeit_buttonbbcode'] = '';
}

if ($CONFIG['plugin_enlargeit_buttonhist'] == '1') {
	$option_output['plugin_enlargeit_buttonhist'] = 'checked="checked"';
	$cache_visibility = 'visible';
	$option_output['plugin_enlargeit_cachecontrol_0'] = '';
	$option_output['plugin_enlargeit_cachecontrol_1'] = '';
	$option_output['plugin_enlargeit_cachecontrol_2'] = '';
	$option_output['plugin_enlargeit_cachemaxage'] = '';
	$option_output['plugin_enlargeit_cachemaxsizemb'] = '';
} else { 
	$option_output['plugin_enlargeit_buttonhist'] = '';
	$cache_visibility = 'hidden';
	$option_output['plugin_enlargeit_cachecontrol_0'] = 'disabled="disabled"';
	$option_output['plugin_enlargeit_cachecontrol_1'] = 'disabled="disabled"';
	$option_output['plugin_enlargeit_cachecontrol_2'] = 'disabled="disabled"';
	$option_output['plugin_enlargeit_cachemaxage'] = ' disabled="disabled"';
	$option_output['plugin_enlargeit_cachemaxsizemb'] = ' disabled="disabled"';
}

if ($CONFIG['thumb_method'] == 'gd2' || version_compare($enlargeit_gd_version, '2', '>=')) { // Only display histogram option if GD2 is available.
	$option_output['plugin_enlargeit_buttonhist'] .= '';
} else {
    $option_output['plugin_enlargeit_buttonhist'] .= ' disabled="disabled"';
}
if ($enlargeit_gd_version == '') {
    $enlargeit_gd_version = $lang_plugin_enlargeit['not_available'];
}
$gd_version_string = sprintf($lang_plugin_enlargeit['gd_version'], $enlargeit_gd_version);
$result = cpg_db_query("SELECT COUNT(*) FROM {$CONFIG['TABLE_PICTURES']} WHERE histogram_filesize>'0'");
list($cache_count) = cpg_db_fetch_row($result, true);
$result = cpg_db_query("SELECT SUM(histogram_filesize) AS sum_histogram FROM {$CONFIG['TABLE_PICTURES']} WHERE histogram_filesize>'0'");
$row = cpg_db_fetch_assoc($result, true);
$cache_sum = $row['sum_histogram'];

$cached_files = sprintf($lang_plugin_enlargeit['file_cache_x_files_using_x_bytes'], cpg_float2decimal($cache_count), cpg_format_bytes($cache_sum));

if ($CONFIG['plugin_enlargeit_buttonnav'] == '1') {
	$option_output['plugin_enlargeit_buttonnav'] = 'checked="checked"';
} else { 
	$option_output['plugin_enlargeit_buttonnav'] = '';
}

if ($CONFIG['plugin_enlargeit_buttonclose'] == '1') {
	$option_output['plugin_enlargeit_buttonclose'] = 'checked="checked"';
} else { 
	$option_output['plugin_enlargeit_buttonclose'] = '';
}

if ($CONFIG['plugin_enlargeit_flvplayer'] == '0') {
	$option_output['plugin_enlargeit_flvplayer_0'] = 'checked="checked"';
	$option_output['plugin_enlargeit_flvplayer_1'] = '';
} elseif ($CONFIG['plugin_enlargeit_flvplayer'] == '1') { // 
	$option_output['plugin_enlargeit_flvplayer_0'] = '';
	$option_output['plugin_enlargeit_flvplayer_1'] = 'checked="checked"';
}

if ($CONFIG['plugin_enlargeit_adminmenu'] == '1') {
	$option_output['plugin_enlargeit_adminmenu'] = 'checked="checked"';
} else { 
	$option_output['plugin_enlargeit_adminmenu'] = '';
}

if (isset($CONFIG['plugin_enlargeit_cachecontrol']) != TRUE || $CONFIG['plugin_enlargeit_cachecontrol'] == '0') {
	$option_output['plugin_enlargeit_cachecontrol_0'] .= 'checked="checked"';
	$option_output['plugin_enlargeit_cachecontrol_1'] .= '';
	$option_output['plugin_enlargeit_cachecontrol_2'] .= '';
} elseif ($CONFIG['plugin_enlargeit_cachecontrol'] == '1') { // 
	$option_output['plugin_enlargeit_cachecontrol_0'] .= '';
	$option_output['plugin_enlargeit_cachecontrol_1'] .= 'checked="checked"';
	$option_output['plugin_enlargeit_cachecontrol_2'] .= '';
} elseif ($CONFIG['plugin_enlargeit_cachecontrol'] == '2') { // 
	$option_output['plugin_enlargeit_cachecontrol_0'] .= '';
	$option_output['plugin_enlargeit_cachecontrol_1'] .= '';
	$option_output['plugin_enlargeit_cachecontrol_2'] .= 'checked="checked"';
}

pageheader($lang_plugin_enlargeit['display_name']);
list($timestamp, $form_token) = getFormToken();
echo <<< EOT
<form action="index.php?file=enlargeit/admin" method="post" name="enlargeit_settings">
EOT;
starttable('100%', $enlargeit_icon_array['table'] . $lang_plugin_enlargeit['plugin_configuration'] . ': ' . $lang_plugin_enlargeit['main_title'] . ' v' . $version, 3, 'cpg_zebra');
echo <<< EOT
	<tr>
		<td class="tablef" colspan="3" >
EOT;
if ($superCage->post->keyExists('submit')) {
    if ($config_changes_counter > 0) {
        msg_box('', $lang_plugin_enlargeit['update_success'], '', '', 'success');
    } else {
        msg_box('', $lang_plugin_enlargeit['no_changes'], '', '', 'validation');
    }
} else {
	echo <<< EOT
	{$lang_plugin_enlargeit['display_name']} &copy; Timo Schewe (<a href="http://www.timos-welt.de/" rel="external" class="external">Timos-welt.de</a>)
	<a href="http://forum.coppermine-gallery.net/index.php/topic,57424.0.html" rel="external" class="admin_menu">{$enlargeit_icon_array['announcement']}{$lang_plugin_enlargeit['announcement_thread']}</a>
	<a href="plugins/enlargeit/docs/{$documentation_file}.htm" class="admin_menu">{$enlargeit_icon_array['documentation']}{$lang_plugin_enlargeit['enlargeit_documentation']}</a>

EOT;
}
echo <<< EOT
		</td>
	</tr>
	<tr>
		<td class="tableh1" colspan="3">
			{$lang_plugin_enlargeit['enlargement_type']} <a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_type" class="greybox" title="{$lang_plugin_enlargeit['enlargement_type']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['enable_for']}
		</td>
		<td colspan="1">
			<input type="checkbox" name="plugin_enlargeit_adminmode" id="plugin_enlargeit_adminmode" class="checkbox" value="1" {$option_output['plugin_enlargeit_adminmode']} /><label for="plugin_enlargeit_adminmode" class="clickable_option">{$lang_plugin_enlargeit['administrators']}</label><br />
			<input type="checkbox" name="plugin_enlargeit_registeredmode" id="plugin_enlargeit_registeredmode" class="checkbox" value="1" {$option_output['plugin_enlargeit_registeredmode']} /><label for="plugin_enlargeit_registeredmode" class="clickable_option">{$lang_plugin_enlargeit['registered_users']}</label><br />
			<input type="checkbox" name="plugin_enlargeit_guestmode" id="plugin_enlargeit_guestmode" class="checkbox" value="1" {$option_output['plugin_enlargeit_guestmode']} /><label for="plugin_enlargeit_guestmode" class="clickable_option">{$lang_plugin_enlargeit['guests']}</label>
		</td>
		<td>
			 <a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_type_enablefor" class="greybox" title="{$lang_plugin_enlargeit['enable_for']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['enlarge_to_pic_in']}
		</td>
		<td colspan="1">
			<input type="radio" name="plugin_enlargeit_pictype" id="plugin_enlargeit_pictype_0" class="radio" value="0" {$option_output['plugin_enlargeit_pictype_0']} /><label for="plugin_enlargeit_pictype_0" class="clickable_option">{$lang_plugin_enlargeit['intermediate_size']}</label><br />
			<input type="radio" name="plugin_enlargeit_pictype" id="plugin_enlargeit_pictype_1" class="radio" value="1" {$option_output['plugin_enlargeit_pictype_1']} /><label for="plugin_enlargeit_pictype_1" class="clickable_option">{$lang_plugin_enlargeit['full_size']}</label><br />
			<input type="radio" name="plugin_enlargeit_pictype" id="plugin_enlargeit_pictype_2" class="radio" value="2" {$option_output['plugin_enlargeit_pictype_2']} /><label for="plugin_enlargeit_pictype_2" class="clickable_option">{$lang_plugin_enlargeit['force_intermediate_size']}</label>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_type_enlargetopicin" class="greybox" title="{$lang_plugin_enlargeit['enlarge_to_pic_in']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['maximize_method']}
		</td>
		<td colspan="1">
			<input type="radio" name="plugin_enlargeit_maximizemethod" id="plugin_enlargeit_maximizemethod_0" class="radio" value="0" {$option_output['plugin_enlargeit_maximizemethod_0']} /><label for="plugin_enlargeit_maximizemethod_0" class="clickable_option">{$lang_plugin_enlargeit['as_popup_window']} ({$lang_plugin_enlargeit['not_recommended']})</label><br />
			<input type="radio" name="plugin_enlargeit_maximizemethod" id="plugin_enlargeit_maximizemethod_1" class="radio" value="1" {$option_output['plugin_enlargeit_maximizemethod_1']} /><label for="plugin_enlargeit_maximizemethod_1" class="clickable_option">{$lang_plugin_enlargeit['open_as_ajax']} ({$lang_plugin_enlargeit['recommended']})</label>
		</td>
		<td>
		    <a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_type_maximize" class="greybox" title="{$lang_plugin_enlargeit['maximize_method']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td class="tableh1" colspan="3">
			{$lang_plugin_enlargeit['animation']} <a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_animation" class="greybox" title="{$lang_plugin_enlargeit['animation']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['animation_type']}
		</td>
		<td colspan="1">
			<select name="plugin_enlargeit_ani" id="plugin_enlargeit_ani" class="listbox">
				<option value="0" {$option_output['plugin_enlargeit_ani'][0]} >{$lang_plugin_enlargeit['none']}</option>
				<option value="1" {$option_output['plugin_enlargeit_ani'][1]} >{$lang_plugin_enlargeit['fade']}</option>
				<option value="2" {$option_output['plugin_enlargeit_ani'][2]} >{$lang_plugin_enlargeit['glide']}</option>
				<option value="3" {$option_output['plugin_enlargeit_ani'][3]} >{$lang_plugin_enlargeit['bumpglide']}</option>
				<option value="4" {$option_output['plugin_enlargeit_ani'][4]} >{$lang_plugin_enlargeit['smoothglide']}</option>
				<option value="5" {$option_output['plugin_enlargeit_ani'][5]} >{$lang_plugin_enlargeit['expglide']}</option>
				<option value="6" {$option_output['plugin_enlargeit_ani'][6]} >{$lang_plugin_enlargeit['topglide']}</option>
				<option value="7" {$option_output['plugin_enlargeit_ani'][7]} >{$lang_plugin_enlargeit['leftglide']}</option>
				<option value="8" {$option_output['plugin_enlargeit_ani'][8]} >{$lang_plugin_enlargeit['topleftglide']}</option>
			</select>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_animation_animationtype" class="greybox" title="{$lang_plugin_enlargeit['animation_type']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['time_between_animation_steps']}
		</td>
		<td colspan="1">
			<input type="number" name="plugin_enlargeit_speed" id="plugin_enlargeit_speed" class="textinput" size="2" maxlength="2" value="{$CONFIG['plugin_enlargeit_speed']}" {$option_output['plugin_enlargeit_speed']} /> {$lang_plugin_enlargeit['milliseconds']}
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_animation_steps" class="greybox" title="{$lang_plugin_enlargeit['time_between_animation_steps']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['animation_steps']}
		</td>
		<td colspan="1">
			<input type="number" name="plugin_enlargeit_maxstep" id="plugin_enlargeit_maxstep" class="textinput" size="2" maxlength="2" value="{$CONFIG['plugin_enlargeit_maxstep']}" {$option_output['plugin_enlargeit_maxstep']} />
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_animation_steps" class="greybox" title="{$lang_plugin_enlargeit['animation_steps']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<label for="plugin_enlargeit_opaglide" class="clickable_option">{$lang_plugin_enlargeit['transparency_for_glide']}</label>
		</td>
		<td colspan="1">
			<input type="checkbox" name="plugin_enlargeit_opaglide" id="plugin_enlargeit_opaglide" class="checkbox" value="1" {$option_output['plugin_enlargeit_opaglide']} />
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_animation_transparency" class="greybox" title="{$lang_plugin_enlargeit['transparency_for_glide']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td class="tableh1" colspan="3">
			{$lang_plugin_enlargeit['border']} <a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_border" class="greybox" title="{$lang_plugin_enlargeit['border']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['border_width']}
		</td>
		<td valign="top" colspan="1">
			<input type="number" name="plugin_enlargeit_brdsize" id="plugin_enlargeit_brdsize" class="textinput" size="2" maxlength="2" value="{$CONFIG['plugin_enlargeit_brdsize']}" /> ({$lang_plugin_enlargeit['zero_to_disable']})
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_border_width" class="greybox" title="{$lang_plugin_enlargeit['border_width']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['border_color']}
		</td>
		<td colspan="1">
			<input type="text" name="plugin_enlargeit_brdcolor" id="plugin_enlargeit_brdcolor" class="textinput" size="8" maxlength="7" value="{$CONFIG['plugin_enlargeit_brdcolor']}" style="text-transform:uppercase;" />
			<span class="detail_head_collapsed">{$lang_plugin_enlargeit['toggle_color_picker']}</span>
			<div id="colorpicker_bordercolor" class="detail_body"></div>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_border_color" class="greybox" title="{$lang_plugin_enlargeit['border_color']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['border_texture']}
		</td>
		<td valign="top">
			<select name="plugin_enlargeit_brdbck" id="plugin_enlargeit_brdbck" class="listbox" style="float:left;margin-right:5px;">
				{$border_texture_options}
			</select>
			<div id="borderpreview" style="background-image:url(./plugins/enlargeit/images/backgrounds/{$CONFIG['plugin_enlargeit_brdbck']}.png);background-repeat:repeat;width:200px;">{$lang_plugin_enlargeit['preview']}</div>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_border_texture" class="greybox" title="{$lang_plugin_enlargeit['border_texture']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<label for="plugin_enlargeit_brdround" class="clickable_option">{$lang_plugin_enlargeit['round_border']}</label>
		</td>
		<td colspan="1">
			<input type="checkbox" name="plugin_enlargeit_brdround" id="plugin_enlargeit_brdround" class="checkbox" value="1" {$option_output['plugin_enlargeit_brdround']} /> ({$lang_plugin_enlargeit['mozilla_only']})
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_border_round" class="greybox" title="{$lang_plugin_enlargeit['round_border']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td class="tableh1" colspan="3">
			{$lang_plugin_enlargeit['shadow']} <a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_shadow" class="greybox" title="{$lang_plugin_enlargeit['shadow']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['shadow_size']}
		</td>
		<td colspan="1">
			<input type="number" name="plugin_enlargeit_shadowsize" id="plugin_enlargeit_shadowsize" class="textinput" size="2" maxlength="1" value="{$CONFIG['plugin_enlargeit_shadowsize']}" /> {$lang_plugin_enlargeit['right_bottom']} ({$lang_plugin_enlargeit['zero_to_disable']})
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_shadow_size" class="greybox" title="{$lang_plugin_enlargeit['shadow_size']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['shadow_opacity']}
		</td>
		<td colspan="1">
			<input type="number" name="plugin_enlargeit_shadowintens" id="plugin_enlargeit_shadowintens" class="textinput" size="2" maxlength="2" value="{$CONFIG['plugin_enlargeit_shadowintens']}" />
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_shadow_opacity" class="greybox" title="{$lang_plugin_enlargeit['shadow_opacity']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['shadow_color']} 
		</td>
		<td colspan="1">
			<input type="text" name="plugin_enlargeit_shadowcolor" id="plugin_enlargeit_shadowcolor" class="textinput" size="8" maxlength="7" value="{$CONFIG['plugin_enlargeit_shadowcolor']}" style="text-transform:uppercase;" />
			<span class="detail_head_collapsed">{$lang_plugin_enlargeit['toggle_color_picker']}</span>
			<div id="colorpicker_shadowcolor" class="detail_body"></div>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_shadow_color" class="greybox" title="{$lang_plugin_enlargeit['shadow_color']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td class="tableh1" colspan="3">
			{$lang_plugin_enlargeit['title_bar']} <a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_title" class="greybox" title="{$lang_plugin_enlargeit['title_bar']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<label for="plugin_enlargeit_titlebar" class="clickable_option">{$lang_plugin_enlargeit['show_titlebar']}</label>
		</td>
		<td colspan="1">
			<input type="checkbox" name="plugin_enlargeit_titlebar" id="plugin_enlargeit_titlebar" class="checkbox" value="1" {$option_output['plugin_enlargeit_titlebar']} /> <label for="plugin_enlargeit_titlebar" class="clickable_option">({$lang_plugin_enlargeit['recommended']})</label>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_title_show_inactive" class="greybox" title="{$lang_plugin_enlargeit['show_titlebar']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['title_bar_text_color']} 
		</td>
		<td colspan="1">
			<input type="text" name="plugin_enlargeit_titletxtcol" id="plugin_enlargeit_titletxtcol" class="textinput" size="8" maxlength="7" value="{$CONFIG['plugin_enlargeit_titletxtcol']}" style="text-transform:uppercase;" />
			<span class="detail_head_collapsed">{$lang_plugin_enlargeit['toggle_color_picker']}</span>
			<div id="colorpicker_titletext" class="detail_body"></div>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_title_text_color" class="greybox" title="{$lang_plugin_enlargeit['title_bar_text_color']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['background_color_ajax_area']}
		</td>
		<td colspan="1">
			<input type="text" name="plugin_enlargeit_ajaxcolor" id="plugin_enlargeit_ajaxcolor" class="textinput" size="8" maxlength="7" value="{$CONFIG['plugin_enlargeit_ajaxcolor']}" style="text-transform:uppercase;" />
			<span class="detail_head_collapsed">{$lang_plugin_enlargeit['toggle_color_picker']}</span>
			<div id="colorpicker_backgroundcontent" class="detail_body"></div>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_title_background_color" class="greybox" title="{$lang_plugin_enlargeit['background_color_ajax_area']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td class="tableh1" colspan="3">
			{$lang_plugin_enlargeit['action']} <a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_action" class="greybox" title="{$lang_plugin_enlargeit['action']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<label for="plugin_enlargeit_center" class="clickable_option">{$lang_plugin_enlargeit['center_enlarge_images']}</label>
		</td>
		<td colspan="1">
			<input type="checkbox" name="plugin_enlargeit_center" id="plugin_enlargeit_center" class="checkbox" value="1" {$option_output['plugin_enlargeit_center']} /> <label for="plugin_enlargeit_center" class="clickable_option">({$lang_plugin_enlargeit['recommended']})</label>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_action_center" class="greybox" title="{$lang_plugin_enlargeit['center_enlarge_images']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<label for="plugin_enlargeit_dragdrop" class="clickable_option">{$lang_plugin_enlargeit['enable_drag_drop']}</label>
		</td>
		<td colspan="1">
			<input type="checkbox" name="plugin_enlargeit_dragdrop" id="plugin_enlargeit_dragdrop" class="checkbox" value="1" {$option_output['plugin_enlargeit_dragdrop']} /> <label for="plugin_enlargeit_dragdrop" class="clickable_option">({$lang_plugin_enlargeit['recommended']})</label>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_action_move" class="greybox" title="{$lang_plugin_enlargeit['enable_drag_drop']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<label for="plugin_enlargeit_wheelnav" class="clickable_option">{$lang_plugin_enlargeit['mouse_wheel_navigation']}</label>
		</td>
		<td colspan="1">
			<input type="checkbox" name="plugin_enlargeit_wheelnav" id="plugin_enlargeit_wheelnav" class="checkbox" value="1" {$option_output['plugin_enlargeit_wheelnav']} /> <label for="plugin_enlargeit_wheelnav" class="clickable_option">({$lang_plugin_enlargeit['recommended']})</label>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_action_wheel" class="greybox" title="{$lang_plugin_enlargeit['mouse_wheel_navigation']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top" valign="top">
			{$lang_plugin_enlargeit['darken_screen']}
		</td>
		<td colspan="1">
			<input type="radio" name="plugin_enlargeit_dark" id="plugin_enlargeit_dark_0" class="radio" value="0" {$option_output['plugin_enlargeit_dark_0']} /><label for="plugin_enlargeit_dark_0" class="clickable_option">{$lang_common['no']}</label><br />
			<input type="radio" name="plugin_enlargeit_dark" id="plugin_enlargeit_dark_1" class="radio" value="1" {$option_output['plugin_enlargeit_dark_1']} /><label for="plugin_enlargeit_dark_1" class="clickable_option">{$lang_common['yes']}: {$lang_plugin_enlargeit['only_darken_when_image_shows']}</label><br />
			<input type="radio" name="plugin_enlargeit_dark" id="plugin_enlargeit_dark_2" class="radio" value="2" {$option_output['plugin_enlargeit_dark_2']} /><label for="plugin_enlargeit_dark_2" class="clickable_option">{$lang_common['yes']}: {$lang_plugin_enlargeit['remain_dark_when_using_navigation']}</label>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_action_darken_toggle" class="greybox" title="{$lang_plugin_enlargeit['darken_screen']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['darken_strength']}
		</td>
		<td colspan="1">
			<input type="number" name="plugin_enlargeit_darkprct" id="plugin_enlargeit_darkprct" class="textinput" size="2" maxlength="2" value="{$CONFIG['plugin_enlargeit_darkprct']}" /> %
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_action_darken_strength" class="greybox" title="{$lang_plugin_enlargeit['darken_strength']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['darkening_speed']}
		</td>
		<td colspan="1">
			<input type="number" name="plugin_enlargeit_darkensteps" id="plugin_enlargeit_darkensteps" class="textinput" size="2" maxlength="2" value="{$CONFIG['plugin_enlargeit_darkensteps']}" /> ({$lang_plugin_enlargeit['darkening_speed_explain']})
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_action_darken_speed" class="greybox" title="{$lang_plugin_enlargeit['darkening_speed']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td class="tableh1" colspan="3">
			{$lang_plugin_enlargeit['buttons']} <a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_buttons" class="greybox" title="{$lang_plugin_enlargeit['buttons']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<label for="plugin_enlargeit_buttonpic" class="clickable_option">{$enlargeit_icon_array['show']} {$lang_plugin_enlargeit['button_picture']}</label>
		</td>
		<td colspan="1">
			<input type="checkbox" name="plugin_enlargeit_buttonpic" id="plugin_enlargeit_buttonpic" class="checkbox" value="1" {$option_output['plugin_enlargeit_buttonpic']} />
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_buttons_picture" class="greybox" title="{$lang_plugin_enlargeit['button_picture']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$enlargeit_icon_array['info']} {$lang_plugin_enlargeit['button_info']}
		</td>
		<td colspan="1">
			<input type="radio" name="plugin_enlargeit_buttoninfo" id="plugin_enlargeit_buttoninfo_0" class="radio" value="0" {$option_output['plugin_enlargeit_buttoninfo_0']} /><label for="plugin_enlargeit_buttoninfo_0" class="clickable_option">{$lang_common['no']}</label><br />
			<input type="radio" name="plugin_enlargeit_buttoninfo" id="plugin_enlargeit_buttoninfo_1" class="radio" value="1" {$option_output['plugin_enlargeit_buttoninfo_1']} /><label for="plugin_enlargeit_buttoninfo_1" class="clickable_option">{$lang_common['yes']}: {$lang_plugin_enlargeit['open_as_ajax']}</label><br />
			<input type="radio" name="plugin_enlargeit_buttoninfo" id="plugin_enlargeit_buttoninfo_2" class="radio" value="2" {$option_output['plugin_enlargeit_buttoninfo_2']} /><label for="plugin_enlargeit_buttoninfo_2" class="clickable_option">{$lang_common['yes']}: {$lang_plugin_enlargeit['open_intermediate_page']}</label>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_buttons_info" class="greybox" title="{$lang_plugin_enlargeit['button_info']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<label for="plugin_enlargeit_buttonfav" class="clickable_option">{$enlargeit_icon_array['favorites']} {$lang_plugin_enlargeit['button_favorites']}</label>
		</td>
		<td colspan="1">
			<input type="checkbox" name="plugin_enlargeit_buttonfav" id="plugin_enlargeit_buttonfav" class="checkbox" value="1" {$option_output['plugin_enlargeit_buttonfav']} />
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_buttons_favorites" class="greybox" title="{$lang_plugin_enlargeit['button_favorites']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<!--
	<tr>
		<td valign="top">
			<label for="plugin_enlargeit_buttonvote" class="clickable_option">{$enlargeit_icon_array['vote']} {$lang_plugin_enlargeit['button_vote']}</label>
		</td>
		<td colspan="1">
			<input type="checkbox" name="plugin_enlargeit_buttonvote" id="plugin_enlargeit_buttonvote" class="checkbox" value="1" {$option_output['plugin_enlargeit_buttonvote']}  disabled="disabled" /> (<em>{$lang_plugin_enlargeit['not_implemented_yet']}</em>)
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_buttons_vote" class="greybox" title="{$lang_plugin_enlargeit['button_vote']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<label for="plugin_enlargeit_buttoncomment" class="clickable_option">{$enlargeit_icon_array['comment']} {$lang_plugin_enlargeit['button_comments']}</label>
		</td>
		<td colspan="1">
			<input type="checkbox" name="plugin_enlargeit_buttoncomment" id="plugin_enlargeit_buttoncomment" class="checkbox" value="1" {$option_output['plugin_enlargeit_buttoncomment']}  disabled="disabled" /> (<em>{$lang_plugin_enlargeit['not_implemented_yet']}</em>)
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_buttons_comments" class="greybox" title="{$lang_plugin_enlargeit['button_comments']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	-->
	<tr>
		<td valign="top">
			{$enlargeit_icon_array['download']} {$lang_plugin_enlargeit['button_download']}
		</td>
		<td colspan="1">
			<input type="radio" name="plugin_enlargeit_buttondownload" id="plugin_enlargeit_buttondownload_0" class="radio" value="0" {$option_output['plugin_enlargeit_buttondownload_0']} /><label for="plugin_enlargeit_buttondownload_0" class="clickable_option">{$lang_common['no']}</label><br />
			<input type="radio" name="plugin_enlargeit_buttondownload" id="plugin_enlargeit_buttondownload_2" class="radio" value="2" {$option_output['plugin_enlargeit_buttondownload_2']} /><label for="plugin_enlargeit_buttondownload_2" class="clickable_option">{$lang_common['yes']}: {$lang_plugin_enlargeit['for_registered_users_only']}</label><br />
			<input type="radio" name="plugin_enlargeit_buttondownload" id="plugin_enlargeit_buttondownload_1" class="radio" value="1" {$option_output['plugin_enlargeit_buttondownload_1']} /><label for="plugin_enlargeit_buttondownload_1" class="clickable_option">{$lang_common['yes']}: {$lang_plugin_enlargeit['for_all']}</label>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_buttons_download" class="greybox" title="{$lang_plugin_enlargeit['button_download']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<label for="plugin_enlargeit_buttonbbcode" class="clickable_option">{$enlargeit_icon_array['bbcode']} {$lang_plugin_enlargeit['button_bbcode']}</label>
		</td>
		<td colspan="1">
			<input type="checkbox" name="plugin_enlargeit_buttonbbcode" id="plugin_enlargeit_buttonbbcode" class="checkbox" value="1" {$option_output['plugin_enlargeit_buttonbbcode']} />
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_buttons_bbcode" class="greybox" title="{$lang_plugin_enlargeit['button_bbcode']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<label for="plugin_enlargeit_buttonhist" class="clickable_option">{$enlargeit_icon_array['histogram']} {$lang_plugin_enlargeit['button_histogram']}</label>
		</td>
		<td>
			<input type="checkbox" name="plugin_enlargeit_buttonhist" id="plugin_enlargeit_buttonhist" class="checkbox" value="1" {$option_output['plugin_enlargeit_buttonhist']} /> <label for="plugin_enlargeit_buttonhist" class="clickable_option">({$gd_version_string})</label>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_buttons_histogram" class="greybox" title="{$lang_plugin_enlargeit['button_histogram']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<label for="plugin_enlargeit_buttonnav" class="clickable_option">{$enlargeit_icon_array['next']} {$lang_plugin_enlargeit['button_navigation']}</label>
		</td>
		<td colspan="1">
			<input type="checkbox" name="plugin_enlargeit_buttonnav" id="plugin_enlargeit_buttonnav" class="checkbox" value="1" {$option_output['plugin_enlargeit_buttonnav']} /> <label for="plugin_enlargeit_buttonnav" class="clickable_option">({$lang_plugin_enlargeit['recommended']})</label>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_buttons_navigation" class="greybox" title="{$lang_plugin_enlargeit['button_navigation']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<label for="plugin_enlargeit_buttonclose" class="clickable_option">{$enlargeit_icon_array['close']} {$lang_plugin_enlargeit['button_close']}</label>
		</td>
		<td colspan="1">
			<input type="checkbox" name="plugin_enlargeit_buttonclose" id="plugin_enlargeit_buttonclose" class="checkbox" value="1" {$option_output['plugin_enlargeit_buttonclose']} /> <label for="plugin_enlargeit_buttonclose" class="clickable_option">({$lang_plugin_enlargeit['recommended']})</label>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_buttons_close" class="greybox" title="{$lang_plugin_enlargeit['button_close']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td class="tableh1" colspan="3">
			{$lang_plugin_enlargeit['multimedia']} <a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_multimedia" class="greybox" title="{$lang_plugin_enlargeit['multimedia']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['image_formats']}
		</td>
		<td valign="top">
		    <select name="plugin_enlargeit_img_types[]" id="plugin_enlargeit_img_types" size="5" multiple="multiple" class="listbox">

EOT;
$current_format_config_array = explode('/', $CONFIG['plugin_enlargeit_img_types']);
$current_upload_allowed_array = explode('/', ($CONFIG['allowed_doc_types'] . '/' . $CONFIG['allowed_img_types'] . '/' . $CONFIG['allowed_mov_types'] . '/' . $CONFIG['allowed_snd_types']));
foreach ($enlargeit_supported_image_file_array as $key) {
    $format_name = strtoupper($key) . ' - ' . $lang_plugin_enlargeit[$key];
    if (in_array($key, $current_format_config_array) == TRUE) {
        $img_type_output[$key] = 'selected="selected"';
    } else {
        $img_type_output[$key] = '';
    }
    if (in_array($key, $current_upload_allowed_array) != TRUE) {
        $format_name .= '*';
    } 
    echo <<< EOT
			<option value="{$key}" {$img_type_output[$key]} >{$format_name}</option>

EOT;
}
echo <<< EOT
            </select>
        </td>
        <td valign="top">
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_multimedia_imageformats" class="greybox" title="{$lang_plugin_enlargeit['image_formats']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
        </td>	
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['video_formats']}
		</td>
		<td valign="top">
		    <select name="plugin_enlargeit_mov_types[]" id="plugin_enlargeit_mov_types" size="4" multiple="multiple" class="listbox">

EOT;
$current_format_config_array = explode('/', $CONFIG['plugin_enlargeit_mov_types']);
$current_upload_allowed_array = explode('/', ($CONFIG['allowed_doc_types'] . '/' . $CONFIG['allowed_img_types'] . '/' . $CONFIG['allowed_mov_types'] . '/' . $CONFIG['allowed_snd_types']));
foreach ($enlargeit_supported_video_file_array as $key) {
    $format_name = strtoupper($key) . ' - ' . $lang_plugin_enlargeit[$key];
    if (in_array($key, $current_format_config_array) == TRUE) {
        $mov_type_output[$key] = 'selected="selected"';
    } else {
        $mov_type_output[$key] = '';
    }
    if (in_array($key, $current_upload_allowed_array) != TRUE) {
        $format_name .= '*';
    } 
    echo <<< EOT
			<option value="{$key}" {$mov_type_output[$key]} >{$format_name}</option>

EOT;
}
echo <<< EOT
            </select>
        </td>
        <td valign="top">
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_multimedia_videoformats" class="greybox" title="{$lang_plugin_enlargeit['video_formats']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
        </td>	
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['flash_player']}
		</td>
		<td colspan="1">
			<input type="radio" name="plugin_enlargeit_flvplayer" id="plugin_enlargeit_flvplayer_0" class="radio" value="0" {$option_output['plugin_enlargeit_flvplayer_0']} /><label for="plugin_enlargeit_flvplayer_0" class="clickable_option">{$lang_plugin_enlargeit['rphmedia']}</label><br />
			<input type="radio" name="plugin_enlargeit_flvplayer" id="plugin_enlargeit_flvplayer_1" class="radio" value="1" {$option_output['plugin_enlargeit_flvplayer_1']} /><label for="plugin_enlargeit_flvplayer_1" class="clickable_option">{$lang_plugin_enlargeit['os_flv']}</label>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_multimedia_flv" class="greybox" title="{$lang_plugin_enlargeit['flash_player']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td class="tableh1" colspan="3">
			{$lang_plugin_enlargeit['plugin_setup']} <a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_setup" class="greybox" title="{$lang_plugin_enlargeit['plugin_setup']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<label for="plugin_enlargeit_adminmenu" class="clickable_option">{$lang_plugin_enlargeit['display_plugin_config_in_admin_menu']}</label>
		</td>
		<td colspan="1">
			<input type="checkbox" name="plugin_enlargeit_adminmenu" id="plugin_enlargeit_adminmenu" class="checkbox" value="1" {$option_output['plugin_enlargeit_adminmenu']} />
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_setup_adminmenu" class="greybox" title="{$lang_plugin_enlargeit['display_plugin_config_in_admin_menu']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td valign="top">
			{$lang_plugin_enlargeit['histogram_cache_file_lifetime']}<br />
			<span style="visibility:{$cache_visibility}" id="cache_visibility">(<em>{$cached_files}</em>)</span>
		</td>
		<td colspan="1">
			<input type="radio" name="plugin_enlargeit_cachecontrol" id="plugin_enlargeit_cachecontrol_0" class="radio" value="0" {$option_output['plugin_enlargeit_cachecontrol_0']} /><label for="plugin_enlargeit_cachecontrol_0" class="clickable_option">{$lang_plugin_enlargeit['unlimited']}</label><br />
			<input type="radio" name="plugin_enlargeit_cachecontrol" id="plugin_enlargeit_cachecontrol_1" class="radio" value="1" {$option_output['plugin_enlargeit_cachecontrol_1']} />
			<label for="plugin_enlargeit_cachecontrol_1" class="clickable_option"><input type="number" name="plugin_enlargeit_cachemaxage" id="plugin_enlargeit_cachemaxage" class="textinput" size="3" maxlength="3" value="{$CONFIG['plugin_enlargeit_cachemaxage']}" {$option_output['plugin_enlargeit_cachemaxage']} /> {$lang_plugin_enlargeit['days']}</label><br />
			<input type="radio" name="plugin_enlargeit_cachecontrol" id="plugin_enlargeit_cachecontrol_2" class="radio" value="2" {$option_output['plugin_enlargeit_cachecontrol_2']} /><label for="plugin_enlargeit_cachecontrol_2" class="clickable_option">{$lang_plugin_enlargeit['max_file_size_total']}:
			<input type="number" name="plugin_enlargeit_cachemaxsizemb" id="plugin_enlargeit_cachemaxsizemb" class="textinput" size="3" maxlength="3" value="{$CONFIG['plugin_enlargeit_cachemaxsizemb']}" {$option_output['plugin_enlargeit_cachemaxsizemb']} />{$lang_byte_units[2]}</label>
		</td>
		<td>
			<a href="plugins/enlargeit/docs/{$documentation_file}.htm#configuration_setup_histogram" class="greybox" title="{$lang_plugin_enlargeit['histogram_cache_file_lifetime']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
		</td>
	</tr>
	<tr>
		<td class="tablef" colspan="3">
			<input type="hidden" name="form_token" value="{$form_token}" />
			<input type="hidden" name="timestamp" value="{$timestamp}" />
			<button type="submit" class="button" name="submit" value="{$lang_plugin_enlargeit['submit']}">{$enlargeit_icon_array['ok']}{$lang_plugin_enlargeit['submit']}</button>
		</td>
	</tr>
EOT;

endtable();
echo <<< EOT
</form>
EOT;
pagefooter();
