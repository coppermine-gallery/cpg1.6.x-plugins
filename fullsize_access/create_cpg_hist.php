<?php

// create_cpg_hist.php

function create_hist_table(){

	global $CONFIG;	
	$tabname = $CONFIG['TABLE_PREFIX'] . "fullsize_hist";

	$query = "CREATE TABLE IF NOT EXISTS " . $tabname . " (" .
		 "`id` int(10) unsigned NOT NULL auto_increment," .
		 "`uid` int(10) unsigned NOT NULL default '0'," .
		 "`tstamp` datetime NOT NULL default '0000-00-00 00:00:00'," .
		 "`picname` varchar(255) NOT NULL default ''," .
		 "`ip` varchar(20) NOT NULL default ''," .
		 "PRIMARY KEY  (`id`)," .
		 "UNIQUE KEY `multi` (`uid`,`picname`)" .
		  ") ENGINE=MyISAM";
		  
	cpg_db_query( $query );          
}  
