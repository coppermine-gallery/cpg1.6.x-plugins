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

$lang_plugin_annotate['annotate'] = 'Annoter';
$lang_plugin_annotate['plugin_name'] = 'Picture Annotation (Annotations d\'images';
$lang_plugin_annotate['plugin_description'] = 'Ajouter des annotations textuelles à vos images';
$lang_plugin_annotate['plugin_credit_creator'] = 'Créé par %s pour cpg1.4.x';
$lang_plugin_annotate['plugin_credit_porter'] = 'Porté pour cpg1.5.x par %s';
$lang_plugin_annotate['plugin_credit_porter16'] = 'Porté pour cpg1.6.x par %s';
$lang_plugin_annotate['plugin_credit_js'] = 'Bibliothèques JavaScript utilisé de %s et %s';
$lang_plugin_annotate['plugin_credit_i18n'] = 'Internationalisation par %s';
$lang_plugin_annotate['submit_to_install'] = 'Valider le formulaire pour installer le plugin';
$lang_plugin_annotate['configure_plugin'] = 'Configurer le plugin Photo annotation';
$lang_plugin_annotate['changes_saved'] = 'Vos modifications ont été enregistrées';
$lang_plugin_annotate['no_changes'] = 'Il n\'y a eu aucun changement ou les valeurs que vous avez inscrites sont invalides';
$lang_plugin_annotate['guests_more_permissions_than_registered'] = 'L’octroi aux simples visiteurs, d\'autorisations plus grandes qu’aux utilisateurs enregistrés n\'a pas de sens. Merci de vérifiez vos paramètres !';
$lang_plugin_annotate['prune_database'] = 'Voulez-vous supprimer toutes les annotations de la base de données ?';
$lang_plugin_annotate['announcement_thread'] = 'Sujet d’annonce';
$lang_plugin_annotate['delete_orphaned_entries'] = 'Supprimer des entrées orphelines';
$lang_plugin_annotate['x_orphaned_entries_deleted'] = '%s entrées orphelines supprimées';
$lang_plugin_annotate['1_orphaned_entry_deleted'] = '1 entrée orpheline supprimée';
$lang_plugin_annotate['save'] = 'Enregistrer';
$lang_plugin_annotate['cancel'] = 'Annuler';
$lang_plugin_annotate['error_saving_note'] = 'Erreur d\'enregistrement de note'; // JS-alert
$lang_plugin_annotate['onsave_not_implemented'] = 'OnSave doit être mis en œuvre pour *réellement* sauvegarder'; // JS-alert
$lang_plugin_annotate['permissions'] = 'Permissions';
$lang_plugin_annotate['group'] = 'Groupe';
$lang_plugin_annotate['guest'] = 'Visiteur';
$lang_plugin_annotate['guests'] = 'Visiteurs';
$lang_plugin_annotate['registered_users'] = 'Utilisateur enregistré';
$lang_plugin_annotate['administrators'] = 'Administrateurs';
$lang_plugin_annotate['read_annotations'] = 'Lire les annotations';
$lang_plugin_annotate['read_write_annotations'] = 'Lire et créez des annotations';
$lang_plugin_annotate['read_write_delete_annotations'] = 'Lire, créer et supprimer des annotations';
$lang_plugin_annotate['no_access'] = 'Pas d\'accès';
$lang_plugin_annotate['lastnotes'] = 'Dernières photos annotées';
$lang_plugin_annotate['shownotes'] = 'Images de';
$lang_plugin_annotate['x_annotations_for_file'] = 'Il y a %s annotations pour ce fichier.';
$lang_plugin_annotate['1_annotation_for_file'] = 'Il y a une annotation pour ce fichier.';
$lang_plugin_annotate['registration_promotion'] = 'Vous devez être connecté pour voir les annotations. %sIdentifiez-vous%s si vous avez déjà un compte ou %senregistrez-vous%s gratuitement pour en avoir un.'; // Do not translate the %s placeholders
$lang_plugin_annotate['update_database'] = 'Mise à jour de la base de données';
$lang_plugin_annotate['update_database_success'] = 'La mise à jour de base de données a été correctement faite';
$lang_plugin_annotate['rapid_annotation'] = 'Annotation rapide';
$lang_plugin_annotate['annotate_x_on_this_pic'] = 'Annoter \'%s\' sur cette photo';
$lang_plugin_annotate['on_this_pic'] = 'Sur cette photo';
$lang_plugin_annotate['all_pics_of'] = 'Voir toutes les photos de &quot;%s&quot;';
$lang_plugin_annotate['annotation_type'] = 'Type d\'annotation';
$lang_plugin_annotate['free_text'] = 'Texte libre';
$lang_plugin_annotate['drop_down_existing_annotations'] = 'Liste déroulante des annotations existantes';
$lang_plugin_annotate['drop_down_registered_users'] = 'Liste déroulante des utilisateurs enregistrés';
$lang_plugin_annotate['display_notes'] = 'Affiche les boutons d\'annotation rapide';
$lang_plugin_annotate['display_notes_title'] = 'Affiche les boutons d\'annotations existantes de l\'album en cours d\'affichage dans la section des boutons (pour faciliter / accélérer les annotations)';
$lang_plugin_annotate['display_links'] = 'Affichage des annotations au-dessus de l\'image';
$lang_plugin_annotate['note_empty'] = 'Les annotations ne peuvent être vides !'; // JS-alert
$lang_plugin_annotate['manage'] = 'Gérer les annotations';
$lang_plugin_annotate['batch_rename'] = 'Lot à renommer';
$lang_plugin_annotate['batch_delete'] = 'Lot à supprimer';
$lang_plugin_annotate['rename_to'] = 'renommez-le';
$lang_plugin_annotate['sure_rename'] = 'Voulez-vous vraiment renommer \'%s\' en \'%s\'?';
$lang_plugin_annotate['rename_success'] = '\'%s\' a été renommé \'%s\'';
$lang_plugin_annotate['rename_fail'] = '\'%s\' n\a <b>pas</b> été renommé en \'%s\'';
$lang_plugin_annotate['sure_delete'] = 'Voulez-vous vraiment supprimer \'%s\'?';
$lang_plugin_annotate['delete_success'] = '\'%s\' a été supprimé avec succès';
$lang_plugin_annotate['import'] = 'Importer les annotations';
$lang_plugin_annotate['import_found'] = 'Trouver %s annotations';
$lang_plugin_annotate['imported_already'] = 'L’importation a déjà été exécutée';
$lang_plugin_annotate['import_success'] = 'Importation de %s annotations';
$lang_plugin_annotate['annotated_by'] = 'Annoté par';
$lang_plugin_annotate['view_profile'] = 'Voir le profil de \'%s\'';
$lang_plugin_annotate['display_stats'] = 'Afficher les statistiques';
$lang_plugin_annotate['display_stats_title'] = 'Afficher \'%s\', \'%s\' et \'%s\' à côté du bouton d\'annotation';
$lang_plugin_annotate['annotations_pic'] = 'Annotations sur cette photo';
$lang_plugin_annotate['annotations_album'] = 'Annotations sur cette album';
$lang_plugin_annotate['annotated_pics'] = 'Photos annotées dans cet album';
$lang_plugin_annotate['filter_annotations'] = 'Filtrer les annotations';
$lang_plugin_annotate['search_results'] = 'Résultats de la recherche';


//EOF