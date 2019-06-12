<?php
require_once('controladores/lib/nusoap.php');
// Crear un cliente apuntando al script del servidor (Creado con WSDL)
$serverURL = 'http://localhost/api.model3d.com/api.repositorio.com/v3repo/controladores/servidorRepositorioSoap.php?wsdl';
$serverScript = 'servidorRepositorioSoap.php';

//$metodoALlamar = 'nuevousuario.registrarusuario';                   //SUCCESS
//$metodoALlamar = 'iniciosesion.iniciarsesion';                      //SUCCESS
//$metodoALlamar = 'nuevorepositorio.registrarrepositorio';           //SUCCESS
//$metodoALlamar = 'obtenerinfousuario.obtenerinfo';                  //SUCCESS
//$metodoALlamar = 'obtenerallrepos.allrepos';                        //SUCCESS
//$metodoALlamar = 'editarrepositorio.editarepositorio';              //SUCCESS
//$metodoALlamar = 'nuevocontenido.anadircontenido';                  //SUCCESS
//$metodoALlamar = 'cambiarestadocuenta.cambioestado';                //SUCCESS
//$metodoALlamar = 'eliminarcontenido.deletecontent';                 //SUCCESS
//$metodoALlamar = 'obtenertiposrepos.tiposderepos';                  //

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
    //||||||||||||||||||||||-REGISTRAR NUEVO USUARIO-|-nuevousuario.registrarusuario-|||||||||||||||||||||||||||||||||||||||||||||||||||||
    /*array(
        'nombre' => 'soap',
		'apellido' => 'service',
		'fecha_na' => '2019-05-31',
		'correo' => 'soap@gmail.com',
		'password' => '123',
		'estado' => '1'
    ),*/

    //||||||||||||||||||||||-INICIAR SESION-|-||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    //array('correo' => 'ita@gmail.com', 'password' => '123'),

    //||||||||||||||||||||||-CREAR UN NUEVO REPOSITORIO-|-||||||||||||||||||||||||||||||||||||||||||||||||||
    /*array(
        'nombre_rep' => 'mi repositorio',
		'id_tiporepositorio' => '4',
		'id_cuenta' => '9',
        'fecha_ceacion' => '2019-05-31'
    ),*/
    //||||||||||||||||||||||-OBTENER INFORMACION DEL USUARIO-|-|||||||||||||||||||||||||||||||||||||||||||||
    //array('correo' => 'ita@gmail.com'),

    //||||||||||||||||||||||-OBTENER TODOS LOS REPOSITORIOS DE MI CUENTA-|-|||||||||||||||||||||||||||||||||
    //array('id_cuenta' => 1),

    //||||||||||||||||||||||-EDITAR INFORMACION DE UN REPOSITORIO-|-||||||||||||||||||||||||||||||||||||||||
    /*array(
        'id_cuenta' => 9,
		'nombre_rep' => 'Recorrido ITCH',
		'id_repositorio' => 13,
		'id_tiporepositorio' => 2
    ),*/

    //||||||||||||||||||||||-AÑADIR CONTENIDO A MI REPOSITORIO-|-|||||||||||||||||||||||||||||||||||||||||||
    /*array(
        'url_archivo' => 'https://cdnb.artstation.com/p/assets/images/images/017/788/381/original/j-tuason-vintage-suit-body.gif?1557339267',
		'add_fecha' => '2019-06-05',
		'id_tipocontenido' => '2',
		'id_repositorio' => '1',
		'id_contenido' => '7'
    ),*/

    //||||||||||||||||||||||-DESHABILITAR O HABILITAR UNA CUENTA-||||||||||||||||||||||||||||||||||||||||||
    /*array(
        'id_cuenta' => 6,
        'estado' => 0
    ),*/

    //||||||||||||||||||||||-BORRAR CONTENITO DE MI REPOSITORIO-|||||||||||||||||||||||||||||||||||||||||||
    /*array(
        'id_contenido' => 7,
		'id_repositorio' => 1
    ),*/

    //||||||||||||||||||||||-OBTENER TODOS LOS TIPOS DE REPOSITORIOS QUE PUEDO CREAR-||||||||||||||||||||||
    //array('parametroVacio' => 'endlessvoid'),


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