<?php 
	session_start();
    if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 and $_SESSION['rol'] != 3 and $_SESSION['rol'] != 4)
    {
        header("location: ./");
    }
	include "../conexion.php";


	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['folio']) || empty($_POST['nombre_medicamento']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$idmedicamento      = $_POST['id'];
            $folio              = $_POST['folio'];
            $nombre_medicamento = $_POST['nombre_medicamento'];
            $via_administracion = $_POST['via_administracion'];
            $observaciones      = $_POST['observaciones'];
            $fecha_caducidad    = $_POST['fecha_caducidad'];

			$sql_update = mysqli_query($conection,"UPDATE medicamentos
															SET folio = '$folio', nombre_medicamento='$nombre_medicamento',via_administracion='$via_administracion',observaciones='$observaciones',
															fecha_caducidad='$fecha_caducidad'
															WHERE idmedicamento= $idmedicamento ");

				if($sql_update){
					$alert='<p class="msg_save">Medicamento actualizado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar el Medicamento.</p>';
				}

		}


	}



	//Mostrar Datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_medicamento.php');
		mysqli_close($conection);
	}
	$idmedicamento = $_REQUEST['id'];

	$sql= mysqli_query($conection,"SELECT * FROM medicamentos WHERE idmedicamento= $idmedicamento and estatus = 1 ");
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_medicamento.php');
	}else{

		while ($data = mysqli_fetch_array($sql)) {
			# code...
			$idmedicamento      = $data['idmedicamento'];
            $folio              = $data['folio'];
            $nombre_medicamento = $data['nombre_medicamento'];
            $via_administracion = $data['via_administracion'];
            $observaciones      = $data['observaciones'];
            $fecha_caducidad    = $data['fecha_caducidad'];

		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Actualizar Medicamento</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar Medicamento</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="POST" >
                  <input type="hidden" name="id" value="<?php echo $idmedicamento; ?>">
                  <label for="folio">Folio</label>
                  <input type="number" name="folio" id="folio" placeholder="Numero de Folio" value="<?php echo $folio; ?>">
                  <label for="nombre_medicamento">Nombre del Medicamento</label>
                  <input type="text" name="nombre_medicamento" id="nombre_medicamento" placeholder="Nombre del Medicamento" value="<?php echo $nombre_medicamento; ?>">
                  <label for="via_administracion">Via de Administracion</label>
                  <input type="text" name="via_administracion" id="via_administracion" placeholder="Via de Administracion" value="<?php echo $via_administracion; ?>">
				  <label for="observaciones">Observaciones</label>
                  <input type="text" name="observaciones" id="observaciones" placeholder="Observaciones" value="<?php echo $observaciones; ?>">
				  <label for="fecha_caducidad">Fecha de Caducidad</label>
                  <input type="date" name="fecha_caducidad" id="fecha_caducidad" placeholder="" value="<?php echo $fecha_caducidad; ?>">
                 
                  <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> Actualizar Medicamento</button>
              </form>
          </div>
	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>