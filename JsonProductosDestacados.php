
{
  "productos":
<?php

 $servidor = "localhost";
$usuario   = "root";
$password   = "";
$NombreDataBase     = "vivo";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli($servidor, $usuario, $password, $NombreDataBase);
$conn->set_charset('utf8');

$sql = "SELECT * FROM productos_destacados";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    echo  json_encode($rows);
} else {
    echo "No encontro nada";
}

?>


}
