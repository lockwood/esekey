// +----------------------------------------------------------------------+
// | EseSite  - initialisation of EseSite Javascript functions Company 7  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: esesite.js, V1.00 2005/07/15
//

function DoPopup(serverName) {

      var targetUrl = 'https://' + serverName + '/rjslettings/idxs.php?p=6&conditions=Accept';
      var windowName = 'newWindow00007';
      var browserParms = 'width=780,height=520,scrollbars=yes,copyhistory=no,status=no,resizable=yes';
      var newWindow = window.open(targetUrl, windowName, browserParms); 
      newWindow.focus();
}

function ShowReady(elem) {
	document.getElementById(elem.id).style.background='#ffffff'; 
	document.getElementById(elem.id).style.cursor='hand'; 
	document.getElementById(elem.id).title='Click to Edit this Element'; 
}
function HideReady(elem) {
	document.getElementById(elem.id).style.background='transparent'; 
}
function EditElement(serverName,elementId,sessid) {
      var targetUrl = 'https://' + serverName + '/admin/editelement.php?id=' + elementId + '&sid=' + sessid;
      var windowName = 'editWindow00007';
      var browserParms = 'width=780,height=520,scrollbars=yes,copyhistory=no,status=yes,resizable=yes';
      var newWindow = window.open(targetUrl, windowName, browserParms); 
      newWindow.focus();
}
function AddElement(serverName,pageId,sessid) {
      var targetUrl = 'https://' + serverName + '/admin/editelement.php?id=0&page=' + pageId + '&sid=' + sessid;
      var windowName = 'editWindow00007';
      var browserParms = 'width=780,height=520,scrollbars=yes,copyhistory=no,status=yes,resizable=yes';
      var newWindow = window.open(targetUrl, windowName, browserParms); 
      newWindow.focus();
}