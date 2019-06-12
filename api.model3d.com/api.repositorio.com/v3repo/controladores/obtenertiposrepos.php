<?php

require_once '../utilidades/ConexionBD.php';

class obtenertiposrepos {

    const NOMBRE_TABLA = "tiporepositorio";

    const ESTADO_ERROR = "Fallo";
    const ESTADO_ERROR_BD = "Erros de base de datos";
    const ESTADO_EXITO = 200;
    const ESTADO_ERROR_PARAMETROS = "Los parametros introducidos son incorrectos";
    const ESTADO_NO_ENCONTRADO = "El contacto que buscas no existe o no introduciste una Id";
    const CODIGO_EXITO = "La operacion fue realizada exitosamente";

    public function tiposderepos($vacio) {
        $comando = "SELECT * FROM " . self::NOMBRE_TABLA;
        $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
        $sentencia->execute();
        $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
?>