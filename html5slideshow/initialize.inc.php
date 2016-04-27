<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

function html5slideshow_language() {
	global $CONFIG, $lang_plugin_html5slideshow;

	require './plugins/html5slideshow/lang/english.php';
	if ($CONFIG['lang'] != 'english' && file_exists("./plugins/html5slideshow/lang/{$CONFIG['lang']}.php")) {
		require "./plugins/html5slideshow/lang/{$CONFIG['lang']}.php";
	}
	return $lang_plugin_html5slideshow;
}

if (version_compare(COPPERMINE_VERSION, '1.6.0', '<')) {
	html5slideshow_language();
}

function h5ss_db_fetch_assoc ($result) {
	if (version_compare(COPPERMINE_VERSION, '1.6.0', '>=')) {
		return cpg_db_fetch_assoc($result);
	} else {
		return cpg_db_fetch_row($result);
	}
}
