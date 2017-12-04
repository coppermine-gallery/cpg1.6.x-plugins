<?php
/**
 * Coppermine Photo Gallery
 * Coppermine version: 1.5.xx
 *
 * Picture Download Link
 * Version 1.4
 *  
 * Plugin Written by Joe Carver - http://photos-by.joe-carver.com/ - http://gallery.josephcarver.com/natural/ - http://i-imagine.net/artists/
 * 08 August 2010
*/
    // language file for plugin - submit changes to the Support thread for inclusion in  
    // the next release of this plugin

// plugin manager text
    $pic_link['display_name'] = 'Add Pic Download Link';
    $pic_link['plugin_documentation'] = 'Plugin Documentation';
    $pic_link['announcement_thread'] = 'Plugin Support Thread'; 
    $pic_link['description'] = 'This plugin will add a download link to the picture page';
	
// admin + confguation				
    $pic_link['configure_plugin_x'] = 'Configure plugin %s';				
    $pic_link['page_heading'] = 'Configure Download Link plugin.';	
    $pic_link['page_head'] = 'Configure the settings of your Download Link plugin.';	
    $pic_link['span_attr'] = 'HTML attributes for surrounding &lt;span&gt; element';
    $pic_link['enabled_categories_regex'] = 'Show download link in categories that match this regular expression';
    $pic_link['link_user'] = 'Show download link to logged users only';
    $pic_link['link_locate'] = 'Place the download link at what position in the picture page?';
    $pic_link['link_locate_0'] = 'above the picture';
    $pic_link['link_locate_1'] = 'under the picture';
    $pic_link['link_locate_2'] = 'under the title/caption';
    $pic_link['link_locate_3'] = 'in the file info box';
    $pic_link['use_content_disposition'] = 'Use Content-Disposition to Save As';
    $pic_link['hideprefix'] = 'And hide the prefix from the download file name';
    $pic_link['whichone'] = 'Link for what picture size?';
    $pic_link['whichone_0'] ='Full Size picture';
    $pic_link['whichone_1'] ='Intermediate picture';
    $pic_link['submit_change'] = 'Submit Changes';
    $pic_link['update_success'] = 'Update Success';
    $pic_link['no_changes'] = 'No changes made';
	  
	// visitor - user text for the button and title of link
	$pic_link['link_table'] = 'Download Link';
	$pic_link['link_title'] = 'Open picture in new window'; 
	$pic_link['link_save_title'] = 'Save Picture'; 
	$pic_link['link_text'] = 'DL &#9660;'; 
	$pic_link['link_null'] = 'For registered users only'; 	
?>