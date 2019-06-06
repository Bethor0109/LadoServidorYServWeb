<?php
include_once('httpful/httpful.phar');

if ($_SERVER['REQUEST_METHOD']== 'POST') {

    $url = "localhost/api.model3d.com/api.repositorio.com/repositorio/nuevorepositorio/nuevo_repositorio";
    
    //yyyy-mm-dd
    $nombre_rep = $_POST["nombre_rep"];
    $id_cuenta = $_POST["id_cuenta"];
    $fecha_ceacion = $_POST["fecha_ceacion"];

    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    
    $datos_post = json_encode(
        array(
            'nombre_rep' => $nombre_rep,
            'id_cuenta' => $id_cuenta,
            'fecha_ceacion' => $fecha_ceacion
        )
    );
    $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($datos_post)
        ->send();

        header("Location: http://localhost/api.model3d.com/repositorio.phpclient/paginahtml/sessionon.php");
}
?>