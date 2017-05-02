// +----------------------------------------------------------------------+
// | EseSite  - initialisation of EseSite Javascript functions Company 1  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: esesite.js, V1.00 2003/10/01
//

function DoPopup(serverName, strSection, strPage, strProperty, strType, strDate, strHeight, strBookDate) {

      var url = 'https://' + serverName + '/fictional/index.php' + 
                '?id=00001' +
                '&s='        + strSection +
                '&p='        + strPage +
                '&r='        + strProperty +
                '&t='        + strType +
                '&d='        + strDate +
                '&b='        + strBookDate;
      var windowName = 'newWindow00001';
      var browserParms = 'width=800,height=' + strHeight + ',scrollbars=no,copyhistory=no,status=yes,resizable=yes';
      var newWindow = window.open(url, windowName, browserParms); 
      newWindow.focus();
}
