<?php
    
    $alert = '';
session_start();
if(!empty($_SESSION['active']))
{
    header('location: sistema/');
}else{
    if(!empty($_POST))
    {
        if(empty($_POST['usuario']) || empty($_POST['clave']))
        {
            $alert = 'Ingrese su usuario y su clave';
        }else{

            require_once "conexion.php";

            $user = mysqli_real_escape_string($conection, $_POST['usuario']);
            $pass = md5(mysqli_real_escape_string($conection,$_POST['clave']));

            $query = mysqli_query($conection,"SELECT * FROM usuario WHERE usuario= '$user' AND clave = '$pass'");
            mysqli_close($conection);
            $result = mysqli_num_rows($query);

            if($result > 0)
            {
                $data = mysqli_fetch_array($query);
                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $data['idusuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['email'] = $data['correo'];
                $_SESSION['user'] = $data['usuario'];
                $_SESSION['rol'] = $data['rol'];

                header('location: sistema/');
            }else{
                $alert = 'El Usuario o la clave son incorrectos';
                session_destroy();
            }
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SSPE</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <section id="container">
          
         <form action="" method="POST">
         <img src="img/login.png" alt="login">
             <h3>Iniciar Sesion</h3>
             <!---<img src="" alt="Login" width="70%">--->

             <input type="text" name="usuario" placeholder="Usuario" required>
             <input type="password" name="clave" placeholder="Contrase&ntilde;a" required>
             <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
             <input type="submit" value="INGRESAR">
         </form>
    </section>
</body>
</html>