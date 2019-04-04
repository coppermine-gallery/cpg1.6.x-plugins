<?php
//---------------------------- fullsize access plugin for CPG 1.49
//---------------------------- Klaus Schwarzburg 2006
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

require_once('fullsize_check.php');


// ZIP download feature disabled (doesn't work because of missing library)
//$thisplugin->add_action('post_breadcrumb','ziplink');
function ziplink(){
	global $CONFIG;
	$superCage = Inspekt::makeSuperCage();
	
	if ($CONFIG['plugin_ks_fullsize_zip'] != 0 ){
	
	if( $superCage->get->testInt('album') and !$superCage->get->keyExists('pid') and fullsize_check_user()){
		echo '<div class="tableh1"><b>';
		echo '<a style="color:white; text-align:right;" href="plugins/fullsize_access/zipdownload_extended.php?album=' . $superCage->get->getInt('album') . '" >Download aller Bilder dieses Albums als ZIP Datei</a>';		
		echo '</b></div>';
	}
	if( strstr($superCage->get->getAlpha('album'),'favpics') != false  and !$superCage->get->keyExists('pid') and fullsize_check_user()){
		echo '<div class="tableh1"><b>';
		echo '<a style="color:white" href="plugins/fullsize_access/zipdownload_extended.php?fav' . '" >Download aller Favoriten als ZIP Datei</a>';		
		echo '</b></div>';
	}
	
	}
}

//Places a download link above the filename on the information list
$thisplugin->add_filter('file_info','download_link');

function  download_link($info)
{
	global $CURRENT_PIC_DATA,$CONFIG;
		
	$info = array_reverse($info);
	if( fullsize_check_user() ){		
		$info['Download'] .= '<a href="plugins/fullsize_access/jpgdownload.php?pid=' . $CURRENT_PIC_DATA['pid'] . '" >Download Original File</a>';		
	} else {
		$info['Download'] = 'Fullsize download for registered users only! Please, <a href="register.php" >Register</a> or <a href="login.php" >login</a>';
	}
	$info = array_reverse($info);
	return $info;
}


$thisplugin->add_filter('file_data','fullsize_disableclick');
// disable fullsize pic by clicking on normal_ pic
function fullsize_disableclick($cpicdata) {
	global $CONFIG;
	
		if(strpos($cpicdata['html'],'fullsize=1') !== false) {
			$cpicdata['html'] = preg_replace('/<a.*fullsize=1.*>(.*)<\/a>/Ui', '\\1', $cpicdata['html']);
			//$cpicdata['html'] = preg_replace('/alt=\".*\"/i','alt="'.$alt_text.'" title="'.$alt_text.'"',$cpicdata['html']);
		}
	
	return $cpicdata;
}





// ------------------------------------------------------------------------------------------------
// add config button
// ------------------------------------------------------------------------------------------------
function fullsize_add_config_button($href,$title,$target,$link)
{
  global $template_gallery_admin_menu;

  $new_template = $template_gallery_admin_menu;
  $button = template_extract_block($new_template,'documentation');
  $params = array(
      '{DOCUMENTATION_HREF}' => $href,
      '{DOCUMENTATION_TITLE}' => $title,
      'target="cpg_documentation"' => $target,
      '{DOCUMENTATION_LNK}' => $link,
   );
   $new_button="<!-- BEGIN $link -->".template_eval($button,$params)."<!-- END $link -->\n";
   template_extract_block($template_gallery_admin_menu,'documentation',"<!-- BEGIN documentation -->" . $button . "<!-- END documentation -->\n" . $new_button);
}

// ------------------------------------------------------------------------------------------------
// add admin button to start of each page
// ------------------------------------------------------------------------------------------------
$thisplugin->add_action('page_start','fullsize_pagestart');
function fullsize_pagestart()
{
	global $CONFIG;
	//require ('plugins/search_album/include/init.inc.php');

	if (GALLERY_ADMIN_MODE) {
		fullsize_add_config_button('index.php?file=fullsize_access/plugin_config','Configure fullsize access','','Fullsize');
	}
}






// Add an install action
$thisplugin->add_action('plugin_install','fullsize_install');

// Install function
function fullsize_install() {

	global $CONFIG;
    // Install
    $superCage = Inspekt::makeSuperCage();
    if ($superCage->post->getAlpha('test') == 'true')
    {
    	require_once('create_cpg_hist.php');
	create_hist_table();
	$sql = "INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (name, value)"
		." VALUES"
		."('plugin_ks_fullsize_filesecure','0')"
		.",('plugin_ks_fullsize_history','1')"
		.",('plugin_ks_fullsize_sendemail','0')"
		.",('plugin_ks_fullsize_allowed','1')"
		.",('plugin_ks_fullsize_to_email','admin@myhome.net')"
		.",('plugin_ks_fullsize_from_email','admin@myhome.net')"
		.",('plugin_ks_fullsize_mailcustomer','0')"
		.",('plugin_ks_fullsize_message_for_customer','Thank you for downloading this image!')"
		.",('plugin_ks_fullsize_zip','1')"
		;
		
	cpg_db_query($sql);	
			
        return true;

    // Loop again
    } else {

        return 1;
    }
}

// Add a configure action
$thisplugin->add_action('plugin_configure','fullsize_configure');

// Configure function
// Displays the mod instructions to fully activate the plugin
function fullsize_configure() {
	global $CONFIG;
	
    echo <<< EOT
    <h2>Confirm Installation!</h2>
    <p>
    If you want to use the security via file system (chmod) feature you must edit the file 'fullsize_secure.php'. See instructions there! 
    After you press 'Go! the installation will be finshed and a new menu item 'Fullsize'
    will appear in the Admin menu. Klick it to configure this plugin. Enjoy!
    </p>
    
   	<form method="post">
	<input type="hidden" name="test" value="true" /><br />
	<input type="submit" value="Go!" />
	</form>
EOT;
}


// Uninstall Plugin
$thisplugin->add_action('plugin_uninstall','fullsize_uninstall');

function fullsize_uninstall() {
	global $CONFIG;
	cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name REGEXP '^plugin_ks_fullsize_'");
	//unlink('fullsize_hist.php');
	return true;
}




?>
