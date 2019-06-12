<?php
require_once('../controladores/lib/nusoap.php');
// Crear un cliente apuntando al script del servidor (Creado con WSDL)
$serverURL = 'http://localhost/api.model3d.com/api.repositorio.com/v3repo/controladores/servidorRepositorioSoap.php?wsdl';
$serverScript = 'servidorRepositorioSoap.php';

$metodoALlamar = 'editarrepositorio.editarepositorio';

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
        'id_cuenta' => 9,
		'nombre_rep' => 'Recorrido ITCH',
		'id_repositorio' => 13,
		'id_tiporepositorio' => 2
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