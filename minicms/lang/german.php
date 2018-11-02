<?php
/**************************************************
  CPG MiniCMS Plugin for Coppermine Photo Gallery
  *************************************************
  CPGMiniCMS
  Copyright (c) 2005-2006 Donovan Bray <donnoman@donovanbray.com>
  *************************************************
  1.3.0  eXtended miniCMS
  Copyright (C) 2004 Michael Trojacher <m.trojacher@webtips.at>
  Original miniCMS Code (c) 2004 by Tarique Sani <tarique@sanisoft.com>,
  Amit Badkas <amit@sanisoft.com>
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.
  *************************************************
  Coppermine version: 1.5.x
  $HeadURL: http://svn.code.sf.net/p/coppermine/code/branches/cpg1.5.x/plugins/minicms/lang/german.php $
  $Revision: 8400 $
  $Author: eenemeenemuu $
  $Date: 2012-05-09 04:36:53 -0400 (Wed, 09 May 2012) $
***************************************************/

/**
 * German Language File
 * @author eenemeenemuu
 * @package language
 * @subpackage german
 * @version 1.7
 */

if (!defined('IN_COPPERMINE')) { die('Not in Coppermine...');}

$lang_minicms = array(
  'minicms' => 'MiniCMS', // Display Name
  'minicms_full' => 'cpg-contrib MiniCMS',
  'admin_title' => 'MiniCMS-Administration', // Title of the button on the gallery admin menu
  'config_title' => 'MiniCMS-Einstellungen', // Title of the button on the gallery admin menu
  'title' => 'Titel', // Title of new content field on cms_admin form
  'page_success' => 'Seite wurde gespeichert', // Success messages
  'page_fail' => 'Fehler beim Speichern der Seite', // Fail Messages
  'non_exist' => 'Inhalt existiert nicht', // Error Message
  'action' => 'Aktion', // Column Heading
  'view' => 'Ansicht', // Column Heading
  'content' => 'Inhalt', // Column Heading
  'edit' => 'Bearbeiten', // Column Heading
  'cpos' => 'Position', //Column Heading, renamed cpos to avoid conflict with coppermines pos field.
  'add_new' => 'Neuen Inhallt hinzufügen', //Form Field
  'new_content' => 'Neuer Inhalt', // Default Title on new content from cms_admin
  'delete' => 'Löschen', // Action
  'pos_up' => 'Nach oben', // Action
  'pos_down' => 'nach unten', // Action
  'type' => 'Typ', // Column Heading
  'article' => 'Artikel', // Column Heading
  'add' => 'Hinzufügen', //Form Field
  'preview' => 'Vorschau', //Form Field
  'submit' => 'Absenden', //Form Field
  'no_change' => 'Keine Änderungen notwendig', //Error message
  'expand_all' => 'Alle ausklappen', // config
  'dbver_nomatch' => 'Derzeitige Datenbankversion stimmt nicht überein',
  'comments_lnk' => 'Kommentare',
  'rss_more_lnk' => 'Artikel',
  'no_rss' => 'RSS nicht verfügbar',
);

$lang_minicms_config_related_size =  array(
      'thumb'=>'thumb',
      'normal'=>'normal',
);

$lang_minicms_config_editor = array(
      'fckeditor' => 'fckeditor',
//      'htmlarea' => 'htmlarea',  //unremark if you've loaded the support files
//      'tinymce' => 'tinymce',    //unremark if you've loaded the support files
);

$lang_minicms_config = array(
// array('Short Descripiton','field name',field type,'Link to documentation'),
  'Allgemeine Einstellungen',
  array('Index-Seiten umleiten', 'redirect_index_php', 0),
  array('Bildgröße auf den verknüpften Seiten', 'related_size', 3,'',$lang_minicms_config_related_size),
  array('HTML WYSIWG Editor','editor',3,'',$lang_minicms_config_editor),
  'RSS',
  array('RSS-Feed aktivieren','rss_enabled',1,'',''),
  array('Maximal-Länge der RSS Beschreibung','rss_description_length',0),
  array('Bilder im Feed anzeigen','rss_include_image',1,'',''),
  array('Bildgröße im Feed','rss_image_size',3,'',$lang_minicms_config_related_size),
);



?>