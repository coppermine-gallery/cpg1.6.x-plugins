function h5ss_pop(url,evt) {
	var parms = 'height='+screen.availHeight+',width='+screen.availWidth+',resizable=yes,scrollbars=no,toolbar=no,menubar=no,location=no,status=no,directories=no';
	var newwindow = window.open(url+'&h5sspu=1','h5slideshow',parms);
	if (window.focus) {newwindow.focus()}
}
