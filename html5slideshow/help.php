<?php
$styles = '../../themes/'.$_GET['t'].'/style.css';
$lang = $_GET['l'];
$hpaths = explode('|', $_GET['g']);
require 'lang/english.php';
if ($lang) require 'lang/'.$lang.'.php';
$hfiles = array();
foreach ($hpaths as $hpath) {
	$hfp = 'lang/help/'.$hpath.'/';
	$hfiles[] = $hfp . (file_exists($hfp.$lang.'.html') ? $lang.'.html' : 'english.html');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="<?=$styles?>">
<style>
.nobgimage { padding: 0 .7em 1em .7em; }
img { vertical-align: text-bottom; }
</style>
</head>
<body class="nobgimage">
<h2><?=$lang_plugin_html5slideshow['cfghelp']?></h2><br />
<?php foreach ($hfiles as $hfile) readfile($hfile); ?>
</body>
</html>