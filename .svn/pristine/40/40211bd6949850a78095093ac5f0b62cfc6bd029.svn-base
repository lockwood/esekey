<?php
function getGreetingResponse($greeting) {

	$response = array('Hi'=>'Lo','Hello'=>'Goodbye','Hello World'=>'Bonjour!');
	if (isset($response[$greeting]))
	{
		return $response[$greeting];
	} else
	{
		return 'That makes no sense to me.';
	}
}

require('main/nusoap/nusoap.php');

$server = new soap_server();

$server->configureWSDL('testserver', 'urn:testquote');

$server->register("getGreetingResponse",
                array('greeting' => 'xsd:string'),
                array('reply' => 'xsd:string'),
                'urn:testquote',
                'urn:testquote#getGreetingResponse');

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA)
                      ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>