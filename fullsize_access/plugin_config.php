<?php
/**************************************************
  Coppermine Plugin - Fullsize Access
  *************************************************
  Copyright (c) 2006 KLaus Schwarzburg
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.
  *************************************************/

global $CONFIG, $lang_meta_album_names, $lang_yes, $lang_no;
global $lang_plugin_searchalbum, $lang_plugin_searchalbum_config;

if (!GALLERY_ADMIN_MODE) cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);

//require('plugins/search_album/include/init.inc.php');


	if ($superCage->post->keyExists('update_config')) {
		
		$ksfa_sec = 0;	
		if ($superCage->post->keyExists('ksfa_sec')) {
			$ksfa_sec = 1;
		}
		$ksfa_hist = 0;	
		if ($superCage->post->keyExists('ksfa_hist')) {
			$ksfa_hist = 1;
		}
		$ksfa_email = 0;	
		if ($superCage->post->keyExists('ksfa_email')) {
			$ksfa_email = 1;
		}
		$ksfa_cemail = 0;	
		if ($superCage->post->keyExists('ksfa_cemail')) {
			$ksfa_cemail = 1;
		}
		$ksfa_zip = 0;	
		if ($superCage->post->keyExists('ksfa_zip')) {
			$ksfa_zip = 1;
		}

		$CONFIG['plugin_ks_fullsize_to_email'] = $superCage->post->getEscaped('email_to');
		$CONFIG['plugin_ks_fullsize_from_email'] = $superCage->post->getEscaped('email_from');
		$CONFIG['plugin_ks_fullsize_message_for_customer'] = $superCage->post->getEscaped('email_cust');
		$CONFIG['plugin_ks_fullsize_filesecure']  = $ksfa_sec;
		$CONFIG['plugin_ks_fullsize_history']  = $ksfa_hist;
		$CONFIG['plugin_ks_fullsize_sendemail']  = $ksfa_email;
		$CONFIG['plugin_ks_fullsize_mailcustomer']  = $ksfa_cemail;
		$CONFIG['plugin_ks_fullsize_zip']  = $ksfa_zip;
		
		$sql = "UPDATE {$CONFIG['TABLE_CONFIG']} SET value = $ksfa_sec WHERE name = 'plugin_ks_fullsize_filesecure'";
		cpg_db_query($sql);							
		$sql = "UPDATE {$CONFIG['TABLE_CONFIG']} SET value = $ksfa_hist WHERE name = 'plugin_ks_fullsize_history'";
		cpg_db_query($sql);							
		$sql = "UPDATE {$CONFIG['TABLE_CONFIG']} SET value = $ksfa_email WHERE name = 'plugin_ks_fullsize_sendemail'";
		cpg_db_query($sql);	
		$sql = "UPDATE {$CONFIG['TABLE_CONFIG']} SET value = $ksfa_cemail WHERE name = 'plugin_ks_fullsize_mailcustomer'";
		cpg_db_query($sql);		
		$sql = "UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '{$CONFIG['plugin_ks_fullsize_to_email']}' WHERE name = 'plugin_ks_fullsize_to_email'";
		cpg_db_query($sql);							
		$sql = "UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '{$CONFIG['plugin_ks_fullsize_from_email']}' WHERE name = 'plugin_ks_fullsize_from_email'";
		cpg_db_query($sql);	
		$sql = "UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '{$CONFIG['plugin_ks_fullsize_message_for_customer']}' WHERE name = 'plugin_ks_fullsize_message_for_customer'";
		cpg_db_query($sql);		
		$sql = "UPDATE {$CONFIG['TABLE_CONFIG']} SET value = $ksfa_zip WHERE name = 'plugin_ks_fullsize_zip'";
		cpg_db_query($sql);	
		
	}//update
	elseif ($superCage->post->keyExists('history')) {
		header ("Location: index.php?file=fullsize_access/fullsize_hist");
	}
	elseif ($superCage->post->keyExists('secure')) {
		require_once('plugins/fullsize_access/fullsize_secure.php');
		secure_all();
	}
	elseif ($superCage->post->keyExists('unsecure')) {
		require_once('plugins/fullsize_access/fullsize_secure.php');
		unsecure_all();
	}



pageheader('Access Control to fullsize pics - Configuration');

starttable('100%');
echo <<< EOT
	<tr>
	<td class="tableh1" width="90%"><b>Fullsize Access Plugin</b> 
		- <a href="pluginmgr.php" class="admin_menu">Plugin Manager</a>
	</td>
	</tr>
	<tr><td class="tableb">
	<form method="post">
	<br />
EOT;

$ksfa_sec = '';
if ($CONFIG['plugin_ks_fullsize_filesecure'] != 0) {
	$ksfa_sec = 'checked';	
}

$ksfa_hist = '';
if ($CONFIG['plugin_ks_fullsize_history'] != 0) {
	$ksfa_hist = 'checked';	
}

$ksfa_email = '';
if ($CONFIG['plugin_ks_fullsize_sendemail'] != 0) {
	$ksfa_email = 'checked';	
}

$ksfa_cemail = '';
if ($CONFIG['plugin_ks_fullsize_mailcustomer'] != 0) {
	$ksfa_cemail = 'checked';	
}
$ksfa_zip = '';
if ($CONFIG['plugin_ks_fullsize_zip'] != 0) {
	$ksfa_zip = 'checked';	
}



echo <<< EOT
		<form method="post">

		<strong>Secure fullsize pics via filesystem: &nbsp;&nbsp;</strong>
		<input type="checkbox" name="ksfa_sec" value="1" $ksfa_sec>		
		<br /><br />
		
		<strong>Maintain history/log for fullsize downloads:&nbsp;&nbsp;</strong>
		<input type="checkbox" name="ksfa_hist" value="1" $ksfa_hist>		
		<br /><br />
		<!--
		<strong>Allow ZIP download for albums and favorites:&nbsp;&nbsp;</strong>
		<input type="checkbox" name="ksfa_zip" value="1" $ksfa_zip>		
		<br /><br />
		-->
		
		<strong>Send email to admin for each download: &nbsp;&nbsp;</strong>
		<input type="checkbox" name="ksfa_email" value="1" $ksfa_email>		
		<br /><br />

		<strong>Send email to downloader/customer for each download: &nbsp;&nbsp;</strong>
		<input type="checkbox" name="ksfa_cemail" value="1" $ksfa_cemail>		
		<br /><br />


		<nobr>- Admin Email To-address: 
			<input type="text" class="textinput" maxlength="100" size="50" name="email_to" value="{$CONFIG['plugin_ks_fullsize_to_email']}"/></nobr>
		<br /><br />
		<nobr>- Admin Email From-Address: 
			<input type="text" class="textinput" maxlength="40" size="50" name="email_from" value="{$CONFIG['plugin_ks_fullsize_from_email']}"/></nobr>
		<br /><br />
		
		- Email message to customer: <br>
			<textarea rows="8" cols="90" class="textinput" maxlength="256" size="50" name="email_cust">{$CONFIG['plugin_ks_fullsize_message_for_customer']}</textarea><br />
		<br /><br />
		
		
		
		<table><tr><td>
			<input type="submit" value="update config" name="update_config"/>
		</td>
		<td>
			<input type="submit" value="show download history" name="history"/>
		</td></tr></table>
		</form>
EOT;

echo '</td></tr>'."\n";

if ($CONFIG['plugin_ks_fullsize_filesecure'] != 0) {
		
	echo '<tr><td class="tableb">'."\n";
	echo <<< EOT
	You have enabled the option <b>'Secure fullsize pics via filesystem'</b>'. If you have not done yet, 
	you must edit the file <b>'plugins\fullsize_access\fullsize_secure.php'</b>. See instructions there!<br><br>
	Here are some caveats when using this option:
	<ul>
	<li>Coppermines internal functions are not able to access the fullsize pics anymore! This means that you cannot use
	the coppermine image editor for example.</li>
	<li>If you to need a temporary access to all fullsize pics you can execute the <b>unsecure all files</b> option
	below. To secure all files again, execute the <b>secure all files</b> option!</li>
	<li>If you enable the <b>'Secure fullsize pics via filesystem'</b>' option in this dialog your files are not automatically 
	secured. Please use the buttons below (dont forget to edit the fullsize_secure.php file)!</li>
	<li>New files uploaded to the gallery are not automatically secured. Again, use
	the secure all files button below</li>
	</ul>
	<br>
	<form method="post">
	<input type="submit" value="unsecure all files" name="unsecure"/>
	</form>
	<form method="post">
	<input type="submit" value="secure all files" name="secure"/>
	</form>
EOT;
	
	echo '</td></tr>'."\n";	
}

endtable();
pagefooter();
ob_end_flush();
?>
