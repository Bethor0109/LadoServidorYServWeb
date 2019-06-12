<?php
/**
 * Created by PhpStorm.
 * User: agesquivel
 * Date: 2019-05-03
 * Time: 18:22
 */

    include_once('httpful/httpful.phar');

    $url = "http://localhost/api.peopleapp.com/v1/contactos";

    $response = \Httpful\Request::get($url)
        ->addHeader('authorization', '863674b14e2b862e10bc6e3b733eb49b')
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
