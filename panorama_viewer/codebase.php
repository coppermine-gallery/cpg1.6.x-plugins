<?php
/**************************************************
  Coppermine 1.6.x Plugin - panorama_viewer
  *************************************************
  Copyright (c) 2009-2019 eenemeenemuu
  **************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

function panorama_viewer_is_panorama() {
    global $CONFIG, $CURRENT_PIC_DATA;

    if (panorama_viewer_is_360_degree_panorama()) {
        return true;
    }

    switch($CONFIG['plugin_panorama_viewer_use_method']) {
        case 'width':
            if ($CURRENT_PIC_DATA['pwidth'] > $CONFIG['plugin_panorama_viewer_use_value']) {
                return true;
            } else {
                return false;
            }
            break;

        case 'ratio':
            if ($CURRENT_PIC_DATA['pwidth'] * $CONFIG['plugin_panorama_viewer_use_value'] > $CURRENT_PIC_DATA['pheight']) {
                return true;
            } else {
                return false;
            }
            break;

        case 'filename':
            if (stripos($CURRENT_PIC_DATA['filename'], $CONFIG['plugin_panorama_viewer_use_value']) !== false) {
                return true;
            } else {
                return false;
            }
            break;

        default:
            return true;
            break;
    }
}

function panorama_viewer_is_360_degree_panorama() {
    global $CONFIG, $CURRENT_PIC_DATA;

    if (!isset($CONFIG['plugin_panorama_viewer_360_degree'])) {
        $CONFIG['plugin_panorama_viewer_360_degree'] = '_360pano.jp';
        cpg_db_query("INSERT INTO {$CONFIG['TABLE_CONFIG']} (name, value) VALUES ('plugin_panorama_viewer_360_degree', '{$CONFIG['plugin_panorama_viewer_360_degree']}')");
    }

    if (stripos($CURRENT_PIC_DATA['filename'], $CONFIG['plugin_panorama_viewer_360_degree']) !== false) {
        return true;
    } else {
        return false;
    }
}

if (defined('DISPLAYIMAGE_PHP')) {
    $superCage = Inspekt::makeSuperCage();
    if ($superCage->get->keyExists('slideshow')) {
        $thisplugin->add_filter('page_html','panorama_viewer_page_html_slideshow');

        function panorama_viewer_page_html_slideshow($html) {
            if (panorama_viewer_is_panorama()) {
                $panorama_start = "<table width=\"100%\" style=\"table-layout:fixed;\"><tr><td width=\"100%\" align=\"center\"><div style=\"width:100%; overflow:hidden;\">";
                $panorama_end = "</div></td></tr></table>";

                $html = preg_replace("/(<img id=\"showImage\".*\/>)/Uis", $panorama_start."\\1".$panorama_end, $html);
            }
            return $html;
        }
    } else {
        $thisplugin->add_filter('html_image_reduced_overlay','panorama_viewer_image');
        $thisplugin->add_filter('html_image_reduced','panorama_viewer_image');
        $thisplugin->add_filter('html_image_overlay','panorama_viewer_image');
        $thisplugin->add_filter('html_image','panorama_viewer_image');

        function panorama_viewer_image($pic_html) {
            global $CURRENT_PIC_DATA;
            $pwidth = $CURRENT_PIC_DATA['pwidth'];
            $pheight = $CURRENT_PIC_DATA['pheight'];
            $div_height_extra_pixel = 24;
            $div_height = $CURRENT_PIC_DATA['pheight'] + $div_height_extra_pixel;
            if ($CURRENT_PIC_DATA['mode'] == 'normal') {
                global $CONFIG;
                $imagesize = getimagesize($CONFIG['fullpath'].$CURRENT_PIC_DATA['filepath'].$CONFIG['normal_pfx'].$CURRENT_PIC_DATA['filename']);
                $pwidth = $imagesize[0];
                $pheight = $imagesize[1];
                $div_height = $imagesize[1] + $div_height_extra_pixel;
            }
            if (panorama_viewer_is_360_degree_panorama()) {
                $pic_html = <<< EOT
                    <script type="text/javascript">
                        function scrollBackInit() {
                            backWidth = {$pwidth};
                            backXStep = 1;
                            backXCall = 20;
                            backXMove = 0;
                            if(document.getElementsByTagName) {
                                backXPos = backYPos = 0;
                                scrollBackObj = document.getElementById("360pano").style;
                                scrollBackObj.backgroundPosition = backXPos + "px " + backYPos + "px";
                                scrollBack();
                            }
                        }
                        function scrollBack() {
                            if(backXMove) {
                                backXPos = (Math.abs(backXPos) > backWidth) ? 0 : backXMove * backXStep + backXPos;
                                scrollBackObj.backgroundPosition = backXPos + "px " + backYPos + "px";
                            }
                            window.setTimeout("scrollBack()", backXCall);
                        }
                        $(document).ready(function() {
                            scrollBackInit();
                        });
                    </script>
                    <table id="360pano" background="{$CURRENT_PIC_DATA['url']}" style="width:100%; height:{$pheight}px; background-repeat:repeat-x; " border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="10%" onmouseover="backXMove=8;" onmouseout="backXMove=0;" valign="middle" align="left"><img src="plugins/panorama_viewer/arrow_left.png" /></td>
                            <td width="10%" onmouseover="backXMove=4;" onmouseout="backXMove=0;"></td>
                            <td width="10%" onmouseover="backXMove=2;" onmouseout="backXMove=0;"></td>
                            <td width="10%" onmouseover="backXMove=1;" onmouseout="backXMove=0;"></td>
                            <td width="20%"></td>
                            <td width="10%" onmouseover="backXMove=-1;" onmouseout="backXMove=0;"></td>
                            <td width="10%" onmouseover="backXMove=-2;" onmouseout="backXMove=0;"></td>
                            <td width="10%" onmouseover="backXMove=-4;" onmouseout="backXMove=0;"></td>
                            <td width="10%" onmouseover="backXMove=-8;" onmouseout="backXMove=0;" valign="middle" align="right"><img src="plugins/panorama_viewer/arrow_right.png" /></td>
                        </tr>
                    </table>
EOT;
            }
            if (panorama_viewer_is_panorama()) {
                $pic_html = "<div style=\"overflow:auto; width:100%; height:{$div_height}px;\">".$pic_html."</div>";
                $pic_html = "<table width=\"100%\" style=\"table-layout:fixed;\"><tr><td width=\"100%\" align=\"center\">".$pic_html."</td></tr></table>";
            }
            return $pic_html;
        }
    }
} elseif (defined('INDEX_PHP')) {
    $thisplugin->add_filter('page_html','panorama_viewer_page_html_thumb');

    function panorama_viewer_page_html_thumb($html) {
        global $CONFIG;
        $panorama_start = "<table width=\"100%\" style=\"table-layout:fixed;\"><tr><td width=\"100%\" align=\"center\"><div style=\"width:100%; overflow:hidden;\">";
        $panorama_end = "</div></td></tr></table>";
        $pattern = "/(<a href=\"displayimage.*<img src=\".*\/{$CONFIG['thumb_pfx']}.*<\/a>)/Uis";
        $html = preg_replace($pattern, $panorama_start."\\1".$panorama_end, $html);
        return $html;
    }
}

//EOF