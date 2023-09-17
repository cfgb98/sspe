<?php 
	session_start();
    if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 and $_SESSION['rol'] != 3)
    {
        header("location: ./");
    }
	include "../conexion.php";
	include "funciones.php";


	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['curp']) || empty($_POST['domicilio']) || empty($_POST['nombre'])|| empty($_POST['apellido_paterno'])|| empty($_POST['apellido_materno']) || empty($_POST['hora']) || empty($_POST['fecha_nacimiento']) || empty($_POST['domicilio']) || empty($_POST['telefono'])|| empty($_POST['cod_postal']) || empty($_POST['estatus_paciente']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$idpaciente       = cacha('id');
			$nombre           = cacha('nombre');
			$apellido_paterno = cacha('apellido_paterno');
			$apellido_materno = cacha('apellido_materno');
            $hora             = cacha('hora');
            $curp             = cacha('curp');
            $fecha_nacimiento = cacha('fecha_nacimiento');
			$domicilio        = cacha('domicilio');
			$telefono         = cacha('telefono');
			$cod_postal       = cacha('cod_postal');
			$estatus_paciente = cacha('estatus_paciente');
			$usuarioid        = $_SESSION['idUser'];  
			$sql_update = mysqli_query($conection,"UPDATE pacientes
															SET  nombre = '$nombre', apellido_paterno = '$apellido_paterno', apellido_materno='$apellido_materno', hora = '$hora', curp='$curp',fecha_nacimiento='$fecha_nacimiento',domicilio='$domicilio',
															telefono='$telefono',cod_postal='$cod_postal',estatus_paciente='$estatus_paciente',idusuario='$usuarioid'
															WHERE idpaciente= $idpaciente ");

				if($sql_update){
					//header("Location: lista_p.embarazadas.php");
				}else{
					$error = mysqli_error($conection);
					$alert="<p class='msg_error'>Error al actualizar el Paciente: $error</p>";
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

			$idpaciente       = $data['idpaciente'];
            $hora             = $data['hora'];
            $curp             = $data['curp'];
			$nombre           = $data['nombre'];
			$apellido_paterno = $data['apellido_paterno'];
			$apellido_materno  = $data['apellido_materno'];
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
			<h1><i class="fas fa-procedures"></i> Actualizar Paciente</h1>
			<hr>
			<div  class="alert" id="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            <form action="" method="POST" >
                  <input type="hidden" name="id" value="<?php echo $idpaciente; ?>">
                  <label for="hora">Hora</label>
                  <input type="time" name="hora" id="hora" placeholder="" value="<?php echo $hora; ?>">
                  <label for="curp">Curp</label>
                  <input type="text" name="curp" id="curp" placeholder="Curp Completa" value="<?php echo $curp; ?>">
                 <label for="nombre">Nombre</label>
				 <input type="text" name="nombre" id="nombre" placeholder="nombre" value="<?php echo $nombre; ?>">
				 <label for="apellido_paterno">Apellido paterno</label>
				 <input type="text" name="apellido_paterno" id="apellido_paterno" placeholder="apellido paterno" value="<?php echo $apellido_paterno; ?>">
				 <label for="apellido_materno">Apellido materno</label>
				 <input type="text" name="apellido_materno" id="apellido_materno" placeholder="apellido materno" value="<?php echo $apellido_materno; ?>">
				 <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                  <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="" value="<?php echo $fecha_nacimiento; ?>">
				  <label for="domicilio">Domicilio</label>
                  <input type="text" name="domicilio" id="domicilio" placeholder="Domicilio Completo" value="<?php echo $domicilio; ?>">
				  <label for="telefono">Telefono</label>
                  <input type="number" name="telefono" id="telefono" placeholder="Numero de Telefono" value="<?php echo $telefono; ?>">
				  <label for="cod_postal">Codigo Postal</label>
                  <input type="number" name="cod_postal" id="cod_postal" placeholder="Codigo Postal" value="<?php echo $cod_postal; ?>">
				  <label for="estatus_paciente" >Estatus</label>
                  <!--<input type="text" name="estatus_paciente" id="estatus_paciente" placeholder="Registro,Ingreso,Alta">--->
                  <select name="estatus_paciente" id="estatus_paciente" value="<?php echo $estatus_paciente; ?>">
                      <option value="REGISTRO" <?php  if($estatus_paciente=="REGISTRO"){ echo "selected";} ?>>REGISTRO</option>
                      <option value="INGRESO"  <?php  if($estatus_paciente=="INGRESO"){ echo "selected";} ?>>INGRESO</option>
                      <option value="ALTA"  <?php  if($estatus_paciente=="ALTA"){ echo "selected";} ?>>ALTA</option>
                  </select>
                  
                 

                  <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> Actualizar Paciente</button>
              </form>
			  <a href="javascript: history.go(-1)" >Volver Atr&aacute;s</a>
          </div>
	</section>

	
    
	<?php include "includes/footer.php"; ?>
</body>
</html>