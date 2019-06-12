<?php
require_once('lib/nusoap.php');
require_once 'obtenerallrepos.php';
//$miURL = 'http://pruebas.orlandobrea.com.ar/nusoap_ej1';
//$miURL = 'localhost/api.model3d.com/api.repositorio.com/repositorio/iniciosesion/iniciar_sesion';
$server = new soap_server();
$namespace = 'localhost/api.model3d.com/api.repositorio.soap/obtenerallrepos.php';
//$namespace = 'localhost/api.model3d.com/api.repositorio.com/repositorio/iniciosesion/iniciar_sesion';
//$server = new soap_server();
//$server->configureWSDL('ws_orlando', $miURL);
//$server->wsdl->schemaTargetNamespace=$miURL;
$server->configureWSDL("obtenerallrepos");

$server->wsdl->schemaTargetNamespace = $namespace;


/*
 *  Ejemplo 1: getRespuesta es una funcion sencilla que recibe un parametro y retorna el mismo
 *  con un string anexado
 
$server->register('getRespuesta', // Nombre de la funcion
				   array('parametro' => 'xsd:string'), // Parametros de entrada
				   array('return' => 'xsd:string'), // Parametros de salida
				   $miURL);
function getRespuesta($parametro){
	return new soapval('return', 'xsd:string', 'soy servidor y devuelvo: '.$parametro);
}	*/

$server->register('obtenerallrepos.obtenerrepos', // Nombre de la funcion
				   array('$id_cuenta' => 'xsd:string'), // Parametros de entrada
				   array('return' => 'xsd:string'), // Parametros de salida
				   $namespace,false,
				   'rpc',
				   'encoded');

/*function obtenerUsuarioPorCorreo($correo, $password){
	return new soapval('return', 'xsd:string', 'Correo: '.$correo.' & Contraseña: '.$password);
}	*/

//$server->service($HTTP_RAW_POST_DATA);
$server->service(file_get_contents("php://input"));
?>