<?php

session_start();
if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 and $_SESSION['rol'] != 3)
{
    header("location: ./");
}

include "../conexion.php";


if(!empty($_POST))
{
    var_dump($_POST);
    $alert='';
    if(empty($_POST['idpaciente']) || empty($_POST['cuantos_embarazos']) || empty($_POST['cuantos_partos']) || empty($_POST['dilatacion'])|| empty($_POST['cuantos_abortos'])|| empty($_POST['amnios'])|| empty($_POST['borramiento'])|| empty($_POST['frecuencia_fetal'])|| empty($_POST['presion_arterial'])|| empty($_POST['urgencias'])|| empty($_POST['idmedico'])|| empty($_POST['idenfermera'])|| empty($_POST['idmedicamento'])|| empty($_POST['estatus_seguimiento']))
    {
      
        $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
        
    }else{
        $idseguimiento = $_POST['idseguimiento'];
        $idpaciente = $_POST['idpaciente'];
        $cuantos_embarazos = $_POST['cuantos_embarazos'];
        $cuantos_partos = $_POST['cuantos_partos'];
        $cuantas_cesareas = $_POST['cuantas_cesareas'];
        $cuantos_abortos = $_POST['cuantos_abortos'];
        $dilatacion = $_POST['dilatacion'];
        $borramiento = $_POST['borramiento'];
        $amnios = $_POST['amnios'];
        $frecuencia_fetal = $_POST['frecuencia_fetal'];
        $presion_arterial = $_POST['presion_arterial'];
        $urgencias = $_POST['urgencias'];
        $idmedicamento = $_POST['idmedicamento'];
        $idenfermera = $_POST['idenfermera'];
        $idmedico = $_POST['idmedico'];
        $usuarioid = $_SESSION['idUser'];
        $estatus_seguimiento = $_POST['estatus_seguimiento'];

        $query_update= mysqli_query($conection,"UPDATE seguimiento SET idpaciente='$idpaciente',cuantos_embarazos='$cuantos_embarazos',cuantos_partos='$cuantos_partos',cuantos_abortos='$cuantos_abortos',dilatacion='$dilatacion',borramiento='$borramiento',amnios='$amnios',frecuencia_fetal='$frecuencia_fetal',presion_arterial='$presion_arterial',urgencias='$urgencias',idmedicamento='$idmedicamento',idenfermera='$idenfermera',idmedico='$idmedico',usuario_id='$usuarioid', estatus_seguimiento='$estatus_seguimiento' WHERE idseguimiento ='$idseguimiento'");
        if($query_update ){
            if( mysqli_affected_rows($conection)>0){
                $alert="<p class='msg_save'>Seguimiento Actualizado</p>";
            } else {
                // La consulta se ejecutó correctamente, pero no hubo cambios en la base de datos.
                $alert = "<p class='msg_info'>No se realizaron cambios en el seguimiento.</p>";
            }

        header("Location: lista_seguimiento.php");
        }else{
            $error = mysqli_error($conection);
            $alert="<p class='msg_error'>Error al actualizar el seguimiento: $error</p>";
        }
    }
}

if(empty($_REQUEST['idseguimiento']))
	{
		header('Location: lista_seguimiento.php');
		mysqli_close($conection);
	}

    $idseguimiento= $_REQUEST['idseguimiento'];
    $sql= mysqli_query($conection,"SELECT * FROM seguimiento WHERE idseguimiento='$idseguimiento' AND estatus=1");
 
	$result_sql = mysqli_num_rows($sql);
    if($result_sql == 0){
		header('Location: lista_seguimiento.php');
	}else {
        while ($data=mysqli_fetch_array($sql)) {
        $idseguimiento = $data['idseguimiento'];
        $idpaciente = $data['idpaciente'];
        $cuantos_embarazos =$data['cuantos_embarazos'];
        $cuantos_partos = $data['cuantos_partos'];
        $cuantas_cesareas = $data['cuantas_cesareas'];
        $cuantos_abortos = $data['cuantos_abortos'];
        $dilatacion = $data['dilatacion'];
        $borramiento = $data['borramiento'];
        $amnios = $data['amnios'];
        $frecuencia_fetal = $data['frecuencia_fetal'];
        $presion_arterial =$data['presion_arterial'];
        $urgencias = $data['urgencias'];
        $idmedicamento = $data['idmedicamento'];
        $idenfermera =$data['idenfermera'];
        $idmedico = $data['idmedico'];
        $usuarioid = $_SESSION['idUser'];
        $estatus_seguimiento = $data['estatus_seguimiento'];
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "includes/scripts.php"; ?>
    <title>Actualizar seguimiento</title>
</head>
<body>
<?php include "includes/header.php"; ?>

<section id="container">
       
      <div class="form_register">
          <h1><i class="fa-solid fa-user-plus"></i>Actualizar Seguimiento</h1>
          <hr>
          <div class="alert"><?php echo isset($alert) ? $alert : '';?></div>

          <form action="" method="POST" >
          <input type="hidden" name="idseguimiento" value="<?php echo $idseguimiento?>">
              
          <label for="nombre_paciente">Nombre del paciente</label>
          <?php
          $query_paciente = mysqli_query($conection,"SELECT idpaciente, nombre,apellido_paterno,apellido_materno FROM pacientes");
          $result_paciente = mysqli_num_rows($query_paciente);
          ?>
          <select name="idpaciente" id="nombre_paciente" required>
        <?php
        if ($result_paciente>0) {
            while ($pacientes = mysqli_fetch_array($query_paciente)) {
                ?>
                <option value="<?php echo $pacientes['idpaciente'];?>"><?php echo $pacientes['nombre'].' '.$pacientes['apellido_paterno'].' '.$pacientes['apellido_materno'] ?></option>
                <?php
            }
        }
        ?>
          </select>
              <label for="cantidad_embarazos">Cantidad de embarazos</label>
              <input type="number" name="cuantos_embarazos" id="cantidad_embarazos" placeholder="" title="solo n&uacute;meros en cantidad de embarazos" pattern="[0-9]+"  min="1"  value="<?php echo  $cuantos_embarazos?>" required>
              <label for="cantidad_partos">Cantidad de partos</label>
              <input type="number" name="cuantos_partos" id="cantidad_partos" placeholder="" title="solo n&uacute;meros en cantidad de partos" pattern="[0-9]+"  min="1"   value="<?php echo $cuantos_partos?>" required>
              <label for="cuantas_cesareas">Cuantas Cesareas</label>
              <input type="number" name="cuantas_cesareas" id="cuantas_cesareas" placeholder="" title="Solo n&uacute;meros en cantidad de cesareas" pattern="[0-9]+" value="<?php echo $cuantas_cesareas?>" required>
              <label for="cantidad_abortos">Cantidad de abortos</label>
              <input type="number" name="cuantos_abortos" id="cantidad_abortos" placeholder=""  pattern="[0-9]+" title="solo n&uacute;meros en cantidad de abortos" min="0"  value="<?php echo $cuantos_abortos?>" required>
              <label for="dilatacion">Dilataci&oacute;n</label>
              <input type="text" name="dilatacion" id="dilatacion" placeholder="" pattern="[A-Za-z\d]+" title="solo letras en dilataci&oacute;n" value="<?php echo $dilatacion ?>" required>
              <label for="borramiento">Borramiento</label>
              <input type="text" name="borramiento" id="borramiento" pattern="^[0-9]+$"  placeholder="" title="solo n&uacute;meros en borramiento"  value="<?php echo $borramiento ?>" required>
              <label for="amnios">Amnios</label>
              <input type="text" name="amnios" id="amnios" placeholder="Amnios" pattern="[A-Za-z\s]+" title="solo letras en amnios"  value= "<?php echo $amnios?>"required>
              <label for="frecuencia_fetal">Frecuencia fetal</label>
              <input type="text" name="frecuencia_fetal" id="frecuencia_fetal" placeholder="Frecuencia fetal" pattern="^\d{1,3}\/\d{1,3}$+" title="solo n&&uacute;meros en frecuencia fetal"  min="1" value="<?php echo $frecuencia_fetal?>" required> 
              <label for="presion_arterial">Presi&oacute;n arterial</label>
              <input type="text" name="presion_arterial" id="presion_arterial"  placeholder="Presi&oacute;n arterial" title="solo n&uacute;meros y / en presi&oacute;n arterial"  pattern="^\d{1,3}\/\d{1,3}$+" min="1" value="<?php echo $presion_arterial ?>" required>
              <label for="urgencias">Urgencias</label>
              <input type="text" name="urgencias" id="urgencias" placeholder=""  pattern="^[A-Za-z0-9\s.]+$" title="Solo letras, espacios en  y numeros en urgencias" value="<?php echo $urgencias ?>" required>
              <label for="medico">Nombre del m&eacute;dico</label>
              <?php
                $query_nombre_medico = mysqli_query($conection," SELECT u.idusuario, u.nombre, u.apellido_paterno, u.apellido_materno, m.idmedico FROM usuario u INNER JOIN medico m  ON u.idusuario = m.idusuario");
                $result_nombre_medico = mysqli_num_rows($query_nombre_medico);
             ?>
              <select name="idmedico" id="medico" required>
                <?php
                if ($result_nombre_medico>0) {
                    while ($nombre = mysqli_fetch_array($query_nombre_medico)) {
                        ?>
                        <option value="<?php echo $nombre["idmedico"];?>"><?php echo $nombre['nombre'].' '.$nombre['apellido_paterno'].' '.$nombre['apellido_materno'] ?></option>
                        <?php
                    }

                }
                ?>
              </select>
             <label for="enfermera">Enfermera</label>
            <?php
            $query_nombre_enfermera = mysqli_query($conection,"SELECT u.idusuario, u.nombre,u.apellido_paterno, u.apellido_materno, e.idenfermeras FROM usuario u INNER JOIN enfermeras e ON u.idusuario = e.idusuario");
            $result_nombre_enfermera = mysqli_num_rows($query_nombre_enfermera);
            ?>
        <select name="idenfermera" id="enfermera" required>
            <?php
            if ($result_nombre_enfermera>0) {
                while ($nombre = mysqli_fetch_array($query_nombre_enfermera)) {
                    ?>
                    <option value="<?php echo $nombre["idenfermeras"];?>"><?php echo $nombre['nombre'].' '.$nombre['apellido_paterno'].' '.$nombre['apellido_materno']?></option>
                   <?php
                }
            }
            ?>
        </select>
             <label for="medicamentos">Medicamentos</label>
             <?php
             $query_medicamentos = mysqli_query($conection,"SELECT idmedicamento, nombre_medicamento FROM medicamentos");
             $result_medicamentos = mysqli_num_rows($query_medicamentos);
             ?>
             <select name="idmedicamento" id="medicamentos" required>
                <?php
                if ($result_medicamentos>0) {
                    while ($medicamentos = mysqli_fetch_array($query_medicamentos)) {
                        ?>
                        <option value="<?php echo $medicamentos['idmedicamento'];?>"><?php echo $medicamentos['nombre_medicamento']?></option>
                        <?php
                    }
                    
                }
                ?>
             </select>
            <label for="estatus_seguimiento">Estatus del seguimiento</label>
            <input type="text" name="estatus_seguimiento" id="estatus_seguimiento" placeholder=""  pattern="[A-Za-z\s]+" title="Solo letras, comas  y espacios en blanco para estatus del seguimiento" value="<?php echo $estatus_seguimiento?>" required>
              <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i>Actualizar Seguimiento</button>
          </form>
          <a href="javascript: history.go(-1)" >Volver Atr&aacute;s</a>
      </div>
</section>

<?php 
var_dump($_POST);
?>
<?php include "includes/footer.php"; ?>
</body>
</html>