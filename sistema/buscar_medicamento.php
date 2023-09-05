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
	<title>Lista de medicamentos</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<?php 

			$busqueda = strtolower($_REQUEST['busqueda']);
			if(empty($busqueda))
			{
				header("location: lista_medicamento.php");
				mysqli_close($conection);
			}


		 ?>
		
		<h1>Lista de medicamentos</h1>
		<a href="registro_medicamento.php" class="btn_new">Crear medicamento</a>
		<a href="reporte_busqueda_medicamento.php?busqueda=<?php echo $busqueda?>" class="btn_new"><i class="fa-solid fa-floppy-disk"></i>Guardar reporte</a>
		<form action="buscar_medicamento.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>Folio</th>
				<th>Nombre</th>
				<th>V&iacute;a de administraci&oacute;n</th>
				<th>Observaciones</th>
				<th>Fecha de caducidad</th>
				<th>Acciones</th>
			</tr>
		<?php 
			//Paginador
			

			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM medicamentos 
																WHERE ( idmedicamento LIKE '%$busqueda%' OR 
																        folio LIKE '%$busqueda%' OR 
																        nombre_medicamento LIKE '%$busqueda%' OR 
																		via_administracion LIKE '%$busqueda%' OR 
																		observaciones LIKE '%$busqueda%' OR 
																		fecha_caducidad LIKE '%$busqueda%') 
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

			$query = mysqli_query($conection,"SELECT * FROM medicamentos 
										WHERE 
										( idmedicamento LIKE '%$busqueda%' OR 
																        folio LIKE '%$busqueda%' OR 
																        nombre_medicamento LIKE '%$busqueda%' OR 
																		via_administracion LIKE '%$busqueda%' OR 
																		observaciones LIKE '%$busqueda%' OR 
																		fecha_caducidad LIKE '%$busqueda%') 
										AND
										estatus = 1 ORDER BY idmedicamento ASC LIMIT $desde,$por_pagina 
				");
			mysqli_close($conection);
			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {
					
			?>
				<tr>
					<td><?php echo $data["idmedicamento"]; ?></td>
					<td><?php echo $data["folio"]; ?></td>
					<td><?php echo $data["nombre_medicamento"]; ?></td>
					<td><?php echo $data["via_administracion"]; ?></td>
					<td><?php echo $data["observaciones"]; ?></td>
					<td><?php echo $data["fecha_caducidad"]; ?></td>
					<td>
						<a class="link_edit" href="editar_medicamento.php?id=<?php echo $data["idmedicamento"]; ?>">Editar</a>

					<?php if($_SESSION['rol'] != 1 || $_SESSION['rol'] != 2){ ?>
						|
						<a class="link_delete" href="eliminar_confirmar_medicamentos.php?id=<?php echo $data["idmedicamento"]; ?>">Eliminar</a>
					<?php } ?>
						
					</td>
				</tr>
			
		<?php 
				}

			}
		 ?>


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
</html>