<?php 
   session_start();
   if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 and $_SESSION['rol'] != 3 and $_SESSION['rol'] != 4)
    {
        header("location: ./");
    }
   include "../conexion.php"

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de Medicamento</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
        <?php 
           $busqueda = strtolower($_REQUEST['busqueda']);
           if(empty($busqueda))
           {
              header("location: lista_medicamento.php");
           }
        
        ?>
		
		<h1>Lista de Medicamentos</h1>
		<a href="registro_medicamento.php" class="btn_new"><i class="fa-solid fa-file-circle-plus"></i> Ingresar Medicamento</a>
		<a href="reporte_busqueda_medicamentos.php?busqueda=<?php echo $busqueda?>" class="btn_new"><i class="fa-regular fa-file-pdf"></i> Descargar PDF</a>
		
		<form action="buscar_medicamento.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" required>
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
		    <tr>
				<th>ID</th>
                <th>Folio</th>
                <th>Nombre del Medicamento</th>
				<th>Via de Administracion</th>
				<th>Observaciones</th>
				<th>Fecha de Caducidad</th>
				<th>Acciones</th>
			</tr>
		<?php 
			//Paginador
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM medicamentos
                                        WHERE (idmedicamento LIKE '%$busqueda%' OR
											   folio       LIKE '%$busqueda%' OR
                                               nombre_medicamento LIKE '%$busqueda%' OR
                                               via_administracion LIKE '%$busqueda%')
                                        AND
                                        estatus = 1 ");
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

			$query = mysqli_query($conection,"SELECT * FROM medicamentos WHERE 
                                              (idmedicamento LIKE '%$busqueda%' OR
											   folio       LIKE '%$busqueda%' OR
                                               nombre_medicamento LIKE '%$busqueda%' OR
                                               via_administracion LIKE '%$busqueda%')
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
						<a class="link_edit" href="editar_medicamento.php?id=<?php echo $data["idmedicamento"]; ?>"><i class="fa-solid fa-pen-to-square"></i> Editar</a>

					<?php if($_SESSION['rol'] != 1 || $_SESSION['rol'] != 2){ ?>
						|
						<a class="link_delete" href="eliminar_medicamento.php?id=<?php echo $data["idmedicamento"]; ?>"><i class="fa-solid fa-trash-can"></i> Eliminar</a>
					<?php } ?>
						
					</td>
				</tr>
			
		<?php 
				}

			}
		 ?>


		</table>
		<div class="paginador">
			<ul>
			<?php 
				if($pagina != 1)
				{
			 ?>
				<li><a href="?pagina=<?php echo 1; ?>"><i class="fa-solid fa-backward-step"></i></a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>"><i class="fa-solid fa-backward"></i></a></li>
			<?php 
				}
				for ($i=1; $i <= $total_paginas; $i++) { 
					# code...
					if($i == $pagina)
					{
						echo '<li class="pageSelected">'.$i.'</li>';
					}else{
						echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
					}
				}

				if($pagina != $total_paginas)
				{
			 ?>
				<li><a href="?pagina=<?php echo $pagina + 1; ?>"><i class="fa-solid fa-forward"></i></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?> "><i class="fa-solid fa-forward-step"></i></a></li>
			<?php } ?>
			</ul>
		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>