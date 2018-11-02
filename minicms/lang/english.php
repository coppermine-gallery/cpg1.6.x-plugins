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
  $HeadURL: http://svn.code.sf.net/p/coppermine/code/branches/cpg1.5.x/plugins/minicms/lang/english.php $
  $Revision: 8400 $
  $Author: eenemeenemuu $
  $Date: 2012-05-09 04:36:53 -0400 (Wed, 09 May 2012) $
***************************************************/

/**
 * English Language File
 * @author Donovan Bray <donnoman@donovanbray.com>
 * @package language
 * @subpackage english
 * @version 1.7
 */

if (!defined('IN_COPPERMINE')) { die('Not in Coppermine...');}

$lang_minicms = array(
  'minicms' => 'MiniCMS', // Display Name
  'minicms_full' => 'cpg-contrib MiniCMS',
  'admin_title' => 'MiniCMS Admin', // Title of the button on the gallery admin menu
  'config_title' => 'MiniCMS Config', // Title of the button on the gallery admin menu
  'title' => 'Title', // Title of new content field on cms_admin form
  'page_success' => 'Page saved successfully', // Success messages
  'page_fail' => 'Error saving page', // Fail Messages
  'non_exist' => 'Content doesn\'t exist', // Error Message
  'action' => 'Action', // Column Heading
  'view' => 'View', // Column Heading
  'content' => 'Content', // Column Heading
  'edit' => 'Edit', // Column Heading
  'cpos' => 'Position', //Column Heading, renamed cpos to avoid conflict with coppermines pos field.
  'add_new' => 'Add new content', //Form Field
  'new_content' => 'New Content', // Default Title on new content from cms_admin
  'delete' => 'Delete', // Action
  'pos_up' => 'Raise Position', // Action
  'pos_down' => 'Lower Position', // Action
  'type' => 'Type', // Column Heading
  'article' => 'Article', // Column Heading
  'add' => 'Add', //Form Field
  'preview' => 'Preview', //Form Field
  'submit' => 'Submit', //Form Field
  'no_change' => 'No change required', //Error message
  'expand_all' => 'Expand All', // config
  'dbver_nomatch' => 'Current database version doesn\'t match',
  'comments_lnk' => 'Comments',
  'rss_more_lnk' => 'article',
  'no_rss' => 'RSS not available',
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
  'General Settings',
  array('Index Redirect Page', 'redirect_index_php', 0),
  array('Size of the images on the related page', 'related_size', 3,'',$lang_minicms_config_related_size),
  array('HTML WYSIWG Content Editor','editor',3,'',$lang_minicms_config_editor),
  'RSS',
  array('Enable RSS feed','rss_enabled',1,'',''),
  array('RSS description length','rss_description_length',0),
  array('Display image in feed','rss_include_image',1,'',''),
  array('Image size in feed','rss_image_size',3,'',$lang_minicms_config_related_size),
);



?>