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
		if(empty($_POST['curp']) || empty($_POST['domicilio']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$idpaciente       = $_POST['id'];
            $hora             = $_POST['hora'];
            $curp             = $_POST['curp'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
			$domicilio        = $_POST['domicilio'];
			$telefono         = $_POST['telefono'];
			$cod_postal       = $_POST['cod_postal'];
			$estatus_paciente = $_POST['estatus_paciente'];

			$sql_update = mysqli_query($conection,"UPDATE pacientes
															SET hora = '$hora', curp='$curp',fecha_nacimiento='$fecha_nacimiento',domicilio='$domicilio',
															telefono='$telefono',cod_postal='$cod_postal',estatus_paciente='$estatus_paciente'
															WHERE idpaciente= $idpaciente ");

				if($sql_update){
					$alert='<p class="msg_save">Paciente actualizado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar el Paciente.</p>';
				}

		}


	}



	//Mostrar Datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_p.embarazadas.php');
		mysqli_close($conection);
	}
	$idpaciente = $_REQUEST['id'];

	$sql= mysqli_query($conection,"SELECT * FROM pacientes WHERE idpaciente= $idpaciente and estatus = 1 ");
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_p.embarazadas.php');
	}else{

		while ($data = mysqli_fetch_array($sql)) {
			# code...
			$idpaciente       = $data['idpaciente'];
            $hora             = $data['hora'];
            $curp             = $data['curp'];
            $fecha_nacimiento = $data['fecha_nacimiento'];
			$domicilio        = $data['domicilio'];
			$telefono         = $data['telefono'];
			$cod_postal       = $data['cod_postal'];
			$estatus_paciente = $data['estatus_paciente'];

		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Actualizar Paciente</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar Paciente</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="POST" >
                  <input type="hidden" name="id" value="<?php echo $idpaciente; ?>">
                  <label for="hora">Hora</label>
                  <input type="time" name="hora" id="hora" placeholder="" value="<?php echo $hora; ?>">
                  <label for="curp">Curp</label>
                  <input type="text" name="curp" id="curp" placeholder="Curp Completa" value="<?php echo $curp; ?>">
                  <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                  <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="" value="<?php echo $fecha_nacimiento; ?>">
				  <label for="domicilio">Domicilio</label>
                  <input type="text" name="domicilio" id="domicilio" placeholder="Domicilio Completo" value="<?php echo $domicilio; ?>">
				  <label for="telefono">Telefono</label>
                  <input type="number" name="telefono" id="telefono" placeholder="Numero de Telefono" value="<?php echo $telefono; ?>">
				  <label for="cod_postal">Codigo Postal</label>
                  <input type="number" name="cod_postal" id="cod_postal" placeholder="Codigo Postal" value="<?php echo $cod_postal; ?>">
				  <label for="estatus_paciente">Estatus</label>
                  <input type="text" name="estatus_paciente" id="estatus_paciente" placeholder="Registro,Ingreso,Alta" value="<?php echo $estatus_paciente; ?>">
                 

                  <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> Actualizar Paciente</button>
              </form>
          </div>
	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>