<?php
require_once('main/nusoap/nusoap.php');

$c = new nusoap_client('http://dlockwood/esekey/helloworld.php');

$reply = $c->call('getGreetingResponse', array('greeting' => $greeting));

echo "The reply for greeting $greeting is: ".$reply;
phpinfo();
?>
