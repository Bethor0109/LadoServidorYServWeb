<?php

require_once 'utilidades/ConexionBD.php';

class contactos {

    const NOMBRE_TABLA = "contacto";
    const ID_CONTACTO = "idContacto";
    const PRIMER_NOMBRE = "primerNombre";
    const PRIMER_APELLIDO = "primerApellido";
    const TELEFONO = "telefono";
    const CORREO = "correo";
    const ID_USUARIO = "idUsuario";

    const ESTADO_ERROR = "Fallo";
    const ESTADO_ERROR_BD = "Erros de base de datos";
    const ESTADO_EXITO = "Eres un maquina, crack, fiera";
    const ESTADO_ERROR_PARAMETROS = "Los parametros introducidos son incorrectos";
    const ESTADO_NO_ENCONTRADO = "El contacto que buscas no existe";
    const CODIGO_EXITO = "La operacion fue realizada exitosamente";

    public static function get($peticion) {
        $idUsuario = usuarios::autorizar();

        if (empty($peticion[0]))
            return self::obtenerContactos($idUsuario);
        else
            return self::obtenerContactos($idUsuario, $peticion[0]);
    }

    public static function post($peticion)
    {
        $idUsuario = usuarios::autorizar();
    
        $body = file_get_contents('php://input');
        $contacto = json_decode($body);
    
        $idContacto = contactos::crear($idUsuario, $contacto);
    
        http_response_code(201);
        return [
            "estado" => self::CODIGO_EXITO,
            "mensaje" => "Contacto creado",
            "id" => $idContacto
        ];
    
    }

    public static function put($peticion) {
        $idUsuario = usuarios::autorizar();

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

    public static function delete($peticion) {
        $idUsuario = usuarios::autorizar();

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

    private function obtenerContactos($idUsuario, $idContacto = NULL) {
        try {
            if (!$idContacto) {
                $comando = "SELECT * FROM " . self::NOMBRE_TABLA .
                    " WHERE " . self::ID_USUARIO . "=?";
    
                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idUsuario
                $sentencia->bindParam(1, $idUsuario, PDO::PARAM_INT);
    
            } else {
                $comando = "SELECT * FROM " . self::NOMBRE_TABLA .
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

    private function crear($idUsuario, $contacto) {
        if ($contacto) {
            try {

                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

                // Sentencia INSERT
                $comando = "INSERT INTO " . self::NOMBRE_TABLA . " ( " .
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

    private function actualizar($idUsuario, $contacto, $idContacto) {
        try {
            // Creando consulta UPDATE
            $consulta = "UPDATE " . self::NOMBRE_TABLA .
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

    private function eliminar($idUsuario, $idContacto) {
        try {
            // Sentencia DELETE
            $comando = "DELETE FROM " . self::NOMBRE_TABLA .
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
}
?>