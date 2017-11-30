<?php
require_once($_SERVER['DOCUMENT_ROOT'] .'/Lab5/lib/nusoap.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'/Lab5/lib/class.wsdlcache.php');

$soapclient = new nusoap_client( 'http://ehusw.es/jav/ServiciosWeb/comprobarmatricula.php?wsdl',true);
$result = $soapclient->call('comprobar',array( 'x'=>$_GET['mail']));

echo($result);


?>