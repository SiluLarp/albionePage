<?php
require "../conexion.php";
//este archivo es usado en el index, la funcion que lo ejecuta se llama
//LoadStreams();	

$queryBD = mysqli_query($conexion,"SELECT * FROM streams ORDER BY id DESC");

if (mysqli_num_rows($queryBD) > 0) {
	//creamos el swhile para cargar los rtegistros
	while($fila = mysqli_fetch_assoc($queryBD)){

		$usersql = mysqli_query($conexion,"SELECT nombre FROM usuario WHERE id = '".$fila['id_usuario']."'");
		$userBD = mysqli_fetch_assoc($usersql);

			//mostramos el idioma de la base de datos
		$queryLa = mysqli_query($conexion,"SELECT idioma_name FROM idioma_usuario WHERE id = '".$fila['idioma']."'");
		$idiomaBD = mysqli_fetch_assoc($queryLa);
		?>
		<div class="satreamCargaAdmin">
		<table>
			<tr><td><label style="color:#FECFC3;">Titulo:</label>&nbsp;<?php echo $fila['titulo'];?></td>
				<td rowspan="3" style="text-align: center;">
					<label class="boradorPubli" onclick="borrarStreams(<?php echo $fila['id'];?>);">BORRAR</label>
				</td>
			</tr>
			<tr><td><label style="color:#FECFC3;">duracion:</label> <?php echo $fila['duracion'];?></td></tr>
			<tr><td><?php echo "<label style='color:#FECFC3;'>Idioma:</label> " . $idiomaBD['idioma_name'] . " | <label style='color:#FECFC3;'>Link:</label> " . $fila['link'];?></td></tr>
		</table>
		</div>
		<?php
	}//while
}else{//if num rows
	echo "<div class='satreamCargaAdmin'><label>Nadie ha publicado stream</label></div>";
}

mysqli_close($conexion);
?>