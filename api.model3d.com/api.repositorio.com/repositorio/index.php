<?php

require_once 'controladores/nuevousuario.php';
require_once 'controladores/iniciosesion.php';
require_once 'controladores/nuevorepositorio.php';
require_once 'controladores/obtenerinfousuario.php';
require_once 'controladores/obtenerallrepos.php';
require_once 'controladores/editarrepositorio.php';
require_once 'controladores/nuevocontenido.php';
require_once 'controladores/cambiarestadocuenta.php';
require_once 'controladores/eliminarcontenido.php';
require_once 'controladores/obtenertiposrepos.php';

//require_once 'vistas/VistaXML.php';
require_once 'vistas/VistaJson.php';
require_once 'utilidades/ExcepcionApi.php';

// Constantes de estado
const ESTADO_EXISTENCIA_RECURSO = "El recurso que buscas no se encuentra";
const ESTADO_METODO_NO_PERMITIDO = "El metodo que intentas usar no esta permitido";

$vista = new VistaJson();
//$vista = new VistaXML();

set_exception_handler(function ($exception) use ($vista) {
    $cuerpo = array(
        "estado" => $exception->estado,
        "mensaje" => $exception->getMessage()
    );
    if ($exception->getCode()) {
        $vista->estado = $exception->getCode();
    } else {
        $vista->estado = 500;
    }

    $vista->imprimir($cuerpo);
}
);

// Extraer segmento de la url
if (isset($_GET['PATH_INFO']))
    $peticion = explode('/', $_GET['PATH_INFO']);
else
    throw new ExcepcionApi(ESTADO_URL_INCORRECTA, utf8_encode("No se reconoce la petición"));

// Obtener recurso
$recurso = array_shift($peticion);
$recursos_existentes = array( 
    'nuevousuario', 
    'iniciosesion', 
    'nuevorepositorio', 
    'obtenerinfousuario', 
    'obtenerallrepos',
    'editarrepositorio',
    'nuevocontenido',
    'cambiarestadocuenta',
    'eliminarcontenido',
    'obtenertiposrepos'
);

// Comprobar si existe el recurso
if (!in_array($recurso, $recursos_existentes)) {
    throw new ExcepcionApi(ESTADO_EXISTENCIA_RECURSO,
        "No se reconoce el recurso al que intentas acceder");
}

$metodo = strtolower($_SERVER['REQUEST_METHOD']);

switch ($metodo) {
    case 'post':
        if (method_exists($recurso, $metodo)) {
            $respuesta = call_user_func(array($recurso, $metodo), $peticion);
            $vista->imprimir($respuesta);
            // Procesar método delete
            break;
        }

    default:
        // Método no aceptado
        $vista->estado = 405;
        $cuerpo = [
            "estado" => ESTADO_METODO_NO_PERMITIDO,
            "mensaje" => utf8_encode("Método no permitido")
        ];
        $vista->imprimir($cuerpo);
}
?>