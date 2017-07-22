<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$H5ss_cfg = unserialize($CONFIG['html5slideshow_cfg']);

// cause the popup script to get included
//gallery_header seems a reasonable place to make it happen
$thisplugin->add_filter('gallery_header','html5slideshow_addpops');

// Add a filter for the thumbnail header
if ($H5ss_cfg['aA']) {
	$thisplugin->add_filter('theme_thumbnails_title','html5slideshow_header');
}

// Add a filter for the album list
if ($H5ss_cfg['aL']) {
	$thisplugin->add_filter('theme_album_params','html5slideshow_alblist');
}

// And shoehorn into the slideshow button
if ($H5ss_cfg['aT']) {
	$thisplugin->add_filter('file_data','html5slideshow_nav');
}

function html5slideshow_addpops($data) {
	js_include('plugins/html5slideshow/js/h5ss.js');
	return $data;
}

// Modify template header
function html5slideshow_header($html) {
	global $CONFIG, $CURRENT_ALBUM_DATA, $lang_plugin_html5slideshow;
	$album = $CURRENT_ALBUM_DATA['aid'];
	if ($album) {
		$H5ss_cfg = html5slideshow_resolved_cfg($album);
		$imgcode = '<img src="plugins/html5slideshow/css/slideshow.png" alt="'.$lang_plugin_html5slideshow['slideshow'].'" title="'.$lang_plugin_html5slideshow['slideshow'].'" style="vertical-align:text-bottom;" />';
		$html['{ALBUM_NAME}'] .= '&nbsp;&nbsp;<a href="index.php?file=html5slideshow/fullSlide&album='.$album
			.($H5ss_cfg['nW'] ? '" onClick="h5ss_pop(this.href,event); return false;">' : '">')
			.$imgcode.'</a>';
	}
	return $html;
}

// Modify template album list
function html5slideshow_alblist($params) {
	global $CONFIG, $CURRENT_ALBUM_DATA, $lang_plugin_html5slideshow;
	preg_match('/=(\d+)$/', $params['{ALB_LINK_TGT}'], $mtchs);
	$album = $mtchs[1];
	if ($album) {
		$H5ss_cfg = html5slideshow_resolved_cfg($album);
		$imgcode = '<img src="plugins/html5slideshow/css/slideshow.png" alt="'.$lang_plugin_html5slideshow['slideshow'].'" title="'.$lang_plugin_html5slideshow['slideshow'].'" style="vertical-align:text-bottom;" />';
		$params['{ALBUM_TITLE}'] .= '</a>&nbsp;&nbsp;<a href="index.php?file=html5slideshow/fullSlide&album='.$album
			.($H5ss_cfg['nW'] ? '" onClick="h5ss_pop(this.href,event); return false;">' : '">')
			.$imgcode;
	}
	return $params;
}

function html5slideshow_nav($data) {
	global $CONFIG, $JS, $album, $cat;
	$H5ss_cfg = html5slideshow_resolved_cfg($album);
	if (isset($JS['vars']['buttons']['slideshow_tgt'])) {
		$url = 'index.php?file=html5slideshow/fullSlide&album='.$album.'&cat='.$cat;
		if ($H5ss_cfg['nW']) {
			$url = 'javascript:h5ss_pop(\'' . $url . '\');';
		}
		$JS['vars']['buttons']['slideshow_tgt'] = $url;
	}
	return $data;
}

function html5slideshow_resolved_cfg($album) {
	global $CONFIG, $lang_errors, $lang_plugin_html5slideshow;
	$cfg = unserialize($CONFIG['html5slideshow_cfg']);
	if ($user = USER_ID) {
		$usrData = cpg_db_fetch_assoc(cpg_db_query("SELECT `H5ss_cfg` FROM {$CONFIG['TABLE_USERS']} WHERE user_id = {$user}"));
		if ($usrCfg = unserialize($usrData['H5ss_cfg'])) {
			$cfg = array_merge($cfg, $usrCfg);
		}
	}
	if ($album && preg_match("/^\d+$/", $album)) {
		$albData = cpg_db_fetch_assoc(cpg_db_query("SELECT `H5ss_cfg` FROM {$CONFIG['TABLE_ALBUMS']} WHERE aid = {$album}"));
		if ($albCfg = unserialize($albData['H5ss_cfg'])) {
			$cfg = array_merge($cfg, $albCfg);
		}
	}
	return $cfg;
}


/***** INSTALL/UNINSTALL *****/

$thisplugin->add_action('plugin_install', 'html5slideshow_install');
function html5slideshow_install () {
	global $CONFIG;
	//these config item names are necessarily small because of 255 char limit in CPG config values
	$html5slideshowCfg = array(
			'aA'=>1,	//slideshow action icon at album header
			'aL'=>1,	//slideshow action icons in album listing
			'aT'=>1,	//shoehorn in this slideshow action at thumbs page
			'uA'=>1,	//user allow album settings (and their default)
			'nW'=>0,	//new (pop) window
			'pS'=>2,	//picture size (intermediate/full)
			'tT'=>'d',	//image transition = dissolve
			'vT'=>1,	//show Title in text area
			'vD'=>1,	//show Desc in title area
			'sI'=>0,	//shuffle slides for show
			'aP'=>1,	//autoplay
			'lS'=>0,	//loop slideshow
			'sD'=>5,	//slide duration
			'dC'=>'#666'	//control area background
				.',#CCC'	//control area text
				.',#333'	//text area background
				.',#FFF'	//text area text
				.',#000',	//pic area background
			'iS'=>'cb1' //iconset
		);
	$cfgs = serialize($html5slideshowCfg);
	if (!$CONFIG['html5slideshow_cfg']) {
		cpg_db_query("INSERT INTO {$CONFIG['TABLE_CONFIG']} (name, value) VALUES ('html5slideshow_cfg', '{$cfgs}')");
		cpg_db_query("ALTER TABLE {$CONFIG['TABLE_ALBUMS']} ADD `H5ss_cfg` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
		cpg_db_query("ALTER TABLE {$CONFIG['TABLE_USERS']} ADD `H5ss_cfg` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
	}
	return true;
}

$thisplugin->add_action('plugin_uninstall', 'html5slideshow_uninstall');
function html5slideshow_uninstall () {
	global $CONFIG, $superCage;

	if ($superCage->post->keyExists('H5ss_submit') && $superCage->post->keyExists('uiType')) {
		if ($superCage->post->getInt('uiType') == 1) {
			cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'html5slideshow_cfg'");
			cpg_db_query("ALTER TABLE {$CONFIG['TABLE_ALBUMS']} DROP `H5ss_cfg`");
			cpg_db_query("ALTER TABLE {$CONFIG['TABLE_USERS']} DROP `H5ss_cfg`");
		}
		return true;
	} else {
		return 1;
	}
}

$thisplugin->add_action('plugin_cleanup', 'html5slideshow_cleanup');
function html5slideshow_cleanup() {
	global $lang_common, $superCage, $lang_plugin_html5slideshow;

	echo '<form name="cpgform" id="cpgform" action="'.$superCage->server->getEscaped('REQUEST_URI').'" method="post">';
	echo <<<EOT
	<br />{$lang_plugin_html5slideshow['uninType']}<br />
	<input type="radio" name="uiType" id="uiFull" value="1" style="margin-left:2em" checked="checked" /> <label for="uiFull">{$lang_plugin_html5slideshow['fullUnin']}</label><br />
	<input type="radio" name="uiType" id="uiPart" value="2" style="margin-left:2em" /> <label for="uiPart">{$lang_plugin_html5slideshow['partUnin']}</label><br />
	<br /><input type="submit" name="H5ss_submit" value="{$lang_common['continue']}" class="button" style="padding:2px 8px" />
	</form>
EOT;
}
