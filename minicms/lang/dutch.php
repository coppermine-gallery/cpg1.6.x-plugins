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
  $HeadURL: http://svn.code.sf.net/p/coppermine/code/branches/cpg1.5.x/plugins/minicms/lang/dutch.php $
  $Revision: 8021 $
  $Author: eenemeenemuu $
  $Date: 2010-11-09 04:55:00 -0500 (Tue, 09 Nov 2010) $
***************************************************/

/**
 * Dutch Language File
 * @author Hein Traag <heintraag@gmail.com>
 * @package language
 * @subpackage dutch
 * @version 1.6
 */

if (!defined('IN_COPPERMINE')) { die('Not in Coppermine...');}

$lang_minicms = array(
  'minicms' => 'MiniCMS', // Display Name
  'minicms_full' => 'cpg-contrib MiniCMS',
  'admin_title' => 'MiniCMS Admin', // Title of the button on the gallery admin menu
  'config_title' => 'MiniCMS Config', // Title of the button on the gallery admin menu
  'title' => 'Titel', // Title of new content field on cms_admin form
  'page_success' => 'Pagina succesvol bewerkt', // Success messages
  'page_fail' => 'Fout bij opslaan van pagina', // Fail Messages
  'non_exist' => 'Inhoud bestaat niet', // Error Message
  'action' => 'Actie', // Column Heading
  'view' => 'Bekijk', // Column Heading
  'content' => 'Inhoud', // Column Heading
  'edit' => 'Edit', // Column Heading
  'cpos' => 'Positie', //Column Heading, renamed cpos to avoid conflict with coppermines pos field.
  'add_new' => 'Voeg nieuwe inhoud toe', //Form Field
  'new_content' => 'Nieuwe inhoud', // Default Title on new content from cms_admin
  'delete' => 'Delete', // Action
  'pos_up' => 'Verzet positie omhoog', // Action
  'pos_down' => 'Verzet positie omlaag', // Action
  'type' => 'Type', // Column Heading
  'article' => 'Artikel', // Column Heading
  'add' => 'Toevoegen', //Form Field
  'preview' => 'Bekijken', //Form Field
  'submit' => 'Plaatsen', //Form Field
  'no_change' => 'Geen wijziging nodig', //Error message
  'expand_all' => 'Allemaal maximaliseren', // config
  'dbver_nomatch' => 'Huidige database versie klopt niet',
  'comments_lnk' => 'Commentaar',
  'rss_more_lnk' => 'artikel',
  'no_rss' => 'RSS niet beschikbaar',
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
// array('Korte omschrijving','field name',field type,'Link naar documentatie'),
  'Algemene miniCMS instellingen',
  array('Index Redirect Page', 'redirect_index_php', 0),
  array('Grootte van de afbeeldingen op de gerelateerde pagina', 'related_size', 3,'',$lang_minicms_config_related_size),
  array('HTML WYSIWG Pagina Editor','editor',3,'',$lang_minicms_config_editor),
  'RSS',
  array('RSS beschikbaarheid','rss_enabled',1,'',''),
  array('RSS omschrijving lengte','rss_description_length',0),
  array('Afbeeldingen in RSS','rss_include_image',1,'',''),
  array('Afbeeldingen grootte in RSS','rss_image_size',3,'',$lang_minicms_config_related_size),
);



?>