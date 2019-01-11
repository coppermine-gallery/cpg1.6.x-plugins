/**************************************************
  Coppermine 1.5.x Plugin - Image manipulation
  *************************************************
  Copyright (c) 2010 Timo Schewe (www.timos-welt.de)
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
  
// variables
var im_useurlvalues, im_usecookies;
var im_isflipv,im_isfliph,im_issepia,im_isbw,im_lightval;
var im_contrastval,im_isemboss,im_isinvert,im_isblur;
var im_saturval,im_sharpenval;
var im_isie = Pixastic.Client.isIE();
if (document.documentMode==9) im_isie=0;
var im_oldhash, im_pid;

// page is ready loaded
function im_init()
{
     if ($('.image:not([src*="images/thumbs/"])')[0] && typeof(js_vars.run_slideshow) == 'undefined') {
        im_useurlvalues    = parseInt(js_vars.im_useurlvalues);
        im_usecookies      = parseInt(js_vars.im_usecookies);
    
        // create btn div
        im_btn = document.createElement('div');
        var im_btnsuffix = 'im_setit();" class="button" style="cursor:pointer;margin-top:4px;" type="button">';
       
        // create 1 or 3 LED sliders depending on compatible mode
        if (im_isie || im_compatible) {
            im_btn.innerHTML = im_makeled(js_vars.im_strlightness,'brig','im_lightval',js_vars.im_icon_brightness);
        } else {
            im_btn.innerHTML = im_makeled(js_vars.im_strlightness,'brig','im_lightval',js_vars.im_icon_brightness);
            im_btn.innerHTML += im_makeled(js_vars.im_strcontrast,'cont','im_contrastval',js_vars.im_icon_contrast);
            im_btn.innerHTML += im_makeled(js_vars.im_strsatur,'satu','im_saturval',js_vars.im_icon_saturation);
            im_btn.innerHTML += im_makeled(js_vars.im_strsharpen,'shar','im_sharpenval',js_vars.im_icon_sharpness);
        }
    
        // create buttons and use sepia instead of b/w if not in IE and not compatible mode
        if (js_vars.im_strreset != '') {
            im_btn.innerHTML += '<button value="'+js_vars.im_strreset+'" class="button" type="button" onclick="im_reset();">'+js_vars.im_icon_reset+js_vars.im_strreset+'</button>';
        }
        if (im_isie || im_compatible) { 
            if (js_vars.im_strbw != '') {
                im_btn.innerHTML += ' <button id="but_bw" value="'+js_vars.im_strbw+'" onclick="im_isbw = (im_isbw) ? 0 : 1; '+'im_setit();" class="button" style="cursor:pointer;margin-top:4px;" type="button">'+js_vars.im_icon_bw+js_vars.im_strbw+'</button>';
            } 
        } else { 
            if (js_vars.im_strsepia != '') {
                im_btn.innerHTML += ' <button value="'+js_vars.im_strsepia+'" id="but_sepia" onclick="im_issepia = (im_issepia) ? 0 : 1; '+'im_setit();" class="button" style="cursor:pointer;margin-top:4px;" type="button">'+js_vars.im_icon_sepia+js_vars.im_strsepia+'</button>';
            } 
        }
        if (js_vars.im_strfliph != '') {
            im_btn.innerHTML += ' <button value="'+js_vars.im_strfliph+'" id="but_fliph" onclick="im_isfliph = (im_isfliph) ? 0 : 1; '+'im_setit();" class="button" style="cursor:pointer;margin-top:4px;" type="button">'+js_vars.im_icon_fliph+js_vars.im_strfliph+'</button>';
        }
        if (js_vars.im_strflipv != '') {
            im_btn.innerHTML += ' <button value="'+js_vars.im_strflipv+'" id="but_flipv" onclick="im_isflipv = (im_isflipv) ? 0 : 1; '+'im_setit();" class="button" style="cursor:pointer;margin-top:4px;" type="button">'+js_vars.im_icon_flipv+js_vars.im_strflipv+'</button>';
        }
        if (js_vars.im_strinvert != '') {
            im_btn.innerHTML += ' <button value="'+js_vars.im_strinvert+'" id="but_invert" onclick="im_isinvert = (im_isinvert) ? 0 : 1; '+'im_setit();" class="button" style="cursor:pointer;margin-top:4px;" type="button">'+js_vars.im_icon_invert+js_vars.im_strinvert+'</button>';
        }
        if (js_vars.im_stremboss != '') {
            im_btn.innerHTML += ' <button value="'+js_vars.im_stremboss+'" id="but_emboss" onclick="im_isemboss = (im_isemboss) ? 0 : 1; '+'im_setit();" class="button" style="cursor:pointer;margin-top:4px;" type="button">'+js_vars.im_icon_emboss+js_vars.im_stremboss+'</button>';
        }
        if (js_vars.im_strblur != '') {
            im_btn.innerHTML += ' <button value="'+js_vars.im_strblur+'" id="but_blur" onclick="im_isblur = (im_isblur) ? 0 : 1; '+'im_setit();" class="button" style="cursor:pointer;margin-top:4px;" type="button">'+js_vars.im_icon_blur+js_vars.im_strblur+'</button>';
        }
       
        // add div to page
        $('.display_media').append(im_btn);
    
        // check for cookie
        var im_cookieval = 0;
        if (im_usecookies)
        {
            im_pid = parseInt(js_vars.picture_id);
            if (!isNaN(im_pid)) 
            {
                // one cookie for 400 PIDs
                            im_cookienumber = Math.floor(im_pid/400);
                            im_cookiestring = im_readCookie('im_'+im_cookienumber);
                            if (!im_cookiestring) im_cookiestring = '';
                            // split cookie string by delimiter to array
                            im_cookiesplitted = im_cookiestring.split('_');
                            var im_isinthere = false;
                            // check if PID is already in cookie
                            for (i=1; i<=im_cookiesplitted.length ; i=i+2)
                            {
                                if (im_cookiesplitted[i] == im_pid.toString(36))
                                {
                                    // get value for PID
                                    im_cookieval = parseInt(im_cookiesplitted[i+1],36) + 90909000;
                                    im_isinthere = true;
                                }
                            }
                if (im_cookieval)
                {
                    im_splitvalue(im_cookieval);
                    im_setit();
                }
            }
        }
    
        // if URL contains info about im, get them
        if (im_useurlvalues && !im_cookieval) im_getvalues();
        else if (!im_cookieval) im_reset();
        im_oldhash = window.location.hash;
        if (im_useurlvalues) setInterval(im_checkstate, 200);
     }
}

// check every 200 ms if URL has changed
function im_checkstate()
{
    if (im_oldhash != window.location.hash) {
        im_getvalues();
        im_oldhash = window.location.hash;
    }
}

// modify image
function im_setit()
{
    // first restore original image
    Pixastic.revert($('.image')[0]);
    // now apply sepia, flip, B/W, blur and emboss
    if (im_issepia) $('.image').pixastic('sepia');
    if (im_isflipv) $('.image').pixastic('flipv');
    if (im_isfliph) $('.image').pixastic('fliph');
    if (im_isbw) $('.image').pixastic('desaturate');
    if (im_isblur) $('.image').pixastic('blur');
    if (im_isemboss) $('.image').pixastic('emboss', {greyLevel:170,direction:'topleft',strength:1.0});
    // invert must be before lighten in IE
    if (im_isinvert) $('.image').pixastic('invert');
    // apply lighten (IE and compatible mode) or lighten, saturation, sharpen
    if (im_isie || im_compatible)
    {
        if (im_lightval)
        {
            if (im_lightval > 0 || !Pixastic.Client.isIE()) $('.image').pixastic('lighten', {amount:im_lightval/10});
            else $('.image').pixastic('lighten', {amount:-1-im_lightval/10});
        }
    }
    else
    {
        if (im_lightval || im_contrastval)$('.image').pixastic('brightness', {brightness:im_lightval*15,contrast:im_contrastval/10});
        if (im_saturval != 0) $('.image').pixastic('hsl', {hue:0,saturation:im_saturval*10,lightness:0});
        if (im_sharpenval != -9) $('.image').pixastic('sharpen', {amount:(im_sharpenval+9)/30});
    }
    
    // correct URL value and save cookie
    im_seturl();
    
    // show button and LED states
    im_showled(im_lightval,'brig');
    im_showbtn(im_isflipv,'but_flipv');
    im_showbtn(im_isfliph,'but_fliph');
    im_showbtn(im_isblur,'but_blur');
    im_showbtn(im_isinvert,'but_invert');
    im_showbtn(im_isemboss,'but_emboss');
    if (!im_isie & !im_compatible)
    {
        im_showled(im_contrastval,'cont');
        im_showled(im_saturval,'satu');
        im_showled(im_sharpenval,'shar');
        im_showbtn(im_issepia,'but_sepia');
    }
    else im_showbtn(im_isbw,'but_bw');
}

// set URL value
function im_seturl()
{
    // encode all settings in a single number
    var im_buttonvalues = im_isblur+im_isemboss*2+im_isinvert*4+im_isfliph*8+im_isflipv*16+im_issepia*32+im_isbw*64;
    im_urlvalue = (im_sharpenval+9)*1000000000+(im_contrastval+9)*10000000+(im_saturval+9)*100000+(im_lightval+9)*1000+im_buttonvalues;
    im_urlvalue = (isNaN(im_urlvalue)) ? 0 : im_urlvalue - 90909000;
    if (im_useurlvalues)
    {
        window.location.hash = "im="+im_urlvalue;
        im_oldhash = window.location.hash;
    }
    // save cookie
    if (im_usecookies) 
    {
        // one cookie for 400 PIDs
        im_cookienumber = Math.floor(im_pid/400);
        im_cookiestring = im_readCookie('im_'+im_cookienumber);
        if (!im_cookiestring) im_cookiestring = '';
        // split string by delimiter to array
        im_cookiesplitted = im_cookiestring.split('_');
        var im_isinthere = false;
        // check if PID is in cookie
        for (i=1; i<=im_cookiesplitted.length ; i=i+2)
        {
            if (im_cookiesplitted[i] == im_pid.toString(36))
            {
                // pid is there so replace it
                im_cookiesplitted[i+1] = im_urlvalue.toString(36);
                im_isinthere = true;
            }
        }
        if (im_isinthere == false && im_urlvalue) 
        {
            // pid is not there so add to array
            im_cookiesplitted.push(im_pid.toString(36));
            im_cookiesplitted.push(im_urlvalue.toString(36));
        }
        // convert array to string
        im_cookiestring = im_cookiesplitted.join('_');
        // save cookie
        im_createCookie('im_'+im_cookienumber,im_cookiestring);
    }
}

// create LED slider
function im_makeled(im_buttonstring,im_idstring,im_valstring,im_iconblub)
{
    var im_tempstr = '';
    if (im_buttonstring) 
    {
        im_tempstr += '<span class="button" style="border:none;background-color:transparent;background-image:none;">'+im_buttonstring+' '+im_iconblub+' &#150; </span>';
        for(var im_i=-9;im_i<10;im_i++)
        {
            im_tempstr += '<a style="height:10px;border-bottom-width:1px;border-left-width:1px;border-top-width:1px;border-right-width:0px;border-style:solid;text-decoration:none;border-color:#222233;cursor:pointer" id="'+im_idstring+im_i+'" onclick="'+im_valstring+' = parseInt(this.id.substr(4)); im_setit();">&nbsp;</a>';
        }
        im_tempstr += '<a style="height:10px;border-width:1px;border-style:solid;text-decoration:none;border-color:#222233;cursor:pointer" id="'+im_idstring+'10" onclick="'+im_valstring+' = parseInt(this.id.substr(4)); im_setit();">&nbsp;</a>';
        im_tempstr += '<span class="button" style="border:none;background-color:transparent;background-image:none;"> + '+im_iconblub+' '+im_buttonstring+'</span><br />';
        
    }
    return im_tempstr;
}


// lighten one LED chain
function im_showled(im_value,im_elid)
{
    //alert (document.getElementById(im_elid+'-9'));
    if (document.getElementById(im_elid+'-9') != null)
    {
        for(var im_i=-9;im_i<11;im_i++)
        {
            if (im_value >= im_i) document.getElementById(im_elid+im_i).style.backgroundColor = '#bbbbff';
            else document.getElementById(im_elid+im_i).style.backgroundColor = '#444455';
        }
    }
}

// set one button state
function im_showbtn(im_value,im_elid)
{
    var im_mybuttns = document.getElementsByTagName('button');
    for(var im_i=0;im_i<im_mybuttns.length;im_i++)
    {
        if (im_mybuttns[im_i].id == im_elid) 
        {   
            if (im_value)
            {
                if (typeof im_mybuttns[im_i].oldbrd == 'undefined') im_mybuttns[im_i].oldbrd = im_mybuttns[im_i].style.borderColor; im_mybuttns[im_i].style.borderColor='#FF0000';
            }
            else
            {
                if (typeof im_mybuttns[im_i].oldbrd != 'undefined') im_mybuttns[im_i].style.borderColor = im_mybuttns[im_i].oldbrd;
            }
        }
    }
}

// reset values
function im_reset()
{
    im_lightval = im_contrastval = im_isbw = im_issepia = im_isflipv = 0;
    im_isfliph = im_isinvert = im_isemboss = im_isblur = im_saturval = 0;
    im_sharpenval = -9;
    im_setit();
}

// add to window.onload
function im_addLoad(im_func) { var im_oldonload = window.onload; if (typeof window.onload != 'function') { window.onload = im_func; } else { window.onload = function() { if (im_oldonload) { im_oldonload(); } im_func(); }; } }



// get values from URL
function im_getvalues()
{
    im_hash = window.location.hash;
    var im_splitted = im_hash.split("=");
    if (im_hash.substr(0,4) != "#im=" || isNaN(im_splitted[1])) im_reset();
    else
    {
        im_urlvalue = parseInt(im_splitted[1]) + 90909000;
        im_splitvalue(im_urlvalue);
        im_setit();
    }
}

// decode all settings from a single number
function im_splitvalue(im_val)
{
    if (im_val > 19191919063 || im_val < 0) im_val = 90909000;
    im_sharpenval = Math.floor(im_val / 1000000000)-9;
    im_val = im_val - Math.floor(im_val / 1000000000) * 1000000000;
    im_contrastval = Math.floor(im_val / 10000000)-9;
    im_val = im_val - Math.floor(im_val / 10000000) * 10000000;
    im_saturval = Math.floor(im_val / 100000)-9;
    im_val = im_val - Math.floor(im_val / 100000) * 100000;  
    im_lightval = Math.floor(im_val / 1000)-9;
    im_val = im_val - Math.floor(im_val / 1000) * 1000;
    im_isbw = (im_val & 64) ? 1 : 0;
    im_issepia = (im_val & 32) ? 1 : 0;
    im_isflipv = (im_val & 16) ? 1 : 0;
    im_isfliph = (im_val & 8) ? 1 : 0;
    im_isinvert = (im_val & 4) ? 1 : 0;
    im_isemboss = (im_val & 2) ? 1 : 0;
    im_isblur = (im_val & 1) ? 1 : 0;
    if ((im_isie || im_compatible) && im_issepia) { im_isbw = 1; im_issepia = 0; }
}

function im_createCookie(im_name,im_value) {
    var im_date = new Date();
    im_date.setTime(im_date.getTime()+62208000000);
    var im_expires = "; expires="+im_date.toGMTString();
    document.cookie = im_name+"="+im_value+im_expires+"; path=/";
}

function im_readCookie(im_name) {
    var im_nameEQ = im_name + "=";
    var im_ca = document.cookie.split(';');
    for(var i=0;i < im_ca.length;i++) 
    {
        var im_c = im_ca[i];
        while (im_c.charAt(0)==' ') im_c = im_c.substring(1,im_c.length);
        if (im_c.indexOf(im_nameEQ) == 0) return im_c.substring(im_nameEQ.length,im_c.length);
    }
    return null;
}

//im_addLoad(im_init);
$(document).ready(function() { im_init(); } );