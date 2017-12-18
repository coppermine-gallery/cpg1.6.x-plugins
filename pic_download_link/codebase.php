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
require_once('include/init.inc.php');
if (!defined('IN_COPPERMINE')) { 
	die('Not in Coppermine...');
}
global $CONFIG;
	
// add link to pic info or under pic	
if ($CONFIG['down_link_locate'] == 3)  {
$thisplugin->add_filter('file_info','pic_download_link');

	function pic_download_link($info)   {
		global $CONFIG, $CURRENT_PIC_DATA, $CURRENT_ALBUM_DATA, $CURRENT_CAT_NAME;
		require_once('plugins/pic_download_link/init.inc.php');
		// in a catecory that is configured as enabled for the link?
		$enabled_categories_regex = $CONFIG['down_link_enabled_categories_regex'];
		if (preg_match($enabled_categories_regex, $CURRENT_CAT_NAME))
		{
			// logged user or not
			$show_download = $CONFIG['down_link_user'];
			if ((USER_ID && $show_download == 1) || ($show_download == 0))  {
				if ($CONFIG['down_link_use_content_disposition'] == 1)  {	
					$pics_link = './?file=pic_download_link/picture&pid=' . $CURRENT_PIC_DATA['pid'];
					$pics_target ='';
					$pics_title  = $pic_link['link_save_title'];
				} else {
					if($CONFIG['down_link_whichone'] == 1) {
						$pics_link = 'albums/' . $CURRENT_PIC_DATA['filepath'] . $CONFIG['normal_pfx'] . $CURRENT_PIC_DATA['filename'];
					} else {
						$pics_link = 'albums/' . $CURRENT_PIC_DATA['filepath'] . $CURRENT_PIC_DATA['filename'];
					}
					$pics_target ='target="blank"';
					$pics_title  = $pic_link['link_title'];
				}
				$info[$pic_link['link_table']] = "<a href=\"" . $pics_link . "\"" . $pics_target . '>' . $pics_title . '</a>';
			}  else  {
				$info[$pic_link['link_text']] =  $pic_link['link_null'];   
			}
			return $info;	
		} else { // this category not enabled to show the link -- add nothing.
			return $info;
		}
	} // end of function


}  else  {
	// show link under pic, or title or caption or menu
	$thisplugin->add_filter('file_data','pic_download_link');

	function pic_download_link($CURRENT_PIC_DATA)  {
		global $CURRENT_ALBUM_DATA, $CONFIG, $pic_link, $CURRENT_CAT_NAME;
		require_once('plugins/pic_download_link/init.inc.php');   
		// in a catecory that is configured as enabled for the link?
		$enabled_categories_regex = $CONFIG['down_link_enabled_categories_regex'];
		if (preg_match($enabled_categories_regex, $CURRENT_CAT_NAME))
		{
			// logged user or not 
			$show_download = $CONFIG['down_link_user'];
			if ((USER_ID && $show_download == 1) || ($show_download == 0))  {
				if ($CONFIG['down_link_use_content_disposition'] == 1)  {	
					$pics_link = './?file=pic_download_link/picture&pid=' . $CURRENT_PIC_DATA['pid'];
					$pics_target ='';
					$pics_title  = $pic_link['link_save_title'];
				} else {
					if($CONFIG['down_link_whichone'] == 1) {
						$pics_link = 'albums/' . $CURRENT_PIC_DATA['filepath'] . $CONFIG['normal_pfx'] . $CURRENT_PIC_DATA['filename'];
					} else {
						$pics_link = 'albums/' . $CURRENT_PIC_DATA['filepath'] . $CURRENT_PIC_DATA['filename'];
					}
					$pics_target ='target="blank"';
					$pics_title  = $pic_link['link_title'];
				}
				$down_link = <<< EOT
<span id="plugin_pic_download_link" {$CONFIG['down_link_span_attr']}>
<a href= "{$pics_link}" title="{$pics_title}" class="download" $pics_target>{$pic_link['link_text']}</a>
</span>
EOT;

				switch($CONFIG['down_link_locate']) {
                                	case 0: {
                                        	$CURRENT_PIC_DATA['html'] = $down_link . $CURRENT_PIC_DATA['html'];
                                                return $CURRENT_PIC_DATA;
                                        }
                                        case 1: {
	                                        $CURRENT_PIC_DATA['html'] .= $down_link;
                                                return $CURRENT_PIC_DATA;
                                        }
                                        case 2: {
						// show link beneath the lowest text or just the pic
						if (!$CURRENT_PIC_DATA['title'] && !$CURRENT_PIC_DATA['caption']) {
							$CURRENT_PIC_DATA['menu'] = $CURRENT_PIC_DATA['menu'] . $down_link;
							return $CURRENT_PIC_DATA;
						} else {
							if (!$CURRENT_PIC_DATA['title']) {
								$CURRENT_PIC_DATA['caption'] = $CURRENT_PIC_DATA['caption'] . $down_link;
								return $CURRENT_PIC_DATA;
							}
							if (!$CURRENT_PIC_DATA['caption']) {
								$CURRENT_PIC_DATA['title'] = $CURRENT_PIC_DATA['title'] . $down_link;
								return $CURRENT_PIC_DATA;
							}  else  {
								$CURRENT_PIC_DATA['caption'] = $CURRENT_PIC_DATA['caption'] . $down_link;
									return $CURRENT_PIC_DATA;
							}		
						}
					}
				}
			} else  {
				return $CURRENT_PIC_DATA;
			}
		} else  {
				return $CURRENT_PIC_DATA;
		}
	} // end of function

}		


// Add plugin_install action
$thisplugin->add_action('plugin_install','pic_download_link_install');

// Add plugin_uninstall action
$thisplugin->add_action('plugin_uninstall','pic_download_link_uninstall');	
	
	// Install the plugin
	function pic_download_link_install() {
		global $CONFIG, $thisplugin;

		// add new meta to db
		cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('down_link_user', '0')");		
		cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('down_link_locate', '1')");
		cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('down_link_use_content_disposition', '0')");
		cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('down_link_enabled_categories_regex', '/.*/')");
		cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('down_link_span_attr', 'style=\"display: block; padding-top: 0.1em; text-align: center;\"')");
		cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('down_link_whichone', '0')");
		cpg_db_query("INSERT IGNORE INTO {$CONFIG['TABLE_CONFIG']} (`name`, `value`) VALUES ('down_link_hideprefix', '0')");
		return true;
	}

	// Uninstall the plugin
	function pic_download_link_uninstall() {
		global $CONFIG, $thisplugin;
		
	//remove the record from config
		cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'down_link_user'");
		cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'down_link_locate'");
		cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'down_link_use_content_disposition'");
		cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'down_link_enabled_categories_regex'");
		cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'down_link_span_attr'");
		cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'down_link_whichone'");
		cpg_db_query("DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'down_link_hideprefix'");
		return true;		
	}

?>
