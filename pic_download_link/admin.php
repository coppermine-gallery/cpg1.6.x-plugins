<?php
  /*******************************************************
  			Add Meta Descriptions and canonical references 
  			By Joe Carver 
			Version 1.4 - 14 June 2010 
  *******************************************************/

    require_once('plugins/pic_download_link/init.inc.php');

	if (!GALLERY_ADMIN_MODE) {
		cpg_die(ERROR, $lang_errors['perm_denied'], __FILE__, __LINE__);
	}
	pageheader(sprintf($pic_link['configure_plugin_x'], $pic_link['display_name']));
	
    global $lang_plugin_php, $CONFIG, $lang_common, $lang_pluginmgr_php, $lang_admin_php, $icon_array;

	list($timestamp, $form_token) = getFormToken();

	// get sanitized POST parameters
		if ($superCage->post->keyExists('submit')) {
		//Check if the form token is valid
		if(!checkFormToken()){
			cpg_die(ERROR, $lang_errors['invalid_form_token'], __FILE__, __LINE__);
		}

  // Define the sanitization patterns
  $sanitization_array = array(  
	  'down_link_user' => array('type' => 'int', 'min' => '0', 'max' => '1'),
	  'down_link_whichone' => array('type' => 'int', 'min' => '0', 'max' => '1'),
	  'down_link_hideprefix' => array('type' => 'int', 'min' => '0', 'max' => '1'),
	  'down_link_locate' => array('type' => 'int', 'min' => '0', 'max' => '3'),
	  'down_link_span_attr' => array('type' => 'stringmatch', 'match' =>  '/^[A-Za-z0-9 _\.\,\:\;\-\+\*\=\&\#\"\']*$/'),
	  'down_link_use_content_disposition' => array('type' => 'int', 'min' => '0', 'max' => '1'),
	  'down_link_enabled_categories_regex' => array('type' => 'stringmatch', 'match' => '/[[:print:]]*/')
	  );
  $config_changes_counter = 0;
  foreach ($sanitization_array as $san_key => $san_value) {
      if (isset($CONFIG[$san_key]) == TRUE) { // only loop if config value is set --- start
          if ($san_value['type'] == 'int') { // type is integer --- start
              if ($superCage->post->getInt($san_key) <= $san_value['max'] && $superCage->post->getInt($san_key) >= $san_value['min'] && $superCage->post->getInt($san_key) != $CONFIG[$san_key]) {
                  $CONFIG[$san_key] = $superCage->post->getInt($san_key);
                  cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value='{$CONFIG[$san_key]}' WHERE name='$san_key'");
                  $config_changes_counter++;
              }
          } // type is integer --- end
 	  elseif ($san_value['type'] == 'stringmatch') { // type is stringmatch --- start
	      $testarr = $superCage->post->getMatched($san_key, $san_value['match']);
	      if ($testarr) {
		     $testval = $testarr[0];      
 	             if ($testval != $CONFIG[$san_key]) {
	                  $CONFIG[$san_key] = $testval;
	                  cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value='" . mysql_real_escape_string($CONFIG[$san_key]) . "' WHERE name='$san_key'");
        	          $config_changes_counter++;
		     }
              }
          } // type is stringmatch --- end
      } // only loop if config value is set --- end
  }
}	

// Set the option outputs for the form variables
if ($CONFIG['down_link_user'] == '1') {
	$option_output['down_link_user'] = 'checked="checked"';
} else { 
	$option_output['down_link_user'] = '';
}

if ($CONFIG['down_link_use_content_disposition'] == '1') {
	$option_output['down_link_use_content_disposition'] = 'checked="checked"';
} else { 
	$option_output['down_link_use_content_disposition'] = '';
}

if ($CONFIG['down_link_hideprefix'] == '1') {
	$option_output['down_link_hideprefix'] = 'checked="checked"';
} else { 
	$option_output['down_link_hideprefix'] = '';
}
	
	// start form
	$superCage = Inspekt::makeSuperCage();
	echo <<< EOT
	<form name="cpgform" id="cpgform" action="{$_SERVER['REQUEST_URI']}" method="post">
EOT;
	
	starttable('100%',  sprintf($pic_link['configure_plugin_x'], $pic_link['display_name']), 2, 'cpg_zebra');	
	
	// reply with success to changes or no changes made
	if ($superCage->post->keyExists('submit')) {
    echo <<< EOT
	<tr>
		<td class="tableh2" colspan="2">
EOT;
    if ($config_changes_counter > 0) {
        msg_box('', $pic_link['update_success'], '', '', 'success');
    } else {
        msg_box('', $pic_link['no_changes'], '', '', 'validation');
    }
echo <<< EOT
		</td>
	</tr>
EOT;
}

$options_cfg_locate = '';
for($i=0; $i<=3; $i++) {
        $options_cfg_locate .= '<input type="radio" class="radio" id="down_link_locate_'.$i.'" name="down_link_locate" value="'.$i.'"';
        if ($i == $CONFIG['down_link_locate']) {
                $options_cfg_locate .= 'checked="checked"';
        }
        $options_cfg_locate .= ' /><label for="down_link_locate_'.$i.'">'.$pic_link['link_locate_'.$i].'</label><br />';
}
$options_cfg_whichone = '';
for($i=0; $i<=1; $i++) {
        $options_cfg_whichone .= '<input type="radio" class="radio" id="down_link_whichone_'.$i.'" name="down_link_whichone" value="'.$i.'" onchange="javascript:plugin_down_link_hideprefix_visibility();" ';
        if ($i == $CONFIG['down_link_whichone']) {
                $options_cfg_whichone .= 'checked="checked"';
        }
        $options_cfg_whichone .= ' /><label for="down_link_whichone_'.$i.'">'.$pic_link['whichone_'.$i].'</label><br />';
}

$html_enabled_categories_regex = htmlentities($CONFIG['down_link_enabled_categories_regex']);
$html_span_attr = htmlentities($CONFIG['down_link_span_attr']);
echo <<< EOT
			<tr>
				<td colspan="2" class="tableh2">
				<b>{$pic_link['page_head']}</b>
				</td>
			</tr>
			<tr>
				<td class="tableb" width="40%">
                {$pic_link['enabled_categories_regex']} <a href="plugins/pic_download_link/docs/{$documentation_file}.htm#down_link_enabled_categories_regex" class="greybox" title="{$pic_link['enabled_categories_regex']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
				</td>
				<td class="tableb">
<!--				<input type="string" name="down_link_enabled_categories_regex" id="down_link_enabled_categories_regex" class="textinput" style="width:90%" value="{$html_enabled_categories_regex}" /> -->
				<textarea name="down_link_enabled_categories_regex" id="down_link_enabled_categories_regex" class="textinput" style="width:90%;height:90%">{$html_enabled_categories_regex}</textarea>
				</td>
            </tr>
            <tr>
				<td class="tableb tableb_alternate " width="40%">
                {$pic_link['link_user']} <a href="plugins/pic_download_link/docs/{$documentation_file}.htm#down_link_user" class="greybox" title="{$pic_link['link_user']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
				</td>
				<td class="tableb tableb_alternate ">
                <input type="checkbox" name="down_link_user" id="down_link_user" class="checkbox" value="1" {$option_output['down_link_user']} />
                <label for="down_link_user" class="clickable_option">{$lang_common['yes']}</label>
				</td>
            </tr>
			<tr>
				<td class="tableb" width="40%">
                {$pic_link['link_locate']} <a href="plugins/pic_download_link/docs/{$documentation_file}.htm#down_link_locate" class="greybox" title="{$pic_link['link_locate']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
				</td>
				<td class="tableb">
				{$options_cfg_locate}
				</td>
            </tr>
			<tr>
				<td class="tableb tableb_alternate " width="40%">
                {$pic_link['span_attr']} <a href="plugins/pic_download_link/docs/{$documentation_file}.htm#down_link_span_attr" class="greybox" title="{$pic_link['span_attr']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
				</td>
				<td class="tableb tableb_alternate ">
<!--				<input type="string" name="down_link_span_attr" id="down_link_span_attr" class="textinput" style="width:90%" value="{$html_span_attr}" /> -->
				<textarea name="down_link_span_attr" id="down_link_span_attr" class="textinput" style="width:90%;height:90%">{$html_span_attr}</textarea>
				</td>
            </tr>
			<tr>
				<td class="tableb" width="40%">
                {$pic_link['whichone']} <a href="plugins/pic_download_link/docs/{$documentation_file}.htm#down_link_whichone" class="greybox" title="{$pic_link['link_whichone']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
				</td>
				<td class="tableb">
				{$options_cfg_whichone}
				</td>
            </tr>
			<tr>
				<td class="tableb tableb_alternate " width="40%">
                {$pic_link['use_content_disposition']} <a href="plugins/pic_download_link/docs/{$documentation_file}.htm#down_link_use_content_disposition" class="greybox" title="{$pic_link['use_content_disposition']}"><img src="images/help.gif" width="13" height="11" border="0" alt="" /></a>
				</td>
				<td class="tableb tableb_alternate">
				<input type="checkbox" onchange="javascript:plugin_down_link_hideprefix_visibility();" name="down_link_use_content_disposition" id="down_link_use_content_disposition" class="checkbox" value="1" {$option_output['down_link_use_content_disposition']} />
				<label for="down_link_use_content_disposition" class="clickable_option">{$lang_common['yes']}</label>
				<span id="down_link_hideprefix_span">&nbsp;
				<input type="checkbox" name="down_link_hideprefix" id="down_link_hideprefix" class="checkbox" value="1" {$option_output['down_link_hideprefix']} />
				<label for="down_link_hideprefix" class="clickable_option">{$pic_link['hideprefix']}</label>
				</span>
				<script type="text/javascript">
                                function plugin_down_link_hideprefix_visibility() {
                                	value = document.getElementById('down_link_use_content_disposition').checked && document.getElementById('down_link_whichone_1').checked;
                                	document.getElementById('down_link_hideprefix_span').style.display = value ? 'inline' : 'none';
				}
				plugin_down_link_hideprefix_visibility();
				</script>
				</td>
            </tr>
			<tr>
				<td colspan="2" class="tableb" align="right">
					<span>
					<input type="hidden" name="form_token" value="{$form_token}" />
					<input type="hidden" name="timestamp" value="{$timestamp}" />
					<input class="admin_menu" type="submit" name="submit" value="{$pic_link['submit_change']}" /> 
					</span>
				</td>
			</tr>
		</td>		
EOT;

	endtable();
	echo <<< EOT
	</form>
EOT;

	pagefooter();
	ob_end_flush();

?>