<?php
/**
 * Created by PhpStorm.
 * User: agesquivel
 * Date: 2019-05-03
 * Time: 18:22
 */

    include_once('httpful/httpful.phar');

    $url = "http://localhost/api.peopleapp.com333/v3repo/contactos/contactos_todos";

    $response = \Httpful\Request::post($url)
        ->addHeader('authorization', '4b2778fbbd23666354a92bad832452f8')
        ->send();

    echo "Respuesta: ";
    echo "<br><br>";
    if ($response->hasBody()) {
        echo $response->raw_body;
    }
    else {
        $response;
    }
    echo "<br><br>";

    echo "Metadatos: ";
    echo "<br><br>";
    echo var_dump($response->meta_data);
    echo "<br>";
