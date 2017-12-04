<?php
/**
 * Coppermine Photo Gallery
 * Coppermine version: 1.5.xx
 *
 * Picture Download Link
 * Version 1.4
 *  
 * Plugin Written by Joe Carver - http://photos-by.joe-carver.com/ - http://gallery.josephcarver.com/natural/ - http://i-imagine.net/artists/
 * 08 August 2010
*/
    // language file for plugin - submit changes to the Support thread for inclusion in  
    // the next release of this plugin

// plugin manager text
    $pic_link['display_name'] = 'Add Pic Downlink Link';
    $pic_link['plugin_documentation'] = 'Plugin-Dokumentation';
    $pic_link['announcement_thread'] = 'Plugin Support Thread (englisch)';
    $pic_link['description'] = 'Dieses Plugin fügt einen Download-Link zu der Bild-Seite hinzu';
	
// admin + confguation				
    $pic_link['configure_plugin_x'] = 'Plugin %s konfigurieren';				
    $pic_link['page_heading'] = 'Download Link plugin konfigurieren.';	
    $pic_link['page_head'] = 'Konfiguration für das  Download Link plugin.';	
    $pic_link['span_attr'] = 'HTML-Attribute für ein umgebendes &lt;span&gt;-Element';
    $pic_link['enabled_categories_regex'] = 'Den Download-Link in Kategorien zeigen, die diesem regulären Ausdruck entsprechen';
    $pic_link['link_user'] = 'Den Link nur angemeldeten Benutzern anzeigen';
    $pic_link['link_locate'] = 'Position, an der der Download-Link angezeigt werden soll';
    $pic_link['link_locate_0'] = 'über dem Bild';
    $pic_link['link_locate_1'] = 'unter dem Bild';
    $pic_link['link_locate_2'] = 'unter dem Titel/der Beschreibung';
    $pic_link['link_locate_3'] = 'in den Dateiinformationen';
    $pic_link['use_content_disposition'] = 'Direkt abspeichern (mit Content-Disposition)';
    $pic_link['hideprefix'] = 'Jedoch den Präfix für den Download-Dateinamen weglassen';
    $pic_link['whichone'] = 'Welche Bild-Größe verlinken?';
    $pic_link['whichone_0'] ='Volle Originalgröße';
    $pic_link['whichone_1'] ='Zwischengröße';
    $pic_link['submit_change'] = 'Einstellungen speichern';
    $pic_link['update_success'] = 'Änderungen abgespeichert';
    $pic_link['no_changes'] = 'Keine Änderungen vorgenommen';
	  
	// visitor - user text for the button and title of link
	$pic_link['link_table'] = 'Download';
	$pic_link['link_title'] = 'In einem neuen Fenster öffnen'; 
	$pic_link['link_save_title'] = 'Bild abspeichern'; 
	$pic_link['link_text'] = 'Bild herunterladen'; 
	$pic_link['link_null'] = 'Nur für registrierte/angemeldete Benutzer'; 	
?>