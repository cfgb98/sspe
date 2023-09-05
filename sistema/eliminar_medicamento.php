<?php 
    session_start();
    if($_SESSION['rol'] != 1 )
    {
        header("location: ./");
    }

    include "../conexion.php";

	if(!empty($_POST))
	{
		
		$idmedicamento = $_POST['idmedicamento'];

        $query_delete = mysqli_query($conection,"UPDATE medicamentos SET estatus = 0 WHERE idmedicamento = '$idmedicamento'");

		if($query_delete){
			header("location: lista_medicamento.php");
		}else{
			echo "Error al eliminar";
		}
	}

    if(empty($_REQUEST['idmedicamento']) )
	{
		header("location: lista_medicamento.php");
		mysqli_close($conection);
	}else{
		$idmedicamento = $_REQUEST['idmedicamento'];

		$query = mysqli_query($conection, "SELECT * FROM medicamentos WHERE idmedicamento = '$idmedicamento'");

		mysqli_close($conection);										 
	    $result = mysqli_num_rows($query);

		if($result > 0){
			while($data = mysqli_fetch_array($query)){

                $idmedicamento      = $data['idmedicamento'];
                $folio              =$data['folio'];
                $nombre           = $data['nombre_medicamento'];
                $via_administracion = $data['via_administracion'];
                $observaciones = $data['observaciones'];
                $fecha_caducidad = $data['fecha_caducidad'];
			}
		}else{
			header("location: lista_medicamento.php");
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php";?>
	<title>Eliminar Medicamento</title>
</head>
<body>
    <?php include "includes/header.php";?>
	<section id="container">
		<div class="data_delete">
		    <i class="fa-solid fa-user-xmark fa-7x" style="color: red"></i>
		   <br>
		   <br>
           <h2>¿Está seguro de eliminar el siguiente registro?</h2>
           <p>Folio: <span><?php echo $folio; ?></span></p>
		   <p>Nombre: <span><?php echo $nombre; ?></span></p>
           <p>V&iacute;a de admnistraci&oacute;n: <span><?php echo $via_administracion; ?></span></p>
           <p>Obseraciones: <span><?php echo $observaciones; ?></span></p>
		   <p>Fecha de caducidad: <span><?php echo $fecha_caducidad; ?></span></p>

		   <form method="POST" action="">
			   <input type="hidden"name="idmedicamento" value="<?php echo $idmedicamento; ?>">
			   <a href="lista_medicamento.php" class="btn_cancel"><i class="fa-solid fa-ban"></i> Cancelar</a>
			   <button type="submit"  class="btn_ok"><i class="fa-solid fa-trash-can"></i> Eliminar</button>
		   </form>
		</div>
	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>