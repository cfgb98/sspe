<?php 
   session_start();
   if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
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
		
		<h1>Lista de Pacientes Embarazadas</h1>
		<a href="registro_paciente.php" class="btn_new"><i class="fa-solid fa-file-circle-plus"></i>Ingresar Paciente</a>
		
		<!-- <form action="buscar_entrada.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
			<input type="submit" value="Buscar" class="btn_search">
		</form> -->

		<table id="lista"  class="table table-striped">
			<thead>
			<tr>
				<th>ID</th>
                <th>Nombre</th>
				<th>Edad</th>
				<th>Telefono</th>
				<th>CURP</th>
				<th>Domicilio</th>
                <th>Fecha</th>
				<th>Medico Tratante</th>
				<th>Medicamento</th>
				<th>Hora</th>
				<th>Acciones</th>
			</tr>
			</thead>
			<tbody>
		<?php 
			//Paginador
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM pacientes WHERE estatus = 1 ");
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

           /* $query = mysqli_query($conection,"SELECT p.codpaciente,p.clave,p.cantidad,p.nodelote,r.material 
                                                FROM entradas e
                                                INNER JOIN material r
                                                ON e.material = r.codmaterial  
                                                WHERE e.estatus = 1 ORDER BY e.codentrada ASC LIMIT $desde,$por_pagina 
                                                ");*/
												
			 $query = mysqli_query($conection,"SELECT p.codpaciente,p.clave,p.cantidad,p.nodelote,r.material 
                                                FROM entradas e
                                                INNER JOIN material r
                                                ON e.material = r.codmaterial  
                                                WHERE e.estatus = 1 ORDER BY e.codentrada ASC 
                                                ");

			mysqli_close($conection);

			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {
		
			?>
				<tr>
					<td><?php echo $data["codentrada"]; ?></td>
				    <td><?php echo $data["clave"]; ?></td>
					<td><?php echo $data["cantidad"]; ?></td>
					<td><?php echo $data["nodelote"]; ?></td>
					<td><?php echo $data["material"]; ?></td>
					<td>
						<a class="link_edit" href="editar_paciente.php?id=<?php echo $data["codpaciente"]; ?>"><i class="fa-solid fa-pen-to-square"></i> Editar</a>
                         |
						<a class="link_delete" href="eliminar_paciente.php?id=<?php echo $data["codpaciente"]; ?>"><i class="fa-solid fa-trash-can"></i> Eliminar</a>
					</td>
				</tr>
			
		<?php 
				}

			}
		 ?>

		</tbody>
		</table>
		<!--<div class="paginador">
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
		</div>-->


	</section>
	<?php include "includes/footer.php"; ?>
</body>
<script>
$(document).ready(function(){
   var table = new DataTable('#lista', {
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
    },
	dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
	});
});
</script>
</html>