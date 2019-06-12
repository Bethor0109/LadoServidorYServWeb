<?php

require_once 'utilidades/ConexionBD.php';

class obtenerallrepos {

    const NOMBRE_TABLA = "repositorio";

    const REPOSITORIO_ID_CUENTA = "id_cuenta";

    const ESTADO_ERROR = "Fallo";
    const ESTADO_ERROR_BD = "Erros de base de datos";
    const ESTADO_EXITO = 200;

    public function obtenerrepos($id_cuenta) {
        try {
            $comando = "SELECT * FROM " . self::NOMBRE_TABLA .
                " WHERE " . self::REPOSITORIO_ID_CUENTA . "=?";

            // Preparar sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
            // Ligar idUsuario
            $sentencia->bindParam(1, $id_cuenta, PDO::PARAM_INT);

            // Ejecutar sentencia preparada
            if ($sentencia->execute()) {           
                http_response_code(200);
                $mydata = self::imprimir($sentencia->fetchAll(PDO::FETCH_ASSOC));
                //echo $mydata;   
                //return "respuesta";
            } else
                throw new ExcepcionApi(self::ESTADO_ERROR, "Se ha producido un error");
    
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
    public function imprimir($cuerpo)
    {
        header('Content-Type: text/xml');

        $xml = new SimpleXMLElement('<respuesta/>');
        self::parsearArreglo($cuerpo, $xml);
        print $xml->asXML();

        exit;
    }
    public function parsearArreglo($data, &$xml_data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'item' . $key;
                }
                $subnode = $xml_data->addChild($key);
                self::parsearArreglo($value, $subnode);
            } else {
                $xml_data->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }
}
?>