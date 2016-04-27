<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');
/* FOR USE WITH NEW ADMIN PLUGIN CONFIGURATION SCHEME */

require_once './plugins/html5slideshow/initialize.inc.php';

// make sure that there is an album or that we are administering the plugin
$h5ss_album = $superCage->get->getInt('album');
if (!$h5ss_album) $h5ss_album = $superCage->post->getInt('album');
if (!USER_ID) {
	cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);
}

// include pertinent script files
if (defined('PLUGINMGR_PHP')) {
	echo js_include('plugins/html5slideshow/js/rscp/jquery.colorPicker.min.js', true);
	echo js_include('plugins/html5slideshow/js/config.js', true);
	echo <<<EOT
	<script>
		js_vars['H5ss_lang'] = {'titl':'{$lang_common['title']}','capt':'{$lang_common['caption']}','tsep':' :: '};
	</script>
EOT;
} else {
	js_include('plugins/html5slideshow/js/rscp/jquery.colorPicker.min.js');
	js_include('plugins/html5slideshow/js/config.js');
	set_js_var('H5ss_lang', array('titl'=>$lang_common['title'],'capt'=>$lang_common['caption'],'tsep'=>' :: '));
}
// flag for user configuring their own album
$usrisown = false;

// get the settings that we'll be working with
$h5ss_album_name = '';
$h5ss_cfg = h5ss_resolve_cfg($h5ss_album, USER_ID, $h5ss_album_name, $usrisown);

// add our style sheet
if (defined('PLUGINMGR_PHP')) {
	echo '<style type="text/css">';readfile('plugins/html5slideshow/js/rscp/colorPicker.css');echo'</style>';
} else {
	$h5ss_meta = '<link rel="stylesheet" href="plugins/html5slideshow/js/rscp/colorPicker.css" type="text/css" />';
	$h5ss_head = $h5ss_album ? $lang_plugin_html5slideshow['cfgtitle'] : ($lang_plugin_html5slideshow['html5slide'].' - '.$lang_gallery_admin_menu['admin_lnk']);
	pageheader($h5ss_head, $h5ss_meta);
}
if ($superCage->post->keyExists('submit')) {
	if (!defined('PLUGINMGR_PHP')) {
		if (!checkFormToken()) {
			global $lang_errors;
			cpg_die(ERROR, $lang_errors['invalid_form_token'], __FILE__, __LINE__);
		}
	}
	h5ss_process_form($h5ss_cfg, $h5ss_album, USER_ID);
}

h5ss_display_form($h5ss_cfg, $h5ss_album, $h5ss_album_name, $usrisown);

/***************************************************************************/


function h5ss_resolve_cfg ($album, $user, &$albname, &$uio)
{
	global $CONFIG, $lang_errors, $lang_plugin_html5slideshow;

	$cfg = unserialize($CONFIG['html5slideshow_cfg']);
	if (GALLERY_ADMIN_MODE && !$album) return $cfg;

	if ($album) {	// user is configuring their album settings
		$albData = h5ss_db_fetch_assoc(cpg_db_query("SELECT `H5ss_cfg`,owner,title FROM {$CONFIG['TABLE_ALBUMS']} WHERE aid = {$album}"));
		if (!$albData) {
			cpg_die(ERROR, $lang_errors['non_exist_ap']);
		}
		if ($cfg['uA'] && (USER_ID == $albData['owner'])) {
			$uio = true;
			$albname = $albData['title'];
		} else {
			$album = false;
		}
	}

	$usrData = h5ss_db_fetch_assoc(cpg_db_query("SELECT `H5ss_cfg`,user_name FROM {$CONFIG['TABLE_USERS']} WHERE user_id = {$user}"));
	if ($usrCfg = unserialize($usrData['H5ss_cfg'])) {
		$cfg = array_merge($cfg, $usrCfg);
	}
	if ($album && ($albCfg = unserialize($albData['H5ss_cfg']))) {
		$cfg = array_merge($cfg, $albCfg);
		$albname .= ' ['.$lang_plugin_html5slideshow['custom'] .']';
	} else {
		$albname .= $usrData['user_name'] . ' ['.$lang_plugin_html5slideshow['default'] .']';
	}

	//remove admin components
	unset($cfg['aA'],$cfg['aL'],$cfg['aT'],$cfg['uA']);

	return $cfg;
}

function helpButton ($parts)
{
	global $CONFIG;
	return '&nbsp;<a class="greybox" href="plugins/html5slideshow/help.php?t=' . $CONFIG['theme'] . '&l='.$CONFIG['lang']
			. '&g='.$parts.'" title="Help"><img src="images/help.gif" width="13" height="11" border="0" alt=""></a>';
}

function h5ss_display_form ($cfg, $album, $albname='', $uio)
{
	global $superCage, $lang_common, $lang_gallery_admin_menu, $lang_plugin_html5slideshow;

	if (!defined('PLUGINMGR_PHP')) {
		echo '<form action="'.$superCage->server->getEscaped('REQUEST_URI').'" method="post">';
	}
	
	if ($album) {
		$thead = '<img src="plugins/html5slideshow/css/slideshow.png" style="vertical-align:text-bottom" alt="" /> '.$lang_plugin_html5slideshow['cfgtitle']. helpButton('usr');
		$thead .= ' :: ' . $albname;
	} else {
		$thead = $lang_plugin_html5slideshow['html5slide']." - ".$lang_gallery_admin_menu['admin_lnk']. helpButton('adm|usr');
	}

	starttable('100%', $thead, 2);

	if (!$album && GALLERY_ADMIN_MODE) {
	$atAlbum_checked = $cfg['aA'] ? 'checked="checked"' : '';
	$atList_checked = $cfg['aL'] ? 'checked="checked"' : '';
	$atThumbs_checked = $cfg['aT'] ? 'checked="checked"' : '';
	$uAllow_checked = $cfg['uA'] ? 'checked="checked"' : '';
	echo <<<EOT
	<tr>
		<td class="tableb">
			{$lang_plugin_html5slideshow['atAlbum']}
		</td>
		<td class="tableb">
			<input type="checkbox" name="atAlbum" {$atAlbum_checked} />
			<img src="plugins/html5slideshow/css/slideshow.png" style="margin-left:12px;vertical-align:text-bottom" />
		</td>
	</tr>
	<tr>
		<td class="tableb">
			{$lang_plugin_html5slideshow['atList']}
		</td>
		<td class="tableb">
			<input type="checkbox" name="atList" {$atList_checked} />
			<img src="plugins/html5slideshow/css/slideshow.png" style="margin-left:12px;vertical-align:text-bottom" />
		</td>
	</tr>
	<tr>
		<td class="tableb">
			{$lang_plugin_html5slideshow['atThumbs']}
		</td>
		<td class="tableb">
			<input type="checkbox" name="atThumbs" {$atThumbs_checked} />
		</td>
	</tr>
	<tr>
		<td class="tableb">
			{$lang_plugin_html5slideshow['uAllow']}
		</td>
		<td class="tableb">
			<input type="checkbox" name="uAllow" {$uAllow_checked} />
		</td>
	</tr>
EOT;
	}

	$iconset = $cfg['iS'];

	$iconsets = form_get_foldercontent('plugins/html5slideshow/css/icons/', 'file', 'png');
	$ichoices = '';
	foreach ($iconsets as $value) {
		$selected = $iconset == $value ? 'selected="selected"' : '';
		$ichoices .= "<option value=\"$value\" $selected>$value</option>";
	}

	$sizeSel = array('','','');
	$sizeSel[$cfg['pS']] = ' selected="selected"';
	$tranSel = array('n'=>'','d'=>'','s'=>'');
	$tranSel[$cfg['tT']] = ' selected="selected"';

	$newWin_checked = $cfg['nW'] ? 'checked="checked"' : '';
	$shuffle_checked = $cfg['sI'] ? 'checked="checked"' : '';
	$autoPlay_checked = $cfg['aP'] ? 'checked="checked"' : '';
	$loopShow_checked = $cfg['lS'] ? 'checked="checked"' : '';
	$dispTitl_checked = $cfg['vT'] ? 'checked="checked"' : '';
	$dispDesc_checked = $cfg['vD'] ? 'checked="checked"' : '';

	$ptext = '';
	if ($cfg['vT']) $ptext = $lang_common['title'];
	if ($cfg['vT'] && $cfg['vD']) $ptext .= ' :: ';
	if ($cfg['vD']) $ptext .= $lang_common['caption'];
	
	$seconds = $cfg['sD'];
	$choices = '';
	for ($value=3; $value<11; $value++) {
		$selected = $seconds == $value ? 'selected="selected"' : '';
		$choices .= "<option value=\"$value\" $selected>$value</option>";
	}

	$dcolors = explode(',', $cfg['dC']);

	$submit_icon = cpg_fetch_icon('ok', 1);

	$action_sel = '';
	if ($album && $uio) {
		$action_sel = <<<EOT
	{$lang_plugin_html5slideshow['action']}: 
	<select class="listbox" name="action" style="margin-right:2em">
		<option value="sa">{$lang_plugin_html5slideshow['savalb']}</option>
		<option value="su">{$lang_plugin_html5slideshow['savusr']}</option>
		<option value="za">{$lang_plugin_html5slideshow['clralb']}</option>
		<option value="zu">{$lang_plugin_html5slideshow['clrusr']}</option>
	</select>
EOT;
	} elseif ($album) {
		$action_sel = <<<EOT
	{$lang_plugin_html5slideshow['action']}: 
	<select class="listbox" name="action" style="margin-right:2em">
		<option value="su">{$lang_plugin_html5slideshow['savusr']}</option>
		<option value="zu">{$lang_plugin_html5slideshow['clrusr']}</option>
	</select>
EOT;
	}

	echo <<<EOT
	<tr>
		<td class="tableb">
			{$lang_plugin_html5slideshow['newWin']}
		</td>
		<td class="tableb">
			<input type="checkbox" name="newWin" {$newWin_checked} />
		</td>
	</tr>
	<tr>
		<td class="tableb">
			{$lang_plugin_html5slideshow['imgSize']}
		</td>
		<td class="tableb">
			<select class="listbox" name="imgSize">
				<option value="1"{$sizeSel[1]}>{$lang_plugin_html5slideshow['sizIntr']}</option>
				<option value="2"{$sizeSel[2]}>{$lang_plugin_html5slideshow['sizFull']}</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="tableb">
			{$lang_plugin_html5slideshow['trnType']}
		</td>
		<td class="tableb">
			<select class="listbox" name="trnType">
				<option value="n"{$tranSel['n']}>{$lang_plugin_html5slideshow['imgNotr']}</option>
				<option value="d"{$tranSel['d']}>{$lang_plugin_html5slideshow['imgDzlv']}</option>
				<option value="s"{$tranSel['s']}>{$lang_plugin_html5slideshow['imgSlid']}</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="tableb">
			{$lang_plugin_html5slideshow['shuffle']}
		</td>
		<td class="tableb">
			<input type="checkbox" name="shuffle" {$shuffle_checked} />
		</td>
	</tr>
	<tr>
		<td class="tableb">
			{$lang_plugin_html5slideshow['autoPlay']}
		</td>
		<td class="tableb">
			<input type="checkbox" name="autoPlay" {$autoPlay_checked} />
		</td>
	</tr>
	<tr>
		<td class="tableb">
			{$lang_plugin_html5slideshow['seconds']}
		</td>
		<td class="tableb">
			<select class="listbox" name="seconds">{$choices}</select>
		</td>
	</tr>
	<tr>
		<td class="tableb">
			{$lang_plugin_html5slideshow['loopShow']}
		</td>
		<td class="tableb">
			<input type="checkbox" name="loopShow" {$loopShow_checked} />
		</td>
	</tr>
	<tr>
		<td class="tableb">
			{$lang_plugin_html5slideshow['txt2show']}
		</td>
		<td class="tableb">
			<input type="checkbox" name="dispTitl" id="dispTitl" {$dispTitl_checked} onchange="setText()" /> <label for="dispTitl">{$lang_common['title']}</label>
			<input type="checkbox" name="dispDesc" id="dispDesc" {$dispDesc_checked} onchange="setText()" style="margin-left:3em" /> <label for="dispDesc">{$lang_common['caption']}</label>
		</td>
	</tr>
	<tr>
		<td class="tableb">
			{$lang_plugin_html5slideshow['iconset']}
		</td>
		<td class="tableb">
			<select id="h5iconsel" class="listbox" name="iconset" onchange="H5applyis(this)">{$ichoices}</select>
		</td>
	</tr>
	<tr>
		<td class="tableb">
			{$lang_plugin_html5slideshow['colors']}
		</td>
		<td class="tableb">
			<div id="smpl" style="width:50%;float:right;text-align:center">
				<div id="smpl_c">{$lang_plugin_html5slideshow['controls']}<img id="h5ssicons" src="plugins/html5slideshow/css/icons/{$iconset}.png" style="margin-left:10px;padding:2px;vertical-align:middle;" alt="iconset"/></div>
				<div id="smpl_t" style="padding-top:1px">{$ptext}</div>
				<div id="smpl_p" style="height:110px"><img src="plugins/html5slideshow/css/smplpic.jpg" alt="" /></div>
			</div>
			<table class="dspcolr">
				<tr><th></th><th>{$lang_plugin_html5slideshow['background']}</th><th>{$lang_plugin_html5slideshow['foreground']}</th></tr>
				<tr><td>{$lang_plugin_html5slideshow['ctlarea']}</td><td class="tac"><input id="h5ctrl_b" type="text" name="ctrl_b" value="{$dcolors[0]}" /></td><td class="tac"><input id="h5ctrl_t" type="text" name="ctrl_t" value="{$dcolors[1]}" /></td></tr>
				<tr><td>{$lang_plugin_html5slideshow['txtarea']}</td><td class="tac"><input id="h5text_b" type="text" name="text_b" value="{$dcolors[2]}" /></td><td class="tac"><input id="h5text_t" type="text" name="text_t" value="{$dcolors[3]}" /></td></tr>
				<tr><td>{$lang_plugin_html5slideshow['picarea']}</td><td class="tac"><input id="h5pica_b" type="text" name="backgrnd" value="{$dcolors[4]}" /></td><td></td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="tableb" colspan="2" style="text-align:center">
			{$action_sel}<button value="{$lang_common['apply_changes']}" name="submit" class="button" type="submit">{$submit_icon}{$lang_common['apply_changes']}</button>
		</td>
	</tr>
EOT;


	endtable();

	if ($album) echo "<input type=\"hidden\" name=\"album\" value=\"{$album}\" />";
	if (!defined('PLUGINMGR_PHP')) {
		list($timestamp, $form_token) = getFormToken();
		echo "<input type=\"hidden\" name=\"form_token\" value=\"{$form_token}\" />";
		echo "<input type=\"hidden\" name=\"timestamp\" value=\"{$timestamp}\" />";
		echo '</form>';
		pagefooter();
	}
}


function h5ss_process_form (&$cfg, $album, $user)
{
	global $CONFIG, $superCage, $lang_common, $lang_plugin_html5slideshow;

	if (!$album) {
		$cfg['aA'] = $superCage->post->keyExists('atAlbum') ? 1 : 0;
		$cfg['aL'] = $superCage->post->keyExists('atList') ? 1 : 0;
		$cfg['aT'] = $superCage->post->keyExists('atThumbs') ? 1 : 0;
		$cfg['uA'] = $superCage->post->keyExists('uAllow') ? 1 : 0;
	}
	$cfg['nW'] = $superCage->post->keyExists('newWin') ? 1 : 0;
	$cfg['sI'] = $superCage->post->keyExists('shuffle') ? 1 : 0;
	$cfg['aP'] = $superCage->post->keyExists('autoPlay') ? 1 : 0;
	$cfg['lS'] = $superCage->post->keyExists('loopShow') ? 1 : 0;
	$cfg['vT'] = $superCage->post->keyExists('dispTitl') ? 1 : 0;
	$cfg['vD'] = $superCage->post->keyExists('dispDesc') ? 1 : 0;
	if ($superCage->post->keyExists('seconds')) {
		$cfg['sD'] = (int)$superCage->post->getEscaped('seconds');
	}
	if ($superCage->post->keyExists('imgSize')) {
		$cfg['pS'] = (int)$superCage->post->getEscaped('imgSize');
	}
	if ($superCage->post->keyExists('trnType')) {
		$cfg['tT'] = $superCage->post->getEscaped('trnType');
	}

	// will have to 'join' the colors to fit in a <256 char serialization for config storage
	// need to keep it all as one item to facilitate having per/album and users' default settings
	$dcolors = array();
	$dcolors[0] = $superCage->post->keyExists('ctrl_b') ? $superCage->post->getEscaped('ctrl_b') : '';
	$dcolors[1] = $superCage->post->keyExists('ctrl_t') ? $superCage->post->getEscaped('ctrl_t') : '';
	$dcolors[2] = $superCage->post->keyExists('text_b') ? $superCage->post->getEscaped('text_b') : '';
	$dcolors[3] = $superCage->post->keyExists('text_t') ? $superCage->post->getEscaped('text_t') : '';
	$dcolors[4] = $superCage->post->keyExists('backgrnd') ? $superCage->post->getEscaped('backgrnd') : '';
	$cfg['dC'] = join(',',$dcolors);

	$cfg['iS'] = $superCage->post->keyExists('iconset') ? $superCage->post->getEscaped('iconset') : '';

	$cfgs = serialize($cfg);
	if ($album) {
		$act = $superCage->post->getAlpha('action');
		switch ($act) {
			case 'sa':
				cpg_db_query("UPDATE {$CONFIG['TABLE_ALBUMS']} SET `H5ss_cfg` = '{$cfgs}' WHERE aid = {$album}");
				break;
			case 'su':
				cpg_db_query("UPDATE {$CONFIG['TABLE_USERS']} SET `H5ss_cfg` = '{$cfgs}' WHERE user_id = {$user}");
				break;
			case 'za':
				cpg_db_query("UPDATE {$CONFIG['TABLE_ALBUMS']} SET `H5ss_cfg` = '' WHERE aid = {$album}");
				break;
			case 'zu':
				cpg_db_query("UPDATE {$CONFIG['TABLE_USERS']} SET `H5ss_cfg` = '' WHERE user_id = {$user}");
				break;
		}
		cpgRedirectPage("thumbnails.php?album={$album}", 'caption', $lang_plugin_html5slideshow['saved'], 0, 'success');
	} else if (GALLERY_ADMIN_MODE) {
		cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '{$cfgs}' WHERE name = 'html5slideshow_cfg'");
	}

	starttable('100%', $lang_common['information']);
	echo '<tr><td class="tableb" width="200">'.$lang_plugin_html5slideshow['saved'].'</td></tr>';
	endtable();
	echo '<br />';
}
