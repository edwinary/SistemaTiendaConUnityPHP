<?php 
ob_start();

/////// VARIABLES DEL SERVIDOR //////
include ("host/sesion.php"); 
include ("host/conexion.php");


/////////// OBTENCIÓN DE FECHAS /////////
date_default_timezone_set('America/Cancun');
$fecha=date('Y-m-j');
$fecha_letras=date('j-F-Y');
$hora=date('h:i a');
$fecha_hora=date('Y-m-j h:i');

//////// RECIBIMOS LA VARIABLE DE ACCION /////////	
  if(isset($_POST["accion"]) && !empty($_POST["accion"])){
	$accion=$_POST["accion"];
  } else if(isset($_GET["accion"]) && !empty($_GET["accion"])){
	$accion=$_GET["accion"];
  }
/////////////////// INICIA CODIGO DE ACCIONES //////////////////////////  


/*----------ACCESO LOGUEAR AL USUARIO-----------------------------------------------------------------------------------------------------------------------------------------------------*/
if($accion=="iniciar_sesion"){
	
	//Inicio de variables de sesión
if (!isset($_SESSION)) {
  session_start();
}

//Recibir los datos ingresados en el formulario
$usuario = mysqli_real_escape_string($conex, $_POST['usuario']);
$contrasena = mysqli_real_escape_string($conex, $_POST['contrasena']);

//Consultar si los datos son están guardados en la base de datos contrasena='".md5($clave)."'"
$consulta = "SELECT * FROM usuarios WHERE usuario='".$usuario."' AND contrasena='".md5($contrasena)."'"; 
$resultado= mysqli_query($conex,$consulta) or die (mysqli_error());
$registro=mysqli_fetch_array($resultado);


if (!$registro[0]) //opcion1: Si el usuario NO existe o los datos son INCORRRECTOS
{
echo '<div class="alert alert-danger alert-dismissible" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <i class="fa fa-check-circle"></i>  &nbsp;&nbsp;&nbsp;Error, verifica tus datos
      </div>';
	  
} else { //opcion2: Usuario logueado correctamente

$_SESSION['id_usuario'] = $registro['id_usuario'];
echo '<div class="alert alert-success alert-dismissible" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <i class="fa fa-check-circle"></i> &nbsp;&nbsp;&nbsp;Entrando a tu cuenta...
      </div>';
echo '<script>
document.getElementById("botonentrar").disabled = true;
</script>';
echo '<meta http-equiv="Refresh" content="2; url=inicio.php">';	
} 
	
} 
/*--------- CERRAR LA SESION DEL USUARIO-----------------------------------------------------------------------------------------------------------------------------------------------------*/
else if($accion=="cerrar_sesion"){
	session_start();

if ($_SESSION['id_usuario']){	
	session_destroy();
	echo '<div class="alert alert-success alert-dismissible" role="alert">
		<center><i class="fa fa-check-circle"></i> &nbsp; Saliendo de tu cuenta... </center>
      </div>';
echo '<meta http-equiv="Refresh" content="2; url=index.php">';
}else{
	//header("Location: inicio.php");
	echo '<div class="alert alert-danger alert-dismissible" role="alert">
     <center> Error! recarga la página y reintentalo.</center>
   </div>';
}
}
/*--------- NUEVO USUARIO-----------------------------------------------------------------------------------------------------------------------------------------------------*/
else if($accion=="registrar_usuario"){
 
$nombres = mysqli_real_escape_string($conex, $_POST['nombres']);
$apellidos = mysqli_real_escape_string($conex, $_POST['apellidos']);
$fecha_nacimiento = mysqli_real_escape_string($conex, $_POST['fecha_nacimiento']);
$correo = mysqli_real_escape_string($conex, $_POST['correo']);
$contrasena1 = mysqli_real_escape_string($conex, $_POST['contrasena1']);

if(empty($nombres) or empty($apellidos) or empty($fecha_nacimiento) or empty($correo) or empty($contrasena1)){
echo '<div class="alert alert-danger alert-dismissible" role="alert">
 <center> Debes llenar todos los campos! </center>
      </div>';
} else {

 //Consultar si los datos son están guardados en la base de datos/correo electronico ya asociado a cuenta
 foreach($conex->query("SELECT COUNT(*) FROM usuarios WHERE correo='".$correo."'") as $existencia) { 
	$usuario_existente=$existencia['COUNT(*)'];
}

if($usuario_existente >= 1){
echo '<div class="alert alert-danger alert-dismissible"  role="alert"> 
		   <center> Ya existe usuario con ese mismo correo electrónico </center>
      </div>';
 } else {
$guardar_nuevo="INSERT INTO usuarios (foto, tipo_usuario, longitud, latitud, hora_seguimiento, correo, nombres, apellidos, sexo, telefono, direccion, estado, ciudad_localidad, codigo_postal, fecha_nacimiento, usuario, contrasena, pin_unico, pregunta_seguridad, respuesta_seguridad, estatus_cuenta)
VALUES ('img/nofoto.jpg', 'usuario', '00000', '00000', '$fecha_hora', '$correo', '$nombres', '$apellidos', 'x', '000000', 'Sin especificar', 'No seleccionado', 'No seleccionado', '0000', '$fecha_nacimiento', '$correo', MD5('$contrasena1'), '1111', 'Sin especificar', 'Sin especificar', 'activo')";
 

/*	
$destinatario = $correo_electronico_u; 
$asunto = "Zona Segura > Registro"; 
$cuerpo = ' 
<html> 
<head> 
   <title>RECIBIMOS TU SOLICITUD</title> 
</head> 
<body> 
<img src="http://japimexico.com/eduka/img/logo_header2.png">
<h2>Gracias por registrarte en <b>EDUKA</b><h2>
<h4>Estos datos te ser&aacute;n utiles para tu cuenta de acceso a EDUKA, te sugerimos los tengas siempre cerca de ti:</h4>
<BR>
<b>Nombre: </b>'.$nombres_u.' '.$apellidos_u.'.<br>
<b>Usuario: </b>'.$usuario_u.'.<br>
<b>Contrase&ntilde;a: </b>'.$contrasena2_u.'.<br>
<b>Clave de recuperaci&oacute;n: </b>'.$clave_recuperacion_u.'.<br>
<br>
<p>Accede a la plataforma dando click <a href="http://japimexico.com/eduka/login.php"><b>aqui</b></a>
</body> 
</html>'; 

//para el envío en formato HTML 
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

//dirección del remitente 
$headers .= "From: Japi Mexico <cesar.reinoso@japimexico.com>\r\n"; 

//dirección de respuesta, si queremos que sea distinta que la del remitente 
//$headers .= "Reply-To: mariano@desarrolloweb.com\r\n"; 

//ruta del mensaje desde origen a destino 
$headers .= "Return-path: cesar.reinoso@japimexico.com\r\n";  
 */
if ($conex->multi_query($guardar_nuevo) == TRUE) { 


/*	
if(mail($destinatario,$asunto,$cuerpo,$headers)){
header("Location: login.php");
}else{
header("Location: registro.php?error");
} 
*/
echo '<div class="alert alert-success alert-dismissible" role="alert">
		<center><i class="fa fa-check-circle"></i> &nbsp; Registro correcto, inicia sesion... </center>
      </div>';
echo '<meta http-equiv="Refresh" content="2; url=login.php">';	
}else{
//echo "Error: " . $guardar_nuevo ."/". $conex->error;
echo '<div class="alert alert-danger alert-dismissible" role="alert">
<center> <i class="fa fa-check-circle"></i>  &nbsp;Error al registrar </center>
      </div>';
	}
  }	
 }
}
/*--------- NUEVA ZONA -----------------------------------------------------------------------------------------------------------------------------------------------------*/
else if($accion=="nueva_zona"){
 
$nombre_zona = mysqli_real_escape_string($conex, $_POST['nombre_zona']);
$latitud = mysqli_real_escape_string($conex, $_POST['latitud']);
$longitud = mysqli_real_escape_string($conex, $_POST['longitud']);
$descripcion = mysqli_real_escape_string($conex, $_POST['descripcion_zona']);
$responsable = mysqli_real_escape_string($conex, $_POST['responsable_zona']);
$apertura = mysqli_real_escape_string($conex, $_POST['apertura_zona']);
$cierre = mysqli_real_escape_string($conex, $_POST['cierre_zona']);
$puntaje = mysqli_real_escape_string($conex, $_POST['puntaje']);
$tipo_zona = mysqli_real_escape_string($conex, $_POST['tipo_zona']);
$ruta = "img/foto_zonas/"; 

if(empty($nombre_zona) or empty($latitud) or empty($longitud) or empty($apertura) or empty($cierre)){
echo '<div class="alert alert-danger alert-dismissible" style="padding: 6px;" role="alert">
 <center><i class="fa fa-ban"></i>  &nbsp; Faltan campos </center>
      </div>';
} else {

 //Consultar si los datos son están guardados en la base de datos/correo electronico ya asociado a cuenta
 foreach($conex->query("SELECT COUNT(*) FROM zonas WHERE nombre_zona='".$nombre_zona."' OR latitud='".$latitud."' AND longitud='".$longitud."'") as $existencia) { 
	$zona_existente=$existencia['COUNT(*)'];
}

if($zona_existente >= 1){
echo '<div class="alert alert-danger alert-dismissible" style="padding: 6px;" role="alert"> 
		   <center><i class="fa fa-ban"></i>  &nbsp; Existente </center>
      </div>';
 } else {
	 
if($_FILES['foto']['tmp_name'] == null){
//// GUARDADO DE LA ZONA SIN FOTO
$guardar_zona="INSERT INTO zonas (tipo_zona, nombre_zona, latitud, longitud, descripcion, responsable, apertura, cierre, puntaje, estado)
VALUES ('$tipo_zona', '$nombre_zona', '$latitud', '$longitud', '$descripcion', '$responsable', '$apertura', '$cierre', '0', '$estado')";
if ($conex->multi_query($guardar_zona) == TRUE) { 
echo '<div class="alert alert-success alert-dismissible" style="padding: 6px;" role="alert">
	     <center><i class="fa fa-check-circle"></i> &nbsp; Guardado </center>
	</div>';
	
}else{
//echo "Error: " . $guardar_zona ."/". $conex->error;
echo '<div class="alert alert-danger alert-dismissible" style="padding: 6px;" role="alert">
<center> <i class="fa fa-ban"></i>  &nbsp;Error (001) </center>
      </div>';
	}
////// FIN DEL GUARDADO DE LA ZONA SIN FOTO
		 
	 } else {
    $nombre_archivo = $_FILES['foto']['name'];
    $nombre_temporal = $_FILES['foto']['tmp_name'];
    $tipo_archivo = $_FILES['foto']['type'];
    $tamano_archivo = $_FILES['foto']['size'];
    $error_archivo = $_FILES['foto']['error'];


        if(move_uploaded_file($nombre_temporal, "img/foto_zonas/".$nombre_archivo)){
          
//// GUARDADO DE LA ZONA CON FOTO
$guardar_zona_foto="INSERT INTO zonas (tipo_zona, nombre_zona, latitud, longitud, descripcion, responsable, apertura, cierre, foto, puntaje, estado)
VALUES ('$tipo_zona', '$nombre_zona', '$latitud', '$longitud', '$descripcion', '$responsable', '$apertura', '$cierre', '".$ruta.$nombre_archivo."', '0', '$estado')";
if ($conex->multi_query($guardar_zona_foto) == TRUE) { 
echo '<div class="alert alert-success alert-dismissible" style="padding: 6px;" role="alert">
	     <center><i class="fa fa-check-circle"></i> &nbsp; Guardado </center>
	</div>';
	
}else{
//echo "Error: " . $guardar_zona_foto ."/". $conex->error;
echo '<div class="alert alert-danger alert-dismissible" style="padding: 6px;" role="alert">
<center> <i class="fa fa-ban"></i>  &nbsp;Error (002) </center>
      </div>';
	}
////// FIN DEL GUARDADO DE LA ZONA CON FOTO
		
		
		
		} else {
        //si ocurrio algun problema entonces mostramos el error
		echo '<div class="alert alert-danger alert-dismissible" style="padding: 6px;" role="alert">
				<center> <i class="fa fa-ban"></i>  &nbsp;Error foto </center>
				</div>';
		 }	

		
	}
	 
	 


	
  }	
 }
}

/*--------- CAMBIAR EL TIPO DE CUENTA DEL USUARIO-----------------------------------------------------------------------------------------------------------------------------------------------------*/
else if($accion=="cambiar_rol"){

  $id_usuario_c = $_POST['id_usuarioc'];
  $tipo = $_POST['tipo'];
  $rol="";
	
if($tipo=="admin"){
$rol='<span class="btn btn-xs btn-success" style="font-size: 10px; padding: 3px; width: 100%;">Administrador</span>';	
}
if($tipo=="usuario"){
$rol='<span  class="btn btn-xs btn-primary" style="font-size: 10px; padding: 3px; width: 100%;">Usuario</span>';	
}

$actualizar_user = "UPDATE usuarios SET tipo_usuario='".$tipo."' WHERE id_usuario='".$id_usuario_c."'";

if ($conex->query($actualizar_user)==TRUE){ 
echo $rol;
} else {
$rol='<span  class="btn btn-xs btn-danger" style="font-size: 10px; padding: 3px; width: 100%;">ERROR</span>';
}

}
/*--------- CAMBIAR EL ESTADO DE LA CUENTA UN USUARIO-----------------------------------------------------------------------------------------------------------------------------------------------------*/
else if($accion=="estado_cuenta"){

  $id_usuario_e = $_POST['id_usuarioe'];
  $tipo = $_POST['seleccionado'];
  $rol="";
	
if($tipo=="activo"){
$rol='<b style="color: #5cb85c; font-size: 12px;" class="pull-right"><i style="color: #5cb85c;" class="fa fa-dot-circle-o"></i> Activo</b>';	
}
if($tipo=="inactivo"){
$rol='<b style="color: #c9020f;  font-size: 12px;" class="pull-right"><i style="color: #c9020f;" class="fa fa-dot-circle-o"></i> Inactivo</b>';	
}

$actualizar_user = "UPDATE usuarios SET estatus_cuenta='".$tipo."' WHERE id_usuario='".$id_usuario_e."'";

if ($conex->query($actualizar_user)==TRUE){ 
echo $rol;
} else {
$rol='<b style="color: #000000;  font-size: 12px;" class="pull-right"><i style="color: #c9020f;" class="fa fa-dot-circle-o"></i> Error</b>';
}

}




  
  
 ////////////////// FIN DE CODIGO DE ACCIONES ///////////
ob_end_flush(); 
  ?>