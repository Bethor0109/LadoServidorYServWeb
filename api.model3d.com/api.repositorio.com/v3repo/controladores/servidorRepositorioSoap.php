<?php
require_once('lib/nusoap.php');

require_once('nuevousuario.php');
require_once('iniciosesion.php');
require_once('nuevorepositorio.php');
require_once('obtenerinfousuario.php');
require_once('obtenerallrepos.php');
require_once('editarrepositorio.php');
require_once('nuevocontenido.php');
require_once('cambiarestadocuenta.php');
require_once('eliminarcontenido.php');
require_once('obtenertiposrepos.php');

$miURL1 = 'nuevousuario';
$miURL2 = 'iniciosesion';
$miURL3 = 'nuevorepositorio';
$miURL4 = 'obtenerinfousuario';
$miURL5 = 'obtenerallrepos';
$miURL6 = 'editarrepositorio';
$miURL7 = 'nuevocontenido';
$miURL8 = 'cambiarestadocuenta';
$miURL9 = 'eliminarcontenido';
$miURL0 = 'obtenertiposrepos';

$miURL = 'servicioSoap';

$server = new soap_server();

$server->configureWSDL('Servicio web SOAP', $miURL);

$server->wsdl->schemaTargetNamespace=$miURL1;
$server->wsdl->schemaTargetNamespace=$miURL2;
$server->wsdl->schemaTargetNamespace=$miURL3;
$server->wsdl->schemaTargetNamespace=$miURL4;
$server->wsdl->schemaTargetNamespace=$miURL5;
$server->wsdl->schemaTargetNamespace=$miURL6;
$server->wsdl->schemaTargetNamespace=$miURL7;
$server->wsdl->schemaTargetNamespace=$miURL8;
$server->wsdl->schemaTargetNamespace=$miURL9;
$server->wsdl->schemaTargetNamespace=$miURL0;

$server->register('nuevousuario.registrarusuario', // Nombre de la funcion
	array(
		'nombre' => 'xsd:string',
		'apellido' => 'xsd:string',
		'fecha_na' => 'xsd:date',
		'correo' => 'xsd:string',
		'password' => 'xsd:string',
		'estado' => 'xsd:int'
	), // Parametros de entrada
	array('return' => 'xsd:string'), // Parametros de salida
	$miURL1);

$server->register('iniciosesion.iniciarsesion', // Nombre de la funcion
	array(
		'correo' => 'xsd:string',
		'password' => 'xsd:string'
	), // Parametros de entrada
	array('return' => 'xsd:string'), // Parametros de salida
	$miURL2);

$server->register('nuevorepositorio.registrarrepositorio', // Nombre de la funcion
	array(
		'nombre_rep' => 'xsd:string',
		'id_tiporepositorio' => 'xsd:int',
		'id_cuenta' => 'xsd:int',
		'fecha_ceacion' => 'xsd:date'
	), // Parametros de entrada
	array('return' => 'xsd:string'), // Parametros de salida
	$miURL3);
 
$server->register('obtenerinfousuario.obtenerinfo', // Nombre de la funcion
	array(
		'correo' => 'xsd:string'
	), // Parametros de entrada
	array('return' => 'xsd:string'), // Parametros de salida
	$miURL4);

$server->register('obtenerallrepos.allrepos', // Nombre de la funcion
	array(
		'id_cuenta' => 'xsd:int'
	), // Parametros de entrada
	array('return' => 'tns:todosLosRepos'), // Parametros de salida
	$miURL5);

$server->register('editarrepositorio.editarepositorio', // Nombre de la funcion
	array(
		'nombre_rep' => 'xsd:string',
		'id_tiporepositorio' => 'xsd:int',
		'id_repositorio' => 'xsd:int',
		'id_cuenta' => 'xsd:int'
	), // Parametros de entrada
	array('return' => 'xsd:string'), // Parametros de salida
	$miURL6);

$server->register('nuevocontenido.anadircontenido', // Nombre de la funcion
	array(
		'url_archivo' => 'xsd:string',
		'add_fecha' => 'xsd:date',
		'id_tipocontenido' => 'xsd:int',
		'id_repositorio' => 'xsd:int',
		'id_contenido' => 'xsd:int'
	), // Parametros de entrada
	array('return' => 'xsd:string'), // Parametros de salida
	$miURL7);

$server->register('cambiarestadocuenta.cambioestado', // Nombre de la funcion
	array(
		'estado' => 'xsd:string',
		'id_cuenta' => 'xsd:int'
	), // Parametros de entrada
	array('return' => 'xsd:string'), // Parametros de salida
	$miURL8);

$server->register('eliminarcontenido.deletecontent', // Nombre de la funcion
	array(
		'id_contenido' => 'xsd:int',
		'id_repositorio' => 'xsd:int'
	), // Parametros de entrada
	array('return' => 'xsd:string'), // Parametros de salida
	$miURL9);

$server->register('obtenertiposrepos.tiposderepos', // Nombre de la funcion
	array(
		'parametroVacio' => 'xsd:int'
	), // Parametros de entrada
	array('return' => 'tns:todosLosTiposDeRepos'), // Parametros de salida
	$miURL0);

$server->service(file_get_contents("php://input"));
?>