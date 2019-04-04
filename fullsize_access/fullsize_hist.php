<?php

// create_cpg_hist.php
// run from within cpg dir

define('IN_COPPERMINE', true);
define('CALENDAR_PHP', true);


pageheader('gallery statistics and fullsize image download history');

echo '<br>';
$htab = $CONFIG['TABLE_PREFIX'] . "fullsize_hist";
$utab = $CONFIG['TABLE_USERS'];
$atab = $CONFIG['TABLE_ALBUMS'];
$ptab = $CONFIG['TABLE_PICTURES'];

if( !USER_IS_ADMIN ) {
 echo '<br><br><b>access to this page is restricted to administrators</b>';
 exit;
}

//echo "</br></br>";

starttable('100%','gallery statistics');

$query = "SELECT COUNT(*),AVG(hits),SUM(hits),SUM(filesize)/(1024*1024) FROM {$ptab}";
$res = cpg_db_query( $query );          
$row = cpg_db_fetch_row($res);
cpg_db_free_result($res);	

//echo "<TABLE CLASS=\"tableh2\" WIDTH=\"50%\">\n";

echo "<tr><td><table CELLPADDING=\"5\">\n";
    echo "<tr class=\"tableb\">\n";
    	echo "<td>\n";
    		echo "total number of images";
    	echo "</td>\n";
    	echo "<td>\n";
    		echo $row[0];
    	echo "</td>\n";    	
    echo "</tr>\n";
    
     echo "<tr class=\"tableb\">\n";
    	echo "<td>\n";
    		echo "total size of images [MB]";
    	echo "</td>\n";
    	echo "<td>\n";
    		echo $row[3];
    	echo "</td>\n";    	
    echo "</tr>\n";
    
     echo "<tr class=\"tableb\">\n";
    	echo "<td>\n";
    		echo "average hits per image";
    	echo "</td>\n";
    	echo "<td>\n";
    		echo $row[1];
    	echo "</td>\n";
    echo "</tr>\n";
    
     echo "<tr class=\"tableb\">\n";
    	echo "<td>\n";
    		echo "total hits";
    	echo "</td>\n";
    	echo "<td>\n";
    		echo $row[2];
    	echo "</td>\n";
    echo "</tr></table>\n";
    
//echo "</table></td></tr>\n";
    
  
//echo "</TABLE>\n";  
endtable();  // gallery statistics
echo "<br><br>";






starttable('100%','total number of fullsize downloads per user');

$query = "SELECT COUNT(*) AS ct," . $utab . ".user_name," . $utab . ".user_email,{$utab}.user_id FROM " . 
         $htab . "," . $utab . " WHERE " .  $htab . ".uid = " . $utab . ".user_id GROUP BY " . $htab .  ".uid ORDER BY ct DESC"; 
$res = cpg_db_query( $query );          


echo "<tr><td><table CELLPADDING=\"5\">\n";
echo "<b><tr class=\"tableb\">\n";
    	echo "<td>\n";
    		echo "<b>number of distinct downloads</b>";
    	echo "</td>\n";
    	echo "<td>\n";
    		echo "<b>user name (click to edit user)</b>";
    	echo "</td>\n";
    	echo "<td>\n";
    		echo "<b>user email</b>";
    	echo "</td>\n";    	
    echo "</tr></b>\n";



 while($row = cpg_db_fetch_row($res)) 
  { 
    echo "<tr class=\"tableb\">\n";
    	echo "<td>\n";
    		echo $row[0] ;
    	echo "</td>\n";
    	echo "<td>\n";
    		echo "<A HREF=\"usermgr.php?op=edit&user_id=$row[3]\" TITLE=\"edit user\">$row[1]</A>" ;
    	echo "</td>\n";
    	echo "<td>\n";
    		if( $row[2] != "" ) echo "<A HREF=\"mailto:" . $row[2] . "\"> " . $row[2] . "</A>\n"; 
    	echo "</td>\n";    	
    echo "</tr>\n";
  }
echo "</table></td></tr>\n";
   
cpg_db_free_result($res);	
endtable();  

echo "</br></br>";


starttable('100%','downloaded fullsize images sorted by download date');

$query = "SELECT  user.user_name,hist.tstamp,hist.picname,pic.pid,alb.title,hist.ip FROM $utab As user,$htab As hist,$ptab AS pic,$atab AS alb  WHERE " .
         "hist.uid=user.user_id AND alb.aid=pic.aid AND hist.picname LIKE pic.filename ORDER BY hist.tstamp DESC " .
	 "LIMIT 100";
$res = cpg_db_query( $query );          

echo "<tr><td><table CELLPADDING=\"5\">\n";
echo "<b><tr class=\"tableb\">\n";
    	echo "<td>\n";
    		echo "<b>user</b>";
    	echo "</td>\n";
    	echo "<td>\n";
    		echo "<b>date</b>";
    	echo "</td>\n";
    	echo "<td>\n";
    		echo "<b>filename</b>";
    	echo "</td>\n";  
    	echo "<td>\n";
    		echo "<b>album</b>";
    	echo "</td>\n";  	
    	    	echo "<td>\n";
    		echo "<b>ip-address</b>";
    	echo "</td>\n";    	

    echo "</tr></b>\n";

 while($row = cpg_db_fetch_row($res)) 
  { 
    echo "<tr class=\"tableb\">\n";
    	echo "<td>\n";
    		echo $row[0];
    	echo "</td>\n";
    	echo "<td>\n";
    		echo $row[1];
    	echo "</td>\n";
    	echo "<td>\n";
    		echo "<A HREF=\"displayimage.php?pos=-$row[3]\">$row[2]</A>";
    	echo "</td>\n"; 
    	echo "<td>\n";
    		echo $row[4];
    	echo "</td>\n";   
    	echo "<td>\n";
    		echo $row[5];
    	echo "</td>\n"; 	
    echo "</tr>\n";
  }
  
echo "</table></td></tr>\n";
  
cpg_db_free_result($res);	
endtable();  
echo "<br><br>";


starttable('100%','most viewed albums');
$query = "SELECT alb.title,SUM(pic.hits) AS ahits, COUNT(*) FROM $atab AS alb, $ptab AS pic WHERE pic.aid=alb.aid GROUP BY alb.aid ORDER BY ahits DESC";
$res = cpg_db_query( $query );          

echo "<tr><td><table CELLPADDING=\"5\">\n";

    echo "<b><tr class=\"tableb\">\n";
    	echo "<td>\n";
    		echo "<b>album name</b>";
    	echo "</td>\n";
    	echo "<td>\n";
    		echo "<b>images in album</b>";
    	echo "</td>\n";
    	echo "<td>\n";
    		echo "<b>total hits in album</b>";
    	echo "</td>\n";    	
    echo "</tr></b>\n";


 while($row = cpg_db_fetch_row($res)) 
  { 
    echo "<tr class=\"tableb\">\n";
    	echo "<td>\n";
    		echo $row[0];
    	echo "</td>\n";
    	echo "<td>\n";
    		echo $row[2];
    	echo "</td>\n";
    	echo "<td>\n";
    		echo $row[1];
    	echo "</td>\n";    	
    echo "</tr>\n";
  }
echo "</table></td></tr>\n";
  
cpg_db_free_result($res);	
endtable();  // album statistics







pagefooter();  
  
?>

