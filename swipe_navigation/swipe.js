/*********************************************
  Coppermine Plugin - Swipe Navigation
  ********************************************
  Copyright (c) 2022 eenemeenemuu
  ********************************************
  Library source: https://github.com/VikramMali/swipe
  * License:
    MIT License

    Copyright (c) 2016 Vikylp

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
    SOFTWARE.
**********************************************/

var startX,
    startY,
    dist,
    threshold = 100, //required min distance traveled to be considered swipe
    allowedTime = 300, // maximum time allowed to travel that distance
    elapsedTime,
    startTime;

window.addEventListener('touchstart', function(e){
    //touchsurface.innerHTML = ''
    var touchobj = e.changedTouches[0]
    dist = 0
    startX = touchobj.pageX
    startY = touchobj.pageY
    startTime = new Date().getTime() // record time when finger first makes contact with surface
    e.preventDefault()
/*
    event.target.addEventListener('touchmove', function(e){
        e.preventDefault() // prevent scrolling when inside DIV
    }, false)
*/
    event.target.addEventListener('touchend', function(e){
        var touchobj = e.changedTouches[0]
        dist = touchobj.pageX - startX // get total dist traveled by finger while in contact with surface
        elapsedTime = new Date().getTime() - startTime // get time elapsed
        // check that elapsed time is within specified, horizontal dist traveled >= threshold, and vertical dist traveled <= 100
        var swiperightBol = (elapsedTime <= allowedTime && Math.abs(dist) >= threshold && Math.abs(touchobj.pageY - startY) <= 100)
        var dir_str = "none";
        var dir_int = 0;
        if(swiperightBol){
            if(dist > 0){
                dir_str = "right";
                dir_int = 1;
            }else{
                dir_str = "left";
                dir_int = 2;
            }
            var _e = new CustomEvent("swap", {
                target : event.target,
                detail: {
                    direction : dir_str,
                    direction_int : dir_int
                },
                bubbles: true,
                cancelable: true
            });
            trigger(event.target,"Swap",_e);
        }
        //handleswipe(swiperightBol, event.target);
        //e.preventDefault()
    }, false)
    function trigger(elem, name, event) {
        elem.dispatchEvent(event);
        eval(elem.getAttribute('on' + name));
    }
}, false)

function swipe_navigation_swap(href) {
    window.location = href;
    document.body.style.opacity = '0.3';
}

//EOF
