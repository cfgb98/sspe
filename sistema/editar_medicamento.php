<?php 
	session_start();
    if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 and $_SESSION['rol'] != 3)
    {
        header("location: ./");
    }
	include "../conexion.php";


	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['folio']) || empty($_POST['nombre_medicamento']) || empty($_POST['via_administracion'])|| empty($_POST['observaciones'])|| empty($_POST['fecha_caducidad']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$idmedicamento      = $_POST['idmedicamento'];
            $folio              = $_POST['folio'];
			$nombre           = $_POST['nombre_medicamento'];
			$via_administracion = $_POST['via_administracion'];
			$observaciones = $_POST['observaciones'];
            $fecha_caducidad = $_POST['fecha_caducidad'];
			$usuarioid        = $_SESSION['idUser']; 
			

			$sql_update = mysqli_query($conection,"UPDATE medicamentos
															SET  nombre_medicamento ='$nombre',via_administracion='$via_administracion',observaciones='$observaciones',fecha_caducidad='$fecha_caducidad',usuario_id='$usuarioid'
															WHERE idmedicamento= $idmedicamento ");

				if($sql_update){
				
                    if (mysqli_affected_rows($conection)>0) {
                        header("Location: lista_medicamento.php");
                    }
				}else{
					$error = mysqli_error($conection);
					$alert="<p class='msg_error'>Error al actualizar el medicmaento: $error</p>";
				}

		}


	}



	//Mostrar Datos
	if(empty($_REQUEST['idmedicamento']))
	{
		header('Location: lista_medicamento.php');
		mysqli_close($conection);
	}
	$idmedicamento = $_REQUEST['idmedicamento'];

	$sql= mysqli_query($conection,"SELECT * FROM medicamentos WHERE idmedicamento= $idmedicamento AND estatus = 1 ");
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_medicamento.php');
	}else{

		while ($data = mysqli_fetch_array($sql)) {

            $idmedicamento      = $data['idmedicamento'];
            $folio              =$data['folio'];
			$nombre           = $data['nombre_medicamento'];
			$via_administracion = $data['via_administracion'];
			$observaciones = $data['observaciones'];
            $fecha_caducidad = $data['fecha_caducidad'];
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
            <form action="" method="POST" >
                  <input type="hidden" name="idmedicamento" value="<?php echo $idmedicamento; ?>">
                  <label for="folio"></label>
                  <input type="text" name="folio" id="folio" placeholder="" value="<?php echo $folio?>">
                  <label for="hora">Nombre</label>
                  <input type="text" name="nombre_medicamento" id="nombre_medicamento" placeholder="" value="<?php echo $nombre; ?>">
                  <label for="via">V&iacute;a de administraci&oacute;n</label>
                  <input type="text" name="via_administracion" id="via" placeholder="" value="<?php echo $via_administracion; ?>">
                 <label for="observaciones">observaciones</label>
				 <input type="text" name="observaciones" id="observaciones" placeholder="observaciones" value="<?php echo $observaciones; ?>">
				 <label for="fecha_caducidad">Fecha de caducidad</label>
				 <input type="date" name="fecha_caducidad" id="fecha_caducidad" value="<?php echo $fecha_caducidad; ?>">
                  <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> Actualizar Medicamento</button>
              </form>
          </div>
	</section>

	<div  class="alert" id="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

	<?php include "includes/footer.php"; ?>
</body>
</html>