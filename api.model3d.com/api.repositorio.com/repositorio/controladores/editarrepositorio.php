<?php

require_once 'utilidades/ConexionBD.php';

class editarrepositorio {

    const NOMBRE_TABLA = "repositorio";

    const REPOSITORIO_ID_CUENTA = "id_cuenta";
    const REPOSITORIO_NOMBRE = "nombre_rep";
    const REPOSITORIO_ID_REPOSITORIO = "id_repositorio";
    const REPOSITORIO_TIPO_REPOSITORIO = "id_tiporepositorio";

    const ESTADO_ERROR = "Fallo";
    const ESTADO_ERROR_BD = "Erros de base de datos";
    const ESTADO_ERROR_PARAMETROS = "Los parametros introducidos son incorrectos";
    const CODIGO_EXITO = "La operacion fue realizada exitosamente";
    const ESTADO_NO_ENCONTRADO = "No se que significa esto pero lo pedia";

    public static function post($peticion) {
        if ($peticion[0] == 'editar_repositorio') {
            return self::editarepositorio();
        } else {
            throw new ExcepcionApi(self::ESTADO_URL_INCORRECTA, "Url mal formada", 400);
        }
    }

    public static function editarepositorio() {
        $body = file_get_contents('php://input');
        $repositorio = json_decode($body);

        $id_cuenta = $repositorio->{'id_cuenta'};
        $nombre_rep = $repositorio->{'nombre_rep'};
        $id_repositorio = $repositorio->{'id_repositorio'};
        $id_tiporepositorio = $repositorio->{'id_tiporepositorio'};

        if (self::actualizarRepo( $id_cuenta, $nombre_rep, $id_repositorio, $id_tiporepositorio, $repositorio ) > 0) {
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

    private function actualizarRepo( $id_cuenta, $id_repositorio, $nombre_rep, $id_tiporepositorio, $repositorio ) {
        try {
            // Creando consulta UPDATE
            $consulta = "UPDATE " . self::NOMBRE_TABLA .
                " SET " . self::REPOSITORIO_NOMBRE . "=?" . "," . self::REPOSITORIO_TIPO_REPOSITORIO . "=?" .
                " WHERE " . self::REPOSITORIO_ID_CUENTA . "=? AND " . self::REPOSITORIO_ID_REPOSITORIO . "=? ";
            // Preparar la sentencia

            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($consulta);
    
            $sentencia->bindParam(1, $nombre_rep);
            $sentencia->bindParam(2, $id_tiporepositorio);
            $sentencia->bindParam(3, $id_cuenta);
            $sentencia->bindParam(4, $id_repositorio);
    
            $id_cuenta = $repositorio->id_cuenta;
            $id_repositorio = $repositorio->id_repositorio;
            $nombre_rep = $repositorio->nombre_rep;
            $id_tiporepositorio = $repositorio->id_tiporepositorio;
    
            // Ejecutar la sentencia
            $sentencia->execute();
    
            return $sentencia->rowCount();
    
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
}
?>