<?php
/*******************************************************
 Coppermine 1.6.x plugin - FileMove
 *******************************************************
 Copyright (c) 2003-2017 Coppermine Dev Team
 *******************************************************
 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 as published by the Free Software Foundation; either version 3
 of the License, or (at your option) any later version.
 *******************************************************
 Ported to CPG 1.6.x June 2017 {ron4mac}
 *******************************************************/

if (!defined('IN_COPPERMINE')) die('Nicht in Coppermine...');

$lang_plugin_FileMove['display_name'] = 'FileMove';		// Angezeigter Name
$lang_plugin_FileMove['description'] = 'W&auml;hlen Sie die zu verschiebenden Dateien oder Ordner und die Datenbank entsprechend zu &auml;ndern';
$lang_plugin_FileMove['author'] = 'Erstellt von Frantz';
$lang_plugin_FileMove['ported'] = '<br />Portiert zu cpg1.5.x von eenemeenemuu<br />Portiert zu cpg1.6.x von ron4mac';
$lang_plugin_FileMove['config_title'] = 'Konfiguration';		// Titel der Schaltfl&auml;che im Galerie-Konfigurationsmen&uuml;
$lang_plugin_FileMove['config_button'] = 'FileMove';		// Name der Schaltfl&auml;che im Galerie-Konfigurationsmen&uuml;
$lang_plugin_FileMove['install_note'] = 'Konfigurieren Sie das Plugin mit der Schaltfl&auml;che in der Admin-Symbolleiste.';        // Hinweis zum Konfigurieren vom Plugin
$lang_plugin_FileMove['install_click'] = 'Klicken Sie auf die Schaltfl&auml;che, um das Plugin zu installieren.';		// Nachricht zum Installieren von Plugin
$lang_plugin_FileMove['folder_name'] = 'W&auml;hlen Sie den Ordner, den oder aus dem Sie verschieben m&ouml;chten';
$lang_plugin_FileMove['folder_ar'] = 'Zielordner ausw&auml;hlen';
$lang_plugin_FileMove['some_files'] = 'Verschieben Sie einzelne Dateien im Ordner';
$lang_plugin_FileMove['choix'] = 'Wahl der Operation';
$lang_plugin_FileMove['choix2'] = 'W&auml;hlen Sie, was Sie tun m&ouml;chten';
$lang_plugin_FileMove['confirm'] = 'Best&auml;tigen Sie Ihre Wahl';
$lang_plugin_FileMove['confirm_titre'] = '<b>Sie haben folgende Ordner ausgew&auml;hlt:</b>';
$lang_plugin_FileMove['confirm_files'] = '<b>Sie haben folgende Dateien ausgew&auml;hlt:</b>';
$lang_plugin_FileMove['selectAll'] = 'Alles ausw&auml;hlen';
$lang_plugin_FileMove['selectNone'] = 'Alles abw&auml;hlen';
$lang_plugin_FileMove['folder'] = 'Verschieben Sie alle Dateien im Ordner';
$lang_plugin_FileMove['DFolder'] = 'Startordner: ';
$lang_plugin_FileMove['AFolder'] = 'Zielordner: ';
$lang_plugin_FileMove['to'] = ' zum ';
$lang_plugin_FileMove['error'] = 'FEHLER!';
$lang_plugin_FileMove['file'] = 'Datei';
$lang_plugin_FileMove['files'] = 'Dateien';
$lang_plugin_FileMove['valid'] = 'Ausgew&auml;hlte Datei(en) verschieben';
$lang_plugin_FileMove['continue'] = 'Fortsetzen';
$lang_plugin_FileMove['back'] = 'Zur&uuml;ck';
$lang_plugin_FileMove['transfer'] = '&Uuml;bertragung der Inhalte der ';
$lang_plugin_FileMove['transfer_file'] = '&Uuml;bertragen ausgew&auml;hlter Dateien aus dem ';
$lang_plugin_FileMove['folder2'] = 'Ordner ';
$lang_plugin_FileMove['folder_error'] = 'Fehler, der Ordner existiert nicht!';
$lang_plugin_FileMove['traitement'] = 'Datei(en) &uuml;bertragen';
$lang_plugin_FileMove['notmoved'] = 'Datei(en) wurden nicht &uuml;bertragen';
$lang_plugin_FileMove['install_info'] = '&Uuml;ber den Punkt "Dateien" im Men&uuml;, k&ouml;nnen Sie &uuml;ber den Men&uuml;punkt "FileMove" auf das Plugin zugreifen';
$lang_plugin_FileMove['extra_info'] = 'Klicken Sie im Men&uuml; Dateien auf den Men&uuml;punkt FileMove, um das Plugin zu verwenden';
