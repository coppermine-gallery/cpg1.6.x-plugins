(function() {
	var
		vendorQuirk = {
			vendorID: 'w3',
			browserPrefix: '',
//			tranEnd: 'transitionEnd',
			reqFull: 'requestFullScreen',
			canFull: 'cancelFullScreen'
		};
	if (navigator.userAgent.indexOf('MSIE')!==-1 || navigator.appVersion.indexOf('Trident/') > 0) {
		vendorQuirk.vendorID = 'ie';
		vendorQuirk.browserPrefix = 'ms';
//		vendorQuirk.tranEnd = '';
	} else if (navigator.userAgent.indexOf('WebKit') > -1) {
		vendorQuirk.vendorID = 'wk';
		vendorQuirk.browserPrefix = 'webkit';
//		vendorQuirk.tranEnd = 'webkitTransitionEnd';
	} else if (navigator.userAgent.indexOf('Gecko') > -1) {
		vendorQuirk.vendorID = 'ff';
		vendorQuirk.browserPrefix = 'moz';
//		vendorQuirk.tranEnd = 'transitionend';
	} else if (navigator.userAgent.indexOf('Opera') > -1) {
		vendorQuirk.vendorID = 'op';
		vendorQuirk.browserPrefix = 'o';
//		vendorQuirk.tranEnd = 'oTransitionEnd';
	} else if (navigator.userAgent.indexOf('KHTML') > -1) {
		vendorQuirk.vendorID = 'kd';
		vendorQuirk.browserPrefix = 'khtml';
//		vendorQuirk.tranEnd = 'khtmlTransitionEnd';
	}
	// export quirks
	window.vendorQuirk = vendorQuirk;
}());


(function() {
	var
		fullScreenApi = {
			supportsFullScreen: false,
			isFullScreen: function() { return false; },
			requestFullScreen: function() {},
			cancelFullScreen: function() {},
			fullScreenEventName: '',
			prefix: ''
		};
 
	// check for native support
	if (typeof document.cancelFullScreen != 'undefined') {
		fullScreenApi.supportsFullScreen = true;
	} else {
		// check for fullscreen support by vendor prefix
		if (typeof document[vendorQuirk.browserPrefix + 'CancelFullScreen'] != 'undefined') {
			fullScreenApi.supportsFullScreen = true;
			fullScreenApi.prefix = vendorQuirk.browserPrefix;
		}
	}

	// update methods to do something useful
	if (fullScreenApi.supportsFullScreen) {
		fullScreenApi.fullScreenEventName = fullScreenApi.prefix + 'fullscreenchange';
		fullScreenApi.isFullScreen = function() {
			switch (this.prefix) {
				case '':
					return document.fullScreen;
				case 'webkit':
					return document.webkitIsFullScreen;
				default:
					return document[this.prefix + 'FullScreen'];
			}
		};
		fullScreenApi.requestFullScreen = function(el) {
			return (this.prefix === '') ? el.requestFullScreen() : el[this.prefix + 'RequestFullScreen']();
		};
		fullScreenApi.cancelFullScreen = function() {
			return (this.prefix === '') ? document.cancelFullScreen() : document[this.prefix + 'CancelFullScreen']();
		};
	}

	// export api
	window.fullScreenApi = fullScreenApi;
}());

// getElementById
function $id(id) {
	return document.getElementById(id);
}

var	ssCtl = (function() {
	var mySC = {autoPlay:true, slideDur:7000, trnType:"d", repeat:false},
		_ill = 0,			// imagelist length
		_iecnt = 5,			// max number of elements in the view frame
		_ffv = 2,			// frame focus view - generally the middle view of the frame
		_fle = 0,			// left edge of view frame relative to imagelist
		_ielms = Array(),	// elements associated with the view frame
		_iniClass,
		_onClass,
		_trzn,
		_slideDur = 7000,	// display duration for eash image
		_sTimer = null,
		_running = false,
		_fullScreenApi = null,
		_topMargin = 22,
		_sldnumelm = null,
		_titlelm = null,
		_pauseRunDiv = null,
		_loading,
		_resizeTime = null,
		_resizing = false,
		_tstartx,
		_tstarty,
		_tstartt,
		_stop = 0,
		_rwnd = 1,
		_prev = 2,
		_paus = 3,
		_next = 4,
		_last = 5,
		_fuls = 6;

	var t_none = {
			preS: function (elm) {
				preSizeImage(elm, null);
			},
			pull: function (elm, lft) {
				elm.className = 'islide img_hide';
			},
			getI: function (elm, num, lft) {
				loadElm(elm, num, lft);
			},
			resz: function () {
				preSizeImages();
			}
		};
	var t_dzlv = {
			preS: function (elm) {
				preSizeImage(elm, null);
			},
			pull: function (elm, lft) {
				elm.className = 'islide img_off';
			},
			getI: function (elm, num, lft) {
				loadElm(elm, num, lft);
			},
			resz: function () {
				preSizeImages();
			}
		};
	var t_slid = {
			preS: function (elm, lft) {
				if (lft) {
					preSizeImage(elm, function(){ elm.style.left = -(elm.width+2)+"px"; });
				} else {
					preSizeImage(elm, function(){ elm.style.left = (window.innerWidth+2)+"px"; });
				}
			},
			pull: function (elm, lft) {
				if (lft) {
					//cause the currently displayed image to slide off screen to the left
					elm.style.left = -(elm.width+2)+"px";
				} else {
					//cause the currently displayed image to slide off screen to the right
					elm.style.left = (window.innerWidth+2)+"px";
				}
			},
			getI: function (elm, num, lft) {
				elm.className = "islide";
				loadElm(elm, num, lft);
			},
			resz: function () {	//adjust right side image positions after window resize
				var ehd = _iecnt - _ffv, i, elm;
				preSizeImages();
				// set right side elements
				for (i=0; i<ehd; i++) {
					elm = _ielms[i+_ffv];
					elm.style.left = (window.innerWidth+2)+"px";
				}
				//set left side elements
				for (i=0; i<_ffv; i++) {
					elm = _ielms[i];
					elm.style.left = -(elm.width+2)+"px";
				}
			}
		};

	function relSlidNum (reln) {
		if (reln < 0) {
			reln = (reln*-1) % _ill;
			return _ill - reln;
		} else {
			return reln % _ill;
		}
	}

	function loadElm (elm, lix, lft) {
		elm.eMsg = null;
		if (vendorQuirk.vendorID == "ff") { elm.src = ''; elm.completed = false; }	//for FF to full load image
	//	elm.src = null;
		elm.src = imagelist[lix].fpath;	console.log(elm.src);
		elm.slidnum = lix;
		elm.isSized = false;
		trzn.preS(elm, lft);
	}

	function imgPlaced (elm) {
		elm.className = _onClass;
		_sldnumelm.innerHTML = elm.slidnum + 1;
		_titlelm.innerHTML = imagelist[elm.slidnum].title;
		if (elm.eMsg) { _titlelm.innerHTML += elm.eMsg; }
		if (_running && !_resizing) { _sTimer = setTimeout(function(){nextSlide()}, _slideDur); }
	}

	//rotate the img frame right (clockwise)
	function frameRight () {
		trzn.pull(_ielms[_ffv], true);
		var lf = _ielms.shift(),
			sNum = relSlidNum(_fle+_iecnt);
		trzn.getI(lf, sNum, false);
		_fle = (_fle+1) % _ill;
		_ielms.push(lf);
	}
	//rotate the img frame left (counterclockwise)
	function frameLeft () {
		trzn.pull(_ielms[_ffv], false);
		var rf = _ielms.pop(),
			sNum = relSlidNum(_fle-1);
		trzn.getI(rf, sNum, true);
		_fle = sNum;
		_ielms.unshift(rf);
	}
	function nextFrame (LR) {
		if (!mySC.repeat) {
			if ((LR==1 && _fle+_ffv+1==_ill)) {
				mySC.doMnu(_stop);
				return false;
			}
		}
		if (_ielms.length > 1) {
			if (LR>0) { frameRight(); } else if (LR<0) { frameLeft(); }
		}
		var tElm = _ielms[_ffv];
//		_titlelm.innerHTML = imagelist[tElm.slidnum].title;
//		if (tElm.eMsg) { _titlelm.innerHTML += tElm.eMsg; }
if (LR !== 0) { _titlelm.innerHTML = ""; }
		positionImage(tElm, function(){ imgPlaced(tElm); /*tElm.className = _onClass;*/});
//		_sldnumelm.innerHTML = tElm.slidnum + 1;
		return true;
	}
	function nextSlide () {
		nextFrame(1);
		//if (nextFrame(1) && _sTimer) _sTimer = setTimeout(function(){nextSlide()}, _slideDur);
	}
	function prevSlide () {
		nextFrame(-1);
	}

	function slideshowPause () {
		// stop the slideshow if it is automatically running.
		if (_sTimer) {
			clearTimeout(_sTimer);
			_sTimer = null;
		}
		_running = false;
	}

	function slideshowRun () {
		_pauseRunDiv.style.backgroundPosition = '-54px 0';
		slideshowPause();
//		positionImage(_ielms[_ffv], null);
//		_sTimer = setTimeout(function(){nextSlide()}, _slideDur);
		_running = true;
		nextFrame(0);
	}
	function slideshowStop () {
		_pauseRunDiv.style.backgroundPosition = '-72px 0';
		slideshowPause();
	}

	function preSizeImages () {
		var i, icnt = _ielms.length;
		for (i=0; i<icnt; i++) {
			preSizeImage(_ielms[i], null);
		}
	}

	function preSizeImage (img, cb) {
		if (!img.complete) { setTimeout(function(){preSizeImage(img, cb)},100); return; }
		var bH = window.innerHeight,
			bW = window.innerWidth,
			pW = img.naturalWidth,
			pH = img.naturalHeight,
			fW, fH;
		if (imagelist[img.slidnum].title) { bH -= 26; }
		if (pW>0 && pH>0) {
			fH = pH>bH ? bH : pH;
			fW = Math.round(pW*fH/pH);
			if (fW>bW) {
				fW = bW;
				fH = Math.round(pH*fW/pW);
			}
			img.height = fH;
			img.width = fW;
			img.isSized = true;
		} else {
		}
		if (cb) cb();
	}

	function positionImage (img, cb) {
		if (!img.isSized) { _loading.style.display = "block"; setTimeout(function(){positionImage(img, cb)},100); return; }
		_loading.style.display = "none";
		var bW = window.innerWidth,
			fW = img.width;
			if (fW<bW) {
				img.style.left = Math.floor((bW-fW)/2)+"px";
			} else img.style.left = '0px';
		if (cb) cb();
	}

	function goToSlide (snum) {
		var ehd, i, rn;
		// set the frame left edge
		_fle = relSlidNum(snum - _ffv);
		// get right side count
		ehd = _iecnt - _ffv;
		// set right side elements
		for (i=0; i<ehd; i++) {
			rn = relSlidNum(i+snum);
			loadElm(_ielms[i+_ffv], rn, false);
		}
		//set left side elements
		for (i=0; i<_ffv; i++) {
			rn = relSlidNum(snum - _ffv + i);
			loadElm(_ielms[i], rn, true);
		}
	}

//===============================================================

	function runToggle () {
		if (_sTimer) {
			slideshowStop();
		} else {
			slideshowRun();
		}
	}

	function rewindShow () {
		slideshowStop();
		goToSlide(0);
		nextFrame(0);
	}

	function lastSlide () {
		slideshowStop();
		goToSlide(_ill-1);
		nextFrame(0);
	}

	function toggleFully () {
		var tfsdiv = $id("cb_full");
		if (_fullScreenApi.isFullScreen()) {
			_fullScreenApi.cancelFullScreen();
			tfsdiv.style.backgroundPosition = '-126px 0';
		}
		else {
			if (_fullScreenApi.supportsFullScreen) {
				_fullScreenApi.requestFullScreen(document.body);
				tfsdiv.style.backgroundPosition = '-144px 0';
			}
		}
	}

	mySC.doMnu = function(cmd) {
		switch(cmd) {
			case _stop:
				if (popdwin) { window.close(); }
				else { window.history.back(); }
				break;
			case _rwnd:
				rewindShow();
				break;
			case _prev:
				slideshowStop();
				prevSlide();
				break;
			case _paus:
				runToggle();
				break;
			case _next:
				slideshowStop();
				nextSlide();
				break;
			case _last:
				lastSlide();
				break;
			case _fuls:
				toggleFully();
				break;
		}
	};

	function doKeyAction (e,code) {
		if (e.preventDefault) e.preventDefault();
		if (e.stopPropagation) e.stopPropagation();
		switch (code) {
			case 32:
				mySC.doMnu(_paus);
				break;
			case 37:
				mySC.doMnu(_prev);
				break;
			case 39:
				mySC.doMnu(_next);
				break;
			case 27:
				mySC.doMnu(_stop);
				break;
			case 91:
				mySC.doMnu(_rwnd);
				break;
			case 93:
				mySC.doMnu(_last);
				break;
			case 9:
			case 13:
				mySC.doMnu(_fuls);
				break;
		}
	}

	function keyPressed (e) {
		switch (e.charCode) {
			case 32:
			case 91:
			case 93:
			case 13:
				doKeyAction(e,e.charCode);
				break;
			default:
				//stelm = $id("status");
				//stelm.innerHTML += e.charCode+':';
				break;
		}
	}

	function keyDowned (e) {
		switch (e.keyCode) {
			case 32:
			case 13:
				break;
			case 37:
			case 39:
			case 27:
			case 9:
				doKeyAction(e,e.keyCode);
				break;
			default:
				//stelm = $id("status");
				//stelm.innerHTML += e.keyCode+';';
				break;
		}
	}

	function swipe (e) {
		var te = e.changedTouches[0];
		var	dx = _tstartx - te.clientX,
			dy = _tstarty - te.clientY;
		e.preventDefault();
		if ((e.timeStamp - _tstartt) > 400) { return; }
		if (Math.abs(dx) > Math.abs(dy)) {
			if (Math.abs(dx) > 150) {
				if (dx>0) {mySC.doMnu(_next)}
				else {mySC.doMnu(_prev)}
			}
		} else {
			if (Math.abs(dy) > 150) {
				mySC.doMnu(_paus);
			}
		}
	}
	function touch (e) {
		var ts = e.changedTouches[0];
		_tstartx = ts.clientX;
		_tstarty = ts.clientY;
		_tstartt = e.timeStamp;
		e.preventDefault();
	}

	function winResized () {
		if (_resizeTime) clearTimeout(_resizeTime);
		_resizeTime=setTimeout(function(){_resizing=true;trzn.resz();nextFrame(0);_resizing=false}, 200);
	}

	function showSeconds () {
		var sspan = $id("seconds");
		sspan.innerHTML = Math.round(_slideDur/1000);
	}

	function imgError () {
		this.eMsg = '<p class="errMsg">'+imgerror+this.src+'</p>';
		this.src = "plugins/html5slideshow/css/broken.png";
	}

	mySC.sdur = function(up) {
		if (up) {_slideDur += 1000}
		else { if (_slideDur > 3000) {_slideDur -= 1000} }
		showSeconds();
	};

	mySC.init = function(fsapi) {
		var i, ielm, iarea = $id("screen");

		trzn = t_none;	//use no transition by default
		_onClass = 'islide img_show';
		_iniClass = 'islide img_hide';

		switch (this.trnType) {
			case 'd':
				trzn = t_dzlv;
				_onClass = 'islide img_on';
				_iniClass = 'islide img_off';
				break;
			case 's':
				trzn = t_slid;	//use slide transition
				_onClass = 'islide img_slin';
				_iniClass = 'islide';
				break;
		}

		_ill = imagelist.length;
		if (_ill < _iecnt) { _iecnt = _ill; }
		for (i=0; i<_iecnt; i++) {
			ielm = document.createElement("IMG");
			ielm.onerror = imgError;
			ielm.style.left = (window.innerWidth+2)+"px";
			ielm.className = _iniClass;
			_ielms.push(ielm);
			iarea.appendChild(ielm);
		}
		// get the middle element of the image frame
		_ffv = Math.floor(_iecnt/2);

		// watch for swipes
		iarea.addEventListener('touchstart', touch, false);
		iarea.addEventListener('touchmove', function(e){e.preventDefault();}, false);
		iarea.addEventListener('touchend', swipe, false);

		_fullScreenApi = fsapi;
		_sldnumelm = $id("slidnum");
		_titlelm = $id("ptext");
		_pauseRunDiv = $id("cb_paus");
		_loading = $id("loading");
		_slideDur = this.slideDur;
		showSeconds();
		goToSlide(0);
		if (this.autoPlay) {
			slideshowRun();
		} else {
			nextFrame(0);
		}
		window.onresize = winResized;
	};

	document.addEventListener("keypress", keyPressed, false);
	document.addEventListener("keydown", keyDowned, false);

	return mySC;
}());

window.onload = function(){ssCtl.init(fullScreenApi);};
