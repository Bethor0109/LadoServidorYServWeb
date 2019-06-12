<?php
require_once('../controladores/lib/nusoap.php');
// Crear un cliente apuntando al script del servidor (Creado con WSDL)
$serverURL = 'http://localhost/api.model3d.com/api.repositorio.com/v3repo/controladores/servidorRepositorioSoap.php?wsdl';
$serverScript = 'servidorRepositorioSoap.php';

$metodoALlamar = 'nuevorepositorio.registrarrepositorio';

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
    array(
        'nombre_rep' => 'mi repositorio',
		'id_tiporepositorio' => '4',
		'id_cuenta' => '9',
        'fecha_ceacion' => '2019-05-31'
    ),
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