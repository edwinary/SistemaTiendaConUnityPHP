<?php

include 'conectar.php';

$nombre = $_GET['nombre'];
$precio = $_GET['precio'];
$descripcion = $_GET['descripcion'];
$tienda = $_GET['tienda'];
$NombreArchivo = $_GET['NombreArchivo'];

$tienda  =str_replace(' ', '', $tienda);

$sql = "SELECT Nombre From '$tienda' WHERE Nombre = '$nombre'";
$result =  $pdo->query($sql);

if($result->rowCount() > 0)
{
  $data = array('done' => false , 'message' => "Error el producto ya existe" );
  Header('Content-Type: application/json');
  echo json_encode($data);
  exit();
}else
  {
      $sql = "INSERT INTO $tienda SET Nombre = '$nombre' , Precio = '$precio' , Descripcion = '$descripcion' , NombreArchivo = '$NombreArchivo'";
      $pdo->query($sql);

echo "<h2>PRODUCTO CREADO</h2>";
echo "El producto:  " . $nombre . "<br/>";
echo "se ha creado con el precio: " . $precio . "<br/>";
echo "descripcion: " . $descripcion . "<br/>";
echo "y creado a la tienda: " . $tienda . "<br/>";
echo $NombreArchivo;

setcookie("Tienda", $tienda, time() + 84600);

      $data = array('done' => true , 'message' => "Producto nuevo creado" );
      Header('Content-Type: application/json');
      echo json_encode($data);
      exit();

}


?>
