/*********************************************
  Coppermine Plugin - Swipe Navigation
  ********************************************
  Copyright (c) 2022 eenemeenemuu
**********************************************/

window.addEventListener('swap', function(event) {
    if (event.detail.direction == 'left' && $('.navmenu img[src*=tab_right]').attr('src')) {
        swipe_navigation_swap($('.navmenu img[src*=tab_right]').parent().attr('href'));
    }
    if (event.detail.direction == 'right' && $('.navmenu img[src*=tab_left]').attr('src')) {
        swipe_navigation_swap($('.navmenu img[src*=tab_left]').parent().attr('href'));
    }
}, false);

//EOF
