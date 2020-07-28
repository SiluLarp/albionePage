<?php
require "../conexion.php";
//buscador de registros por nombre
//variable buscador
$valorToSearch = $_POST['parametroSearch'];

	$q=$conexion->real_escape_string($valorToSearch);
	//para evitar mostrar el mismo usuario de la sesion colocamos la condicion id <> a la sesion en la secuencia
	$query="SELECT * FROM publicacion WHERE item_name LIKE '%".$q."%'";

$buscarPublic=mysqli_query($conexion, $query);

if (mysqli_num_rows($buscarPublic) > 0) {
	$sqltotal = mysqli_query($conexion,"SELECT COUNT(*) AS totalP FROM publicacion");
	$resul = mysqli_fetch_assoc($sqltotal);
	echo "<label id='totalPublicacion'>".$resul['totalP']."</label><hr><br>";//mostramos el total de todas las publicaciones

while ($filas = mysqli_fetch_assoc($buscarPublic)) {
	$sqlUser = mysqli_query($conexion,"SELECT * FROM usuario WHERE id = '".$filas['id_usuario']."'");
	$userBD = mysqli_fetch_assoc($sqlUser);

	//tabla idiomas
	$sqlLanguaje = mysqli_query($conexion,"SELECT idioma_name FROM idioma_usuario WHERE id = '".$userBD['idioma']."'");
	$idiomaTable = mysqli_fetch_assoc($sqlLanguaje);

	$imgBD = $filas['imagen'];
	if ($imgBD == "0") {
		$imagenVenta = "img/categorias/otros.png";
	}else{
		$imagenVenta = $imgBD;
	}
	?>
	<div class="publicacionUsuario">
		<table>
			<tr><td><img src="<?php echo $imagenVenta;?>" style="width: 35px;"></td>
				<td rowspan="3" style="text-align: center;">
					<label class="boradorPubli" onclick="desaparecerPubli(<?php echo $filas['id'] . ",../" . $$filas['imagen'];?>);">BORRAR</label>
				</td>
			</tr>
			<tr><td><?php echo "<label style='color:#FECFC3;'>Item:</label> " . $filas['item_name'] ." (" . $userBD['nick'] . ")";?></td></tr>
			<tr><td><?php echo "<label style='color:#FECFC3;'>idioma:</label> " . $idiomaTable['idioma_name'] . " | <label style='color:#FECFC3;'>Descripción:</label> " . $filas['descripcion'];?></td></tr>
		</table>
	</div><br>
	<?php
}//while
}else{//fi num rows
	echo "<div class='publicacionUsuario'>No hay registros</div>";
}
mysqli_close($conexion);
?>