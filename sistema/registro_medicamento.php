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
          

            $folio              = $_POST['folio'];
            $nombre_medicamento = $_POST['nombre_medicamento'];
            $via_administracion = $_POST['via_administracion'];
            $observaciones      = $_POST['observaciones'];
            $fecha_caducidad    = $_POST['fecha_caducidad'];
            $usuario_id         = $_SESSION['idUser'];

                $query_insert = mysqli_query($conection,"INSERT INTO medicamentos(folio,nombre_medicamento,via_administracion,observaciones,fecha_caducidad,usuario_id)
                                                         VALUES('$folio','$nombre_medicamento','$via_administracion','$observaciones','$fecha_caducidad','$usuario_id')");


                if($query_insert){
                       $alert='<p class="msg_save">Medicamento guardado correctamente.</p>';
                }else{
                      $alert='<p class="msg_error">Error al guardar el Medicamento.</p>';
                }
        }
        mysqli_close($conection);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"?>
	<title>Registro De Medicamentos</title>
</head>
<body>
    <?php include "includes/header.php";?>
	<section id="container">
	       
          <div class="form_register">
              <h1><i class="fa-solid fa-user-plus"></i> Registro De Mediamentos</h1>
              <hr>
              <div class="alert"><?php echo isset($alert) ? $alert : '';?></div>

              <form action="" method="POST" >
                  <label for="folio">Folio</label>
                  <input type="number" name="folio" id="folio" placeholder="Numero de Folio">
                  <label for="nombre_medicamento">Nombre del Medicamento</label>
                  <input type="text" name="nombre_medicamento" id="nombre_medicamento" placeholder="Nombre del Medicamento">
                  <label for="via_administracion">Via de Administracion</label>
                  <input type="text" name="via_administracion" id="via_administracion" placeholder="Via de Administracion">
                  <label for="observaciones">Observaciones</label>
                  <input type="text" name="observaciones" id="observaciones" placeholder="Observaciones">
                  <label for="fecha_caducidad">fecha de Caducidad</label>
                  <input type="date" name="fecha_caducidad" id="fecha_caducidad" placeholder="">
                 
                 <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> Guardar Medicamento</button>
              </form>
          </div>
	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>