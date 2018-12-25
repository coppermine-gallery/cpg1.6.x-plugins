<?php
/*********************************************
  Coppermine Plugin - Favorite Button
  ********************************************
  Copyright (c) 2009-2018 eenemeenemuu
**********************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

if (defined('DISPLAYIMAGE_PHP')) {
    $thisplugin->add_filter('theme_img_navbar','fav_button');
}

function fav_button($template_img_navbar) {
    global $CURRENT_PIC_DATA, $FAVPICS, $REFERER, $lang_picinfo;

    $ref = $REFERER ? "&amp;referer=$REFERER" : '';
    $fav_tgt = "addfav.php?pid={$CURRENT_PIC_DATA['pid']}".$ref."#top_display_media";

    if (!in_array($CURRENT_PIC_DATA['pid'], $FAVPICS)) {
        $fav_title = $lang_picinfo['addFav'];
        $fav_icon = "nofav.png";
        $fav_icon_hover = "nofav_hover.png";
    } else {
        $fav_title = $lang_picinfo['remFav'];
        $fav_icon = "isfav.png";
        $fav_icon_hover = "isfav_hover.png";
    }

    $fav_button = "
        <td align=\"center\" valign=\"middle\" class=\"navmenu\" width=\"42\">
            <a href=\"$fav_tgt\" class=\"navmenu_pic\" title=\"$fav_title\" id=\"fav_lnk\"><img src=\"plugins/fav_button/$fav_icon\" border=\"0\" align=\"middle\" alt=\"$fav_title\" id=\"fav_ico\" /></a>
        </td>
        <script type=\"text/javascript\">
            $('#fav_lnk').mouseover(function() { $('#fav_ico').attr('src', 'plugins/fav_button/$fav_icon_hover'); } );
            $('#fav_lnk').mouseout(function() { $('#fav_ico').attr('src', 'plugins/fav_button/$fav_icon'); } );
        </script>
    ";

    //$search = substr_count($template_img_navbar, "<!-- BEGIN nav_start -->") > 0 ? "<!-- BEGIN nav_start -->" : "<!-- BEGIN nav_prev -->";
    //$template_img_navbar = str_replace($search, $fav_button.$search, $template_img_navbar);
    $search = '<!-- END slideshow_button -->';
    $template_img_navbar = str_replace($search, $search.$fav_button, $template_img_navbar);

    return $template_img_navbar;
}

//EOF