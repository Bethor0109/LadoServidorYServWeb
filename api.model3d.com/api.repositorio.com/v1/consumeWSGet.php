<?php
/**
 * Created by PhpStorm.
 * User: agesquivel
 * Date: 2019-05-03
 * Time: 18:22
 */

    $url = "http://localhost/api.peopleapp.com/v1/contactos";

    $opciones = array('http' =>
        array(
            'method' => 'GET',
            'max_redirects' => '0',
            'ignore_errors' => '1',
            'header'  => 'authorization: 863674b14e2b862e10bc6e3b733eb49b'
        )
    );

    $contexto = stream_context_create($opciones);
    $flujo = fopen($url, 'r', false, $contexto);

    // información de cabeceras y meta datos sobre el flujo
    echo "Metadatos: ";
    echo "<br>";
    var_dump(stream_get_meta_data($flujo));
    echo "<br>";

    // datos reales en $url
    echo "<br>Contenido de respuesta: ";
    echo "<br>";
    var_dump(stream_get_contents($flujo));

    fclose($flujo);
