<?php 
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}

	include "../conexion.php";	

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de usuarios</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<?php 

			$busqueda = strtolower($_REQUEST['busqueda']);
			if(empty($busqueda))
			{
				header("location: lista_usuarios.php");
				mysqli_close($conection);
			}


		 ?>
		
		<h1>Lista de usuarios</h1>
		<a href="registro_usuario.php" class="btn_new">Crear usuario</a>
		<a href="reporte_busqueda_usuario.php?busqueda=<?php echo $busqueda?>" class="btn_new"><i class="fa-solid fa-floppy-disk"></i>Guardar reporte</a>
		<form action="buscar_usuario.php" method="get" class="form_search">
		
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table id="lista"  class="table table-striped">
			<thead>
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
			</thead>
			<tbody>
		<?php 
			//Paginador
			$rol = '';
			if($busqueda == 'Administrador')
			{
				$rol = " OR rol LIKE '%1%' ";

			}else if($busqueda == 'Medico'){

				$rol = " OR rol LIKE '%2%' ";

			}else if($busqueda == 'Enfermero'){

				$rol = " OR rol LIKE '%3%' ";
			}


			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM usuario 
																WHERE ( idusuario LIKE '%$busqueda%' OR 
																        apellido_paterno LIKE '%$busqueda%' OR 
																        apellido_materno LIKE '%$busqueda%' OR 
																		nombre LIKE '%$busqueda%' OR 
																		correo LIKE '%$busqueda%' OR 
																		usuario LIKE '%$busqueda%')
																		$rol   
																AND estatus = 1  ");

			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];
			$por_pagina = 5;

			if(empty($_GET['pagina']))
			{
				$pagina = 1;
			}else{
				$pagina = (int)$_GET['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_paginas = ceil($total_registro / $por_pagina);

			$query = mysqli_query($conection,"SELECT u.idusuario, u.apellido_paterno,u.apellido_materno,u.nombre,u.cedula, u.correo, u.usuario, r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol 
										WHERE 
										( u.idusuario LIKE '%$busqueda%' OR
										    u.apellido_paterno LIKE '%$busqueda%' OR 
										    u.apellido_materno LIKE '%$busqueda%' OR  
											u.nombre LIKE '%$busqueda%' OR 
											u.correo LIKE '%$busqueda%' OR 
											u.usuario LIKE '%$busqueda%' OR 
											r.rol    LIKE  '%$busqueda%' ) 
										AND
										estatus = 1 ORDER BY u.idusuario ASC LIMIT $desde,$por_pagina 
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
					<td>
						<a class="link_edit" href="editar_usuario.php?id=<?php echo $data["idusuario"]; ?>">Editar</a>

					<?php if($_SESSION['rol'] != 1 || $_SESSION['rol'] != 2){ ?>
						|
						<a class="link_delete" href="eliminar_confirmar_usuario.php?id=<?php echo $data["idusuario"]; ?>">Eliminar</a>
					<?php } ?>
						
					</td>
				</tr>
			
		<?php 
				}

			}
		 ?>

		</tbody>
		</table>
<?php 
	
	if($total_registro != 0)
	{
 ?>
		<div class="paginador">
			<ul>
			<?php 
				if($pagina != 1)
				{
			 ?>
				<li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">|<</a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo $busqueda; ?>"><<</a></li>
			<?php 
				}
				for ($i=1; $i <= $total_paginas; $i++) { 
					
					if($i == $pagina)
					{
						echo '<li class="pageSelected">'.$i.'</li>';
					}else{
						echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
					}
				}

				if($pagina != $total_paginas)
				{
			 ?>
				<li><a href="?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>">>></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?> ">>|</a></li>
			<?php } ?>
			</ul>
		</div>
<?php } ?>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
<script>
$(document).ready(function(){
   var table = new DataTable('#lista', {
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
    },
	});
});
</script>
</html>