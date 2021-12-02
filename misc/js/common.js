var imgOver = function imgOver(imgName) {
	imgName.src = imgName.src.replace(/(_on.gif|.gif)$/i, "_on.gif");
	imgName.src = imgName.src.replace(/(_on.jpg|.jpg)$/i, "_on.jpg");
	imgName.src = imgName.src.replace(/(_on.png|.png)$/i, "_on.png");
}

var imgOut = function imgOut(imgName) {
	imgName.src = imgName.src.replace(/(_on.gif|.gif)$/i, ".gif");
	imgName.src = imgName.src.replace(/(_on.jpg|.jpg)$/i, ".jpg");
	imgName.src = imgName.src.replace(/(_on.png|.png)$/i, ".png");
}

var readyMsg = function readyMsg() {
	window.alert( "서비스 준비중 입니다." );
}

var yetMsg = function yetMsg() {
	window.alert( "아직 안되용~" );
}

var popopen = function popopen(url, t, w, h, Left, Top,s) {
	mywin=window.open(url, t, 'toolbar=no, location=no, status=yes, menubar=no, scrollbars='+s+', resizable=no, Width='+w+'px, Height='+h+'px, Left='+Left+', Top='+Top);
	mywin.focus();
}


function	trim( str ){
	retstr = "";

	retstr = ltrim( str );
	retstr = rtrim( retstr );

	return	retstr;
}


function	ltrim	( str ) {
	leng = str.length;
	retstr = "";
	i = 0;

	for  ( ; i < leng ; i++ ){
		char = str.substr( i, 1 );
		if  ( char != " " )
			break;
	}

	retstr = str.substr( i );

	return	retstr;
}


function	rtrim	( str ) {
	leng = str.length;
	retstr = "";
	i = leng - 1;

	for  ( ; i >= 0 ; i-- ){
		char = str.substr( i, 1 );
		if  ( char != " " )
			break;
	}

	retstr = str.substr( 0, i + 1 );

	return	retstr;
}


function	emailvalidcheck	( str ) {
	var is_valid = str.match(/^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/);

	is_valid = ( is_valid == null ) ? false : true;

	return	is_valid;
}


function	passwordvalidcheck	( str ) {
	leng = str.length;
	charflag = 0;
	numflag = 0;

	for  ( i = 0 ; i < leng ; i++ ){
		char = str.substr( i, 1 );

		if  ( isNaN( char ) ){
			charflag = 1;
		}
		else{
			numflag = 1;
		}
	}

	if  ( ( charflag + numflag == 2 ) && leng >= 6 )
		is_valid = true;
	else
		is_valid = false;

	return	is_valid;
}


var autoResizePopup = function autoResizePopup() {
	var winW, winH, sizeToW, sizeToH;

	if ( parseInt(navigator.appVersion) > 3 ) {
		if ( navigator.appName=="Netscape" ) {
			winW = window.innerWidth;
			winH = window.innerHeight;
		}
		if ( navigator.appName.indexOf("Microsoft") != -1 ) {
			winW = document.body.scrollWidth;
			winH = document.body.scrollHeight;
		}
	}
	sizeToW = 0;
	sizeToH = 0;
	if ( winW > 1000 ) {
		sizeToW = 1000 - document.body.clientWidth;
	} else if ( Math.abs(document.body.clientWidth - winW ) > 3 ) {
		sizeToW = winW - document.body.clientWidth;
	}
	if ( winH > 680 ) {
		sizeToH = 680 - document.body.clientHeight;
	} else if ( Math.abs(document.body.clientHeight - winH) > 4 ) {
		sizeToH = winH - document.body.clientHeight;
	}
	if ( sizeToW != 0 || sizeToH != 0 )
		window.resizeBy(sizeToW, sizeToH);
}


// 플래시 object
function dispswf(swf,w,h,bg,id,tit,a,b,c){
 document.write('<object id="'+id+'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="'+w+'" height="'+h+'" align="middle" title="'+tit+'">');
 document.write('<param name="allowScriptAccess" value="sameDomain" />');
 document.write('<param name="movie" value="'+swf+'" />');
 document.write('<param name="quality" value="high" />');
 document.write('<param name="base" value="." />');
 document.write('<param name="FlashVars" value="depth1='+a+'&depth2='+b+'&depth3='+c+'" />');
 if(bg == ""){
  document.write('<param name="wmode" value="transparent" />');
  document.write('<embed name="'+id+'" src="'+swf+'" quality="high" wmode="transparent" width="'+w+'" height="'+h+'"  align="middle" allowscriptaccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />');  
 }else{
  document.write('<param name="bgcolor" value="'+bg+'" />');
  document.write('<embed name="'+id+'" src="'+swf+'" quality="high" bgcolor="'+bg+'" width="'+w+'" height="'+h+'"  align="middle" allowscriptaccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />');
 }
 document.write('</object>');
}

//function SetActive ( id ) {
//	document.getElementById(id).className = "error";
//}
//
//function ResetActive ( id ) {
//	document.getElementById(id).className = "";
//}
//
//function HideHelpMessage( id ) {
//	document.getElementById( id ).style.display = "none";
//}
//
//function ShowHelpMessage( id ) {
//	document.getElementById( id ).style.display = "";
//}