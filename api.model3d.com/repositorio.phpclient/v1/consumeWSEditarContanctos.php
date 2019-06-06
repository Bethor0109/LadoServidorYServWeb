<?php
include_once('httpful/httpful.phar');


if ($_SERVER['REQUEST_METHOD']== 'POST') {
    
    //$url = "http://localhost/api.peopleapp.com333/v3repo/contactos/";
    $url = "localhost/api.peopleapp.com333/v3repo/contactos/editar_contacto";
    
    $idContacto = $_POST["idContacto"];
    $primerNombre = $_POST["primerNombre"];
    $primerApellido  = $_POST["primerApellido"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];

    $datos_post = json_encode(
        array(
            'idContacto' => $idContacto,
            'primerNombre' => $primerNombre,
            'primerApellido' => $primerApellido,
            'telefono'=>$telefono,
            'correo'=>$correo
        )
    );
    $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($datos_post)
        ->addHeader('authorization', '4b2778fbbd23666354a92bad832452f8')
        ->send();
}




/*
    $contexto = stream_context_create($opciones);
$flujo = fopen($url, 'r', false, $contexto);

$contenidoRespuesta = stream_get_contents($flujo);


fclose($flujo);

*/


?>