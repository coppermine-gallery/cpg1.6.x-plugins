/**************************************************
  Coppermine 1.6.x Plugin - picture_navigation
  *************************************************
  Copyright (c) 2010-2019 eenemeenemuu
  **************************************************/

$(document).ready(function() {
    if ($('td.display_media').html().search('table-layout:fixed;') == -1) {
        panorama_viewer_active = false;
        width = '50%';
    } else {
        panorama_viewer_active = true;
        width = '50px';
    }

    if ($('.navmenu_pic img[src*=prev]').parent().attr('href') != 'javascript:;') {
        icon_prev = $('.navmenu_pic img[src*=prev]').parent().html().match(/src="(.*?)"/);
        icon_prev = icon_prev[1];
        icon_prev_inactive = icon_prev.replace('prev', 'prev_inactive');
        btn_prev = '<td onclick="window.location = $(\'.navmenu_pic img[src*=prev]\').parent().attr(\'href\');" onmouseover="$(this).css(\'background-image\', \'url(\' + icon_prev + \')\');" onmouseout="$(this).css(\'background-image\', \'url(\' + icon_prev_inactive + \')\');" style="width: ' + width + '; min-width: 16px; cursor: pointer; background: url(' + icon_prev_inactive + ') no-repeat right center;"></td>';
    } else {
        btn_prev = '<td style="width: ' + width + ';"></td>';
    }
    if ($('.navmenu_pic img[src*=next]').parent().attr('href') != 'javascript:;') {
        icon_next = $('.navmenu_pic img[src*=next]').parent().html().match(/src="(.*?)"/);
        icon_next = icon_next[1];
        icon_next_inactive = icon_next.replace('next', 'next_inactive');
        btn_next = '<td onclick="window.location = $(\'.navmenu_pic img[src*=next]\').parent().attr(\'href\');" onmouseover="$(this).css(\'background-image\', \'url(\' + icon_next + \')\');" onmouseout="$(this).css(\'background-image\', \'url(\' + icon_next_inactive + \')\');" style="width: ' + width + '; min-width: 16px; cursor: pointer; background: url(' + icon_next_inactive + ') no-repeat left center;"></td>';
    } else {
        btn_next = '<td style="width: ' + width + ';"></td>';
    }

    if (panorama_viewer_active) {
        $('td.display_media').html($('td.display_media').html().replace('<tr>', '<tr>' + btn_prev).replace(/(<\/div><\/td><\/tr>[\s\S]*)<\/tr>/, '$1' + btn_next + '</tr>'));
    } else {
        $('td.display_media').html($('td.display_media').html().replace('<tr>', '<tr>' + btn_prev).replace('</tr>', btn_next + '</tr>'));
    }
});