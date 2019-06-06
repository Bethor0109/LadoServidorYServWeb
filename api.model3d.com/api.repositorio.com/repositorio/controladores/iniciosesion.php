<?php

require_once 'utilidades/ConexionBD.php';


class iniciosesion {

    const NOMBRE_TABLA = "cuenta";

    const CUENTA_CORREO = "correo";
    const CUENTA_CONTRASENA = "password";

    const CUENTA_ACTIVA = 1;

    const ESTADO_ERROR = "Fallo";
    const ESTADO_ERROR_BD = "Erros de base de datos";
    const ESTADO_URL_INCORRECTA = "URL incorrecta";
    const ESTADO_FALLA_DESCONOCIDA = "404";
    const ESTADO_PARAMETROS_INCORRECTOS = "Los parametros introducidos son incorrectos";
    const ESTADO_LOGIN_CORRECTO = "200";

    public static function post($peticion) {
        if ($peticion[0] == 'iniciar_sesion') {
            return self::iniciarsesion();
        } else {
            throw new ExcepcionApi(self::ESTADO_URL_INCORRECTA, "Url mal formada", 400);
        }
    }

    private function iniciarsesion() {
        $respuesta = array();

        $body = file_get_contents('php://input');
        $usuario = json_decode($body);

        $correo = $usuario->correo;
        $password = $usuario->password;

        if (self::autenticar($correo, $password)) {
            $usuarioBD = self::obtenerUsuarioPorCorreo($correo);
            if ($usuarioBD != NULL) {
                http_response_code(200);
                $respuesta["correo"] = $usuarioBD["correo"];
                $respuesta["password"] = $usuarioBD["password"];
                return ["estado" => self::ESTADO_LOGIN_CORRECTO, "cuenta" => $respuesta];
            } else {
                throw new ExcepcionApi(self::ESTADO_FALLA_DESCONOCIDA,
                    "Ha ocurrido un error");
            }
        } else {
            throw new ExcepcionApi(self::ESTADO_PARAMETROS_INCORRECTOS,
                utf8_encode("400"));

        }
    }

    private function obtenerUsuarioPorCorreo($correo)
    {
        $comando = "SELECT " .
            self::CUENTA_CONTRASENA . "," .
            self::CUENTA_CORREO .
            " FROM " . self::NOMBRE_TABLA .
            " WHERE " . self::CUENTA_CORREO . "=?";
    
        $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
    
        $sentencia->bindParam(1, $correo);
    
        if ($sentencia->execute())
            return $sentencia->fetch(PDO::FETCH_ASSOC);
        else
            return null;
    }

    private function autenticar($password, $correo)
    {
        $comando = "SELECT password, estado FROM " . self::NOMBRE_TABLA .
            " WHERE " . self::CUENTA_CORREO . " =?";
        try {
    
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);

            $sentencia->bindParam(1, $password);
    
            $sentencia->execute();
            if ($sentencia) {
                $resultado = $sentencia->fetch();
                if (self::CUENTA_ACTIVA == $resultado['estado']){
                    return true;
                }else{
                    echo "No es posible acceder a la cuenta especificada, por favor contacte al sevicio de ayuda";
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
/*
    private function validarContrasena($contrasenaPlana, $contrasenaHash)
    {
        $contrasenaPlana == $contrasenaHash ? true : false;
    }*/
}
?>