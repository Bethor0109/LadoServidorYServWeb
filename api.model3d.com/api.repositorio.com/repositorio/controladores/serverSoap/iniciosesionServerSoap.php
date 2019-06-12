<?php
require_once('lib/nusoap.php');
require_once('../iniciosesion.php');

$server = new soap_server();
$iniciosesion = new iniciosesion();

$namespace = 'localhost/api.model3d.com/api.repositorio.com/repositorio/iniciosesion/iniciar_sesion';

$server->configureWSDL("iniciar_sesion");

$server->wsdl->schemaTargetNamespace = $namespace;

$server->register('obtenerUsuario', // Nombre de la funcion
				   array('correo' => 'xsd:string',
				   		 'password' => 'xsd:string'), // Parametros de entrada
				   array('return' => 'xsd:string'), // Parametros de salida
				   $namespace,false,
				   'rpc',
				   'encoded');

function obtenerUsuario($correo, $password){
	$iniciosesion->obtenerUsuarioPorCorreo($correo);
    return new soapval('return', 'xsd:string', 'debug: '.$iniciosesion);
}

$server->service(file_get_contents("php://input"));
?>