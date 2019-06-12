<?php

require_once '../utilidades/ConexionBD.php';

class obtenerallrepos {

    const NOMBRE_TABLA = "repositorio";

    const REPOSITORIO_ID_CUENTA = "id_cuenta";

    const ESTADO_ERROR = "Fallo";
    const ESTADO_ERROR_BD = "Erros de base de datos";
    const ESTADO_EXITO = 200;
    const ESTADO_ERROR_PARAMETROS = "Los parametros introducidos son incorrectos";
    const ESTADO_NO_ENCONTRADO = "El contacto que buscas no existe o no introduciste una Id";
    const CODIGO_EXITO = "La operacion fue realizada exitosamente";
/*
    public static function post($peticion) {
        // Procesar post       
        if ($peticion[0] == 'repos_de_cuenta') {
            return self::allrepos();
        } else {
            throw new ExcepcionApi(self::ESTADO_URL_INCORRECTA, "Url mal formada", 400);
        }
    }
*/
    public static function allrepos($id_cuenta) {
        /*$cuerpo = file_get_contents('php://input');
        $usuario = json_decode($cuerpo);

        $id_cuenta = $usuario->id_cuenta;*/
        $datos = self::obtenerrepos($id_cuenta);
        
        return array('mensaje' => $datos);;
    }

    private function obtenerrepos($id_cuenta) {
        try {
            $comando = "SELECT * FROM " . self::NOMBRE_TABLA .
                " WHERE " . self::REPOSITORIO_ID_CUENTA . "=?";

            // Preparar sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
            // Ligar idUsuario
            $sentencia->bindParam(1, $id_cuenta, PDO::PARAM_INT);
    
            // Ejecutar sentencia preparada
            if ($sentencia->execute()) {
                //http_response_code(200);
                return $sentencia->fetchAll(PDO::FETCH_ASSOC);
            } else
                throw new ExcepcionApi(self::ESTADO_ERROR, "Se ha producido un error");
    
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
}
?>