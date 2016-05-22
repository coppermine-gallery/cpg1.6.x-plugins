<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');
require_once './plugins/html5slideshow/initialize.inc.php';
global $lang_plugin_html5slideshow, $lang_gallery_admin_menu;

$name = $lang_plugin_html5slideshow['html5slide'];
$description = $lang_plugin_html5slideshow['plug_desc'];
$author = 'Ron Crans';
$version = '1.3.7';
$plugin_cpg_version = array('min' => '1.5');
if (version_compare(COPPERMINE_VERSION, '1.6.0', '<')) {
	$extra_info = '<a href="index.php?file=html5slideshow/config" class="admin_menu">'.cpg_fetch_icon('config', 1)."$name {$lang_gallery_admin_menu['admin_lnk']}</a>";
}
$install_info = $lang_plugin_html5slideshow['plug_info'];
$config_action = 'config';
