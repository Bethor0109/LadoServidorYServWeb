<?php

require_once 'obtenerallrepos.php';

$repos = new obtenerallrepos();

$id_cuenta = 1;

$repos->obtenerrepos($id_cuenta);

print_r($repos);

?>