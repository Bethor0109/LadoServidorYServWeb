<?php
include_once('httpful/httpful.phar');
session_unset(); 
session_destroy(); 
if ($_SERVER['REQUEST_METHOD']== 'POST') {

    $url = "localhost/api.model3d.com/api.repositorio.com/repositorio/iniciosesion/iniciar_sesion";
    
    $correo = $_POST["correo"];
    $password = $_POST["password"];

    $datos_post = json_encode(
        array(
            'correo'=>$correo,
            'password'=>$password
        )
    );

    $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($datos_post)
        ->send();

    /*echo "Respuesta: ";
    echo "<br><br>";
    echo $response->raw_body;
    echo "<br><br>";*/
    if(400 == $response->body->estado){
        header("Location: http://localhost/api.model3d.com/repositorio.phpclient/paginahtml/logsigIN.html");
    } else if(200 == $response->body->estado){
       session_start();
        $_SESSION["correo"] = $correo;
        /*$urls = "http://localhost/api.model3d.com/repositorio.phpclient/paginahtml/sessionon.php";
        $data = array('correo' => $correo);
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($urls, false, $context);*/
        header("Location: http://localhost/api.model3d.com/repositorio.phpclient/paginahtml/sessionon.php");
    } else if(404 == $response->body->estado){
        header("Location: http://localhost/api.model3d.com/repositorio.phpclient/paginahtml/logsigIN.html");
    }
}
?>