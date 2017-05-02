// +----------------------------------------------------------------------+
// | EseSite  - initialisation of EseSite Javascript functions Company 11 |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2008 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: esesite.js, V1.00 2008/03/18
//

function DoPopup(serverName) {

      var targetUrl = 'https://' + serverName + '/pebblevilla/idxs.php?p=2&conditions=Accept';
      var windowName = 'newWindow00011';
      var browserParms = 'width=780,height=520,scrollbars=yes,copyhistory=no,status=no,resizable=yes';
      var newWindow = window.open(targetUrl, windowName, browserParms); 
      newWindow.focus();
}

