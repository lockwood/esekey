// +----------------------------------------------------------------------+
// | EseSite  - initialisation of EseSite Javascript functions Company 0  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: 0/esesite.js, V1.01 2004/10/15
//

var objAdmin;

function DoEseAdmin(serverName) {

    var targetUrl = 'https://' + serverName + '/admin/window.php';
    objAdmin = window.open(targetUrl, 'Admin', 'resizable=yes,scrollbars=yes,status=no,toolbar=no');

    if ((screen.width <= 1024) && (screen.height <= 768)) {
        objAdmin.moveTo(0,0);
        objAdmin.resizeTo(screen.availWidth,screen.availHeight);
        objAdmin.focus();
    } else {
        objAdmin.resizeTo(1024,740);			
        objAdmin.moveTo( (screen.availWidth - 1024) / 2 , (screen.availHeight - 740) / 2 );
        objAdmin.focus();
    }

}	

