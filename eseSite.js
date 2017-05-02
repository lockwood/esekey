// +----------------------------------------------------------------------+
// | EseSite  - initialisation of EseSite Javascript functions            |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: esesite.js, V1.01 2004/10/15
//

var objAdmin;

function DoEseAdmin(serverName) {

    var targetUrl = 'https://' + serverName + '/admin/window.php';
    objAdmin = window.open(targetUrl, 'Admin', 'resizable=yes,scrollbars=yes,status=yes,toolbar=no');
    objAdmin.focus();

}	

