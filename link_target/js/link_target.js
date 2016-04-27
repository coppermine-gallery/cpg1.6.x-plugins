/*************************
  Coppermine Photo Gallery
  ************************
  Copyright (c) 2003-2016 Coppermine Dev Team
  v1.0 originally written by Gregory Demar

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License version 3
  as published by the Free Software Foundation.

  ********************************************
  Coppermine version: 1.6.01
  $HeadURL: https://svn.code.sf.net/p/coppermine/code/trunk/cpg1.6.x/js/link_target.js $
  $Revision: 8634 $
**********************************************/

$(document).ready(function() {
    //convert external links to open in new window (in comments);
    jQuery.each($("a[rel*='external']"), function(){
        $(this).click(function(){
            window.open(this.href);
            return false;
        });
        $(this).keypress(function(){
            window.open(this.href);
            return false;
        });
    });
});