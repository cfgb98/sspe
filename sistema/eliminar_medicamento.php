<?php 
    session_start();
    if($_SESSION['rol'] != 1 and $_SESSION['rol'] !=2 and $_SESSION['rol'] != 3 and $_SESSION['rol'] != 4)
    {
        header("location: ./");
    }

    include "../conexion.php";

	if(!empty($_POST))
	{
		if(empty($_POST['idmedicamento'])){
			header("location: lista_medicamento.php");
			mysqli_close($conection);
		}
		$idmedicamento = $_POST['idmedicamento'];

        //Para eliminar un registro en la base de datos
		//$query_delete = mysqli_query($conection,"DELETE FROM usuario WHERE idusuario =$idusuario");
        $query_delete = mysqli_query($conection,"UPDATE medicamentos SET estatus = 0 WHERE idmedicamento = $idmedicamento ");

		if($query_delete){
			header("location: lista_medicamento.php");
		}else{
			echo "Error al eliminar";
		}
	}

    if(empty($_REQUEST['id']))
	{
		header("location: lista_medicamento.php");
		mysqli_close($conection);
	}else{
		$idmedicamento = $_REQUEST['id'];

		$query = mysqli_query($conection,"SELECT * FROM medicamentos  WHERE idmedicamento = $idmedicamento ");										
		mysqli_close($conection);										 
	    $result = mysqli_num_rows($query);

		if($result > 0){
			while($data = mysqli_fetch_array($query)){
                
                $folio     = $data['folio'];
				$nombre_medicamento = $data['nombre_medicamento'];
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
           <h2>¿Está seguro de eliminar el Siguiente Medicamento?</h2>
		   <p>Folio: <span><?php echo $folio; ?></span></p>
           <p>Nombre del Medicamento: <span><?php echo $nombre_medicamento; ?></span></p>
		   
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