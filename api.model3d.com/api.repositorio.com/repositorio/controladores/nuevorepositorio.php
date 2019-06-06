<?php

require_once 'utilidades/ConexionBD.php';

class nuevorepositorio {

    const NOMBRE_TABLA = "repositorio";

    const REPOSITORIO_ID_CUENTA = "id_cuenta";
    const REPOSITORIO_NOMBRE = "nombre_rep";
    const REPOSITORIO_DATE = "fecha_ceacion";

    const ESTADO_ERROR = "Fallo";
    const ESTADO_ERROR_BD = "Erros de base de datos";
    const ESTADO_ERROR_PARAMETROS = "Los parametros introducidos son incorrectos";
    const CODIGO_EXITO = "La operacion fue realizada exitosamente";

    public static function post($peticion) {
        if ($peticion[0] == 'nuevo_repositorio') {
            return self::registrarrepositorio();
        } else {
            throw new ExcepcionApi(self::ESTADO_URL_INCORRECTA, "Url mal formada", 400);
        }
    }

    public static function registrarrepositorio()
    {
        $body = file_get_contents('php://input');
        $repositorio = json_decode($body);

        $resultado = nuevorepositorio::crearrepositorio($repositorio);
    
        http_response_code(201);
        return [
            "estado" => self::CODIGO_EXITO,
            "mensaje" => "Contacto creado",
            "resultado" => $resultado
        ];
    
    }

    private function crearrepositorio($contenido) {
        if ($contenido) {
            try {
                
                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

                // Sentencia INSERT
                $comando = "INSERT INTO " . self::NOMBRE_TABLA . " (" .
                    self::REPOSITORIO_NOMBRE . ", " .
                    self::REPOSITORIO_ID_CUENTA . ", " .
                    self::REPOSITORIO_DATE . ")" .
                    " VALUES (?,?,?)";
                    
                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);

                $sentencia->bindParam(1, $nombre_rep);
                $sentencia->bindParam(2, $id_cuenta);
                $sentencia->bindParam(3, $fecha_ceacion);

                $nombre_rep = $contenido->nombre_rep;
                $id_cuenta = $contenido->id_cuenta;             
                $fecha_ceacion = $contenido->fecha_ceacion;

                $sentencia->execute();
                
            } catch (PDOException $e) {
                throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
            }
        } else {
            throw new ExcepcionApi(
                self::ESTADO_ERROR_PARAMETROS, 
                utf8_encode("Error en existencia o sintaxis de parámetros"));
        }

    }
}
?>