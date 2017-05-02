<?php
// +----------------------------------------------------------------------+
// | CONTROL_NAV  - Esekey Admin Console Navigation Control               |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: admin/control_nav.php,v 1.00 2004/12/08
//

if (isset($_GET[menu])) { // menu heading passed from caller
    $menu = $_GET[menu];
    if ($menu == '1') { // level 1 call
        $_SESSION[$ss]['level'] = 1;
    } elseif ($menu == '2') { // level 2 call
        $_SESSION[$ss]['level'] = 2;
    } else { // level 0 call
        $_SESSION[$ss]['level'] = 0;
        $_SESSION[$ss]['current_menu'] = $menu;
    }
} else {
    $_SESSION[$ss]['level'] = 0;
    $_SESSION[$ss]['current_menu'] = 'EseCompany';
}

if (isset($_GET[link])) { // link passed from caller
    $link = $_GET[link];
} else {
    $link = 'status.php';
}

if ($_SESSION[$ss]['level'] > 0) { // title passed from caller
    $title = $_GET[title];
} else { // get title from session table
    for ($i = 0; $i < count($_SESSION[$ss]['menu']); $i++) {
        for ($j = 1; $j < count($_SESSION[$ss]['menu'][$i][0]); $j++) {
            if ($_SESSION[$ss]['menu'][$i][1][$j] == $link) {
                $title = $_SESSION[$ss]['menu'][$i][0][$j];
            }
        }
    } 
}

$_SESSION[$ss]['link'][$_SESSION[$ss]['level']] = $link;
$_SESSION[$ss]['title'][$_SESSION[$ss]['level']] = $title;

?>