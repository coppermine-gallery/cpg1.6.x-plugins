/**************************************************
  Coppermine 1.6.x Plugin - EnlargeIt!
  *************************************************
  Copyright (c) 2010 Timos-Welt (www.timos-welt.de)
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
 **************************************************/
$(document).ready(function() {
	$('#colorpicker_bordercolor').farbtastic('#plugin_enlargeit_brdcolor');
	$('#colorpicker_titletext').farbtastic('#plugin_enlargeit_titletxtcol');
	$('#colorpicker_backgroundcontent').farbtastic('#plugin_enlargeit_ajaxcolor');
	$('#colorpicker_shadowcolor').farbtastic('#plugin_enlargeit_shadowcolor');
//	$('#plugin_enlargeit_speed').SpinButton({min: 10,max: 32});
//	$('#plugin_enlargeit_maxstep').SpinButton({min: 4,max: 30});
//	$('#plugin_enlargeit_brdsize').SpinButton({min: 0,max: 40});
//	$('#plugin_enlargeit_shadowsize').SpinButton({min: 0,max: 9});
//	$('#plugin_enlargeit_shadowintens').SpinButton({min: 1,max: 30});
//	$('#plugin_enlargeit_darkprct').SpinButton({min: 0,max: 100, step: 10});
//	$('#plugin_enlargeit_darkensteps').SpinButton({min: 1,max: 20});
//	$('#plugin_enlargeit_cachemaxage').SpinButton({min: 1,max: 365});
//	$('#plugin_enlargeit_cachemaxsizemb').SpinButton({min: 1,max: 99});
    $('#plugin_enlargeit_buttonhist').change(function () {
		if ($('#plugin_enlargeit_buttonhist').attr('checked')) {
			$('#plugin_enlargeit_cachecontrol_0').attr('disabled', '');
			$('#plugin_enlargeit_cachecontrol_1').attr('disabled', '');
			$('#plugin_enlargeit_cachecontrol_2').attr('disabled', '');
			$('#plugin_enlargeit_cachemaxage').attr('disabled', '');
			$('#plugin_enlargeit_cachemaxsizemb').attr('disabled', '');
			$('#cache_visibility').css('visibility', 'visible');
		} else {
			$('#plugin_enlargeit_cachecontrol_0').attr('disabled', 'disabled');
			$('#plugin_enlargeit_cachecontrol_1').attr('disabled', 'disabled');
			$('#plugin_enlargeit_cachecontrol_2').attr('disabled', 'disabled');
			$('#plugin_enlargeit_cachemaxage').attr('disabled', 'disabled');
			$('#plugin_enlargeit_cachemaxsizemb').attr('disabled', 'disabled');
			$('#cache_visibility').css('visibility', 'hidden');
		}
    })
	$('#plugin_enlargeit_ani').change(function () {
		if ($('#plugin_enlargeit_ani').val() == 0) {
			$('#plugin_enlargeit_speed').attr('disabled', 'disabled');
			$('#plugin_enlargeit_maxstep').attr('disabled', 'disabled');
			$('#plugin_enlargeit_opaglide').attr('disabled', 'disabled');
		} else {
			$('#plugin_enlargeit_speed').attr('disabled', '');
			$('#plugin_enlargeit_maxstep').attr('disabled', '');
			$('#plugin_enlargeit_opaglide').attr('disabled', '');
		}
	})
	$('#plugin_enlargeit_brdbck').change(function(){
			$('#borderpreview').css('background-image', 'url('+'plugins/enlargeit/images/backgrounds/'+$('#plugin_enlargeit_brdbck').val()+'.png'+')');
    });
});