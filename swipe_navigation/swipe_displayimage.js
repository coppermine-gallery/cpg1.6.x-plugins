/*********************************************
  Coppermine Plugin - Swipe Navigation
  ********************************************
  Copyright (c) 2022 eenemeenemuu
**********************************************/

window.addEventListener('swap', function(event) {
    if (event.detail.direction == 'left' && $('.navmenu_pic img[src*=next]').attr('src').indexOf("inactive") == -1) {
        swipe_navigation_swap($('.navmenu_pic img[src*=next]').parent().attr('href'));
    }
    if (event.detail.direction == 'right' && $('.navmenu_pic img[src*=prev]').attr('src').indexOf("inactive") == -1) {
        swipe_navigation_swap($('.navmenu_pic img[src*=prev]').parent().attr('href'));
    }
}, false);

//EOF
