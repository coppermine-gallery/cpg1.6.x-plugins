<?php
/**************************************************
  Coppermine 1.6.x Plugin - Picture Annotation (annotate)
  *************************************************
  Copyright (c) 2003-2019 Coppermine Dev Team
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  **************************************************/

if (!defined('IN_COPPERMINE')) {
    die('Not in Coppermine...');
}

$lang_plugin_annotate['annotate'] = 'Annoteerimine';
$lang_plugin_annotate['plugin_name'] = 'Pildi annoteerimine';
$lang_plugin_annotate['plugin_description'] = 'Annotatsioonide lisamine piltidele';
$lang_plugin_annotate['plugin_credit_creator'] = 'Autor (CM versioonid cpg1.4.x): %s';
$lang_plugin_annotate['plugin_credit_porter'] = 'CM versioonidele cpg1.5.x portis: %s';
$lang_plugin_annotate['plugin_credit_porter16'] = 'CM versioonidele cpg1.6.x portis: %s';
$lang_plugin_annotate['plugin_credit_js'] = 'Kasutatud JavaScripti teegid: %s ja %s';
$lang_plugin_annotate['plugin_credit_i18n'] = 'Hargmaistamine (i18n): %s';
$lang_plugin_annotate['submit_to_install'] = 'Plugina installeerimiseks saatke ankeet.';
$lang_plugin_annotate['configure_plugin'] = 'Annoteerimisplugina seaded';
$lang_plugin_annotate['changes_saved'] = 'Muudatused on salvestatud.';
$lang_plugin_annotate['no_changes'] = 'Midagi ei ole muudetud või sisestatud väärtused ei sobi.';
$lang_plugin_annotate['guests_more_permissions_than_registered'] = 'Külalistele suuremate õiguste andmine kui registreeritud kasutajatele ei ole mõttekas. Palun vaadake seaded üle!';
$lang_plugin_annotate['prune_database'] = 'Kas soovite kõik annotatsioonid andmebaasist kustutada?';
$lang_plugin_annotate['announcement_thread'] = 'Teated foorumis';
$lang_plugin_annotate['delete_orphaned_entries'] = 'Pildita jäänud annotatsioonide kustutamine';
$lang_plugin_annotate['x_orphaned_entries_deleted'] = 'Kustutatud %s pildita jäänud annotatsiooni.';
$lang_plugin_annotate['1_orphaned_entry_deleted'] = 'Kustutatud üks pildita jäänud annotatsioon.';
$lang_plugin_annotate['save'] = 'Salvesta';
$lang_plugin_annotate['cancel'] = 'Loobun';
$lang_plugin_annotate['error_saving_note'] = 'Viga annotatsiooni salvestamisel'; // JS-alert
$lang_plugin_annotate['onsave_not_implemented'] = 'Et *tegelikult* salvestada, peab <i>onsave</i> töötama.'; // JS-alert
$lang_plugin_annotate['permissions'] = 'Õigused';
$lang_plugin_annotate['group'] = 'Grupp';
$lang_plugin_annotate['guest'] = 'Külalise';
$lang_plugin_annotate['guests'] = 'Külalised';
$lang_plugin_annotate['registered_users'] = 'Registreeritud kasutajad';
$lang_plugin_annotate['administrators'] = 'Administraatorid';
$lang_plugin_annotate['read_annotations'] = 'Annotatsioonide lugemine';
$lang_plugin_annotate['read_write_annotations'] = 'Annotatsioonide lugemine ja kirjutamine';
$lang_plugin_annotate['read_write_delete_annotations'] = 'Annotatsioonide lugemine, kirjutamine ja kustutamine';
$lang_plugin_annotate['no_access'] = 'Juurdepääsu ei ole.';
$lang_plugin_annotate['lastnotes'] = 'Viimati annoteeritud pildid';
$lang_plugin_annotate['shownotes'] = 'Pildid, millel on';
$lang_plugin_annotate['x_annotations_for_file'] = 'Selle faili kohta on %s annotatsiooni.';
$lang_plugin_annotate['1_annotation_for_file'] = 'Selle faili kohta on üks annotatsioon.';
$lang_plugin_annotate['registration_promotion'] = 'Annotatsioonide vaatamiseks peate olema sisse logitud. Kui teil juba on konto, %slogige sisse%s. Kui teil veel kontot ei ole, %registreeruge%s (see on tasuta).'; // Do not translate the %s placeholders
$lang_plugin_annotate['update_database'] = 'Ajakohasta andmebaas';
$lang_plugin_annotate['update_database_success'] = 'Andmebaas on ajakohastatud.';
$lang_plugin_annotate['rapid_annotation'] = 'Kiirannotatsioon';
$lang_plugin_annotate['annotate_x_on_this_pic'] = 'Annoteerin sellel pildil: „%s”';
$lang_plugin_annotate['on_this_pic'] = 'Sellel pildil on';
$lang_plugin_annotate['all_pics_of'] = 'Näita kõiki pilte, millel on %s';
$lang_plugin_annotate['annotation_type'] = 'Annotatsiooni tüüp';
$lang_plugin_annotate['free_text'] = 'vabas vormis tekst';
$lang_plugin_annotate['drop_down_existing_annotations'] = 'juba salvestatud annotatsioonide ripploend';
$lang_plugin_annotate['drop_down_registered_users'] = 'registreeritud kasutajate ripploend';
$lang_plugin_annotate['display_notes'] = 'Näidatakse kiirannoteerimise nuppe';
$lang_plugin_annotate['display_notes_title'] = 'Parasjagu avatud albumisse salvestatud annotatsioonide nuppe näidatakse teiste nuppude juures (kergema/kiirema annoteerimise huvides)';
$lang_plugin_annotate['display_links'] = 'Annotatsioone näidatakse pildi kohal';
$lang_plugin_annotate['note_empty'] = 'Annotatsioon ei tohi olla tühi!'; // JS-alert
$lang_plugin_annotate['manage'] = 'Annotatsioonide haldamine';
$lang_plugin_annotate['batch_rename'] = 'Ümbernimetamine';
$lang_plugin_annotate['batch_delete'] = 'Kustutamine';
$lang_plugin_annotate['rename_to'] = 'nimetatakse ümber:';
$lang_plugin_annotate['sure_rename'] = 'Kas soovite nimetada annotatsiooni „%s” ümber kujule „%s”?';
$lang_plugin_annotate['rename_success'] = 'Annotatsioon „%s” on nimetatud ümber kujule „%s”.';
$lang_plugin_annotate['rename_fail'] = 'Annotatsiooni „%s” <b>ei</b> nimetatud ümber kujule „%s”';
$lang_plugin_annotate['sure_delete'] = 'Kas soovite kustutada annotatsiooni „%s”?';
$lang_plugin_annotate['delete_success'] = 'Annotatsioon „%s” on kustutatud.';
$lang_plugin_annotate['import'] = 'Annotatsioonide importimine';
$lang_plugin_annotate['import_found'] = 'Leitud %s annotatsioon(i)';
$lang_plugin_annotate['imported_already'] = 'Importimine on juba sooritatud.';
$lang_plugin_annotate['import_success'] = 'Imporditud %s annotatsioon(i)';
$lang_plugin_annotate['annotated_by'] = 'Annoteeris:';
$lang_plugin_annotate['view_profile'] = 'Näita kasutaja %s profiili';
$lang_plugin_annotate['display_stats'] = 'Näidatakse statistikat';
$lang_plugin_annotate['display_stats_title'] = 'Annoteerimisnupu kõrval kuvatakse „%s”, „%s” ja „%s”.';
$lang_plugin_annotate['annotations_pic'] = 'Annotatsioonid sellel pildil';
$lang_plugin_annotate['annotations_album'] = 'Annotatsioonid selles albumis';
$lang_plugin_annotate['annotated_pics'] = 'Annoteeritud pildid selles albumis';
$lang_plugin_annotate['filter_annotations'] = 'Otsing annotatsioonidest';
$lang_plugin_annotate['search_results'] = 'Otsingu tulemused';
$lang_plugin_annotate['disable_mobile'] = 'Mobiilseadmetel annotatsioone ei kuvata (sel juhul on vaja pluginat <a href="http://forum.coppermine-gallery.net/index.php/topic,74827.0.html" class="external" rel="external">Theme switch</a>)';

//EOF