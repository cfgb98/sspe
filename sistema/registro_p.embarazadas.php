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
        if(empty($_POST['curp']) || empty($_POST['domicilio']))
        {
            $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
        }else{
          
           
            $hora= $_POST['hora'];
            $nombre = $_POST['nombre'];
            $apellido1 = $_POST['apellido1'];
            $apellido2 = $_POST['apellido2'];
            $curp             = $_POST['curp'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $domicilio        = $_POST['domicilio'];
            $telefono         = $_POST['telefono'];
            $cod_postal       = $_POST['cod_postal'];
            $estatus_paciente = $_POST['estatus_paciente'];
            $idusuario        = $_SESSION['idUser'];

                $query_insert = mysqli_query($conection,"INSERT INTO pacientes(nombre,apellido_paterno,apellido_materno,hora,curp,fecha_nacimiento,domicilio,telefono,cod_postal,estatus_paciente,idusuario)
                                                         VALUES('$nombre','$apellido1','$apellido2','$hora','$curp','$fecha_nacimiento','$domicilio','$telefono','$cod_postal','$estatus_paciente','$idusuario')");


                if($query_insert){
                       $alert='<p class="msg_save">Paciente guardada correctamente.</p>';
                       header("location: lista_p.embarazadas.php");
                }else{
                      $alert='<p class="msg_error">Error al guardar la Paciente.</p>';
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
	<title>Registro De Paciente</title>
</head>
<body>
    <?php include "includes/header.php";?>
	<section id="container">
	       
          <div class="form_register">
              <h1><i class="fa-solid fa-user-plus"></i> Registro De Paciente</h1>
              <hr>
              <div class="alert"><?php echo isset($alert) ? $alert : '';?></div>

              <form action="" method="POST" >
                  <label for="hora">Hora</label>
                  <input type="time" name="hora" id="hora" placeholder="" required>
                  <label for="nombre">Nombre</label>
                  <input type="text" name="nombre" id="nombre" placeholder="nombre" required>
                  <label for="apellido1">Apellido paterno</label>
                  <input type="text" name="apellido1" id="apellido1" placeholder="apellido paterno" required>
                  <label for="apellido2">Apellido materno</label>
                  <input type="text" name="apellido2" id="apellido2" placeholder="apellido materno" required>
                  <label for="curp">Curp</label>
                  <input type="text" name="curp" id="curp" placeholder="Curp Completa" required>
                  <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                  <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="" required>
                  <label for="domicilio">Domicilio</label>
                  <input type="text" name="domicilio" id="domicilio" placeholder="Domicilio Completa" required>
                  <label for="telefono">Telefono</label>
                  <input type="number" name="telefono" id="telefono" placeholder="Telefono" required>
                  <label for="cod_postal">Codigo Postal</label>
                  <input type="text" name="cod_postal" id="cod_postal" placeholder="Codigo Postal" required>
                  <label for="estatus_paciente">Estatus</label>
                  <input type="text" name="estatus_paciente" id="estatus_paciente" placeholder="Registro,Ingreso,Alta" required>

                  <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> Guardar Paciente</button>
              </form>
          </div>
	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>