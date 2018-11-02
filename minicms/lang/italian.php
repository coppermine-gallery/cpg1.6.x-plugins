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
  $HeadURL: http://svn.code.sf.net/p/coppermine/code/branches/cpg1.5.x/plugins/minicms/lang/italian.php $
  $Revision: 8312 $
  $Author: eenemeenemuu $
  $Date: 2012-01-26 09:05:58 -0500 (Thu, 26 Jan 2012) $
***************************************************/

/**
 * Italian Language File
 * @author Lontano <lontano@daviderenda.com >
 * @package language
 * @subpackage italian
 * @version 1.7
 */

if (!defined('IN_COPPERMINE')) { die('Not in Coppermine...');}

$lang_minicms = array(
  'minicms' => 'MiniCMS', // Display Name
  'minicms_full' => 'cpg-contrib MiniCMS',
  'admin_title' => 'Amministrazione MiniCMS', // Title of the button on the gallery admin menu
  'config_title' => 'Configurazione MiniCMS', // Title of the button on the gallery admin menu
  'title' => 'Title', // Title of new content field on cms_admin form
  'page_success' => 'Pagina salvata', // Success messages
  'page_fail' => 'Errore pagina non salvata', // Fail Messages
  'non_exist' => 'Contenuto inesistente', // Error Message
  'action' => 'Azione', // Column Heading
  'view' => 'Vista', // Column Heading
  'content' => 'Contenuto', // Column Heading
  'edit' => 'Modifica', // Column Heading
  'cpos' => 'Positione', //Column Heading, renamed cpos to avoid conflict with coppermines pos field.
  'add_new' => 'Aggiungi nuovo contenuto', //Form Field
  'new_content' => 'Nuovo Contenuto', // Default Title on new content from cms_admin
  'delete' => 'Cancella', // Action
  'pos_up' => 'Alza Posizione', // Action
  'pos_down' => 'Abbassa Posizione', // Action
  'type' => 'Tipo', // Column Heading
  'article' => 'Articolo', // Column Heading
  'add' => 'Aggiungi', //Form Field
  'preview' => 'Previsualizza', //Form Field
  'submit' => 'Invia', //Form Field
  'no_change' => 'Nessuna modifica richiesta', //Error message
  'expand_all' => 'Espandi tutto', // config
  'dbver_nomatch' => 'Versione database corrente non corrspondente',
  'comments_lnk' => 'Commenti',
  'rss_more_lnk' => 'articolo',
  'no_rss' => 'RSS non disponibile',
);

$lang_minicms_config_related_size =  array(
      'thumb'=>'miniatura',
      'normal'=>'normale',
);

$lang_minicms_config_editor = array(
      'fckeditor' => 'fckeditor',
//      'htmlarea' => 'htmlarea',  //unremark if you've loaded the support files
//      'tinymce' => 'tinymce',    //unremark if you've loaded the support files
);

$lang_minicms_config = array(
// array('Short Descripiton','field name',field type,'Link to documentation'),
  'Configurazione Generale',
  array('Index della pagina di redirect', 'redirect_index_php', 0),
  array('Dimensione delle immagini nella pagina', 'related_size', 3,'',$lang_minicms_config_related_size),
  array('Editor di contenuti HTML visuale','editor',3,'',$lang_minicms_config_editor),
  'RSS',
  array('Abilita feed RSS','rss_enabled',1,'',''),
  array('Lunghezza descrizione RSS','rss_description_length',0),
  array('Mostra immagini nel feed RSS','rss_include_image',1,'',''),
  array('Dimensione immagini nel feed RSS','rss_image_size',3,'',$lang_minicms_config_related_size),
);

?>