<?php
/**************************************************
  Coppermine 1.5.x Plugin - Picture Annotation (annotate)
  *************************************************
  Copyright (c) 2003-2009 Coppermine Dev Team
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  ********************************************
  $HeadURL$
  $Revision$
  $LastChangedBy$
  $Date$
  **************************************************/

if (!defined('IN_COPPERMINE')) {
    die('Not in Coppermine...');
}

$lang_plugin_annotate['annotate'] = 'Beschriftung';
$lang_plugin_annotate['plugin_name'] = 'Bild-Beschriftung';
$lang_plugin_annotate['plugin_description'] = 'Füge Beschriftungen in Textform den Bildern der Galerie hinzu';
$lang_plugin_annotate['plugin_credit_creator'] = 'Programmiert durch %s für cpg1.4.x';
$lang_plugin_annotate['plugin_credit_porter'] = 'Portiert nach cpg1.5.x durch %s';
$lang_plugin_annotate['plugin_credit_js'] = 'Verwendete JavaScriptBibliotheken von %s und %s';
$lang_plugin_annotate['plugin_credit_i18n'] = 'Internationalisierung durch %s';
$lang_plugin_annotate['submit_to_install'] = 'Sende das Formular ab, um das Plugin zu installieren';
$lang_plugin_annotate['configure_plugin'] = 'Konfiguriere Bild-Beschriftungs-Plugin';
$lang_plugin_annotate['changes_saved'] = 'Deine Änderungen wurden gespeichert';
$lang_plugin_annotate['no_changes'] = 'Es gab keine Änderungen oder Deine Änderungen waren ungültig';
$lang_plugin_annotate['guests_more_permissions_than_registered'] = 'Gästen mehr Rechte zu gewähren als registrierten Benutzern macht keinen Sinn. Überprüfe Deine Einstellungen!';
$lang_plugin_annotate['prune_database'] = 'Wollen Sie alle Beschriftungen aus der Datenbank löschen?';
$lang_plugin_annotate['announcement_thread'] = 'Ankündigungs-Thema';
$lang_plugin_annotate['delete_orphaned_entries'] = 'Verwaiste Beschriftungen löschen';
$lang_plugin_annotate['x_orphaned_entries_deleted'] = '%s verwaiste Einträge wurden gelöscht';
$lang_plugin_annotate['1_orphaned_entry_deleted'] = '1 verwaister Eintrag wurde gelöscht';
$lang_plugin_annotate['save'] = 'Speichern';
$lang_plugin_annotate['cancel'] = 'Abbrechen';
$lang_plugin_annotate['error_saving_note'] = 'Fehler beim Speichern'; // JS-alert
$lang_plugin_annotate['onsave_not_implemented'] = 'onsave muss implementiert sein, damit man tatsächlich etwas speichern kann'; // JS-alert
$lang_plugin_annotate['permissions'] = 'Berechtigungen';
$lang_plugin_annotate['group'] = 'Gruppe';
$lang_plugin_annotate['guests'] = 'Gäste';
$lang_plugin_annotate['registered_users'] = 'Registrierte Benutzer';
$lang_plugin_annotate['administrators'] = 'Administratoren';
$lang_plugin_annotate['read_annotations'] = 'Beschriftungen lesen';
$lang_plugin_annotate['read_write_annotations'] = 'Beschriftungen lesen und schreiben';
$lang_plugin_annotate['read_write_delete_annotations'] = 'Beschriftungen lesen, schreiben und löschen';
$lang_plugin_annotate['no_access'] = 'kein Zugriff';
$lang_plugin_annotate['lastnotes'] = 'zuletzt beschriftete Bilder';
$lang_plugin_annotate['shownotes'] = 'Bilder mit';
$lang_plugin_annotate['x_annotations_for_file'] = 'Es sind %s Beschriftungen für diese Datei vorhanden.';
$lang_plugin_annotate['1_annotation_for_file'] = 'Es ist eine Beschriftungen für diese Datei vorhanden.';
$lang_plugin_annotate['registration_promotion'] = 'Du musst angemeldet sein, um Beschriftungen anzusehen. %sMelde Dich an%s wenn Du schon ein Benutzerkonto hast oder %sregistriere%s Dich kostenlos.'; // Do not translate the %s placeholders
$lang_plugin_annotate['update_database'] = 'Datenbank aktualisieren';
$lang_plugin_annotate['update_database_success'] = 'Datenbank erfolgreich aktualisiert';
$lang_plugin_annotate['rapid_annotation'] = 'Schnellbeschriftung';
$lang_plugin_annotate['annotate_x_on_this_pic'] = 'Beschrifte dieses Bild mit &quot;%s&quot;';
$lang_plugin_annotate['on_this_pic'] = 'Auf diesem Bild';
$lang_plugin_annotate['all_pics_of'] = 'Zeige alle Bilder mit &quot;%s&quot;';
$lang_plugin_annotate['annotation_type'] = 'Beschriftungsart';
$lang_plugin_annotate['free_text'] = 'Freitext';
$lang_plugin_annotate['drop_down_existing_annotations'] = 'Liste bereits bestehender Beschriftungen';
$lang_plugin_annotate['drop_down_registered_users'] = 'Liste der registrierten Benutzer';
$lang_plugin_annotate['display_notes'] = 'Zeige Schnellbeschriftungs-Buttons';
$lang_plugin_annotate['display_notes_title'] = 'Zeige Buttons von bereits erstellten Beschriftungen des jeweiligen Albums im Buttonbereich (zur leichteren/schnelleren Beschriftung)';
$lang_plugin_annotate['display_links'] = 'Zeige Markierungen über dem Bild';
$lang_plugin_annotate['note_empty'] = 'Beschriftungen dürfen nicht leer sein!'; // JS-alert
$lang_plugin_annotate['manage'] = 'Beschriftungen verwalten';
$lang_plugin_annotate['batch_rename'] = 'Batch-umbenennen';
$lang_plugin_annotate['batch_delete'] = 'Batch-löschen';
$lang_plugin_annotate['rename_to'] = 'umbenennen in';
$lang_plugin_annotate['sure_rename'] = 'Soll "%s" wirklich in "%s" umbenannt werden?';
$lang_plugin_annotate['rename_success'] = '"%s" wurde in "%s" umbenannt';
$lang_plugin_annotate['rename_fail'] = '"%s" wurde <b>nicht</b> in "%s" umbenannt';
$lang_plugin_annotate['sure_delete'] = 'Soll "%s" wirklich gelöscht werden?';
$lang_plugin_annotate['delete_success'] = '"%s" wurde erfolgreich gelöscht';
$lang_plugin_annotate['import'] = 'Beschriftungen importieren';
$lang_plugin_annotate['import_found'] = '%s Beschriftungen gefunden';
$lang_plugin_annotate['imported_already'] = 'Der Import wurde bereits ausgeführt';
$lang_plugin_annotate['import_success'] = '%s Beschriftungen importiert';
$lang_plugin_annotate['annotated_by'] = 'Beschriftet von';
$lang_plugin_annotate['view_profile'] = 'Profil von "%s" anzeigen';
$lang_plugin_annotate['display_stats'] = 'Zeige Statistik';
$lang_plugin_annotate['display_stats_title'] = 'Zeigt \'%s\', \'%s\' und \'%s\' neben dem Beschriftungsbutton';
$lang_plugin_annotate['annotations_pic'] = 'Markierungen auf diesem Bild';
$lang_plugin_annotate['annotations_album'] = 'Markierungen in diesem Album';
$lang_plugin_annotate['annotated_pics'] = 'Markierte Bilder in diesem Album';
$lang_plugin_annotate['filter_annotations'] = 'Beschriftungen filtern';
$lang_plugin_annotate['search_results'] = 'Suchergebnisse';
$lang_plugin_annotate['disable_mobile'] = 'Für mobile Geräte deaktivieren (benötigt das <a href="http://forum.coppermine-gallery.net/index.php/topic,74827.0.html" class="external" rel="external">Theme switch-Plugin</a>)';
?>