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
  $HeadURL: http://svn.code.sf.net/p/coppermine/code/branches/cpg1.5.x/plugins/minicms/lang/french.php $
  $Revision: 8021 $
  $Author: eenemeenemuu $
  $Date: 2010-11-09 04:55:00 -0500 (Tue, 09 Nov 2010) $
***************************************************/

/**
 * French Language File
 * @author François Keller <keller.f@wanadoo.fr>
 * @package language
 * @subpackage French
 * @version 1.6
 */

if (!defined('IN_COPPERMINE')) { die('Not in Coppermine...');}

$lang_minicms = array(
  'minicms' => 'MiniCMS', // Display Name
  'minicms_full' => 'cpg-contrib MiniCMS',
  'admin_title' => 'MiniCMS Admin', // Title of the button on the gallery admin menu
  'config_title' => 'MiniCMS Config', // Title of the button on the gallery admin menu
  'title' => 'Titre', // Title of new content field on cms_admin form
  'page_success' => 'Page sauvegardée avec succès', // Success messages
  'page_fail' => 'Erreur lors de la sauvegarde de la page', // Fail Messages
  'non_exist' => 'Il n\y a pas de contenu existant', // Error Message
  'action' => 'Action', // Column Heading
  'view' => 'Visualiser', // Column Heading
  'content' => 'Contenu', // Column Heading
  'edit' => 'Editer', // Column Heading
  'cpos' => 'Position', //Column Heading, renamed cpos to avoid conflict with coppermines pos field.
  'add_new' => 'Ajouter un nouvel article', //Form Field
  'new_content' => 'Nouvel Article', // Default Title on new content from cms_admin
  'delete' => 'Effacer', // Action
  'pos_up' => 'Monter', // Action
  'pos_down' => 'Descendre', // Action
  'type' => 'Type', // Column Heading
  'article' => 'Article', // Column Heading
  'add' => 'Ajouter', //Form Field
  'preview' => 'Prévisualisation', //Form Field
  'submit' => 'Soumettre', //Form Field
  'no_change' => 'Aucun changements effectués', //Error message
  'expand_all' => 'Tout afficher', // config
  'dbver_nomatch' => 'La version de la base de donnée ne correspond pas',
  'comments_lnk' => 'Commentaires',
  'rss_more_lnk' => 'article',
  'no_rss' => 'RSS non disponible',
);

$lang_minicms_config_related_size =  array(
      'thumb'=>'vignette',
      'normal'=>'normal',
);

$lang_minicms_config_editor = array(
      'fckeditor' => 'fckeditor',
//      'htmlarea' => 'htmlarea',  //unremark if you've loaded the support files
//      'tinymce' => 'tinymce',    //unremark if you've loaded the support files
);

$lang_minicms_config = array(
// array('Short Descripiton','field name',field type,'Link to documentation'),
  'Paramètres Généraux',
  array('Index de la page de réorientation', 'redirect_index_php', 0),
  array('Taille des images dans la page', 'related_size', 3,'',$lang_minicms_config_related_size),
  array('Editeur HTML WYSIWG ','editor',3,'',$lang_minicms_config_editor),
  'RSS',
  array('Activer le flux RSS','rss_enabled',1,'',''),
  array('Longeur de la description dans le flux RSS ','rss_description_length',0),
  array('Afficher les images dans le flux RSS','rss_include_image',1,'',''),
  array('Taille de l\'image dans le flux RSS','rss_image_size',3,'',$lang_minicms_config_related_size),
);

?>