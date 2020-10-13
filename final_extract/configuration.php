<?php
/**
 * Coppermine 1.6.x Plugin - final_extract
 *
 * @copyright	Copyright (c) 2009 Donnovan Bray
 * @license		GNU General Public License version 3 or later; see LICENSE
 *
 * @author		Donnovan Bray (original)
 * @author		ron4mac (23 Dec 2018); version for CPG 1.6.x
 */
defined('IN_COPPERMINE') or die('Not in Coppermine...');

$name = 'Final_Extract';
$description = 'Removes specified template blocks from final output with Usergroup Option';
$author = <<<EOT
    Donnoman@donovanbray.com from cpg-contrib.org<br>
    Modified by: Sami<br>
    Modified by: Frantz<br>
    Modified by: eenemeenemuu<br>
    Updated for CPG 1.6.x by: ron4mac
EOT;
$extra_info = 'Configure this plugin using the admin menu item <a href="index.php?file=final_extract/admin" class="admin_menu">Final extract</a>';
$version = '2.7';
$plugin_cpg_version = array('min' => '1.6');
$final_extract_icon_array['ok'] = cpg_fetch_icon('ok', 1); 

//EOF