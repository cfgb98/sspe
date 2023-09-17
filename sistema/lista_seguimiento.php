<?php
session_start();
if($_SESSION['rol'] != 1  and $_SESSION['rol'] != 2 and $_SESSION['rol'] != 3)
{
header("location: ./");
}

include "../conexion.php"

?>
<?php 

if ($_SESSION['rol']==2) {
	$idMedico = $_SESSION['idUser'];
}elseif ($_SESSION['rol']==3) {
	$idEnfermera = $_SESSION['idUser'];
}

$qmed="select idmedicamento,nombre_medicamento from medicamentos where  estatus=1";
					$rqmed=mysqli_query($conection,$qmed);
					while($datam =mysqli_fetch_row($rqmed)){
						$cat_medicamentos[$datam[0]]=$datam[1];
					}
$qmedo="select idmedicamento,observaciones from medicamentos where  estatus=1";
					$rqmedo=mysqli_query($conection,$qmedo);
					while($datamo =mysqli_fetch_row($rqmedo)){
						$cat_medicamentoso[$datamo[0]]=$datamo[1];
					}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de Seguimiento</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<h1>Lista de Seguimiento</h1>
		<a href="registro_seguimiento.php" class="btn_new"><i class="fa-solid fa-file-circle-plus"></i> Crear Seguimiento</a>
		
		<!-- <form action="buscar_seguimiento.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
			<input type="submit" value="Buscar" class="btn_search">
		</form> -->
		<div style="width:100%" class="col-12 nowrap">
		<table id="lista"  class="display nowrap table-striped " style="width:100%">
			<thead>
			<tr>
				<th>ID</th>
				<th>Nombre del paciente</th>
				<th>Cuantos embarazos</th>
				<th>Cuantos partos</th>
				<th>Cuantos abortos</th>
				<th>Dilatacion</th>
				<th>Borramiento</th>
				<th>Amnios</th>
				<th>Frecuencia fetal</th>
				<th>Presi&oacute;n arterial</th>
				<th>Urgencias</th>
				<th>M&eacute;dico</th>
				<th>Enfermera</th>
				<th>Medicamentos</th>
				<th>Estatus seguimiento</th>
				<th>Acciones</th>
			</tr>
			</thead>
			<tbody>
		<?php 
			//Paginador
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM seguimiento WHERE estatus=1");
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
			$ext="";
			if($_SESSION['rol']==2){
				$sql_m="select idmedico from medico where idusuario='$idMedico'";
				$rsql_m=mysqli_query($conection,$sql_m);
				$amedic=mysqli_fetch_row($rsql_m);
				$elmed=$amedic[0];
				$ext="and idmedico='$elmed'";
				
			}
			if($_SESSION['rol']==3){
				$sql_e="select idenfermeras from enfermeras where idusuario='$idEnfermera'";
				$rsql_e=mysqli_query($conection,$sql_e);
				$aenf=mysqli_fetch_row($rsql_e);
				$elenf=$aenf[0];
				
				$ext="and idenfermera='$elenf' ";
				
			}
			
			$query = mysqli_query($conection,"SELECT * FROM seguimiento  WHERE estatus=1 $ext ORDER BY idseguimiento ASC ");
			//echo "SELECT * FROM seguimiento   WHERE estatus=1 ORDER BY idseguimiento ASC ";
			//whew para solo mostrar pacientes del medico en sesion actual
			$query_paciente = mysqli_query($conection,"SELECT p.nombre, p.apellido_paterno, p.apellido_materno FROM pacientes p  INNER JOIN seguimiento s ON p.idpaciente=s.idpaciente");
			$query_medico = mysqli_query($conection,"SELECT s.idmedico,u.nombre, u.apellido_paterno, u.apellido_materno
			FROM seguimiento s
			INNER JOIN medico m ON s.idmedico = m.idmedico
			INNER JOIN usuario u ON m.idusuario = u.idusuario");

			$query_enfermera = mysqli_query($conection,"SELECT s.idenfermera,u.nombre, u.apellido_paterno, u.apellido_materno
			FROM seguimiento s
			INNER JOIN enfermeras e ON s.idenfermera = e.idenfermeras
			INNER JOIN usuario u ON e.idusuario = u.idusuario;");
			

			$result = mysqli_num_rows($query);
			$result_paciente = mysqli_num_rows($query_paciente);
			$result_medico = mysqli_num_rows($query_medico);
			$result_enfermera = mysqli_num_rows($query_enfermera);
			if($result > 0 && $result_paciente>0 && $result_medico >0 && $result_enfermera >0){
			
				while ($data = mysqli_fetch_array($query)) {
					$data2=mysqli_fetch_array($query_paciente);  
					$data3=mysqli_fetch_array($query_medico);
					$data4=mysqli_fetch_array($query_enfermera);

					$idseguimiento= (int)$data['idseguimiento'];
					/*$query_medicamento = mysqli_query($conection, "SELECT m.idmedicamento, m.nombre_medicamento
					FROM seguimiento_medicamento sm
					INNER JOIN medicamentos m ON sm.idmedicamento = m.idmedicamento
					WHERE sm.idseguimiento = $idseguimiento");
			$data5 =mysqli_fetch_array($query_medicamento);*/
					$qm="select idmedicamento from seguimiento_medicamento where idseguimiento='$idseguimiento' and estatus=1";
					$rqm=mysqli_query($conection,$qm);
					
					$o=0;
					$meds="";
					$medso="";
					while($data5 =mysqli_fetch_array($rqm)){
						$meds.='<div class="alert alert-primary" role="alert"><b>'.$cat_medicamentos[$data5['idmedicamento']]."</b> <br>".$cat_medicamentoso[$data5['idmedicamento']].'</div>';
						

					}
					//$meds=substr($meds,0,-6);
					
					
			
						
			?>
				<tr>
					<td><?php echo (int)$data["idseguimiento"]; ?></td>
					<td><?php echo $data2["nombre"]." ".$data2["apellido_paterno"]." ".$data2["apellido_materno"]; ?></td>
					<td><?php echo (int)$data["cuantos_embarazos"]; ?></td>
					<td><?php echo (int)$data["cuantos_partos"]; ?></td>
					<td><?php echo (int)$data["cuantos_abortos"]; ?></td>
					<td><?php echo $data["dilatacion"]; ?></td>
					<td><?php echo $data["borramiento"]; ?></td>
					<td><?php echo $data['amnios'] ?></td>
                    <td><?php echo $data['frecuencia_fetal'] ?></td>
                    <td><?php echo $data['presion_arterial'] ?></td>
                    <td><?php echo $data['urgencias'] ?></td>
					<td><img src="img/med.png" style="height:50px"><?php echo $data3['nombre']." ".$data3['apellido_paterno']." ".$data3['apellido_materno']?></td>
					<td><img src="img/enf.png" style="height:50px"><?php echo $data4['nombre']." ".$data4['apellido_paterno']." ".$data4['apellido_materno'] ?></td>
					<td><?php echo $meds ?></td>
                    <td><?php echo $data['estatus_seguimiento'] ?></td>
                    
					<td>
						<a class="link_edit" href="editar_seguimiento.php?idseguimiento=<?php echo $data["idseguimiento"]; ?>"><i class="fa-solid fa-pen-to-square"></i> Editar</a>

					
						|
						<a class="link_delete" href="eliminar_seguimiento.php?idseguimiento=<?php echo $data["idseguimiento"]; ?>"><i class="fa-solid fa-trash-can"></i> Eliminar</a>
					
					</td>
				
				</tr>
			
		<?php 
				}

			}
		 ?>

		</tbody>
		</table>
		</div>

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
        ],
	columnDefs: [
        {
            className: 'dtr-control',
            orderable: false,
            targets: 0
        }
    ],
    order: [1, 'asc'],
    responsive: {
        details: {
            type: 'column'
        }
    }
	});
});
</script>
</html>