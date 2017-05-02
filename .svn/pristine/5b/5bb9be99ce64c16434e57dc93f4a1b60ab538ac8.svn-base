// +----------------------------------------------------------------------+
// | EseSite  - initialisation of EseSite Javascript functions Company 9  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: esesite.js, V1.00 2007/02/01
//

var objAdmin;

function DoEseAdmin(serverName) {

    var targetUrl = 'https://' + serverName + '/admin/window.php';
    objAdmin = window.open(targetUrl, 'Admin', 'resizable=yes,scrollbars=yes,status=yes,toolbar=no');
    objAdmin.focus();

}	

function DoPopup(serverName) {

      var targetUrl = 'https://' + serverName + '/accommodation-windsor/idxs.php?p=6&conditions=Accept';
      var windowName = 'newWindow00009';
      var browserParms = 'width=780,height=520,scrollbars=yes,copyhistory=no,status=no,resizable=yes';
      var newWindow = window.open(targetUrl, windowName, browserParms); 
      newWindow.focus();
}

function PopupAvailability(propertyId) {

      var targetUrl = 'http://dlockwood/esekey/accommodation-windsor/p3.php?property=' + propertyId + '&popup=1';
//      var targetUrl = 'http://www.esekey.com/accommodation-windsor/p3.php?property=' + propertyId + '&popup=1';
      var windowName = 'newWindow00009';
      if (propertyId == 0) {
	      var browserParms = 'width=' + screen.availWidth + ',height=520,scrollbars=yes,copyhistory=no,status=no,resizable=yes';
	  } else {
	      var browserParms = 'width=500,height=520,scrollbars=yes,copyhistory=no,status=no,resizable=yes';
	  }
      var newWindow = window.open(targetUrl, windowName, browserParms); 
      newWindow.focus();
}

function PopupWeekly(propertyId) {

      var targetUrl = 'http://dlockwood/esekey/accommodation-windsor/p9.php?property=' + propertyId + '&popup=1';
//      var targetUrl = 'http://www.esekey.com/accommodation-windsor/p9.php?property=' + propertyId + '&popup=1';
      var windowName = 'newWindow00009';
      var browserParms = 'width=780,height=360,scrollbars=yes,copyhistory=no,status=no,resizable=yes';
      var newWindow = window.open(targetUrl, windowName, browserParms); 
      newWindow.focus();
}

function PopupBookAvail(propertyId) {

      var targetUrl = 'https://dlockwood/esekey/accommodation-windsor/p3.php?property=' + propertyId + '&popup=1&bk=1';
//      var targetUrl = 'https://securesslhost.net/~esekey9/accommodation-windsor/p3.php?property=' + propertyId + '&popup=1&bk=1';
      var windowName = 'newWindow00009';
      var browserParms = 'width=780,height=520,scrollbars=yes,copyhistory=no,status=yes,resizable=yes';
      var newWindow = window.open(targetUrl, windowName, browserParms); 
      newWindow.focus();
}

