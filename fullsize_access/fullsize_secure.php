<?php

// this file must be edited before use!



////////////////////// section to edit

	// edit ftp user/host data here:
	$ftp_server = "ftp.myhost.de";
	$ftp_user_name = "me";
	$ftp_user_pass = "hello";
	$ftppath_to_cpg = '/cpg/'; // this is the path to your cpg dir starting from your home page root (what the ftp sees by default)
	
////////////////////// end section to edit





function download_mail($filename,$uid) {

	global $CONFIG;
	
	$query = "SELECT user_name,user_email FROM " . $CONFIG['TABLE_USERS'] . " WHERE user_id=" . $uid;
	$res = cpg_db_query($query);
	$row = cpg_db_fetch_row($res);
	
	$txt = "Fullsize image <" . $filename . "> has been downloaded by user <" . $row[0] . "> " .
			"\nUsers email address is : " . $row[1]; 
	cpg_db_free_result($res);	
	
	mail($CONFIG['plugin_ks_fullsize_to_email'] ,"CPG Gallery download notification - " . $row[0],$txt,"From: " . $CONFIG['plugin_ks_fullsize_from_email']);
}


function download_mail_customer($filename,$uid) {

	global $CONFIG;
	
	$query = "SELECT user_name,user_email FROM " . $CONFIG['TABLE_USERS'] . " WHERE user_id=" . $uid;
	$res = cpg_db_query($query);
	$row = cpg_db_fetch_row($res);
	cpg_db_free_result($res);	
	
	$subj =$CONFIG['gallery_name'] . " -  your picture download (" .  $filename . ")";
	$txt = $CONFIG['plugin_ks_fullsize_message_for_customer'] . "\n";
		
	mail($row[1],$subj,$txt,"From: " . $CONFIG['plugin_ks_fullsize_to_email']);
}





function add_to_history($uid,$filename) {
 // ks add on
 	global $CONFIG, $raw_ip;
	
	$suc = 1;
	if( $CONFIG['plugin_ks_fullsize_history'] != 0) {		
		 		
		 $tabname = $CONFIG['TABLE_PREFIX'] . "fullsize_hist";
		 $query = "INSERT IGNORE INTO " . $tabname . " (uid,tstamp,picname,ip) VALUES(" . $uid . ",NOW(),'" . $filename . "','" . $raw_ip . "')"; 
		 $result = cpg_db_query($query);
		 $suc = cpg_db_affected_rows();
		 if( $suc > 0 ) {
		 
		}
	}
	if( $CONFIG['plugin_ks_fullsize_sendemail'] != 0 && $suc>0 ) {
		download_mail($filename,$uid);
	}
	if( $CONFIG['plugin_ks_fullsize_mailcustomer'] != 0 && $suc>0 ) {
		download_mail_customer($filename,$uid);
	}
	 return( $suc ); // zero if insert failed
 }
 

 
function create_fullsize_read__($pid) {
  global $CONFIG;
  
    $query = "SELECT filepath,filename FROM " . $CONFIG['TABLE_PICTURES'] . " WHERE pid=" . $pid;
	$res = cpg_db_query($query);
	$row = cpg_db_fetch_row($res);
	cpg_db_free_result($res);	
  
  return( create_fullsize_read_($CONFIG['fullpath'] . $row[0] . $row[1]) );
}  
 
 
 
function create_fullsize_read($path,$filename) {
  global $CONFIG;
  return( create_fullsize_read_($CONFIG['fullpath'] . $path . $filename) );
} 
 
function create_fullsize_read_($path) {
// copies the chmod secured files to the open world
	global $CONFIG,$ftp_server,$ftp_user_name,$ftp_user_pass,$ftppath_to_cpg,$USER_DATA;
	
	if( $CONFIG['plugin_ks_fullsize_filesecure'] > 0){
		
		$server_file = $ftppath_to_cpg . $path;	
			
		$conn_id = ftp_connect($ftp_server); 

		// login with username and password
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 

		// check connection
		if ((!$conn_id) || (!$login_result)) { 
	       echo "FTP connection has failed!";
	       echo "Attempted to connect to $ftp_server for user $ftp_user_name"; 
	       exit; 
		} else {
	       //echo "Connected to $ftp_server, for user $ftp_user_name";
		}
	   
	   ftp_site($conn_id, "chmod 0666 " .  $server_file);
	   
	   // close the FTP stream 
	   ftp_close($conn_id);
	}

	// add to history
	$tmp = basename($path);
	add_to_history($USER_DATA['user_id'],$tmp);
	
	

	return ( $path );
}


function secure_fullsize($file) {
// copies the chmod secured files to the open world
	global $ftp_server,$ftp_user_name,$ftp_user_pass,$ftppath_to_cpg;
	
	if( $CONFIG['plugin_ks_fullsize_filesecure'] == 0){return;}
	
	$file = $ftppath_to_cpg . $file;
	
	$conn_id = ftp_connect($ftp_server); 

	// login with username and password
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 

	// check connection
	if ((!$conn_id) || (!$login_result)) { 
       echo "FTP connection has failed!";
       echo "Attempted to connect to $ftp_server for user $ftp_user_name"; 
       exit; 
   } else {
       //echo "Connected to $ftp_server, for user $ftp_user_name";
   }  
ftp_site($conn_id, "chmod 0660 " .  $file);

// close the FTP stream 
ftp_close($conn_id);

	return ;
}


function secure_all(){security_all(true);}
function unsecure_all(){security_all(false);}

function security_all($secure =false){
	
	global $CONFIG,$ftp_server,$ftp_user_name,$ftp_user_pass,$ftppath_to_cpg;
	
	if( $secure ){ $cmd = "chmod 0660 ";}
	else { $cmd = "chmod 0666 ";}
	$conn_id = ftp_connect($ftp_server); 

	// login with username and password
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 

	// check connection
	if ((!$conn_id) || (!$login_result)) { 
	       echo "FTP connection has failed!";
	       echo "Attempted to connect to $ftp_server for user $ftp_user_name"; 
	       exit; 
	   } else {
	       echo "Connected to $ftp_server, for user $ftp_user_name";
	   }
	   

	$query = "SELECT filepath,filename FROM " . $CONFIG['TABLE_PICTURES']
			. " WHERE filename LIKE '%.jpg' OR filename LIKE '%.png' OR filename LIKE '%.gif'";          
	$res = cpg_db_query( $query );          

	 while($row = cpg_db_fetch_row($res)) 
	  { 
	    $fn = $ftppath_to_cpg . $CONFIG['fullpath'] . $row[0] . $row[1];
	    ftp_site($conn_id, $cmd .  $fn);
	    //echo $fn;
	  }	  	  	  
	// close the FTP stream 
	ftp_close($conn_id);	  
	cpg_db_free_result($res);
}





?>