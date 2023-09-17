<?php 
    session_start();
    if($_SESSION['rol'] != 1 and $_SESSION['rol'] !=2 and $_SESSION['rol'] != 3)
    {
        header("location: ./");
    }

    include "../conexion.php";

	if(!empty($_POST))
	{
		if(empty($_POST['idpaciente'])){
			header("location: lista_p.embarazadas.php");
			mysqli_close($conection);
		}
		$idpaciente = $_POST['idpaciente'];

        //Para eliminar un registro en la base de datos
		//$query_delete = mysqli_query($conection,"DELETE FROM usuario WHERE idusuario =$idusuario");
        $query_delete = mysqli_query($conection,"UPDATE pacientes SET estatus = 0 WHERE idpaciente = $idpaciente ");

		if($query_delete){
			header("location: lista_p.embarazadas.php");
		}else{
			echo "Error al eliminar";
		}
	}

    if(empty($_REQUEST['id']))
	{
		header("location: lista_p.embarazadas.php");
		mysqli_close($conection);
	}else{
		$idpaciente = $_REQUEST['id'];

		$query = mysqli_query($conection,"SELECT nombre, apellido_paterno, apellido_materno, fecha_nacimiento FROM pacientes  WHERE idpaciente = $idpaciente ");										
		mysqli_close($conection);										 
	    $result = mysqli_num_rows($query);

		if($result > 0){
			while($data = mysqli_fetch_array($query)){
                
                $nombre     = $data['nombre'];
				$apellido_paterno = $data['apellido_paterno'];
				$apellido_materno = $data['apellido_materno'];
				$fecha_nacimiento = $data['fecha_nacimiento'];
			}
		}else{
			header("location: lista_p.embarazadas.php");
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php";?>
	<title>Eliminar Paciente</title>
</head>
<body>
    <?php include "includes/header.php";?>
	<section id="container">
		<div class="data_delete">
	    	<i class="fas fa-head-side-mask fa-7x" style="color: red"></i>
		   <br>
		   <br>
           <h2>¿Est&aacute; seguro de eliminar el Siguiente Paciente?</h2>
		   <p>Nombre: <span><?php echo $nombre .' '.$apellido_paterno.' '.$apellido_materno; ?></span></p>
           <p>Fecha de Nacimiento: <span><?php echo $fecha_nacimiento; ?></span></p>
		   
		   <form method="POST" action="">
			   <input type="hidden"name="idpaciente" value="<?php echo $idpaciente; ?>">
			   <a href="lista_p.embarazadas.php" class="btn_cancel"><i class="fa-solid fa-ban"></i> Cancelar</a>
			   <button type="submit"  class="btn_ok"><i class="fa-solid fa-trash-can"></i> Eliminar</button>
		   </form>
		</div>
	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>