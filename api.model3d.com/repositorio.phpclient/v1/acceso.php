<?php
include_once('httpful/httpful.phar');
/*$correo = $_POST["correo"];
$contrasena = $_POST["contrasena"];*/

$correo = "german@mail.com";
$contrasena = "12345";

$url = "http://localhost/api.peopleapp.com333/v3repo/usuarios/login";

//Armar Json que se enviará al WebService
$datos_post = json_encode(
    array(
        'contrasena' => $contrasena,
        'correo' => $correo
    )
);

/*$datos_post = json_encode(
    array(
        'contrasena' => '12345',
        'correo' => 'carlos@mail.com'
    )
);*/

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
        'header'  => 'Content-type: application/json',
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
$contenidoRespuesta = stream_get_contents($flujo); //vacía el buffer de la respuesta
var_dump($contenidoRespuesta);

//Extraer variables de la respuesta al web Service
$datosJson = json_decode($contenidoRespuesta, true);

echo "<br> Datos Json Recibidos";
echo var_dump($datosJson);

echo "<br>nombre usuario: " . $datosJson["usuario"]["nombre"];
echo "<br>correo usuario: " . $datosJson["usuario"]["correo"];
echo "<br>clave Api usuario: " . $datosJson["usuario"]["claveApi"];

//Creación de la sesión

     //Si se usa debe contener (sólo caracteres alfanuméricos) e ir antes de session_start():
     session_id("Prueba de sesión");
     // Iniciar la sesión
     session_start();

     // Variables de sesión:
     $_SESSION['correo'] = $datosJson["usuario"]["correo"];
     $_SESSION['nombre'] = $datosJson["usuario"]["nombre"];
     $_SESSION['claveApi'] = $datosJson["usuario"]["claveApi"];

echo "<br>sesión nombre usuario: " . $_SESSION['correo'];
echo "<br>sesión correo usuario: " . $_SESSION['nombre'];
echo "<br>sesión clave Api usuario: " . $_SESSION['claveApi'];

fclose($flujo);
