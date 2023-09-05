<?php 
    session_start();
    if($_SESSION['rol'] != 1 and $_SESSION['rol'] !=2 and $_SESSION['rol'] != 3)
    {
        header("location: ./");
    }

    include "../conexion.php";

	if(!empty($_POST))
	{
		if(empty($_POST['identrada'])){
			header("location: lista_entradas.php");
			mysqli_close($conection);
		}
		$identrada = $_POST['identrada'];

        //Para eliminar un registro en la base de datos
		//$query_delete = mysqli_query($conection,"DELETE FROM usuario WHERE idusuario =$idusuario");
        $query_delete = mysqli_query($conection,"UPDATE entradas SET estatus = 0 WHERE codentrada = $identrada ");

		if($query_delete){
			header("location: lista_entradas.php");
		}else{
			echo "Error al eliminar";
		}
	}

    if(empty($_REQUEST['id']))
	{
		header("location: lista_entradas.php");
		mysqli_close($conection);
	}else{
		$identrada = $_REQUEST['id'];

		$query = mysqli_query($conection,"SELECT * FROM entradas  WHERE codentrada = $identrada ");										
		mysqli_close($conection);										 
	    $result = mysqli_num_rows($query);

		if($result > 0){
			while($data = mysqli_fetch_array($query)){
                
                $clave    = $data['clave'];
				$cantidad = $data['cantidad'];
			}
		}else{
			header("location: lista_entradas.php");
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php";?>
	<title>Eliminar Entrada</title>
</head>
<body>
    <?php include "includes/header.php";?>
	<section id="container">
		<div class="data_delete">
		    <i class="fa-solid fa-user-xmark fa-7x" style="color: red"></i>
		   <br>
		   <br>
           <h2>¿Está seguro de eliminar la Siguiente Entrada?</h2>
		   <p>Clave: <span><?php echo $clave; ?></span></p>
           <p>Cantidad: <span><?php echo $cantidad; ?></span></p>
		   
		   <form method="POST" action="">
			   <input type="hidden"name="identrada" value="<?php echo $identrada; ?>">
			   <a href="lista_entradas.php" class="btn_cancel"><i class="fa-solid fa-ban"></i> Cancelar</a>
			   <button type="submit"  class="btn_ok"><i class="fa-solid fa-trash-can"></i> Eliminar</button>
		   </form>
		</div>
	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>