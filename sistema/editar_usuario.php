<?php 
	
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}

	include "../conexion.php";

	if(!empty($_POST))
	{
		$alert='';
		if( empty($_POST['correo']) || empty($_POST['usuario'])  || empty($_POST['rol']) || empty($_POST['cedula'])|| empty($_POST['clave']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$idUsuario         = $_POST['idUsuario'];
			$apellido_paterno  = $_POST['apellido_paterno'];
			$apellido_materno  = $_POST['apellido_materno'];
			$nombre            = $_POST['nombre'];
			$cedula            = $_POST['cedula'];
			$email             = $_POST['correo'];
			$user              = $_POST['usuario'];
			$clave             = md5($_POST['clave']);
			$rol               = $_POST['rol'];


			$query = mysqli_query($conection,"SELECT * FROM usuario 
													   WHERE (usuario = '$user' AND idusuario != $idUsuario)
													   OR (correo = '$email' AND idusuario != $idUsuario) ");

			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert='<p class="msg_error">El correo o el usuario ya existe.</p>';
			}else{

				if(empty($_POST['clave']))
				{

					$sql_update = mysqli_query($conection,"UPDATE usuario
															SET  apellido_paterno='$apellido_paterno',apellido_materno='$apellido_materno',nombre='$nombre',cedula='$cedula',correo='$email',usuario='$user',rol='$rol'
															WHERE idusuario= $idUsuario ");
				}else{
					$sql_update = mysqli_query($conection,"UPDATE usuario
															SET  apellido_paterno='$apellido_paterno',apellido_materno='$apellido_materno',nombre='$nombre',cedula='$cedula',correo='$email',usuario='$user',clave='$clave', rol='$rol'
															WHERE idusuario= $idUsuario ");

				}

				if($sql_update){
					$alert='<p class="msg_save">Usuario actualizado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar el usuario.</p>';
				}

			}


		}

	}

	//Mostrar Datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_usuarios.php');
		mysqli_close($conection);
	}
	$iduser = $_REQUEST['id'];

	$sql= mysqli_query($conection,"SELECT u.idusuario,u.apellido_paterno,u.apellido_materno,u.nombre,u.cedula,u.correo,u.usuario, (u.rol) as idrol, (r.rol) as rol
									FROM usuario u
									INNER JOIN rol r
									on u.rol = r.idrol
									WHERE idusuario= $iduser and estatus = 1 ");
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_usuarios.php');
	}else{
		$option = '';
		while ($data = mysqli_fetch_array($sql)) {
			$iduser            = $data['idusuario'];
			$apellido_paterno  = $data['apellido_paterno'];
			$apellido_materno  = $data['apellido_materno'];
			$nombre            = $data['nombre'];
			$cedula            = $data['cedula'];
			$correo            = $data['correo'];
			$usuario           = $data['usuario'];
			$idrol             = $data['idrol'];
			$rol               = $data['rol'];

			if($idrol == 1){
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
			}else if($idrol == 2){
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';	
			}else if($idrol == 3){
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
			}


		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Actualizar Usuario</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar usuario</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				  <input type="hidden" name="idUsuario" value="<?php echo $iduser; ?>">
				  <label for="apellido_paterno">Apellido Paterno</label>
                  <input type="text" name="apellido_paterno" id="apellido_paterno" placeholder="Apellido Paterno" value="<?php echo $apellido_paterno; ?>">
                  <label for="apellido_materno">Apellido Materno</label>
                  <input type="text" name="apellido_materno" id="apellido_materno" placeholder="Apellido Materno" value="<?php echo $apellido_materno; ?>">
                  <label for="nombre">Nombre</label>
                  <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>">
                  <label for="cedula">Cedula</label>
                  <input type="number" name="cedula" id="cedula" placeholder="CEDULA" value="<?php echo $cedula; ?>">
                  <label for="correo">Correo Electronico</label>
                  <input type="email" name="correo" id="correo" placeholder="Correo electrónico" value="<?php echo $correo; ?>">
                  <label for="usuario">Usuario</label>
                  <input type="text" name="usuario" id="usuario" placeholder="Usuario" value="<?php echo $usuario; ?>">
                  <label for="clave">Clave</label>
                  <input type="password" name="clave" id="clave" placeholder="Clave de acceso">
				  <label for="rol">Tipo Usuario</label>

				<?php 
					include "../conexion.php";
					$query_rol = mysqli_query($conection,"SELECT * FROM rol");
					mysqli_close($conection);
					$result_rol = mysqli_num_rows($query_rol);

				 ?>

				<select name="rol" id="rol" class="notItemOne">
					<?php
						echo $option; 
						if($result_rol > 0)
						{
							while ($rol = mysqli_fetch_array($query_rol)) {
					?>
							<option value="<?php echo $rol["idrol"]; ?>"><?php echo $rol["rol"] ?></option>
					<?php 
								# code...
							}
							
						}
					 ?>
				</select>
                  <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> Actualizar Usuario</button>
              </form>
          </div>
	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>