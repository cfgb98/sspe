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
    if(empty($_POST['paciente']) || empty($_POST['cantidad_embarazos']) || empty($_POST['cantidad_partos']) || empty($_POST['dilatacion'])|| empty($_POST['cantidad_abortos'])|| empty($_POST['amnios'])|| empty($_POST['borramiento'])|| empty($_POST['frecuencia_fetal'])|| empty($_POST['presion_arterial'])|| empty($_POST['urgencias'])|| empty($_POST['medico'])|| empty($_POST['enfermera'])|| empty($_POST['medicamentos'])|| empty($_POST['estatus_seguimiento']))
    {
        // var_dump($_POST);
        // print_r($_POST);
        $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
        
    }else{
      
        $idpaciente = $_POST['paciente'];
        $query = mysqli_query($conection, "SELECT COUNT(*)  AS count_seguimiento FROM seguimiento WHERE idpaciente = '$idpaciente' ");
        $result = mysqli_fetch_array($query);
        $count_seguimiento = $result['count_seguimiento'];
        if($count_seguimiento > 0){
            $alert='<p class="msg_error">El paciente ya tiene seguimiento</p>';
        }else{

            $idpaciente = $_POST['paciente'];
            $cuantos_embarazos = $_POST['cantidad_embarazos'];
            $cuantos_partos = $_POST['cantidad_partos'];
            $cuantos_abortos = $_POST['cantidad_abortos'];
            $dilatacion = $_POST['dilatacion'];
            $borramiento = $_POST['borramiento'];
            $amnios = $_POST['amnios'];
            $frecuencia_fetal = $_POST['frecuencia_fetal'];
            $presion_arterial = $_POST['presion_arterial'];
            $urgencias = $_POST['urgencias'];
            $idmedicamento = $_POST['medicamentos'];
            $idenfermera = $_POST['enfermera'];
            $idmedico = $_POST['medico'];
            $usuarioid = $_SESSION['idUser'];
            $estatus_seguimiento = $_POST['estatus_seguimiento'];

            $query_insert = mysqli_query($conection,"INSERT INTO seguimiento(idpaciente,cuantos_embarazos,cuantos_partos,cuantos_abortos,dilatacion,borramiento,amnios,frecuencia_fetal,presion_arterial,urgencias,idmedicamento,idenfermera,idmedico,usuario_id,estatus_seguimiento)
                VALUES('$idpaciente','$cuantos_embarazos','$cuantos_partos','$cuantos_abortos','$dilatacion','$borramiento','$amnios','$frecuencia_fetal','$presion_arterial','$urgencias','$idmedicamento','$idenfermera','$idmedico','$usuarioid','$estatus_seguimiento')");
            if($query_insert){
                $alert='<p class="msg_save">Seguimiento creado correctamente.</p>';
            }else{
                $alert='<p class="msg_error">Error al crear el seguimiento.</p>';
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
<title>Registro de seguimiento</title>
</head>
<body>
<?php include "includes/header.php";?>
<section id="container">
       
      <div class="form_register">
          <h1><i class="fa-solid fa-user-plus"></i>Registro de Seguimiento</h1>
          <hr>
          <div class="alert"><?php echo isset($alert) ? $alert : '';?></div>

          <form action="" method="POST" >
              
          <label for="nombre_paciente">Nombre del paciente</label>
          <?php
          $query_paciente = mysqli_query($conection,"SELECT idpaciente, nombre,apellido_paterno,apellido_materno FROM pacientes");
          $result_paciente = mysqli_num_rows($query_paciente);
          ?>
          <select name="paciente" id="nombre_paciente" required>
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
              <input type="number" name="cantidad_embarazos" id="cantidad_embarazos" placeholder="Cantidad de embarazos" title="solo n&uacute;meros en cantidad de embarazos" pattern="[0-9]+"  min="1" required>
              <label for="cantidad_partos">Cantidad de partos</label>
              <input type="number" name="cantidad_partos" id="cantidad_partos" placeholder="Cantidad de partos" title="solo n&uacute;meros en cantidad de partos" pattern="[0-9]+"  min="1"  required>
              <label for="cantidad_abortos">Cantidad de abortos</label>
              <input type="number" name="cantidad_abortos" id="cantidad_abortos" placeholder="Cantidad de abortos"  pattern="[0-9]+" title="solo n&uacute;meros en cantidad de abortos" min="0" required>
              <label for="dilatacion">Dilataci&oacute;n</label>
              <input type="text" name="dilatacion" id="dilatacion" placeholder="Dilataci&oacute;n" pattern="[A-Za-z\d]+" title="solo letras en dilataci&oacute;n" required>
              <label for="borramiento">Borramiento</label>
              <input type="text" name="borramiento" id="borramiento" pattern="^[0-9]+$"  placeholder="Borramiento" title="solo letras en borramiento" required>
              <label for="amnios">Amnios</label>
              <input type="text" name="amnios" id="amnios" placeholder="Amnios" pattern="[A-Za-z\s]+" title="solo letras en amnios" required>
              <label for="frecuencia_fetal">Frecuencia fetal</label>
              <input type="text" name="frecuencia_fetal" id="frecuencia fetal" placeholder="Frecuencia fetal" pattern="^\d{1,3}\/\d{1,3}$+" title="solo n&&uacute;meros en frecuencia fetal"  min="1"  required> 
              <label for="presion_arterial">Presi&oacute;n arterial</label>
              <input type="text" name="presion_arterial" id="presion_arterial"  placeholder="Presi&oacute;n arterial" title="solo n&uacute;meros y / en presi&oacute;n arterial"  pattern="^\d{1,3}\/\d{1,3}$+" min="1"  required>
              <label for="urgencias">Urgencias</label>
              <input type="text" name="urgencias" id="urgencias" placeholder="Si ha tenido urgencias y su descripci&oacute;n"  pattern="^[A-Za-z0-9\s.]+$" title="Solo letras, espacios en  y numeros en urgencias" required>
              <label for="medico">Nombre del m&eacute;dico</label>
              <?php
                $query_nombre_medico = mysqli_query($conection," SELECT u.idusuario, u.nombre, u.apellido_paterno, u.apellido_materno, m.idmedico FROM usuario u INNER JOIN medico m  ON u.idusuario = m.idusuario");
                $result_nombre_medico = mysqli_num_rows($query_nombre_medico);
             ?>
              <select name="medico" id="medico" required>
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
        <select name="enfermera" id="enfermera" required>
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
             <select name="medicamentos" id="medicamentos" required>
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
            <input type="text" name="estatus_seguimiento" id="estatus_seguimiento" placeholder="Estatus del seguimiento"  pattern="[A-Za-z\s]+" title="Solo letras, comas  y espacios en blanco para estatus del seguimiento" required>
              <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i>Crear Seguimiento</button>
          </form>
          <a href="javascript: history.go(-1)" >Volver Atr&aacute;s</a>
      </div>
</section>

<?php include "includes/footer.php"; ?>
</body>
</html>