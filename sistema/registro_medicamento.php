
<?php
session_start();
if($_SESSION['rol'] != 1)
{
header("location: ./");
}

include "../conexion.php";
include "funciones.php";


if(!empty($_POST))
    {
        $alert='';
        if(empty($_POST['folio']) || empty($_POST['nombre']) || empty($_POST['via'])|| empty($_POST['observaciones'] || empty($_POST['caducidad'])))
        {
            $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
        }else{
          
           
            $folio= cacha('folio');
            $nombre = cacha('nombre');
            $via = cacha('via');
            $observaciones = cacha('observaciones');
            $caducidad          = cacha('caducidad');
            $idusuario        = $_SESSION['idUser'];

        $query_insert = mysqli_query($conection,"INSERT INTO medicamentos(folio,nombre_medicamento,via_administracion,observaciones,fecha_caducidad,usuario_id)
                                                         VALUES('$folio','$nombre','$via','$observaciones','$caducidad','$idusuario')");


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
    <?php include "includes/scripts.php"; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de medicamentos</title>
</head>
<body>
<?php include "includes/header.php"; ?>
<section id="container">
		
		<div class="form_register">
			<h1><i class="fas fa-pills"></i> Registro de medicamentos</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="POST" >
                  <label for="folio">Folio</label>
                  <input type="text" id="folio" name="folio" placeholder="folio" required>
                  <label for="nombre">Nombre</label>
                  <input type="text" id="nombre" name="nombre" placeholder="nombre" required>
                  <label for="via">Via de administraci&oacute;n</label>
                  <input type="text" id="via" name="via" placeholder="via de administraci&oacute;n" required>
                  <label for="observaciones">Observaciones</label>
                  <input type="text" id="observaciones" name="observaciones" placeholder="observaciones" required>
                  <label for="caducidad">Fecha de caducidad</label>
                  <input type="date" name="caducidad" id="caducidad" placeholder="" required>
                  <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i>Registrar medicamento</button>
              </form>
          </div>
	</section>
    <a href="javascript: history.go(-1)" >Volver Atr&aacute;s</a>
<?php include "includes/footer.php"; ?>
</body>
</html>
