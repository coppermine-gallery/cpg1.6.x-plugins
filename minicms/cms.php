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
  $HeadURL: http://svn.code.sf.net/p/coppermine/code/branches/cpg1.5.x/plugins/minicms/cms.php $
  $Revision: 8021 $
  $Author: eenemeenemuu $
  $Date: 2010-11-09 04:55:00 -0500 (Tue, 09 Nov 2010) $
***************************************************/

require_once('include/init.inc.php');

$html = minicms();
$title = (isset($cms_array[0]['title'])) ? $cms_array[0]['title'] : $lang_minicms['article'];
pageheader($title);
echo $html;
pagefooter();

?>