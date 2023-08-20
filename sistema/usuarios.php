<?php 
require_once("../conexion.php");
header("Content-Type: aplication/xls");
header("Content-Disposition: attachment; filename= archivo.xls");


?>
	<table>
			<tr>
				<th>ID</th>
				<th>Apellido Paterno</th>
				<th>Apellido Materno</th>
				<th>Nombre</th>
				<th>Cedula</th>
				<th>Correo</th>
				<th>Usuario</th>
				<th>Rol</th>
				<th>Acciones</th>
			</tr>
		<?php 
			//Paginador
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM usuario WHERE estatus = 1 ");
			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];

			$por_pagina = 10;

			if(empty($_GET['pagina']))
			{
				$pagina = 1;
			}else{
				$pagina = $_GET['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_paginas = ceil($total_registro / $por_pagina);

			$query = mysqli_query($conection,"SELECT u.idusuario, u.apellido_paterno, u.apellido_materno, u.nombre, u.cedula, u.correo, u.usuario, r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE estatus = 1 ORDER BY u.idusuario ASC LIMIT $desde,$por_pagina 
				");

			mysqli_close($conection);

			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {
					
			?>
				<tr>
					<td><?php echo $data["idusuario"]; ?></td>
					<td><?php echo $data["apellido_paterno"]; ?></td>
					<td><?php echo $data["apellido_materno"]; ?></td>
					<td><?php echo $data["nombre"]; ?></td>
					<td><?php echo $data["cedula"]; ?></td>
					<td><?php echo $data["correo"]; ?></td>
					<td><?php echo $data["usuario"]; ?></td>
					<td><?php echo $data['rol'] ?></td>
				</tr>
			
		<?php 
				}

			}
		 ?>


		</table>