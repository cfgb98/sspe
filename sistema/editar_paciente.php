<?php 
	session_start();
    if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
    {
        header("location: ./");
    }
	include "../conexion.php";


	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['material']) || empty($_POST['fondofijo']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$idmaterial  = $_POST['id'];
            $clave      = $_POST['clave'];
            $material   = $_POST['material'];
            $fondofijo  = $_POST['fondofijo'];

			$sql_update = mysqli_query($conection,"UPDATE material
															SET clave = '$clave', material='$material',fondofijo='$fondofijo'
															WHERE codmaterial= $idmaterial ");

				if($sql_update){
					$alert='<p class="msg_save">Material actualizado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar el Material.</p>';
				}

		}


	}



	//Mostrar Datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_material.php');
		mysqli_close($conection);
	}
	$idmaterial = $_REQUEST['id'];

	$sql= mysqli_query($conection,"SELECT * FROM material WHERE codmaterial= $idmaterial and estatus = 1 ");
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_material.php');
	}else{

		while ($data = mysqli_fetch_array($sql)) {
			# code...
			$idmaterial= $data['codmaterial'];
            $clave      = $data['clave'];
            $material   = $data['material'];
            $fondofijo  = $data['fondofijo'];

		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Actualizar Material</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar Material</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="POST" >
                  <input type="hidden" name="id" value="<?php echo $idmaterial; ?>">
                  <label for="clave">Clave</label>
                  <input type="text" name="clave" id="clave" placeholder="Clave del Material" value="<?php echo $clave; ?>">
                  <label for="material">Material</label>
                  <input type="text" name="material" id="material" placeholder="Nombre del  Material" value="<?php echo $material; ?>">
                  <label for="fondofijo">Fondo Fijo</label>
                  <input type="number" name="fondofijo" id="fondofijo" placeholder="Fondo Fijo" value="<?php echo $fondofijo; ?>">
                 

                  <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> Actualizar Material</button>
              </form>
          </div>
	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>