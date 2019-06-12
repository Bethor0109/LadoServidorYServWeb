<?php

require_once '../utilidades/ConexionBD.php';

class nuevocontenido {

    const TABLA_CONTENIDO = "contenido";
    const TABLA_REPOSITORIO = "repositorio";
    const TABLA_REPOCONTE = "repositoriocontenido";

    const CONTENIDO_URL = "url_archivo";
    const CONTENIDO_DATE = "add_fecha";
    const CONTENIDO_ID_TIPOCONTENIDO = "id_tipocontenido";


    const CONTENIDO_ID_CONTENIDO = "id_contenido";
    const REPOSITORIO_ID_REPOSITORIO = "id_repositorio";

    const ESTADO_ERROR = "Fallo";
    const ESTADO_ERROR_BD = "Erros de base de datos";
    const ESTADO_ERROR_PARAMETROS = "Los parametros introducidos son incorrectos";
    const CODIGO_EXITO = "La operacion fue realizada exitosamente";
/*
    public static function post($peticion) {
        if ($peticion[0] == 'nuevo_contenido') {
            return self::anadircontenido();
        } else {
            throw new ExcepcionApi(self::ESTADO_URL_INCORRECTA, "Url mal formada", 400);
        }
    }
*/
    public static function anadircontenido($url_archivo,$add_fecha,$id_tipocontenido,$id_repositorio,$id_contenido)
    {
        /*$body = file_get_contents('php://input');
        $contenido = json_decode($body);

        $resultado = nuevocontenido::newcontent($contenido);
    */
        //$contenido = [$url_archivo,$add_fecha,$id_tipocontenido,$id_repositorio,$id_contenido];
        nuevocontenido::newcontent($url_archivo,$add_fecha,$id_tipocontenido,$id_repositorio,$id_contenido);
        //http_response_code(201);
        return "Funciono";/*[
            "estado" => self::CODIGO_EXITO,
            "mensaje" => "Contacto creado",
            "resultado" => $resultado
        ];*/
    
    }

    private function newcontent($url_archivo,$add_fecha,$id_tipocontenido,$id_repositorio,$id_contenido) {

            try {
                
                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

                // Sentencia INSERT
                $comando = "INSERT INTO " . self::TABLA_CONTENIDO . " ( " .
                    self::CONTENIDO_URL . "," .
                    self::CONTENIDO_DATE . "," .
                    self::CONTENIDO_ID_TIPOCONTENIDO . ")" .
                    " VALUES(?,?,?)";

                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);

                $sentencia->bindParam(1, $url_archivo);
                $sentencia->bindParam(2, $add_fecha);
                $sentencia->bindParam(3, $id_tipocontenido);


                $sentencia->execute();

                // Retornar en el último id insertado
                //return $pdo->lastInsertId();
/*------------*/$id_contenido =  $pdo->lastInsertId();

                $comando = "INSERT INTO " . self::TABLA_REPOCONTE . " ( " .
                    self::REPOSITORIO_ID_REPOSITORIO . "," .
                    self::CONTENIDO_ID_CONTENIDO . ")" .
                    " VALUES(?,?)";

                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);

                $sentencia->bindParam(1, $id_repositorio);
                $sentencia->bindParam(2, $id_contenido);

                $sentencia->execute();
                
            } catch (PDOException $e) {
                throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
            }

    }
}
?>