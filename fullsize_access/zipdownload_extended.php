<?php
// ------------------------------------------------------------------------- //
// Coppermine Photo Gallery 1.3.2                                            //
// ------------------------------------------------------------------------- //
// Copyright (C) 2002-2004 Gregory DEMAR                                     //
// http://www.chezgreg.net/coppermine/                                       //
// ------------------------------------------------------------------------- //
// Updated by the Coppermine Dev Team                                        //
// (http://coppermine.sf.net/team/)                                          //
// see /docs/credits.html for details                                        //
// ------------------------------------------------------------------------- //
// This program is free software; you can redistribute it and/or modify      //
// it under the terms of the GNU General Public License as published by      //
// the Free Software Foundation; either version 2 of the License, or         //
// (at your option) any later version.                                       //
// ------------------------------------------------------------------------- //
// CVS version: $Id$
// ------------------------------------------------------------------------- //

define('IN_COPPERMINE', true);
define('THUMBNAILS_PHP', true);
define('INDEX_PHP', true);
chdir('../../');
require('include/init.inc.php');
include ( 'include/archive.php');
chdir('plugins/fullsize_access');
require('fullsize_secure.php');
require_once('fullsize_check.php');
chdir('../../');


/*
define('IN_COPPERMINE', true);
define('THUMBNAILS_PHP', true);
define('INDEX_PHP', true);
require('include/init.inc.php');
include ( 'include/archive.php');

require('plugins/fullsize_access/fullsize_secure.php');
*/



if ($CONFIG['plugin_ks_fullsize_zip'] != 1  || !USER_ID ) {
//someone has entered the url manually, while the admin has disabled zipdownload
pageheader($lang_error);
starttable('-2', $lang_error);
print <<<EOT
<tr>
        <td align="center" class="tableb">
      {$lang_errors['perm_denied']}
      </td>
</tr>
EOT;
endtable();
pagefooter();
ob_end_flush();
} else {
// zipdownload allowed, go ahead...


$files = array();

if ($superCage->get->keyExists('album') ) {

$favs .= "-1";

        $select_columns = 'filepath,filename';

        $result = cpg_db_query("SELECT $select_columns FROM {$CONFIG['TABLE_PICTURES']} WHERE approved = 'YES' AND aid=" . $superCage->get->getInt('album'));
        $rowset = cpg_db_fetch_rowset($result);
        foreach ($rowset as $key => $row){

                //$filelist[] = $rowset[$key]['filepath'].$rowset[$key]['filename'];
                $files[] = create_fullsize_read($rowset[$key]['filepath'],$rowset[$key]['filename']);
                //add_to_history($USER_DATA['user_id'],$rowset[$key]['filename']);

        }


} elseif ($superCage->get->keyExists('fav') ) {

	if (count($FAVPICS)>0){
		$favs = implode(",",$FAVPICS);

		$select_columns = 'filepath,filename';

		$result = cpg_db_query("SELECT $select_columns FROM {$CONFIG['TABLE_PICTURES']} WHERE approved = 'YES'AND pid IN ($favs)");
		$rowset = cpg_db_fetch_rowset($result);
		foreach ($rowset as $key => $row){
			$files[] = create_fullsize_read($rowset[$key]['filepath'],$rowset[$key]['filename']);
			//$files[] = $rowset[$key]['filepath'].$rowset[$key]['filename'];
	}
}

} else {

	foreach( $superCage->get->_source as $key => $val ) {
	  if( strpos($key,"pic") !== false ) {
		$favs .= "$val,";
	 }
	}
	$favs .= "-1";

        $select_columns = 'filepath,filename';

        $result = cpg_db_query("SELECT $select_columns FROM {$CONFIG['TABLE_PICTURES']} WHERE approved = 'YES'AND pid IN ($favs)");
        $rowset = cpg_db_fetch_rowset($result);
        foreach ($rowset as $key => $row){

                //$filelist[] = $rowset[$key]['filepath'].$rowset[$key]['filename'];
                $files[] = create_fullsize_read($rowset[$key]['filepath'],$rowset[$key]['filename']);
                //add_to_history($USER_DATA['user_id'],$rowset[$key]['filename']);

        }


}

$flags['storepath'] = 0;
// $cwd = './albums';
//$cwd = "./{$CONFIG['fullpath']}";
$cwd = substr($cwd, 0, -1);

$zip = new zipfile($cwd,$flags);

$zip->addfiles($files);

$zip->filedownload('pictures.zip');


foreach( $files as $fn ) {

secure_fullsize($fn);
}

}
?>
