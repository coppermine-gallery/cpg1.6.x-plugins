/**************************************************
  Coppermine 1.5.x Plugin - keyboard_navigation
  *************************************************
  Copyright (c) 2009-2012 eenemeenemuu
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  ********************************************
  $HeadURL$
  $Revision$
  $LastChangedBy$
  $Date$
  **************************************************/

$(document).ready(function() {
    jQuery.expr[':'].focus = function( elem ) {
        return elem === document.activeElement && ( elem.type || elem.href );
    };
    $(document).keydown(function(e) {
        if (!e) {
            e = window.event;
        }
        if (e.which) {
            kcode = e.which;
        } else if (e.keyCode) {
            kcode = e.keyCode;
        }
        if (!$(':input').is(':focus') && $("#jquery-lightbox").length != 1) {
            if(kcode == 37) {
                href = $('.navmenu_pic img[src*=prev]').parent().attr('href');
                if (href) {
                    window.location = href;
                }
            }
            if(kcode == 39) {
                href = $('.navmenu_pic img[src*=next]').parent().attr('href');
                if (href) {
                    window.location = href;
                }
            }
            if(kcode == 38) {
                href = $('.navmenu_pic img[src*=thumb]').parent().attr('href');
                if (href) {
                    window.location = href;
                }
            }
            if(kcode == 40) {
                blocking('picinfo', 'yes', 'block');
                return false;
            }
        }
    });
});