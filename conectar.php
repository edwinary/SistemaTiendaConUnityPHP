<?php

$servidor= "localhost";
$usuario= "root";
$password = "";
$nombreBD= "vivo";

$conn = mysqli_connect($servidor, $usuario, $password, $nombreBD);
// Aquí se revisa la conexión con MySQL
if (!$conn) {
    die("la conexión ha fallado: " . mysqli_connect_error());
}


?>
