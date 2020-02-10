/*오픈레이어*/
function openlayer(nm){var obj = document.getElementById(nm);obj.style.display = 'block';}
function closelayer(nm){var obj = document.getElementById(nm);obj.style.display = 'none';}

/*우편번호*/
function pop_post(){window.open('../inc/post01.php', 'pop_post','width=522,height=474,statusbar=no,scrollbars=no');}

/*갤러리*/
function ImgChange_t(p_img_t){	document.all.la_img_t.src = "../img/" + p_img_t;}



<!-- //퀵메뉴 스크립트
var isDOM = (document.getElementById ? true : false); 
var isIE4 = ((document.all && !isDOM) ? true : false);
var isNS4 = (document.layers ? true : false);
function getRef(id) {
	if (isDOM) return document.getElementById(id);
	if (isIE4) return document.all[id];
	if (isNS4) return document.layers[id];
}
var isNS = navigator.appName == "Netscape";
function moveRightEdge() {
	var yMenuFrom, yMenuTo, yOffset, timeoutNextCheck;
	if (isNS4) {
		yMenuFrom   = divMenu.top;
		yMenuTo     = windows.pageYOffset + 100;   // 위쪽 위치
	} else if (isDOM) {
		yMenuFrom   = parseInt (divMenu.style.top, 10);
		yMenuTo     = (isNS ? window.pageYOffset : document.body.scrollTop) + 100; // 위쪽 위치
	}
	timeoutNextCheck = 500;
	if (yMenuFrom != yMenuTo) {
		yOffset = Math.ceil(Math.abs(yMenuTo - yMenuFrom) / 20);
		if (yMenuTo < yMenuFrom)
			yOffset = -yOffset;
		if (isNS4)
			divMenu.top += yOffset;
		else if (isDOM)
			divMenu.style.top = parseInt (divMenu.style.top, 10) + yOffset;
			timeoutNextCheck = 10;
	}
	setTimeout ("moveRightEdge()", timeoutNextCheck);
}

if (isNS4) {
	var divMenu = document["divMenu"];
	divMenu.top = top.pageYOffset + 40;
	divMenu.visibility = "visible";
	moveRightEdge();
} else if (isDOM) {
	var divMenu = getRef('divMenu');
	divMenu.style.top = (isNS ? window.pageYOffset : document.body.scrollTop) + 100;
	divMenu.style.visibility = "visible";
	moveRightEdge();
}
// 퀵메뉴 스크립트 끝
--> 
