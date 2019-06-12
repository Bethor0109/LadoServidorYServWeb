<?php /*
include_once('httpful/httpful.phar'); 

$urlDatosUsuario = "localhost/api.model3d.com/api.repositorio.com/repositorio/obtenerinfousuario/obtener_info";
$urlRepositorios = "localhost/api.model3d.com/api.repositorio.com/repositorio/obtenerallrepos/repos_de_cuenta";

$datosUsuario = json_encode(
    array(
        'correo'=> "german@gmail.com"
    )
);

$datosRepos = json_encode(
    array(
        'id_cuenta'=> 1
    )
);

$responseUsuario = \Httpful\Request::post($urlDatosUsuario)
    ->sendsJson()
    ->body($datosUsuario)
    ->send();

$responseRepos = \Httpful\Request::post($urlRepositorios)
    ->sendsJson()
    ->body($datosRepos)
    ->send();

$date = date('Y-m-d');

$id = $responseUsuario->body->usuario->id_cuenta;
$name = $responseUsuario->body->usuario->nombre;
$lastname = $responseUsuario->body->usuario->apellido;

echo $responseUsuario;
echo $responseRepos;

<input name="nombre_rep" type="hidden" class="form-control" value="Sensor de temperatura">	
    <input name="fecha_ceacion" type="hidden" class="form-control" value="2019-05-31">	
*/
?>

<form action="../../reporte2/ex.php" method="POST">
    <input name="id_cuenta" type="hidden" value="1">						
    <input type="submit">
</form>