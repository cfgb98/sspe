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
        if(empty($_POST['nombre']) || empty($_POST['edad']))
        {
            $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
        }else{
          

            $nombre        = $_POST['nombre'];
            $noexpediente  = $_POST['noexpediente'];
            $edad          = $_POST['edad'];
            $telefono      = $_POST['telefono'];
            $curp          = $_POST['curp'];
            $domicilio     = $_POST['domicilio'];
            $fecha         = $_POST['fecha'];
            $medico        = $_POST['medico'];
            $medicamento   = $_POST['medicamento'];
            $hora          = $_POST['hora'];
            $usuario_id    = $_SESSION['idUser'];

                $query_insert = mysqli_query($conection,"INSERT INTO pacientes(nombre,noexpediente,edad,telefono,curp,domicilio,fecha,medico,
                                                                     medicamento,hora,usuario_id)
                                                         VALUES('$nombre','$noexpediente','$edad','$telefono','$curp','$domicilio','$fecha',
                                                         '$medico','$medicamento','$hora','$usuario_id')");


                if($query_insert){
                       $alert='<p class="msg_save">Paciente guardado correctamente.</p>';
                }else{
                      $alert='<p class="msg_error">Error al guardar el Paciente.</p>';
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
	<title>Registro de Paciente</title>
</head>
<body>
    <?php include "includes/header.php";?>
	<section id="container">
	       
          <div class="form_register">
              <h1><i class="fa-sharp fa-solid fa-briefcase"></i> Registro de Paciente</h1>
              <hr>
              <div class="alert"><?php echo isset($alert) ? $alert : '';?></div>

              <form action="" method="POST" >
                  <label for="clave">Clave</label>
                  <input type="text" name="clave" id="clave" placeholder="Clave del Material">
                  <label for="material">Material</label>
                  <input type="text" name="material" id="material" placeholder="Nombre del  Material">
                  <label for="fondofijo">Fondo Fijo</label>
                  <input type="number" name="fondofijo" id="fondofijo" placeholder="Fondo Fijo">
                  <label for="proveedor">Proveedor</label>
                  <?php 
                    
                    $query_proveedor = mysqli_query($conection,"SELECT codproveedor, proveedor FROM proveedor WHERE
                      estatus = 1 ORDER BY proveedor ASC");
                    $result_proveedor = mysqli_num_rows($query_proveedor);
                    mysqli_close($conection);
                  ?>
                  <select name="proveedor" id="proveedor">
                  <?php
                     if($result_proveedor > 0){
                           while($proveedor = mysqli_fetch_array($query_proveedor)){
                           
                  ?>
                      <option value="<?php echo $proveedor['codproveedor'];?>"><?php echo $proveedor['proveedor'];?></option>
                  <?php 
                     }
                    }
                  ?>
                  </select>

                  <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> Guardar Paciente</button>
              </form>
          </div>
	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>