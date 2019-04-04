<?php
$name='Secured fullsize download';
$description = <<<EOT
Secures access to fullsize images and adds a download link for registered users. <br />
<!-- Adds secured links for downloading albums and favorites as a zip file. <br /> -->
Adds a download history mechanism and statistics page
EOT;
$author='Created for cpg1.4.x by <a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=8075" class="external" rel="external">Klaus Schwarzburg</a><br />Ported to cpg1.5.x by <a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=24278" class="external" rel="external">eenemeenemuu</a><br />Ported to cpg1.6.x by <a href="http://forum.coppermine-gallery.net/index.php?action=profile;u=24278" class="external" rel="external">eenemeenemuu</a>';
$version='1.1';
$plugin_cpg_version = array('min' => '1.5.42');
$extra_info = <<<EOT
    <a href="index.php?file=fullsize_access/plugin_config" class="admin_menu">{$config_icon}$name {$lang_gallery_admin_menu['admin_lnk']}</a>
EOT;
$extra_info .= $install_info = '<a href="http://forum.coppermine-gallery.net/index.php/topic,74870.0.html" rel="external" class="admin_menu">'.cpg_fetch_icon('announcement', 1).'Announcement thread</a>';
?>