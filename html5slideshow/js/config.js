var H5ss_icons = null;
var H5ss_ctrl = null;
var H5ss_text = null;
var H5ss_pica = null;
var H5ss_dtcb = null;
var H5ss_dccb = null;

function toRGBA(C,O) {
	if (C.match(/^#([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})$/i)) {
		var c = ([parseInt(RegExp.$1, 16), parseInt(RegExp.$2, 16), parseInt(RegExp.$3, 16)]);
		if (c.length === 3) {
			return 'rgba(' + c[0] + ',' + c[1] + ',' + c[2] + ',' + O + ')';
		}
	}
	return C;
}
function setCtrlB(v) {
	H5ss_ctrl.style.backgroundColor = v;
}
function setCtrlT(v) {
	H5ss_ctrl.style.color = v;
}
function setTextB(v) {
	H5ss_text.style.backgroundColor = toRGBA(v, 0.5);
}
function setTextT(v) {
	H5ss_text.style.color = v;
}
function setPicaB(v) {
	H5ss_pica.style.backgroundColor = v;
}
function setText() {
	var txt = '';
	if (H5ss_dtcb.checked) txt = js_vars.H5ss_lang.titl;
	if (H5ss_dccb.checked) {
		if (txt) txt += js_vars.H5ss_lang.tsep;
		txt += js_vars.H5ss_lang.capt;
	}
	H5ss_text.innerHTML = txt;
	H5ss_text.style.fontSize = ['inherit','medium','large','x-large','xx-large'][$('#txtSize').val()];
}

function H5applybg() {
	setCtrlB($('#h5ctrl_b').val());
	setCtrlT($('#h5ctrl_t').val());
	setTextB($('#h5text_b').val());
	setTextT($('#h5text_t').val());
	setPicaB($('#h5pica_b').val());
}

function H5applyis(elem) {
	H5ss_icons.src = "plugins/html5slideshow/css/icons/"+elem.value+".png"
}

$(document).ready(function() {
	H5ss_ctrl = document.getElementById("smpl_c");
	H5ss_text = document.getElementById("smpl_t");
	H5ss_pica = document.getElementById("smpl_p");
	H5ss_dtcb = document.getElementById("dispTitl");
	H5ss_dccb = document.getElementById("dispDesc");

	H5ss_icons = document.getElementById("h5ssicons");
	H5applybg();

	$.fn.colorPicker.defaults.colors = ['000','333','666','999','CCC','FFF','003','006','009','00C','00F','030','033','036','039','03C','03F','060','063','066','069','06C','06F','090','093','096','099','09C','09F','0C0','0C3','0C6','0C9','0CC','0CF','0F0','0F3','0F6','0F9','0FC','0FF','300','303','306','309','30C','30F','330','336','339','33C','33F','360','363','366','369','36C','36F','390','393','396','399','39C','39F','3C0','3C3','3C6','3C9','3CC','3CF','3F0','3F3','3F6','3F9','3FC','3FF','600','603','606','609','60C','60F','630','633','636','639','63C','63F','660','663','669','66C','66F','690','693','696','699','69C','69F','6C0','6C3','6C6','6C9','6CC','6CF','6F0','6F3','6F6','6F9','6FC','6FF','900','903','906','909','90C','90F','930','933','936','939','93C','93F','960','963','966','969','96C','96F','990','993','996','99C','99F','9C0','9C3','9C6','9C9','9CC','9CF','9F0','9F3','9F6','9F9','9FC','9FF','C00','C03','C06','C09','C0C','C0F','C30','C33','C36','C39','C3C','C3F','C60','C63','C66','C69','C6C','C6F','C90','C93','C96','C99','C9C','C9F','CC0','CC3','CC6','CC9','CCF','CF0','CF3','CF6','CF9','CFC','CFF','F00','F03','F06','F09','F0C','F0F','F30','F33','F36','F39','F3C','F3F','F60','F63','F66','F69','F6C','F6F','F90','F93','F96','F99','F9C','F9F','FC0','FC3','FC6','FC9','FCC','FCF','FF0','FF3','FF6','FF9','FFC'];
	$.fn.colorPicker.defaults.showHexField = false;

	$('#h5ctrl_b').colorPicker({prevCB: setCtrlB});
	$('#h5ctrl_t').colorPicker({prevCB: setCtrlT});
	$('#h5text_b').colorPicker({prevCB: setTextB});
	$('#h5text_t').colorPicker({prevCB: setTextT});
	$('#h5pica_b').colorPicker({prevCB: setPicaB});
});