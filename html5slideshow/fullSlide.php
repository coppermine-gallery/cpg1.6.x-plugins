<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once "./plugins/html5slideshow/initialize.inc.php";
$H5ss_jsf = 'slides';

if ($CONFIG['debug_mode']==1 || ($CONFIG['debug_mode']==2 && GALLERY_ADMIN_MODE)) {
	$H5ss_jsf .= '.js';
} else {
	$H5ss_jsf .= '.min.js';
}

$H5ss_cfg = unserialize($CONFIG['html5slideshow_cfg']);

$uid = USER_ID;
$usrData = h5ss_db_fetch_assoc(cpg_db_query("SELECT `H5ss_cfg` FROM {$CONFIG['TABLE_USERS']} WHERE user_id = {$uid}"));
if ($usrCfg = unserialize($usrData['H5ss_cfg'])) {
	$H5ss_cfg = array_merge($H5ss_cfg, $usrCfg);
}

$errmsg = '';
$filelist = array();
$usrisown = false;

if ($superCage->get->testAlpha('album')) {
	$album = $superCage->get->getAlpha('album');
} else {
	$album = $superCage->get->getInt('album');
	$albData = h5ss_db_fetch_assoc(cpg_db_query("SELECT `H5ss_cfg`,owner FROM {$CONFIG['TABLE_ALBUMS']} WHERE aid = {$album}"));
	if (!$albData) {
	    cpg_die(ERROR, $lang_errors['non_exist_ap']);
	}
	if ($albCfg = unserialize($albData['H5ss_cfg'])) {
		$H5ss_cfg = array_merge($H5ss_cfg, $albCfg);
	}
	$usrisown = $H5ss_cfg['uA'] && (USER_ID === $albData['owner']);
}

$fprefix = $H5ss_cfg['pS'] == 1 ? 'normal_' : '';
get_meta_album_set($superCage->get->getInt('cat'));
$count = 0;
$album_name = '';
$rowset = get_pic_data($album, $count, $album_name);
if ($rowset) {
	foreach ($rowset as $row) {
		$ftyp = cpg_get_type($row['filename']);
		if ($ftyp['content'] != 'image') continue;
		$txtinfo = '';
		if ($H5ss_cfg['vT']) $txtinfo = trim($row['title']);
		if ($H5ss_cfg['vD'] && trim($row['caption'])) $txtinfo .= ($txtinfo ? ' ... ' : '') . trim($row['caption']);
		$fileentry = array(
				'fpath' => get_pic_url($row, ($H5ss_cfg['pS'] == 1 ? 'normal' : 'fullsize')),
				'height' => $row['pheight'],
				'title' => bb_decode($txtinfo)
				);
		$filelist[] = $fileentry;
	}
} else {
	$errmsg .= $lang_plugin_html5slideshow['noimgerr'];
}
if (!count($filelist)) $errmsg .= $lang_plugin_html5slideshow['noimgerr'];
if ($H5ss_cfg['sI']) shuffle($filelist);
$popdwin = ($superCage->get->getInt('h5sspu') == 1);
$icons = $H5ss_cfg['iS'];
$dcolors = split(',', $H5ss_cfg['dC']);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US" dir="<?=$lang_text_dir?>">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$CONFIG['charset'] == 'language file' ? $lang_charset : $CONFIG['charset']?>" />
<title><?=strip_tags($album_name)?> :: <?=$lang_plugin_html5slideshow['ssword']?></title>
<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width, height=device-height" />
<link rel="stylesheet" type="text/css" href="plugins/html5slideshow/css/slides.css">
<style type="text/css">
	html { height:100%; overflow:hidden }
	body { background-color:<?=$dcolors[4]?>; width:100%; height:100%; overflow:hidden }
	div#controls { background-color:<?=$dcolors[0]?>; color:<?=$dcolors[1]?>; }
	div#ptext { background-color:<?=$dcolors[2]?>; color:<?=$dcolors[3]?>; }
	div#screen { background-color:<?=$dcolors[4]?>; overflow:hidden; }
	div.spribut { background: url('plugins/html5slideshow/css/icons/<?=$icons?>.png') no-repeat; }
</style>
<script src="plugins/html5slideshow/js/<?=$H5ss_jsf?>" type="text/javascript"></script>
<script type="text/javascript">
	var albumID = '<?=$album?>';
	var popdwin = <?=$popdwin?'true':'false'?>;
	var imagelist = <?=json_encode($filelist)?>;
	var imgerror = "<?=$lang_plugin_html5slideshow['imgerror']?>";
	ssCtl.autoPlay = <?=$H5ss_cfg['aP']*1?>;
	ssCtl.repeat = <?=$H5ss_cfg['lS']?'true':'false'?>;
	ssCtl.slideDur = <?=$H5ss_cfg['sD']*1000?>;
	ssCtl.trnType = "<?=$H5ss_cfg['tT']?>";
	function asscfg() {
		var csl = "index.php?file=html5slideshow/config&album="+albumID;
		if (popdwin) { parent.opener.location = csl; window.close(); }
		else { window.location = csl; }
	}
</script>
</head>

<body>
<?php if ($errmsg): ?>
	<div id="ptext" style="font-size:1.5em"><?=$errmsg?>&nbsp;&nbsp;<button type="button" onclick="ssCtl.doMnu(0)"><?=$lang_plugin_html5slideshow['stop_a']?></button></div>
<?php else: ?>
	<div id="fullarea" style="height:100%">
		<div id="controls">
			<div class="albnam"><p><span id="albNam"><?=$album_name?>&nbsp;&nbsp;::&nbsp;&nbsp;</span><?=sprintf($lang_plugin_html5slideshow['of_format'],'<span id="slidnum"></span>',count($filelist))?></p></div>
		<?php if ($H5ss_cfg['uA'] && USER_ID>0): ?>
			<img class="sscfg" src="images/icons/config.png" width="16" height="16" onclick="asscfg()" title="<?=$lang_plugin_html5slideshow['configss']?>" alt="config" />
		<?php endif; ?>
			<div class="ofslid">
				<div id="cb_less" class="spribut" onclick="ssCtl.sdur(0)" title="<?=$lang_plugin_html5slideshow['minus']?>"></div>
				<span id="seconds"></span>&nbsp;<?=$lang_plugin_html5slideshow['secsabrv']?>
				<div id="cb_more" class="spribut" onclick="ssCtl.sdur(1)" title="<?=$lang_plugin_html5slideshow['plus']?>"></div>
			</div>
			<div class="sldctls">
				<div id="cb_stop" class="spribut" onclick="ssCtl.doMnu(0)" title="<?=$lang_plugin_html5slideshow['stop_t']?>"></div>
				&nbsp;
				<div id="cb_rwnd" class="spribut" onclick="ssCtl.doMnu(1)" title="<?=$lang_plugin_html5slideshow['rwnd_t']?>"></div>
				<div id="cb_prev" class="spribut" onclick="ssCtl.doMnu(2)" title="<?=$lang_plugin_html5slideshow['prev_t']?>"></div>
				<div id="cb_paus" class="spribut" onclick="ssCtl.doMnu(3)" title="<?=$lang_plugin_html5slideshow['togl_t']?>"></div>
				<div id="cb_next" class="spribut" onclick="ssCtl.doMnu(4)" title="<?=$lang_plugin_html5slideshow['next_t']?>"></div>
				<div id="cb_last" class="spribut" onclick="ssCtl.doMnu(5)" title="<?=$lang_plugin_html5slideshow['last_t']?>"></div>
				&nbsp;&nbsp;
				<div id="cb_full" class="spribut" onclick="ssCtl.doMnu(6)" title="<?=$lang_plugin_html5slideshow['full_t']?>"></div>
			</div>
		</div>
		<div id="ptext"></div>
		<div id="screen" style="height:100%;-webkit-backface-visibility:hidden;">
			<!-- <img src="plugins/html5slideshow/css/loading.gif" style="position:relative;z-index:99;top:10px;left:50%;margin-left:-30px;" /> -->
			<p id="loading" style="display:none">∙∙∙LOADING∙∙∙</p>
		</div>
		<!-- <div id="status"></div> -->
	</div>
<?php endif; ?>
</body>

</html>