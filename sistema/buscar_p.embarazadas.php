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
	<title>Lista de Pacientes Embarazadas</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
        <?php 
           $busqueda = strtolower($_REQUEST['busqueda']);
           if(empty($busqueda))
           {
              header("location: lista_p.embarazadas.php");
           }
        
        ?>
		
		<h1>Lista de Pacientes Embarazadas</h1>
		<a href="registro_p.embarazadas.php" class="btn_new"><i class="fa-solid fa-file-circle-plus"></i> Ingresar Embarazada</a>
		<a href="reporte_busqueda_p.embarazadas.php?busqueda=<?php echo $busqueda?>" class="btn_new"><i class="fa-regular fa-file-pdf"></i> Descargar PDF</a>
		
		<form action="buscar_p.embarazadas.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
		    <tr>
				<th>ID</th>
                <th>Hora</th>
				<th>CURP</th>
				<th>Fecha de Nacimiento</th>
				<th>Domicilio</th>
				<th>Telefono</th>
				<th>Codigo Postal</th>
				<th>Estatus de Paciente</th>
				<th>Acciones</th>
			</tr>
		<?php 
			//Paginador
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM pacientes
                                        WHERE (idpaciente LIKE '%$busqueda%' OR
											   curp       LIKE '%$busqueda%' OR
                                               cod_postal LIKE '%$busqueda%' OR
                                               estatus_paciente LIKE '%$busqueda%')
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

			$query = mysqli_query($conection,"SELECT * FROM pacientes WHERE 
                                              (idpaciente LIKE '%$busqueda%' OR
											   curp       LIKE '%$busqueda%' OR
                                               cod_postal LIKE '%$busqueda%' OR
                                               estatus_paciente LIKE '%$busqueda%')
                                             AND
                                             estatus = 1 ORDER BY idpaciente ASC LIMIT $desde,$por_pagina 
				");

			mysqli_close($conection);

			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {
                    
			?>
				<tr>
				    <td><?php echo $data["idpaciente"]; ?></td>
					<td><?php echo $data["hora"]; ?></td>
					<td><?php echo $data["curp"]; ?></td>
				    <td><?php echo $data["fecha_nacimiento"]; ?></td>
					<td><?php echo $data["domicilio"]; ?></td>
					<td><?php echo $data["telefono"]; ?></td>
					<td><?php echo $data["cod_postal"]; ?></td>
					<td><?php echo $data["estatus_paciente"]; ?></td>	
					<td>
						<a class="link_edit" href="editar_p.embarazada.php?id=<?php echo $data["idpaciente"]; ?>"><i class="fa-solid fa-pen-to-square"></i> Editar</a>

					<?php if($_SESSION['rol'] != 1 || $_SESSION['rol'] != 2){ ?>
						|
						<a class="link_delete" href="eliminar_p.embarazada.php?id=<?php echo $data["idpaciente"]; ?>"><i class="fa-solid fa-trash-can"></i> Eliminar</a>
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