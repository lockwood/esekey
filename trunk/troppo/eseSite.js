// +----------------------------------------------------------------------+
// | EseSite  - initialisation of EseSite Javascript functions Company 3  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: esesite.js, V1.00 2003/10/01
//

function DoPopup(serverName) {

      var targetUrl = 'https://' + serverName + '/troppo/idxs.php?p=13&conditions=Accept';
      var windowName = 'newWindow00003';
      var browserParms = 'width=780,height=520,scrollbars=yes,copyhistory=no,status=no,resizable=yes';
      var newWindow = window.open(targetUrl, windowName, browserParms); 
      newWindow.focus();
}

