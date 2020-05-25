<?php

include 'conectar.php';

$tablita $_GET['tablita']; // Obtengo el nombre de la tabla
$tablita =str_replace(' ', '', $tablita); // Borro los espcios si es que hay

$mi_tabla= "CREATE TABLE $tablita(
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Nombre VARCHAR(50) NOT NULL,
Precio VARCHAR(60) NOT NULL,
LinkServidor VARCHAR(50) NOT NULL,
NombreArchivo VARCHAR(50)NOT NULL,
Descripcion VARCHAR(50)NOT NULL,
Tienda VARCHAR(50) NOT NULL

)";
// Todos los datos

// Resultado

if (mysqli_query($conn, $mi_tabla)) {
    echo "Tienda Creada Con Exito";
} else {
    echo "Error al crear la tienda:  " . mysqli_error($conn);
}
?>