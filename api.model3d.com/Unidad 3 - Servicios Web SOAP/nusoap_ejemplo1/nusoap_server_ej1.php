<?php
require_once('nusoap/lib/nusoap.php');
$miURL = 'http://pruebas.orlandobrea.com.ar/nusoap_ej1';
$server = new soap_server();
$server->configureWSDL('ws_orlando', $miURL);
$server->wsdl->schemaTargetNamespace=$miURL;


/*
 *  Ejemplo 1: getRespuesta es una funcion sencilla que recibe un parametro y retorna el mismo
 *  con un string anexado
 */
$server->register('getRespuesta', // Nombre de la funcion
				   array('parametro' => 'xsd:string'), // Parametros de entrada
				   array('return' => 'xsd:string'), // Parametros de salida
				   $miURL);
function getRespuesta($parametro){
	return new soapval('return', 'xsd:string', 'soy servidor y devuelvo: '.$parametro);
}

$server->service($HTTP_RAW_POST_DATA);
?>