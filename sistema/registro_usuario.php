<?php
    session_start();
    if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
    {
        header("location: ./");
    }

    include "../conexion.php";
	include "funciones.php";

    if(!empty($_POST))
    {
        $alert='';
        if(empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['clave']))
        {
            $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
        }else{
          
            $apellido_paterno = cacha('apellido_paterno');
            $apellido_materno = cacha('apellido_materno');
            $nombre           = cacha('nombre');
            $cedula           = cacha('cedula');
            $email            = cacha('correo');
            $user             = cacha('usuario');
            $clave            = md5($_POST['clave']);
            $rol              = cacha('rol');

            $query = mysqli_query($conection, "SELECT * FROM usuario WHERE usuario = '$user' OR correo = '$email' ");
            $result = mysqli_fetch_array($query);

            if($result > 0){
                $alert='<p class="msg_error">El correo o el usuario ya existe.</p>';
            }else{
                

            $query_insert = mysqli_query($conection,"INSERT INTO usuario(apellido_paterno,apellido_materno,nombre,cedula,correo,usuario,clave,rol)
                                                                     VALUES('$apellido_paterno','$apellido_materno','$nombre','$cedula','$email','$user','$clave','$rol')");
                if($query_insert){
                    if ($_POST['rol']==2) {
                        $ultimoid_result = mysqli_query($conection,'SELECT MAX(idusuario) AS ultimo_id FROM usuario');
                        $row = mysqli_fetch_assoc($ultimoid_result);
                        $ultimo_id = $row['ultimo_id'];
                        $query_medico = mysqli_query($conection,"INSERT INTO medico(estatus_medico,idusuario) VALUES('Registro','$ultimo_id')");
                    }else if ($_POST['rol']==3) {
                        $ultimoid_result = mysqli_query($conection,'SELECT MAX(idusuario) AS ultimo_id FROM usuario');
                        $row = mysqli_fetch_assoc($ultimoid_result);
                        $ultimo_id = $row['ultimo_id'];
                        $query_medico = mysqli_query($conection,"INSERT INTO enfermeras(estatus_enfermera,idusuario) VALUES('Registro','$ultimo_id')");
                    }
                    $alert='<p class="msg_save">Usuario creado correctamente.</p>';
                }else{
                    $alert='<p class="msg_error">Error al crear el usuario.</p>';
                }
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"?>
	<title>Registro Usuario</title>
</head>
<body>
    <?php include "includes/header.php";?>
	<section id="container">
	       
          <div class="form_register">
              <h1><i class="fa-solid fa-user-plus"></i> Registro Usuario</h1>
              <hr>
              <div class="alert"><?php echo isset($alert) ? $alert : '';?></div>

              <form action="" method="POST" >
                  <label for="apellido_paterno">Apellido Paterno</label>
                  <input type="text" name="apellido_paterno" id="apellido_paterno" placeholder="Apellido Paterno" required pattern="[A-Za-z\s]+" title="solo letras y espacios">
                  <label for="apellido_materno">Apellido Materno</label>
                  <input type="text" name="apellido_materno" id="apellido_materno" placeholder="Apellido Materno" required pattern="[A-Za-z\s]+" title="solo letras y espacios">
                  <label for="nombre">Nombre</label>
                  <input type="text" name="nombre" id="nombre" placeholder="Nombre" required pattern="[A-Za-z\s]+" title="solo letras">
                  <label for="cedula">Cedula</label>
                  <input type="number" name="cedula" id="cedula" placeholder="CEDULA">
                  <label for="correo">Correo Electronico</label>
                  <input type="email" name="correo" id="correo" placeholder="Correo electrónico" required>
                  <label for="usuario">Usuario</label>
                  <input type="text" name="usuario" id="usuario" placeholder="Usuario" required pattern="[A-Za-z]+" title="solo letras">
                  <label for="clave">Clave</label>
                  <input type="password" name="clave" id="clave" placeholder="Clave de acceso"  minlength="8"  title="m&iacute;nimo 8 caracteres" required>
                  <label for="rol">Tipo Usuario</label>

                 <?php
                    $query_rol = mysqli_query($conection,"SELECT * FROM rol");
                    mysqli_close($conection);
                    $result_rol = mysqli_num_rows($query_rol);
                 ?>
                  <select name="rol" id="rol">
                     <?php 
                           if($result_rol > 0)
                           {
                               while ($rol = mysqli_fetch_array($query_rol)){
                        ?>   
                                 <option value="<?php echo $rol["idrol"]; ?>"><?php echo $rol["rol"] ?></option>    
                        <?php
                               }
                           }
                        ?>  
                  </select>
                  <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> Crear Usuario</button>
              </form>
              <a href="javascript: history.go(-1)" >Volver Atr&aacute;s</a>
          </div>
	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>