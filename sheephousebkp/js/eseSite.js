// +----------------------------------------------------------------------+
// | EseSite  - initialisation of EseSite Javascript functions Company 4  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2005 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: esesite.js, V1.00 2005/03/03
//

function DoPopup(serverName) {

      var targetUrl = 'https://' + serverName + '/sheephousemanor/idxs.php?p=9&conditions=Accept';
      var windowName = 'newWindow00004';
      var browserParms = 'width=780,height=520,scrollbars=yes,copyhistory=no,status=no,resizable=yes';
      var newWindow = window.open(serverName, windowName, browserParms); 
      newWindow.focus();
}

