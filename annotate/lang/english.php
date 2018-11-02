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

$lang_plugin_annotate['annotate'] = 'Annotate';
$lang_plugin_annotate['plugin_name'] = 'Picture Annotation';
$lang_plugin_annotate['plugin_description'] = 'Add text annotations to your images';
$lang_plugin_annotate['plugin_credit_creator'] = 'Created by %s for cpg1.4.x';
$lang_plugin_annotate['plugin_credit_porter'] = 'Ported to cpg1.5.x by %s';
$lang_plugin_annotate['plugin_credit_js'] = 'JavaScript libraries used by %s and %s';
$lang_plugin_annotate['plugin_credit_i18n'] = 'Internationalization by %s';
$lang_plugin_annotate['submit_to_install'] = 'Submit the form to install the plugin';
$lang_plugin_annotate['configure_plugin'] = 'Configure Picture Annotation plugin';
$lang_plugin_annotate['changes_saved'] = 'Your changes have been saved';
$lang_plugin_annotate['no_changes'] = 'There have been no changes or the values you entered where invalid';
$lang_plugin_annotate['guests_more_permissions_than_registered'] = 'Granting guests more permissions than registered users doesn\'t make sense. Please review your settings!';
$lang_plugin_annotate['prune_database'] = 'Do you want to remove all annotations from the database?';
$lang_plugin_annotate['announcement_thread'] = 'Announcement thread';
$lang_plugin_annotate['delete_orphaned_entries'] = 'Delete orphaned entries';
$lang_plugin_annotate['x_orphaned_entries_deleted'] = '%s orphaned entries deleted';
$lang_plugin_annotate['1_orphaned_entry_deleted'] = '1 orphaned entry deleted';
$lang_plugin_annotate['save'] = 'Save';
$lang_plugin_annotate['cancel'] = 'Cancel';
$lang_plugin_annotate['error_saving_note'] = 'Error saving note'; // JS-alert
$lang_plugin_annotate['onsave_not_implemented'] = 'onsave must be implemented in order to *actually* save'; // JS-alert
$lang_plugin_annotate['permissions'] = 'Permissions';
$lang_plugin_annotate['group'] = 'Group';
$lang_plugin_annotate['guests'] = 'Guests';
$lang_plugin_annotate['registered_users'] = 'Registered Users';
$lang_plugin_annotate['administrators'] = 'Administrators';
$lang_plugin_annotate['read_annotations'] = 'Read annotations';
$lang_plugin_annotate['read_write_annotations'] = 'Read and create annotations';
$lang_plugin_annotate['read_write_delete_annotations'] = 'Read, create and delete annotations';
$lang_plugin_annotate['no_access'] = 'No access';
$lang_plugin_annotate['lastnotes'] = 'Last annotated pictures';
$lang_plugin_annotate['shownotes'] = 'Pictures of';
$lang_plugin_annotate['x_annotations_for_file'] = 'There are %s annotations for this file.';
$lang_plugin_annotate['1_annotation_for_file'] = 'There is one annotation for this file.';
$lang_plugin_annotate['registration_promotion'] = 'You need to be logged in to view annotations. %sLog in%s if you already have an account or %sregister%s for free.'; // Do not translate the %s placeholders
$lang_plugin_annotate['update_database'] = 'Update database';
$lang_plugin_annotate['update_database_success'] = 'Database update was successfully';
$lang_plugin_annotate['rapid_annotation'] = 'Rapid annotation';
$lang_plugin_annotate['annotate_x_on_this_pic'] = 'Annotate \'%s\' on this picture';
$lang_plugin_annotate['on_this_pic'] = 'On this picture';
$lang_plugin_annotate['all_pics_of'] = 'Show all pictures of &quot;%s&quot;';
$lang_plugin_annotate['annotation_type'] = 'Annotation type';
$lang_plugin_annotate['free_text'] = 'Free text';
$lang_plugin_annotate['drop_down_existing_annotations'] = 'Drop-down list of already existing annotations';
$lang_plugin_annotate['drop_down_registered_users'] = 'Drop-down list of registered users';
$lang_plugin_annotate['display_notes'] = 'Display rapid annotation buttons';
$lang_plugin_annotate['display_notes_title'] = 'Display buttons of existing annotations of the currently viewed album in the buttons section (for easier/faster annotation)';
$lang_plugin_annotate['display_links'] = 'Display annotations above the picture';
$lang_plugin_annotate['note_empty'] = 'Annotations may not be empty!'; // JS-alert
$lang_plugin_annotate['manage'] = 'Manage annotations';
$lang_plugin_annotate['batch_rename'] = 'Batch rename';
$lang_plugin_annotate['batch_delete'] = 'Batch delete';
$lang_plugin_annotate['rename_to'] = 'rename to';
$lang_plugin_annotate['sure_rename'] = 'Do you really want to rename \'%s\' to \'%s\'?';
$lang_plugin_annotate['rename_success'] = '\'%s\' was renamed to \'%s\'';
$lang_plugin_annotate['rename_fail'] = '\'%s\' was <b>not</b> renamed to \'%s\'';
$lang_plugin_annotate['sure_delete'] = 'Do you really want to delete \'%s\'?';
$lang_plugin_annotate['delete_success'] = '\'%s\' was deleted successfully';
$lang_plugin_annotate['import'] = 'Import annotations';
$lang_plugin_annotate['import_found'] = 'Found %s annotations';
$lang_plugin_annotate['imported_already'] = 'Import has already been executed';
$lang_plugin_annotate['import_success'] = 'Imported %s annotations';
$lang_plugin_annotate['annotated_by'] = 'Annotated by';
$lang_plugin_annotate['view_profile'] = 'View profile of \'%s\'';
$lang_plugin_annotate['display_stats'] = 'Display statistics';
$lang_plugin_annotate['display_stats_title'] = 'Display \'%s\', \'%s\' and \'%s\' next to the annotation button';
$lang_plugin_annotate['annotations_pic'] = 'Annotations on this picture';
$lang_plugin_annotate['annotations_album'] = 'Annotations in this album';
$lang_plugin_annotate['annotated_pics'] = 'Annotated pictures in this album';
$lang_plugin_annotate['filter_annotations'] = 'Filter annotations';
$lang_plugin_annotate['search_results'] = 'Search results';
$lang_plugin_annotate['disable_mobile'] = 'Disable for mobile devices (needs the <a href="http://forum.coppermine-gallery.net/index.php/topic,74827.0.html" class="external" rel="external">Theme switch plugin</a>)';
?>