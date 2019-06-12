<?php
require_once('lib/nusoap.php');
// Crear un cliente apuntando al script del servidor (Creado con WSDL)
$serverURL = 'http://localhost/api.model3d.com/api.repositorio.soap/nusoap_server_ej1.php?wsdl';
//$serverURL = 'localhost/api.model3d.com/api.repositorio.com/repositorio/iniciosesion/iniciar_sesion';
$serverScript = 'nusoap_server_ej1.php';
$metodoALlamar = 'obtenerUsuarioPorCorreo';

$cliente = new nusoap_client("$serverURL/$serverScript?wsdl", 'wsdl');
// Se pudo conectar?
$error = $cliente->getError();
if ($error) {
	echo '<pre style="color: red">' . $error . '</pre>';
	echo '<p style="color:red;'>htmlspecialchars($cliente->getDebug(), ENT_QUOTES).'</p>';
	die();
}

// 1. Llamar a la funcion getRespuesta del servidor
$result = $cliente->call(
    "$metodoALlamar",                     // Funcion a llamar
    array('correo' => 'german@gmail.com',
          'password' => '123'),    // Parametros pasados a la funcion
    "uri:$serverURL/$serverScript",                   // namespace
    "uri:$serverURL/$serverScript/$metodoALlamar"       // SOAPAction
);
// Verificacion que los parametros estan ok, y si lo estan. mostrar rta.
if ($cliente->fault) {
    echo '<b>Error: ';
    print_r($result);
    echo '</b>';
} else {
    $error = $cliente->getError();
    if ($error) {
        echo '<b style="color: red">Error: ' . $error . '</b>';
    } else {
    	echo 'Respuesta: '.$result;
    }
}

?>