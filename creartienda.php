<?php

include 'conectar.php';



$mi_tabla= "CREATE TABLE tiendas(
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Nombre VARCHAR(50) NOT NULL,
LinkServidor VARCHAR(50) NOT NULL,
NombreArchivo VARCHAR(50)NOT NULL,
Descripcion VARCHAR(50)NOT NULL

)";
// Todos los datos

// Resultado

if (mysqli_query($conn, $mi_tabla)) {
    echo "Tienda Creada Con Exito";
} else {
    echo "Error al crear la tienda:  " . mysqli_error($conn);
}
?>