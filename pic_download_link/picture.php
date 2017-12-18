<?php
 /**************************************************
  Coppermine Photo Gallery 1.5.x
  *************************************************
  pic_download_link Plugin
  *************************************************
  picture.php Adapted from Jared Hatfield's Plugin 'Download and Alternate File Loading'
  and 'CPGPicdownload'
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.
***************************************************/
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

ini_set("display_errors","1");
error_reporting(E_ALL);

require_once('include/init.inc.php');

function readfile_chunked($filename,$retbytes=true)
{
	$chunksize = 1*(1024*1024); // how many bytes per chunk
	$buffer = '';
	$cnt =0;
	// $handle = fopen($filename, 'rb');
	$handle = fopen($filename, 'rb');
	if ($handle === false)
	{
		return false;
	}
	while (!feof($handle))
	{
		$buffer = fread($handle, $chunksize);
		echo $buffer;
		ob_flush();
		flush();
		if ($retbytes)
		{
			$cnt += strlen($buffer);
		}
	}
	$status = fclose($handle);
	if ($retbytes && $status)
	{
		return $cnt; // return num. bytes delivered like readfile() does.
	}
	return $status;
}

function display_error()
{
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: no-cache');
	header("Content-Type: image/gif");
	readfile_chunked("./images/read_error48x48.gif");
	exit();
}


$cage = Inspekt::makeGetCage();
if ($cage->keyExists ('pid'))
{
	$pid = $cage->getInt ('pid');

	//try to keep the pids at least limited to albums they have access to and approved pics.
	get_meta_album_set(0, $META_ALBUM_SET);
	$result = cpg_db_query("SELECT filepath, filename FROM {$CONFIG['TABLE_PICTURES']} WHERE approved = 'YES' $META_ALBUM_SET AND pid='$pid'");
	$row = mysql_fetch_array($result);
	mysql_free_result($result);
	mysql_close();
	$filepath = $row['filepath'];
	$filename = $row['filename'];

	if ($CONFIG['down_link_whichone'] == 1) {
		$file = $CONFIG['fullpath'] . $filepath . $CONFIG['normal_pfx'] . $filename;
		if ($CONFIG['down_link_hideprefix'] == 1) {
			$save_as_name = $filename;
		} else {
			$save_as_name = $CONFIG['normal_pfx'] . $filename;
		}
	} else {
		$file = $CONFIG['fullpath'] . $filepath . $filename;
		$save_as_name = $filename;
	}

	if (file_exists($file) && $filepath != "" && $filename != "")
	{
		ini_set('session.cache_limiter', '');

		header("Content-Type: application/octet-stream");
		header("Content-Disposition: disposition-type=attachment; filename=\"$save_as_name\"");

		readfile_chunked($file);
	}
	else
	{
		//File did not exist
		display_error();
	}

}
else
{
	//If no PID is set
	display_error();
}

?>
