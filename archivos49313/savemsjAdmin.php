<?php
//aqui se guarda el mensaje del administrador
require "../conexion.php";

//3 variables, titulo, descripcion e  imagen
$titulo = $_POST['tituloJava'];
$descripcion = $_POST['descripcionJava'];
$encuestavalue = $_POST['encuestaStatus'];

//variables para subir la imagen
$nombre_file = &$_FILES['file']['name'];
$tipo = &$_FILES['file']['type'];
$tamano = &$_FILES['file']['size'];

//comenzamos el guardado, primer la imagen
if (($nombre_file == !NULL) && ($tamano <= 209715200))
{	
	//indicamos los formatos que permitimos subir a nuestro servidor
   if (($tipo == "image/gif") || ($tipo == "image/jpeg") || ($tipo == "image/jpg") || ($tipo == "image/png"))
   {
   	 // Ruta donde se guardarán videos que subamos
      $directorio = $_SERVER['DOCUMENT_ROOT'].'/AlbionMarketPlayer/Multimedia/';
      // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
      move_uploaded_file($_FILES['file']['tmp_name'],$directorio.$nombre_file);
      
      //echo "guardado";
      $BD_fileImg = "multimedia/" . $nombre_file;
      
   }
}else{
	$BD_fileImg = "0";
}

//ya tenemos las variables guardamos todo
$sqlSave = mysqli_query($conexion,"INSERT INTO admin_msj(titulo,mensaje,imagen,encuesta_estatus) VALUES('$titulo','$descripcion','$BD_fileImg','$encuestavalue')");
if ($sqlSave) {
	echo 1;
}else{
	echo 2;
}

mysqli_close($conexion);
?>