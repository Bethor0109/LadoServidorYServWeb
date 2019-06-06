<?php

require_once 'utilidades/ConexionBD.php';

class cambiarestadocuenta {

    const NOMBRE_TABLA = "cuenta";

    const CUENTA_ID_CUENTA = "id_cuenta";
    const CUENTA_ESTADO = "estado";

    const ESTADO_ERROR = "Fallo";
    const ESTADO_ERROR_BD = "Erros de base de datos";
    const ESTADO_ERROR_PARAMETROS = "Los parametros introducidos son incorrectos";
    const CODIGO_EXITO = "La operacion fue realizada exitosamente";

    public static function post($peticion) {
        if ($peticion[0] == 'cambiar_estado') {
            return self::cambioestado();
        } else {
            throw new ExcepcionApi(self::ESTADO_URL_INCORRECTA, "Url mal formada", 400);
        }
    }

    public static function cambioestado() {
        $body = file_get_contents('php://input');
        $infocuenta = json_decode($body);

        $id_cuenta = $infocuenta->{'id_cuenta'};
        $estado = $infocuenta->{'estado'};

        if (self::cambiarestado( $id_cuenta, $estado ) > 0) {
            http_response_code(200);
            return [
                "estado" => self::CODIGO_EXITO,
                "mensaje" => "Registro actualizado correctamente"
            ];
        } else {
            throw new ExcepcionApi(self::ESTADO_NO_ENCONTRADO,
                "El contacto al que intentas acceder no existe", 404);
        }
    }

    private function cambiarestado( $estado, $id_cuenta ) {
        try {
            // Creando consulta UPDATE
            $consulta = "UPDATE " . self::NOMBRE_TABLA .
                " SET " . self::CUENTA_ESTADO . "=?" .
                " WHERE " . self::CUENTA_ID_CUENTA . "=? ";
            // Preparar la sentencia

            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($consulta);
    
            $sentencia->bindParam(1, $id_cuenta);
            $sentencia->bindParam(2, $estado);
    
            //$id_cuenta = $infocuenta->id_cuenta;
            //$estado = $infocuenta->estado;
    
            // Ejecutar la sentencia
            $sentencia->execute();
    
            return $sentencia->rowCount();
    
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
}
?>