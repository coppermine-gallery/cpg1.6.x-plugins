<?php
define('IN_COPPERMINE', true);
define('THUMBNAILS_PHP', true);
define('INDEX_PHP', true);
chdir('../../');
require('include/init.inc.php');
chdir('plugins/fullsize_access');
require('fullsize_secure.php');
require_once('fullsize_check.php');
chdir('../../');

if( !fullsize_check_user() )
 {cpg_die(ERROR, "Sorry, no access to fullsize images for guests!",1,1);return;} 
//Header( "Content-type: image/jpeg");

if($superCage->get->keyExists('pid')){
	$file = create_fullsize_read__($superCage->get->getInt('pid'));
	//header("Content-Disposition: attachment; filename=\"" . $HTTP_GET_VARS["file"] . "\"");
	//include($HTTP_GET_VARS["file"]);
	//secure_fullsize($tmp);

//echo  $file;

	header('Content-Description: File Transfer'); 
	header('Content-Type: application/force-download'); 
	header('Content-Length: ' . filesize($file)); 
	header('Content-Disposition: attachment; filename=' . basename($file)); 
	readfile($file);

	secure_fullsize($file);
	
}

?>

