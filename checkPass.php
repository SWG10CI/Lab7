<?php
require_once('/lib/nusoap.php');
require_once('/lib/class.wsdlcache.php');

$soapclient = new nusoap_client( 'https://iv27c.000webhostapp.com/Lab5/ComprobarContrasena.php?wsdl',true);
$result = $soapclient->call('comprobar',array( 'x'=>$_GET['pass']));

echo($result);

?>