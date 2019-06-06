<?php

require_once 'utilidades/ConexionBD.php';

class userContact{

//  ◤━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━◥
//  | Datos aplicables a ambas tablas |
//  ◣━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━◢
    const CORREO = "correo";
    const ID_USUARIO = "idUsuario";

//  ◤━━━━━━━━━━━━━━━━━━━━━━━━━━━━◥
//  | Datos de la tabla "usuario" |
//  ◣━━━━━━━━━━━━━━━━━━━━━━━━━━━━◢
    const TABLA_USER = "usuario";
    const NOMBRE = "nombre";
    const CONTRASENA = "contrasena";
    const CLAVE_API = "claveApi";

//  ◤━━━━━━━━━━━━━━━━━━━━━━━━━━━━━◥
//  | Datos de la tabla "contacto" |
//  ◣━━━━━━━━━━━━━━━━━━━━━━━━━━━━━◢  
    const TABLA_CONTACT = "contacto";
    const ID_CONTACTO = "idContacto";
    const PRIMER_NOMBRE = "primerNombre";
    const PRIMER_APELLIDO = "primerApellido";
    const TELEFONO = "telefono";

//  ◤━━━━━━━━━◥
//  | Mensajes |
//  ◣━━━━━━━━━◢  
    const ESTADO_URL_INCORRECTA = "URL incorrecta";
    const ESTADO_CREACION_EXITOSA = "Eres un maquina, crack, fiera";
    const ESTADO_CREACION_FALLIDA = "Creacion fallida";
    const ESTADO_FALLA_DESCONOCIDA = "Te topaste con una falla desconocida";
    const ESTADO_ERROR_BD = "Error con la base de datos";
    const ESTADO_PARAMETROS_INCORRECTOS = "Los parametros introducidos son incorrectos";
    const ESTADO_CLAVE_NO_AUTORIZADA = "La clave introducida no esta autorizada";
    const ESTADO_AUSENCIA_CLAVE_API = "No se introdujo una clave API";
    const ESTADO_LOGIN_CORRECTO = "Has entrado al sistema... hackerman";
    const ESTADO_ERROR = "Fallo";
    const ESTADO_EXITO = "Eres un maquina, crack, fiera";
    const ESTADO_ERROR_PARAMETROS = "Los parametros introducidos son incorrectos";
    const ESTADO_NO_ENCONTRADO = "El contacto que buscas no existe";
    const CODIGO_EXITO = "La operacion fue realizada exitosamente";
    const ESTADO_EXISTENCIA_RECURSO = "El recurso ya existe";
    const ESTADO_METODO_NO_PERMITIDO = "Ese metodo no es permitido";   
//  ▅▄▃▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁ METODOS ▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▂▃▄▅

//  ▂ ▃ ▄ ▅ ▆ ▇ █ GET █ ▇ ▆ ▅ ▄ ▃ ▂
    public static function get($peticion) {
        $idUsuario = self::autorizar();

        if (empty($peticion[0]))
            return self::obtenerContactos($idUsuario);
        else
            return self::obtenerContactos($idUsuario, $peticion[0]);
    }

//  ▂ ▃ ▄ ▅ ▆ ▇ █ POST █ ▇ ▆ ▅ ▄ ▃ ▂
    public static function post($peticion) {
        //◥◤╞═════ usuarios ═════╡◥◤
        if ($peticion[0] == 'registro') {
            return self::registrar();
        } else if ($peticion[0] == 'login') {
            return self::loguear();
        } else {
            throw new ExcepcionApi(self::ESTADO_URL_INCORRECTA, "Url mal formada", 400);
        }
        //◢◣╞═════ usuarios ═════╡◢◣

        //◥◤╞═════ contactos ═════╡◥◤
        $idUsuario = self::autorizar();
    
        $body = file_get_contents('php://input');
        $contacto = json_decode($body);
    
        $idContacto = self::crearC($idUsuario, $contacto);
    
        http_response_code(201);
        return [
            "estado" => self::CODIGO_EXITO,
            "mensaje" => "Contacto creado",
            "id" => $idContacto
        ];
        //◢◣╞═════ contactos ═════╡◢◣
    }

//  ▂ ▃ ▄ ▅ ▆ ▇ █ PUT █ ▇ ▆ ▅ ▄ ▃ ▂
    public static function put($peticion) {
        $idUsuario = self::autorizar();

        if (!empty($peticion[0])) {
            $body = file_get_contents('php://input');
            $contacto = json_decode($body);
    
            if (self::actualizar($idUsuario, $contacto, $peticion[0]) > 0) {
                http_response_code(200);
                return [
                    "estado" => self::CODIGO_EXITO,
                    "mensaje" => "Registro actualizado correctamente"
                ];
            } else {
                throw new ExcepcionApi(self::ESTADO_NO_ENCONTRADO,
                    "El contacto al que intentas acceder no existe", 404);
            }
        } else {
            throw new ExcepcionApi(self::ESTADO_ERROR_PARAMETROS, "Falta id", 422);
        }
    }   

//  ▂ ▃ ▄ ▅ ▆ ▇ █ DELETE █ ▇ ▆ ▅ ▄ ▃ ▂
    public static function delete($peticion) {
        $idUsuario = self::autorizar();

        if (!empty($peticion[0])) {
            if (self::eliminar($idUsuario, $peticion[0]) > 0) {
                http_response_code(200);
                return [
                    "estado" => self::CODIGO_EXITO,
                    "mensaje" => "Registro eliminado correctamente"
                ];
            } else {
                throw new ExcepcionApi(self::ESTADO_NO_ENCONTRADO,
                    "El contacto al que intentas acceder no existe", 404);
            }
        } else {
            throw new ExcepcionApi(self::ESTADO_ERROR_PARAMETROS, "Falta id", 422);
        }
    }
//  ▅▄▃▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁ FUNCIONES CONTACTOS ▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▂▃▄▅

//  ▂ ▃ ▄ ▅ ▆ ▇ █ obtenerContactos █ ▇ ▆ ▅ ▄ ▃ ▂
    private function obtenerContactos($idUsuario, $idContacto = NULL) {
        try {
            if (!$idContacto) {
                $comando = "SELECT * FROM " . self::TABLA_CONTACT .
                    " WHERE " . self::ID_USUARIO . "=?";

                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idUsuario
                $sentencia->bindParam(1, $idUsuario, PDO::PARAM_INT);

            } else {
                $comando = "SELECT * FROM " . self::TABLA_CONTACT .
                    " WHERE " . self::ID_CONTACTO . "=? AND " .
                    self::ID_USUARIO . "=?";

                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idContacto e idUsuario
                $sentencia->bindParam(1, $idContacto, PDO::PARAM_INT);
                $sentencia->bindParam(2, $idUsuario, PDO::PARAM_INT);
            }

            // Ejecutar sentencia preparada
            if ($sentencia->execute()) {
                http_response_code(200);
                return
                    [
                        "estado" => self::ESTADO_EXITO,
                        "datos" => $sentencia->fetchAll(PDO::FETCH_ASSOC)
                    ];
            } else
                throw new ExcepcionApi(self::ESTADO_ERROR, "Se ha producido un error");

        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
//  ▂ ▃ ▄ ▅ ▆ ▇ █ crearC █ ▇ ▆ ▅ ▄ ▃ ▂
    private function crearC($idUsuario, $contacto) {
        if ($contacto) {
            try {

                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

                // Sentencia INSERT
                $comando = "INSERT INTO " . self::TABLA_CONTACT . " ( " .
                    self::PRIMER_NOMBRE . "," .
                    self::PRIMER_APELLIDO . "," .
                    self::TELEFONO . "," .
                    self::CORREO . "," .
                    self::ID_USUARIO . ")" .
                    " VALUES(?,?,?,?,?)";

                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);

                $sentencia->bindParam(1, $primerNombre);
                $sentencia->bindParam(2, $primerApellido);
                $sentencia->bindParam(3, $telefono);
                $sentencia->bindParam(4, $correo);
                $sentencia->bindParam(5, $idUsuario);


                $primerNombre = $contacto->primerNombre;
                $primerApellido = $contacto->primerApellido;
                $telefono = $contacto->telefono;
                $correo = $contacto->correo;

                $sentencia->execute();

                // Retornar en el último id insertado
                return $pdo->lastInsertId();

            } catch (PDOException $e) {
                throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
            }
        } else {
            throw new ExcepcionApi(
                self::ESTADO_ERROR_PARAMETROS, 
                utf8_encode("Error en existencia o sintaxis de parámetros"));
        }
    }
//  ▂ ▃ ▄ ▅ ▆ ▇ █ actualizar █ ▇ ▆ ▅ ▄ ▃ ▂
    private function actualizar($idUsuario, $contacto, $idContacto) {
        try {
            // Creando consulta UPDATE
            $consulta = "UPDATE " . self::TABLA_CONTACT .
                " SET " . self::PRIMER_NOMBRE . "=?," .
                self::PRIMER_APELLIDO . "=?," .
                self::TELEFONO . "=?," .
                self::CORREO . "=? " .
                " WHERE " . self::ID_CONTACTO . "=? AND " . self::ID_USUARIO . "=?";
    
            // Preparar la sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($consulta);
    
            $sentencia->bindParam(1, $primerNombre);
            $sentencia->bindParam(2, $primerApellido);
            $sentencia->bindParam(3, $telefono);
            $sentencia->bindParam(4, $correo);
            $sentencia->bindParam(5, $idContacto);
            $sentencia->bindParam(6, $idUsuario);
    
            $primerNombre = $contacto->primerNombre;
            $primerApellido = $contacto->primerApellido;
            $telefono = $contacto->telefono;
            $correo = $contacto->correo;
    
            // Ejecutar la sentencia
            $sentencia->execute();
    
            return $sentencia->rowCount();
    
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
//  ▂ ▃ ▄ ▅ ▆ ▇ █ eliminar █ ▇ ▆ ▅ ▄ ▃ ▂
    private function eliminar($idUsuario, $idContacto) {
        try {
            // Sentencia DELETE
            $comando = "DELETE FROM " . self::TABLA_CONTACT .
                " WHERE " . self::ID_CONTACTO . "=? AND " .
                self::ID_USUARIO . "=?";
    
            // Preparar la sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
    
            $sentencia->bindParam(1, $idContacto);
            $sentencia->bindParam(2, $idUsuario);
    
            $sentencia->execute();
    
            return $sentencia->rowCount();
    
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

//  ▅▄▃▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁ FUNCIONES USUARIOS ▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▂▃▄▅
//  ▂ ▃ ▄ ▅ ▆ ▇ █ crearU █ ▇ ▆ ▅ ▄ ▃ ▂
    private function crearU($datosUsuario) {
        $nombre = $datosUsuario->nombre;

        $contrasena = $datosUsuario->contrasena;
        $contrasenaEncriptada = self::encriptarContrasena($contrasena);

        $correo = $datosUsuario->correo;

        $claveApi = self::generarClaveApi();

        try {

            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Sentencia INSERT
            $comando = "INSERT INTO " . self::TABLA_USER . " ( " .
                self::NOMBRE . "," .
                self::CONTRASENA . "," .
                self::CLAVE_API . "," .
                self::CORREO . ")" .
                " VALUES(?,?,?,?)";

            $sentencia = $pdo->prepare($comando);

            $sentencia->bindParam(1, $nombre);
            $sentencia->bindParam(2, $contrasenaEncriptada);
            $sentencia->bindParam(3, $claveApi);
            $sentencia->bindParam(4, $correo);

            $resultado = $sentencia->execute();

            if ($resultado) {
                return self::ESTADO_CREACION_EXITOSA;
            } else {
                return self::ESTADO_CREACION_FALLIDA;
            }
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

//  ▂ ▃ ▄ ▅ ▆ ▇ █ encriptarContrasena █ ▇ ▆ ▅ ▄ ▃ ▂
    private function encriptarContrasena($contrasenaPlana) {
        if ($contrasenaPlana)
            return password_hash($contrasenaPlana, PASSWORD_DEFAULT);
        else return null;
    }

//  ▂ ▃ ▄ ▅ ▆ ▇ █ generarClaveApi █ ▇ ▆ ▅ ▄ ▃ ▂
    private function generarClaveApi() {
        return md5(microtime().rand());
    }

//  ▂ ▃ ▄ ▅ ▆ ▇ █ registrar █ ▇ ▆ ▅ ▄ ▃ ▂
    private function registrar() {
        $cuerpo = file_get_contents('php://input');
        $usuario = json_decode($cuerpo);

        $resultado = self::crearU($usuario);

        switch ($resultado) {
            case self::ESTADO_CREACION_EXITOSA:
                http_response_code(200);
                return
                    [
                        "estado" => self::ESTADO_CREACION_EXITOSA,
                        "mensaje" => utf8_encode("¡Registro con éxito!")
                    ];
                break;
            case self::ESTADO_CREACION_FALLIDA:
                throw new ExcepcionApi(self::ESTADO_CREACION_FALLIDA, "Ha ocurrido un error");
                break;
            default:
                throw new ExcepcionApi(self::ESTADO_FALLA_DESCONOCIDA, "Falla desconocida", 400);
        }
    }

//  ▂ ▃ ▄ ▅ ▆ ▇ █ loguear █ ▇ ▆ ▅ ▄ ▃ ▂
    private function loguear() {
        $respuesta = array();

        $body = file_get_contents('php://input');
        $usuario = json_decode($body);

        $correo = $usuario->correo;
        $contrasena = $usuario->contrasena;

        if (self::autenticar($correo, $contrasena)) {
            $usuarioBD = self::obtenerUsuarioPorCorreo($correo);

            if ($usuarioBD != NULL) {
                http_response_code(200);
                $respuesta["nombre"] = $usuarioBD["nombre"];
                $respuesta["correo"] = $usuarioBD["correo"];
                $respuesta["claveApi"] = $usuarioBD["claveApi"];
                return ["estado" => self::ESTADO_LOGIN_CORRECTO, "usuario" => $respuesta];
            } else {
                throw new ExcepcionApi(self::ESTADO_FALLA_DESCONOCIDA,
                    "Ha ocurrido un error");
            }
        } else {
            throw new ExcepcionApi(self::ESTADO_PARAMETROS_INCORRECTOS,
                utf8_encode("Correo o contraseña inválidos"));
        }
    }

//  ▂ ▃ ▄ ▅ ▆ ▇ █ autenticar █ ▇ ▆ ▅ ▄ ▃ ▂
    private function autenticar($correo, $contrasena)
    {
        $comando = "SELECT contrasena FROM " . self::TABLA_USER .
            " WHERE " . self::CORREO . "=?";

        try {

            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);

            $sentencia->bindParam(1, $correo);

            $sentencia->execute();

            if ($sentencia) {
                $resultado = $sentencia->fetch();

                if (self::validarContrasena($contrasena, $resultado['contrasena'])) {
                    return true;
                } else return false;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

//  ▂ ▃ ▄ ▅ ▆ ▇ █ validarContrasena █ ▇ ▆ ▅ ▄ ▃ ▂
    private function validarContrasena($contrasenaPlana, $contrasenaHash)
    {
        return password_verify($contrasenaPlana, $contrasenaHash);
    }

//  ▂ ▃ ▄ ▅ ▆ ▇ █ obtenerUsuarioPorCorreo █ ▇ ▆ ▅ ▄ ▃ ▂
    private function obtenerUsuarioPorCorreo($correo)
    {
        $comando = "SELECT " .
            self::NOMBRE . "," .
            self::CONTRASENA . "," .
            self::CORREO . "," .
            self::CLAVE_API .
            " FROM " . self::TABLA_USER .
            " WHERE " . self::CORREO . "=?";

        $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);

        $sentencia->bindParam(1, $correo);

        if ($sentencia->execute())
            return $sentencia->fetch(PDO::FETCH_ASSOC);
        else
            return null;
    }

//  ▂ ▃ ▄ ▅ ▆ ▇ █ validarClaveApi █ ▇ ▆ ▅ ▄ ▃ ▂
    private function validarClaveApi($claveApi)
    {
        $comando = "SELECT COUNT(" . self::ID_USUARIO . ")" .
            " FROM " . self::TABLA_USER .
            " WHERE " . self::CLAVE_API . "=?";

        $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);

        $sentencia->bindParam(1, $claveApi);

        $sentencia->execute();

        return $sentencia->fetchColumn(0) > 0;
    }

//  ▂ ▃ ▄ ▅ ▆ ▇ █ obtenerIdUsuario █ ▇ ▆ ▅ ▄ ▃ ▂
    private function obtenerIdUsuario($claveApi)
    {
        $comando = "SELECT " . self::ID_USUARIO .
            " FROM " . self::TABLA_USER .
            " WHERE " . self::CLAVE_API . "=?";

        $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);

        $sentencia->bindParam(1, $claveApi);

        if ($sentencia->execute()) {
            $resultado = $sentencia->fetch();
            return $resultado['idUsuario'];
        } else
            return null;
    }

//  ▂ ▃ ▄ ▅ ▆ ▇ █ autorizar █ ▇ ▆ ▅ ▄ ▃ ▂   
    public static function autorizar()
    {
        $cabeceras = apache_request_headers();

        if (isset($cabeceras["authorization"])) {

            $claveApi = $cabeceras["authorization"];

            if (self::validarClaveApi($claveApi)) {
                return self::obtenerIdUsuario($claveApi);
            } else {
                throw new ExcepcionApi(
                    self::ESTADO_CLAVE_NO_AUTORIZADA, "Clave de API no autorizada", 401);
            }

        } else {
            throw new ExcepcionApi(
                self::ESTADO_AUSENCIA_CLAVE_API,
                utf8_encode("Se requiere Clave del API para autenticación"));
        }
    }
}
?>