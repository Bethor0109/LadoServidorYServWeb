<?php
include_once('httpful/httpful.phar');
$url = "http://localhost/api.peopleapp.com333/v1/usuarios/login";

$datos_post = json_encode(
    array(
        'contrasena' => '12345',
        'correo' => 'german@mail.com'
    )
);

/* O puede ser convirtiendo una cadena JSon válida a un objeto genérico con json_decode
y luego convertir el objeto genérico a un objeto JSon con json_encode:

$datos_post = json_encode(json_decode('
{"contrasena":"12345",
"correo":"carlos@mail.com"}
'));

*/

$opciones = array('http' =>
    array(
        'method' => 'POST',
        'max_redirects' => '0',
        'ignore_errors' => '1',
        'header'  => 'Content-type: application/json, authorization: 4b2778fbbd23666354a92bad832452f8',
        'content' => $datos_post
    )
);

$contexto = stream_context_create($opciones);
$flujo = fopen($url, 'r', false, $contexto);

// información de cabeceras y meta datos sobre el flujo
echo "Metadatos: ";
echo "<br>";
var_dump(stream_get_meta_data($flujo));
echo "<br>";

// datos reales en $url
echo "<br>Contenido de respuesta: ";
echo "<br>";
var_dump(stream_get_contents($flujo));

fclose($flujo);
