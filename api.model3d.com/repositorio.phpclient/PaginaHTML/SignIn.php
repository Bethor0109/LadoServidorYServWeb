<?php
include_once('httpful/httpful.phar');

if ($_SERVER['REQUEST_METHOD']== 'POST') {

    $url = "localhost/api.model3d.com/api.repositorio.com/repositorio/nuevousuario/nuevo_usuario";
    
    
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $fecha_na  = $_POST["fecha_na"];
    $correo = $_POST["correo"];
    $password = $_POST["password"];
    $estado = 1;

    $datos_post = json_encode(
        array(
            'nombre' => $nombre,
            'apellido' => $apellido,
            'fecha_na' => $fecha_na,
            'correo'=>$correo,
            'password'=>$password,
            'estado'=>1
        )
    );
    $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($datos_post)
        ->send();

        header("Location: http://localhost/api.model3d.com/repositorio.phpclient/paginahtml/logsigIN.html");
}
?>