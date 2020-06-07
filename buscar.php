<?php
	$servername = "localhost";
    $username = "root";
  	$password = "";
  	$dbname = "vivo";

	$conn = new mysqli($servername, $username, $password, $dbname);
      if($conn->connect_error){
        die("Conexión fallida: ".$conn->connect_error);
      }

    $salida = "";

    $query = "SELECT * FROM clientes WHERE nombre NOT LIKE '' ORDER By id LIMIT 25";

    if (isset($_POST['consulta'])) {
    	$q = $conn->real_escape_string($_POST['consulta']);
    	$query = "SELECT * FROM clientes WHERE id LIKE '%$q%' OR nombre LIKE '%$q%' OR numero LIKE '%$q%' ";
    }

    $resultado = $conn->query($query);

    if ($resultado->num_rows>0) {
    	$salida.="<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
    			<thead>
    				<tr id='titulo'>
    					<td>NOMBRE</td>
    					<td>NUMERO</td>
    					<td>DIRECCION CASA</td>
    					<td>DIRECCION TRABAJO</td>
                        <td>DIRECCION ALTERNATIVA</td>
                        <td>COMENTARIOS</td>
                        <td>PUNTOS</td>

    				</tr>

    			</thead>
    			

    	<tbody>";

    	while ($fila = $resultado->fetch_assoc()) {
    		$salida.="<tr>
    					<td>".$fila['nombre']."</td>
    					<td>".$fila['numero']."</td>
    					<td>".$fila['direccion_casa']."</td>
    					<td>".$fila['direccion_trabajo']."</td>
                        <td>".$fila['direccion_alternativa']."</td>
                        <td>".$fila['comentarios']."</td>
                        <td>".$fila['puntos']."</td>

    				</tr>";

    	}
    	$salida.="</tbody></table>";
    }else{
    	$salida.="NO HAY DATOS :(";
    }


    echo $salida;

    $conn->close();



?>