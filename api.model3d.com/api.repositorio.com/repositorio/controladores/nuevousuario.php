<?php

require_once 'utilidades/ConexionBD.php';

class nuevousuario {

    const NOMBRE_TABLA_1 = "usuarios";
    const NOMBRE_TABLA_2 = "cuenta";

    const USUARIO_NOMBRE = "nombre";
    const USUARIO_APELLIDO = "apellido";
    const USUARIO_FECHANAC = "fecha_na";

    const CUENTA_CORREO = "correo";
    const CUENTA_CONTRASENA = "password";
    const CUENTA_IDUSUARIO = "id_usuario";
    const CUENTA_ESTADO = "estado";

    const ESTADO_ERROR = "Fallo";
    const ESTADO_ERROR_BD = "Erros de base de datos";
    const ESTADO_ERROR_PARAMETROS = "Los parametros introducidos son incorrectos";
    const CODIGO_EXITO = "La operacion fue realizada exitosamente";

    public static function post($peticion) {
        if ($peticion[0] == 'nuevo_usuario') {
            return self::registrarusuario();
        } else {
            throw new ExcepcionApi(self::ESTADO_URL_INCORRECTA, "Url mal formada", 400);
        }
    }

    public static function registrarusuario()
    {
        //$cuerpo = file_get_contents('php://input');
        //$usuario = json_decode($cuerpo);
        
        //$idUsuario = usuarios::autorizar();
    
        $body = file_get_contents('php://input');
        $contenido = json_decode($body);
    
        $idContacto = nuevousuario::crear($contenido);
    
        http_response_code(201);
        return [
            "estado" => self::CODIGO_EXITO,
            "mensaje" => "Contacto creado",
            "id" => $idContacto
        ];
    
    }

    private function crear($contenido) {
        if ($contenido) {
            try {

                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

                // Sentencia INSERT
                $comando = "INSERT INTO " . self::NOMBRE_TABLA_1 . " ( " .
                    self::USUARIO_NOMBRE . "," .
                    self::USUARIO_APELLIDO . "," .
                    self::USUARIO_FECHANAC . ")" .
                    " VALUES(?,?,?)";

                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);

                $sentencia->bindParam(1, $nombre);
                $sentencia->bindParam(2, $apellido);
                $sentencia->bindParam(3, $fecha_na);


                $nombre = $contenido->nombre;
                $apellido = $contenido->apellido;
                $fecha_na = $contenido->fecha_na;

                $sentencia->execute();

                // Retornar en el último id insertado
                //return $pdo->lastInsertId();
/*------------*/$id_usuario =  $pdo->lastInsertId();
                $comando = "INSERT INTO " . self::NOMBRE_TABLA_2 . " ( " .
                    self::CUENTA_CORREO . "," .
                    self::CUENTA_CONTRASENA . "," .
                    self::CUENTA_IDUSUARIO . "," .
                    self::CUENTA_ESTADO . ")" .
                    " VALUES(?,?,?,?)";

                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);

                $sentencia->bindParam(1, $correo);
                $sentencia->bindParam(2, $password);
                $sentencia->bindParam(3, $id_usuario);
                $sentencia->bindParam(4, $estado);


                $correo = $contenido->correo;
                $password = $contenido->password;
                $estado = $contenido->estado;


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