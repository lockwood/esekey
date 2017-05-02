// +----------------------------------------------------------------------+
// | MENU  - initialisation of Admin Console Menu functions               |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: menu.js, V1.02 2004/12/06
//

var g_objPlusImg = new Image();
g_objPlusImg.src = 'images/plus.gif';

var g_objMinusImg = new Image();
g_objMinusImg.src = 'images/minus.gif';


function HideLevel(strId) {
	var objThisLevel = document.getElementById(strId);
	var objThisImg   = document.getElementById('img_' + strId);
	
	objThisLevel.style.display = 'none';
	objThisImg.src = g_objPlusImg.src;
}


function ShowLevel(strId) {
	
	var objThisLevel = document.getElementById(strId);
	var objThisImg   = document.getElementById('img_' + strId);

	if (objThisLevel.style.display == 'none') {
		objThisLevel.style.display = 'block';
		objThisImg.src = g_objMinusImg.src;
		strLastMenu = strId;
	}	else {
		HideLevel(strId);
	}
	
}

