<?php

require_once 'utilidades/ConexionBD.php';

class obtenerinfousuario {

    const NOMBRE_TABLA_1 = "usuarios";
    const NOMBRE_TABLA_2 = "cuenta";

    const CUENTA_ID_CUENTA = "id_cuenta";
    const CUENTA_CORREO = "correo";
    const CUENTA_PASSWORD = "password";
    const CUENTA_ID_USUARIO = "id_usuario";
    const CUENTA_ESTADO = "estado";

    const USUARIOS_NOMBRE = "nombre";
    const USUARIOS_APELLIDOS = "apellido";

    const ESTADO_ERROR = "Fallo";
    const ESTADO_ERROR_BD = "Erros de base de datos";
    const ESTADO_URL_INCORRECTA = "URL incorrecta";
    const ESTADO_EXITO = "200";
    const ESTADO_FALLA_DESCONOCIDA = "404";
    const ESTADO_PARAMETROS_INCORRECTOS = "Los parametros introducidos son incorrectos";
    const ESTADO_LOGIN_CORRECTO = "200";

    public static function post($peticion) {
        if ($peticion[0] == 'obtener_info') {
            return self::obtenerinfo();
        } else {
            throw new ExcepcionApi(self::ESTADO_URL_INCORRECTA, "Url mal formada", 400);
        }
    }

    private static function obtenerinfo() {
        $body = file_get_contents('php://input');
        $usuario = json_decode($body);

        $correo = $usuario->correo;

        if ($correo!=null) {
            $cuentaBD = self::obtenerInfoCuentaPorCorreo($correo);
            $usuarioBD = self::obtenernpUsuario($cuentaBD["id_usuario"]);
            if ($usuarioBD != NULL) {
                http_response_code(200);
                $respuesta["id_cuenta"] = $cuentaBD["id_cuenta"];
                $respuesta["nombre"] = $usuarioBD["nombre"];
                $respuesta["apellido"] = $usuarioBD["apellido"];
                return ["estado" => self::ESTADO_LOGIN_CORRECTO, "usuario" => $respuesta];
            } else {
                throw new ExcepcionApi(self::ESTADO_FALLA_DESCONOCIDA,
                    "Ha ocurrido un error");
            }
        } else {
            throw new ExcepcionApi(self::ESTADO_PARAMETROS_INCORRECTOS,
                utf8_encode("400"));

        }
    }

    private static function obtenerInfoCuentaPorCorreo($correo)
    {
        try {
            $comando = "SELECT " .
                self::CUENTA_ID_CUENTA . "," .
                self::CUENTA_ID_USUARIO .
                " FROM " . self::NOMBRE_TABLA_2 .
                " WHERE " . self::CUENTA_CORREO . "=?";
        
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
        
            $sentencia->bindParam(1, $correo);
        
            if ($sentencia->execute()){
                http_response_code(200);
                return $sentencia->fetch(PDO::FETCH_ASSOC);
            }  
            else
                return null;
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

    private static function obtenernpUsuario($id_usuario)
    {
        $comando = "SELECT " .
            self::USUARIOS_NOMBRE . "," .
            self::USUARIOS_APELLIDOS .
            " FROM " . self::NOMBRE_TABLA_1 .
            " WHERE " . self::CUENTA_ID_USUARIO . "=?";
    
        $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
    
        $sentencia->bindParam(1, $id_usuario);
    
        if ($sentencia->execute()){
            http_response_code(200);
            return $sentencia->fetch(PDO::FETCH_ASSOC);
        }
        else
            return null;
    }
}
?>