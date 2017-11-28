<?php

require_once('../lib/nusoap.php');
require_once('../lib/class.wsdlcache.php');

$ns="https://iv27c.000webhostapp.com/Lab5/samples";
$server = new soap_server;
$server->configureWSDL('comprobar',$ns);
$server->wsdl->schemaTargetNamespace=$ns;






$server->register('comprobar',
array('x'=>'xsd:string'),
array('z'=>'xsd:string'),
$ns);

function comprobar ($pass){

	$fich = file_get_contents("toppasswords.txt");
	if (strpos($fich, $pass) == false) {
        return 'VALIDA';
    }
    else{
    	return 'INVALIDA';
    }

}

if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );


?>