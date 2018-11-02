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
  $HeadURL: http://svn.code.sf.net/p/coppermine/code/branches/cpg1.5.x/plugins/minicms/include/htmlarea_edit.inc.php $
  $Revision: 8021 $
  $Author: eenemeenemuu $
  $Date: 2010-11-09 04:55:00 -0500 (Tue, 09 Nov 2010) $
***************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

function theme_minicms_edit_editor(&$cms)
{
    global $MINICMS,$lang_minicms,$referer;
    ob_start();
        echo '<SELECT name="type">';
           foreach ($MINICMS['conType'] as $key => $conType) {
             if ($key==$cms['type']) {
                echo "<OPTION selected value=\"$key\">$conType</OPTION>";
             } else {
                echo "<OPTION value=\"$key\">$conType</OPTION>";
             }
           }
        echo '</SELECT>';
    $cms['select_type']=ob_get_clean();

    print <<<EOT
<!-- HTMLArea Start //-->
<!-- load the main HTMLArea files -->
<script type="text/javascript" src="plugins/minicms/htmlarea/htmlarea.js"></script>
<script type="text/javascript" src="plugins/minicms/htmlarea/lang/en.js"></script>
<script type="text/javascript" src="plugins/minicms/htmlarea/dialog.js"></script>
<script type="text/javascript" src="plugins/minicms/htmlarea/popupdiv.js"></script>
<script type="text/javascript" src="plugins/minicms/htmlarea/popupwin.js"></script>
<!-- load the TableOperations plugin files -->
<script type="text/javascript" src="plugins/minicms/htmlarea/plugins/TableOperations/table-operations.js"></script>
<script type="text/javascript" src="plugins/minicms/htmlarea/plugins/TableOperations/lang/en.js"></script>

<script type="text/javascript" src="plugins/minicms/htmlarea/plugins/Contextmenu/context-menu.js"></script>
<script type="text/javascript" src="plugins/minicms/htmlarea/plugins/ContextMenu/lang/en.js"></script>
<!-- load the ImageManager plugin files -->
<script type="text/javascript" src="plugins/minicms/htmlarea/plugins/ImageManager/image-manager.js"></script>
<!--<script type="text/javascript" src="plugins/minicms/htmlarea/plugins/ImageManager/lang/en.js"></script>-->
<style type="text/css">
	@import url(plugins/minicms/htmlarea/htmlarea.css);
	@import url(plugins/minicms/htmlarea/plugins/ContextMenu/menu.css);
	textarea { background-color: #fff; border: 1px solid 00f; }
</style>


<script type="text/javascript">
	_editor_url = "plugins/minicms/htmlarea/";
	_editor_lang = "en";
	</script>
	<script type="text/javascript" src="htmlarea/htmlarea.js"></script>
	<script type="text/javascript">
	HTMLArea.loadPlugin("ImageManager");
	HTMLArea.loadPlugin("TableOperations");
	HTMLArea.loadPlugin("ContextMenu");
</script>

<script type="text/javascript">
	var editor = null;
	function initEditor() {
		// Create a new configuration object
		var config = new HTMLArea.Config();
		// Comment this out if you dont use IE and get nice 100% width in Editor
		config.width = "855px";
		config.height = "300px";
		config.popupURL = "popups/";
		// create an editor for the "content" textbox
		editor = new HTMLArea("minicms_content",config);
		// register the TableOperations plugin with our editor
		editor.registerPlugin("TableOperations");
		editor.registerPlugin("ContextMenu");
		editor.generate();
		return false;
	}
</script>
<!-- HTMLArea End //-->

EOT;

    print <<<EOT
        <form name="post" method="post" action="index.php?file=minicms/cms_edit&amp;referer=$referer">
EOT;
    starttable("100%", $cms['title'] , 3);
    print <<<EOT
    	<tr>
    		<td colspan="3" align="center">
    			<h2>{$cms['message']}</h2>
    		</td>
    	</tr>
    	<tr>
    		<td>{$lang_minicms['title']}</td>
    		<td>{$lang_minicms['type']}</td>
    		<td>{$lang_minicms['content']}</td>
    	</tr>
    	<tr valign="top">
    		<td class="row2">
    			<input value="{$cms['ID']}" type="hidden" name="id" >
    			<input type="text" value="{$cms['title']}" class="post" tabindex="1" style="width: 450px;" maxlength="60" size="45" name="title" />
    		</td>
    		<td class="row2">
    			{$cms['select_type']}
    		</td>
    		<td class="row2">
    			<input type="text" value="{$cms['conid']}" class="post" tabindex="3" style="width: 50px;" maxlength="5" name="conid" />
    		</td>
    	</tr>
    	<tr valign="top">
    		<td class="row2" colspan="3">
    			<textarea style="width:100%" rows="24" cols="80" name="minicms_content" id="minicms_content" tabindex="4">{$cms['content']}</textarea>
    		</td>
    	</tr>
    	<tr>
    		<td align="center" colspan="3" class="catBottom">
    			<input value="{$lang_minicms['preview']}" class="mainoption" name="submit" tabindex="5" type="submit">&nbsp;
    			<input value="{$lang_minicms['submit']}" class="mainoption" name="submit" tabindex="6" accesskey="s" type="submit">
    		</td>
    	</tr>
    	<script type="text/javascript">
    		// Calling function to generate HTMLArea
    		initEditor();
    	</script>
    </form>
EOT;
    endtable();

}

?>
