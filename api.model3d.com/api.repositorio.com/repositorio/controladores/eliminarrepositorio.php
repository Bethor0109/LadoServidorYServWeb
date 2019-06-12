<?php

require_once 'utilidades/ConexionBD.php';

class eliminarrepositorio {

    const TABLA_REPOCON = "repositoriocontenido";
    const TABLA_CONTENIDO = "contenido";

    const REPOCON_ID_REPOSITORIO = "id_repositorio";
    /* 
    Este es el query pero no supe implementarlo xD :(
        SET @idrepo := 1;
        CREATE TEMPORARY TABLE contenidosid SELECT * FROM repositoriocontenido; 
        DELETE FROM repositoriocontenido WHERE id_repositorio = @idrepo;
        DELETE FROM contenido WHERE id_contenido IN (SELECT `id_contenido` AS 'all content id' FROM contenidosid WHERE id_repositorio = @idrepo GROUP BY id_contenido);
    */
    const ESTADO_ERROR = "Fallo";
    const ESTADO_ERROR_BD = "Erros de base de datos";
    const ESTADO_ERROR_PARAMETROS = "Los parametros introducidos son incorrectos";
    const CODIGO_EXITO = "La operacion fue realizada exitosamente";

    public static function post($peticion) {
        if ($peticion[0] == 'eliminar_repositorio') {
            return self::deleterepo();
        } else {
            throw new ExcepcionApi(self::ESTADO_URL_INCORRECTA, "Url mal formada", 400);
        }
    }

    public static function deleterepo() {
        $body = file_get_contents('php://input');
        $infocontent = json_decode($body);

        $id_contenido = $infocontent->{'id_contenido'};
        $id_repositorio = $infocontent->{'id_repositorio'};

        if (self::eliminar($id_contenido, $id_repositorio) > 0) {
            http_response_code(200);
            return [
                "estado" => self::CODIGO_EXITO,
                "mensaje" => "Registro eliminado correctamente"
            ];
        } else {
            throw new ExcepcionApi(self::ESTADO_NO_ENCONTRADO,
                "El contacto al que intentas acceder no existe", 404);
        }
    }

    private function eliminar($id_contenido, $id_repositorio) {
        try {
            // Sentencia DELETE
            $comando = "DELETE FROM " . self::TABLA_REPOCON .
                " WHERE " . self::REPOCON_ID_CONTENIDO . "=? AND " .
                self::REPOCON_ID_REPOSITORIO . "=?";
    
            // Preparar la sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
    
            $sentencia->bindParam(1, $id_contenido);
            $sentencia->bindParam(2, $id_repositorio);
    
            $sentencia->execute();
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/
            $comando = "DELETE FROM " . self::TABLA_CONTENIDO .
                " WHERE " . self::REPOCON_ID_CONTENIDO . "=?";
    
            // Preparar la sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
    
            $sentencia->bindParam(1, $id_contenido);
    
            $sentencia->execute();
    
            return $sentencia->rowCount();
    
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
}
?>