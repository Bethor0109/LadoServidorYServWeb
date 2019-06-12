<?php
require_once "lib/nusoap.php";
require_once 'obtenerallrepos.php';

$server = new soap_server();

$server->configureWSDL('hellowsdl2', 'urn:hellowsdl2');

// Parametros de entrada
$server->wsdl->addComplexType(
    'Person',
    'complexType',
    'struct',
    'all',
    "",
    array(
        'id_cuenta' => array('name' => 'id_cuenta', 'type' => 'xsd:int')
    )
);
// Parametros de salida
$server->wsdl->addComplexType(
    'SweepstakesGreeting',
    'complexType',
    'struct',
    'all',
    "",
    array(
        'greeting' => array('name' => 'greeting', 'type' => 'xsd:string')
    )
);

$server->register('hello', // method name
    array('person' => 'tns:Person'), // input parameters
    array('return' => 'tns:SweepstakesGreeting'), // output parameters
    'urn:hellowsdl2', // namespace
    'urn:hellowsdl2#hello', // soapaction
    'rpc', // style
    'encoded', // use
    'Greet a person entering the sweepstakes' // documentation
);

function hello($person)
{
    //$todosrepos = obtenerallrepos.obtenerrepos($person['id_cuenta']);
    $repos = new obtenerallrepos();
    $id = $person['id_cuenta'];
    $repos->obtenerrepos($id);

    //print_r($repos);
    global $server;

    $greeting = 
        ' - ' . $repos['nombre_rep'] .
        ' - ' . $repos['fecha_ceacion'] . '.';

    return array(
        'greeting' => $greeting,
    );
}

//$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : "";
$server->service(file_get_contents("php://input"));

?>