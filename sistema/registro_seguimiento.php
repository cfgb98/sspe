<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
{
    header("location: ./");
}

include "../conexion.php";

if(!empty($_POST))
{
    var_dump($_POST);
    $alert='';
    if ((empty(trim($_POST['idpaciente'])) || $_POST['cuantos_embarazos'] <= 0 || $_POST['cuantos_partos'] <= 0 ||
    $_POST['cuantos_abortos'] < 0 || empty(trim($_POST['dilatacion'])) || empty(trim($_POST['amnios'])) ||
    empty(trim($_POST['borramiento'])) || $_POST['frecuencia_fetal'] <= 0 || empty(trim($_POST['presion_arterial'])) ||
    empty(trim($_POST['urgencias'])) || empty(trim($_POST['idmedico'])) || empty(trim($_POST['idenfermera'])) ||
    empty(trim($_POST['idmedicamentos'])) || empty(trim($_POST['estatus_seguimiento']))))
    {
      
        $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
        
    }else{
      
        $idpaciente = $_POST['idpaciente'];
        $query = mysqli_query($conection, "SELECT COUNT(*)  AS count_seguimiento FROM seguimiento WHERE idpaciente = '$idpaciente' ");
        $result = mysqli_fetch_array($query);
        $count_seguimiento = $result['count_seguimiento'];
        if($count_seguimiento > 0){
            $alert='<p class="msg_error">El paciente ya tiene seguimiento</p>';
        }else{

            $idpaciente = $_POST['idpaciente'];
            $cuantos_embarazos = $_POST['cuantos_embarazos'];
            $cuantos_partos = $_POST['cuantos_partos'];
            $cuantos_abortos = $_POST['cuantos_abortos'];
            $dilatacion = $_POST['dilatacion'];
            $borramiento = $_POST['borramiento'];
            $amnios = $_POST['amnios'];
            $frecuencia_fetal = $_POST['frecuencia_fetal'];
            $presion_arterial = $_POST['presion_arterial'];
            $urgencias = $_POST['urgencias'];
            $idmedicamentos = $_POST['idmedicamentos'];
            $idenfermera = $_POST['idenfermera'];
            $idmedico = $_POST['idmedico'];
            $usuarioid = $_POST['idusuario'];
            $estatus_seguimiento = $_POST['estatus_seguimiento'];

            $query_insert = mysqli_query($conection,"INSERT INTO seguimiento(idpaciente,cuantos_embarazos,cuantos_partos,cuantos_abortos,dilatacion,borramiento,amnios,frecuencia_fetal,presion_arterial,urgencias,,idenfermera,idmedico,usuario_id,estatus_seguimiento)
                VALUES($idpaciente,$cuantos_embarazos,$cuantos_partos,$cuantos_abortos,'$dilatacion','$borramiento','$amnios',$frecuencia_fetal,'$presion_arterial','$urgencias',$idenfermera,$idmedico,$usuarioid,'$estatus_seguimiento')");
                $id_seguimiento = mysqli_insert_id($conection);//obtener ultimo id seguimiento
            
                foreach ($idmedicamentos as $idmedicamento) {
            
                $query_insert_seguimiento_medicamento = mysqli_query($conection,"INSERT INTO seguimiento_medicamento(idseguimiento,idmedicamento) VALUES($id_seguimiento,$idmedicamento)");
            
                    if (!$query_insert_seguimiento_medicamento) {
                        $alert='<p class="msg_error">Error al insertar medicamentos en seguimiento:'. mysqli_error($conection).'</p>';
                    } else {
                        $alert='<p class="msg_save">Medicamentos insertados correctamente en seguimiento.</p>';
                    }
                    
            }

            if($query_insert && mysqli_affected_rows($conection) > 0){ 

                echo "Consulta insert: $query_insert";
                $alert='<p class="msg_save">Seguimiento creado correctamente.</p>';
            }else{
                $alert='<p class="msg_error">Error al crear el seguimiento:'. mysqli_error($conection).'</p>';
                var_dump($query_insert);
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
              <input type="hidden" name="idusuario" value="<?php echo $_SESSION['idUser']?>">
          <label for="nombre_paciente">Nombre del paciente</label>
          <?php
          $query_paciente = mysqli_query($conection,"SELECT idpaciente, nombre,apellido_paterno,apellido_materno FROM pacientes");
          $result_paciente = mysqli_num_rows($query_paciente);
          ?>
          <select name="idpaciente" id="nombre_paciente" required>
        <?php
        if ($result_paciente>0) {
            while ($pacientes = mysqli_fetch_assoc($query_paciente)) {
                ?>
                <option value="<?php echo $pacientes['idpaciente'];?>"><?php echo $pacientes['nombre'].' '.$pacientes['apellido_paterno'].' '.$pacientes['apellido_materno'] ?></option>
                <?php
            }
        }
        ?>
          </select>
              <label for="cuantos_embarazos">Cantidad de embarazos</label>
              <input type="number" name="cuantos_embarazos" id="cuantos_embarazos" placeholder="Cantidad de embarazos" title="solo n&uacute;meros en cantidad de embarazos" pattern="^[0-9]+$"  min="1" required>
              <label for="cuantos_partos">Cantidad de partos</label>
              <input type="number" name="cuantos_partos" id="cuantos_partos" placeholder="Cantidad de partos" title="solo n&uacute;meros en cantidad de partos" pattern="^[0-9]+$"  min="1"  required>
              <label for="cuantos_abortos">Cantidad de abortos</label>
              <input type="number" name="cuantos_abortos" id="cuantos_abortos" placeholder="Cantidad de abortos"  pattern="^[0-9]+$ title="solo n&uacute;meros en cantidad de abortos" min="0" required>
              <label for="dilatacion">Dilataci&oacute;n</label>
              <input type="text" name="dilatacion" id="dilatacion" placeholder="Dilataci&oacute;n" pattern="^\d+cm$" title="solo letras en dilataci&oacute;n" required>
              <label for="borramiento">Borramiento</label>
              <input type="text" name="borramiento" id="borramiento" pattern="^(100|[1-9][0-9]?|0)$"  placeholder="Borramiento" title="solo letras en numeros" required>
              <label for="amnios">Amnios</label>
              <input type="text" name="amnios" id="amnios" placeholder="Amnios" pattern="^[A-Za-z\s]+$" title="solo letras en amnios" required>
              <label for="frecuencia_fetal">Frecuencia fetal</label>
              <input type="number" name="frecuencia_fetal" id="frecuencia_fetal" placeholder="Frecuencia fetal"  pattern="^\d{1,3}$" title="solo n&&uacute;meros en frecuencia fetal"  min="1"  required> 
              <label for="presion_arterial">Presi&oacute;n arterial</label>
              <input type="text" name="presion_arterial" id="presion_arterial"  placeholder="Presi&oacute;n arterial" title="solo n&uacute;meros y / en presi&oacute;n arterial"  pattern="^\d{1,3}\/\d{1,3}$" min="1"  required>
              <label for="urgencias">Urgencias</label>
              <input type="text" name="urgencias" id="urgencias" placeholder="Si ha tenido urgencias y su descripci&oacute;n"  pattern="^[A-Za-z0-9\s.]+$" title="Solo letras, espacios en  y numeros en urgencias" required>
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
             <select name="idmedicamentos[]" id="medicamentos" multiple required>
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
            <input type="text" name="estatus_seguimiento" id="estatus_seguimiento" placeholder="Estatus del seguimiento" required>
              <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i>Crear Seguimiento</button>
          </form>
          <a href="javascript: history.go(-1)" >Volver Atr&aacute;s</a>
      </div>
</section>

<?php include "includes/footer.php"; ?>
</body>
</html>