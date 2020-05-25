<?php
include 'dbConnection.php';

$producto  = $_POST['producto'];
$precio     = $_POST['precio'];
$cantidad = $_POST['cantidad'];



$sql = "SELECT producto From inventariogeneral WHERE producto = '$producto'";
$result =  $pdo->query($sql);

if($result->rowCount() > 0)
{
  $data = array('done' => false , 'message' => "Error el producto ya existe" );
  Header('Content-Type: application/json');
  echo json_encode($data);
  exit();
}else
  {
      $sql = "INSERT INTO inventariogeneral SET producto = '$producto' , precio = '$precio' , cantidad = '$cantidad'";
      $pdo->query($sql);

      $data = array('done' => true , 'message' => "Producto nuevo creado" );
      Header('Content-Type: application/json');
      echo json_encode($data);
      exit();

}

?>
