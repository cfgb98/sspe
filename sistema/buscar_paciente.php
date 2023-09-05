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
	<title>Lista de Materiales</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
        <?php 
           $busqueda = strtolower($_REQUEST['busqueda']);
           if(empty($busqueda))
           {
              header("location: lista_material.php");
           }
        
        ?>
		
		<h1>Lista de Materiales</h1>
		<a href="registro_material.php" class="btn_new"><i class="fa-solid fa-file-circle-plus"></i> Crear Material</a>
		
		<form action="buscar_material.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
                <th>ID</th>
                <th>Clave</th>
				<th>Material</th>
				<th>Fondo Fijo</th>
				<th>Acciones</th>
			</tr>
		<?php 
			//Paginador
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM material
                                        WHERE (codmaterial LIKE '%$busqueda%' OR
                                               clave LIKE '%$busqueda%' OR
                                               material LIKE '%$busqueda%' OR
                                               fondofijo LIKE '%$busqueda%')
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

			$query = mysqli_query($conection,"SELECT * FROM material WHERE 
                                              (codmaterial LIKE '%$busqueda%' OR
                                              clave LIKE '%$busqueda%' OR
                                              material LIKE '%$busqueda%' OR
                                              fondofijo LIKE '%$busqueda%')
                                            AND
                                             estatus = 1 ORDER BY codmaterial ASC LIMIT $desde,$por_pagina 
				");

			mysqli_close($conection);

			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {
                    
			?>
				<tr>
                    <td><?php echo $data["codmaterial"]; ?></td>
				    <td><?php echo $data["clave"]; ?></td>
					<td><?php echo $data["material"]; ?></td>
					<td><?php echo $data["fondofijo"]; ?></td>
					<td>
						<a class="link_edit" href="editar_material.php?id=<?php echo $data["codmaterial"]; ?>"><i class="fa-solid fa-pen-to-square"></i> Editar</a>

					<?php if($_SESSION['rol'] != 1 || $_SESSION['rol'] != 2){ ?>
						|
						<a class="link_delete" href="eliminar_material.php?id=<?php echo $data["codmaterial"]; ?>"><i class="fa-solid fa-trash-can"></i> Eliminar</a>
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