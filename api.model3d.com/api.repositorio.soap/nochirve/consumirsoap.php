<?php
require_once 'lib/nusoap.php';

//$client = new soapclient('http://localhost/phphack/hellowsdl2.php?wsdl', true);
$client = new soapclient('http://localhost/api.model3d.com/api.repositorio.soap/hellowsdl2.php?wsdl', true);

$err = $client->getError();
if ($err) {
// Display the error
    echo "<h2>Constructor error</h2><pre>" . $err . "</pre>";
// At this point, you know the call that follows will fail
}

$person = array("id_cuenta" => "1");
$result = $client->call("hello", array("person" => $person));
echo "resultado: " . $result;
print_r($result);
print $result;
echo gettype($result);
/*
if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
} else {
    // Check for errors
    $err = $client->getError();
    if ($err) {
        // Display the error
        echo "<h2>Error</h2><pre>" . $err . "</pre>";
    } else {
        // Display the result
        echo "<h2>Result</h2><pre>";
        echo $result;
        echo "</pre>";
    }
}
*/
echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";
// Display the debug messages
echo "<h2>Debug</h2>";
echo "<pre>" . htmlspecialchars($client->debug_str, ENT_QUOTES) . "</pre>";
