<?php

session_start();
if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 and $_SESSION['rol'] != 3)
{
    header("location: ./");
}

include "../conexion.php";
include "funciones.php";


if(!empty($_POST))
{
    //var_dump($_POST);
    $alert='';
    if(empty($_POST['idpaciente']) || empty($_POST['cuantos_embarazos']) || empty($_POST['cuantos_partos']) || empty($_POST['dilatacion'])|| empty($_POST['amnios'])|| empty($_POST['frecuencia_fetal'])|| empty($_POST['presion_arterial'])|| empty($_POST['urgencias'])|| empty($_POST['idmedico'])|| empty($_POST['idenfermera'])|| empty($_POST['idmedicamentos'])|| empty($_POST['estatus_seguimiento']))
    {
      
        $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		if(empty($_POST['idpaciente']) ){
			echo "idpaciente";
		}
		if(empty($_POST['estatus_seguimiento'])){ echo "estatus_seguimiento"; }
		if(empty($_POST['cuantos_embarazos'])){ echo "cuantos_embarazos"; }
		if(empty($_POST['cuantos_partos'])){ echo "cuantos_partos"; }
		if(empty($_POST['dilatacion']))		{ echo "dilatacion"; }
		if(empty($_POST['cuantos_abortos'])){ echo "cuantos_abortos"; }
		if(empty($_POST['amnios']))	{ echo "amnios"; }
		if(empty($_POST['borramiento'])){ echo "borramiento"; }
		if(empty($_POST['frecuencia_fetal'])){ echo "frecuencia_fetal"; }
		if(empty($_POST['presion_arterial']))	{ echo "presion_arterial"; }
		if(empty($_POST['idenfermera'])){ echo "idenfermera"; }
		if(empty($_POST['idmedico'])){ echo "idmedico"; }
		if(empty($_POST['frecuencia_fetal'])){ echo "frecuencia_fetal"; }
        
    }else{
		
		
		
        $idseguimiento = cacha('idseguimiento');
        $idpaciente = cacha('idpaciente');
        $cuantos_embarazos = cacha('cuantos_embarazos');
        $cuantos_partos = cacha('cuantos_partos');
        $cuantos_abortos = cacha('cuantos_abortos');
        $dilatacion = cacha('dilatacion');
        $borramiento = cacha('borramiento');
        $amnios = cacha('amnios');
        $frecuencia_fetal = cacha('frecuencia_fetal');
        $presion_arterial = str_replace("_","",cacha('presion_arterial'));
        $urgencias = cacha('urgencias');
        //$idmedicamento = $_POST['idmedicamento'];
		$idmedicamentos2 = $_POST['idmedicamentos'];
		$lista="";
			if(is_array($idmedicamentos2)){
				$idmedicamentos=implode(",",$idmedicamentos2);
				for($a=0;$a<count($idmedicamentos2);$a++){
					$lista.="'".$idmedicamentos2[$a]."',";
				}
				$lista=substr($lista,0,-1);
			}
        $idenfermera = $_POST['idenfermera'];
        $idmedico = $_POST['idmedico'];
        $usuarioid = $_SESSION['idUser'];
        $estatus_seguimiento = $_POST['estatus_seguimiento'];

        $query_update= mysqli_query($conection,"UPDATE seguimiento SET idpaciente='$idpaciente',cuantos_embarazos='$cuantos_embarazos',cuantos_partos='$cuantos_partos',cuantos_abortos='$cuantos_abortos',dilatacion='$dilatacion',borramiento='$borramiento',amnios='$amnios',frecuencia_fetal='$frecuencia_fetal',presion_arterial='$presion_arterial',urgencias='$urgencias',idenfermera='$idenfermera',idmedico='$idmedico',usuario_id='$usuarioid', estatus_seguimiento='$estatus_seguimiento' WHERE idseguimiento ='$idseguimiento'");
        if($query_update ){
            if( mysqli_affected_rows($conection)>0){
                $alert="<p class='msg_save'>Seguimiento Actualizado</p>";
				$sql_quita="update seguimiento_medicamento set estatus=0 where idseguimiento='$idseguimiento' and idmedicamento not in ($lista)";
				$rsql_quita=mysqli_query($conection,$sql_quita);
				if(!$rsql_quita){
				//	$alert.="<p class='msg_error'>No se quitaron medicamentos $sql_quita</p>";
				}
				else{
				//	$alert.="<p class='msg_error'>No se quitaron medicamentos $sql_quita</p>";
				}
				$sql_restantes="select idmedicamento from seguimiento_medicamento where estatus=1 and idseguimiento='$idseguimiento'";
				$rsql_restantes=mysqli_query($conection,$sql_restantes);
				$m=0;
				while($amed=mysqli_fetch_row($rsql_restantes)){
					$ami[$m]=$amed[0];
					$m++;
				}
				if(isset($ami)){
					//$alert.="<p class='msg_info'>si esta ".$idmedicamentos2[$i]."</p>";
					//print_r($ami);
					//echo "<br>";
				for($i=0;$i<count($idmedicamentos2);$i++){
					echo "$idmedicamentos2[$i] <br>";
					if(in_array($idmedicamentos2[$i],$ami)){
						//$alert.="<p class='msg_info'>si esta ".$idmedicamentos2[$i]."</p>";
						
					}
					else{
						$nmed=$idmedicamentos2[$i];
						$sql_pon="insert into seguimiento_medicamento(idseguimiento,idmedicamento) VALUES ('$idseguimiento','$nmed')";
						$rsql_pon=mysqli_query($conection,$sql_pon);
						//$alert.="<p class='msg_info'>se agrego ".$idmedicamentos2[$i]."</p>";
					}
					
				}
				}
				else{
					for($i=0;$i<count($idmedicamentos2);$i++){
					echo "$idmedicamentos2[$i] <br>";
					
						$nmed=$idmedicamentos2[$i];
						$sql_pon="insert into seguimiento_medicamento(idseguimiento,idmedicamento) VALUES ('$idseguimiento','$nmed')";
						$rsql_pon=mysqli_query($conection,$sql_pon);
						$alert.="<p class='msg_info'>se agrego ".$idmedicamentos2[$i]."</p>";
					
					
					}
				}
				
				
				
				
            } else {
                // La consulta se ejecutó correctamente, pero no hubo cambios en la base de datos.
                $alert = "<p class='msg_info'>No se realizaron cambios en el seguimiento.</p>";
				$sql_quita="update seguimiento_medicamento set estatus=0 where idseguimiento='$idseguimiento' and idmedicamento not in ($lista)";
				$rsql_quita=mysqli_query($conection,$sql_quita);
				if(!$rsql_quita){
					//$alert.="<p class='msg_error'>No se quitaron medicamentos $sql_quita</p>";
				}
				else{
					//$alert.="<p class='msg_info'>No se quitaron medicamentos $sql_quita</p>";
				}
				$sql_restantes="select idmedicamento from seguimiento_medicamento where estatus=1 and idseguimiento='$idseguimiento'";
				$rsql_restantes=mysqli_query($conection,$sql_restantes);
				$m=0;
				while($amed=mysqli_fetch_row($rsql_restantes)){
					$ami[$m]=$amed[0];
					$m++;
				}
				if(isset($ami)){
					//$alert.="<p class='msg_info'>si esta ".$idmedicamentos2[$i]."</p>";
					//print_r($ami);
					//echo "<br>";
				for($i=0;$i<count($idmedicamentos2);$i++){
					//echo "$idmedicamentos2[$i] <br>";
					if(in_array($idmedicamentos2[$i],$ami)){
						$alert.="<p class='msg_info'>si esta ".$idmedicamentos2[$i]."</p>";
						
					}
					else{
						$nmed=$idmedicamentos2[$i];
						$sql_pon="insert into seguimiento_medicamento(idseguimiento,idmedicamento) VALUES ('$idseguimiento','$nmed')";
						$rsql_pon=mysqli_query($conection,$sql_pon);
						$alert.="<p class='msg_info'>se agrego ".$idmedicamentos2[$i]."</p>";
					}
					
				}
				}
				else{
					for($i=0;$i<count($idmedicamentos2);$i++){
					//echo "$idmedicamentos2[$i] <br>";
					
						$nmed=$idmedicamentos2[$i];
						$sql_pon="insert into seguimiento_medicamento(idseguimiento,idmedicamento) VALUES ('$idseguimiento','$nmed')";
						$rsql_pon=mysqli_query($conection,$sql_pon);
						$alert.="<p class='msg_info'>se agrego ".$idmedicamentos2[$i]."</p>";
					
					
					}
				}
            }

        //header("Location: lista_seguimiento.php");
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
        $cuantos_abortos = $data['cuantos_abortos'];
        $dilatacion = $data['dilatacion'];
        $borramiento = $data['borramiento'];
        $amnios = $data['amnios'];
        $frecuencia_fetal = $data['frecuencia_fetal'];
        $presion_arterial =$data['presion_arterial'];
        $urgencias = $data['urgencias'];
     //   $idmedicamento = $data['idmedicamento'];
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
<?php
if(isset($_GET['idseguimiento'])){
$seg=$_GET['idseguimiento'];

}
          $query_paciente = mysqli_query($conection,"SELECT idpaciente, nombre,apellido_paterno,apellido_materno FROM pacientes where idpaciente='$seg'");
          $result_paciente = mysqli_num_rows($query_paciente);
		  if ($result_paciente>0) {
            $pacientes = mysqli_fetch_array($query_paciente);
		  }
          ?>

<section id="container">
       
      <div class="form_register">
          <h1><i class="fas fa-file-medical-alt"></i> Actualizar Seguimiento</h1>
          <hr>
          <div class="alert"><?php echo isset($alert) ? $alert : '';?></div>

          <form action="" method="POST" >
          <input type="hidden" name="idseguimiento" value="<?php echo $idseguimiento?>">
              
          <label for="nombre_paciente2">Nombre del paciente</label>
		  <input type="hidden" name="idpaciente" id="nombre_paciente" value="<?php echo $pacientes['idpaciente'];?>">
		  <?php 
		  $nomc=$pacientes['nombre'].' '.$pacientes['apellido_paterno'].' '.$pacientes['apellido_materno'];
		  ?>
		  <input type="text" name="nombre_paciente2" id="nombre_paciente2" value="<?php echo $nomc ?>" readonly>
		  <?php echo $pacientes['nombre'].' '.$pacientes['apellido_paterno'].' '.$pacientes['apellido_materno']; ?>
          
          <!--<select name="idpaciente" id="nombre_paciente" required>
        <?php
       /* if ($result_paciente>0) {
            while ($pacientes = mysqli_fetch_array($query_paciente)) {
                ?>
                <option value="<?php echo $pacientes['idpaciente'];?>" <?php if(){ } ?>><?php echo $pacientes['nombre'].' '.$pacientes['apellido_paterno'].' '.$pacientes['apellido_materno'] ?></option>
                <?php
            }
        }*/
        ?>
          </select>-->
              <label for="cantidad_embarazos">Cantidad de embarazos</label>
              <input type="number" name="cuantos_embarazos" id="cantidad_embarazos" placeholder="" title="solo n&uacute;meros en cantidad de embarazos" pattern="[0-9]+"  min="1"  value="<?php echo  $cuantos_embarazos?>" required>
              <label for="cantidad_partos">Cantidad de partos</label>
              <input type="number" name="cuantos_partos" id="cantidad_partos" placeholder="" title="solo n&uacute;meros en cantidad de partos" pattern="[0-9]+"  min="1"   value="<?php echo $cuantos_partos?>" required>
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
			 $qmed="select idmedicamento from seguimiento_medicamento where idseguimiento='$idseguimiento' and estatus=1";
					$rqmed=mysqli_query($conection,$qmed);
					$o=0;
					while($datam =mysqli_fetch_row($rqmed)){
						$cat_medicamentos[$o]=$datam[0];
						$o++;
			}
             ?>
             <select multiple name="idmedicamentos[]" id="medicamentos" required>
                <?php
                if ($result_medicamentos>0) {
                    while ($medicamentos = mysqli_fetch_array($query_medicamentos)) {
                        ?>
                        <option value="<?php echo $medicamentos['idmedicamento'];?>" <?php if(isset($cat_medicamentos)){if(in_array($medicamentos['idmedicamento'], $cat_medicamentos)){ echo " selected ";} } ?>><?php echo $medicamentos['nombre_medicamento']?></option>
                        <?php
                    }
                    
                }
                ?>
             </select>
            <label for="estatus_seguimiento">Estatus del seguimiento</label>
           <!-- <input type="text" name="estatus_seguimiento" id="estatus_seguimiento" placeholder=""  pattern="[A-Za-z\s]+" title="Solo letras, comas  y espacios en blanco para estatus del seguimiento" value="<?php echo $estatus_seguimiento?>" required>-->
           <select name="estatus_seguimiento" id="estatus_seguimiento" required >
                      <option value="PROCESO" <?php  if($estatus_seguimiento=="PROCESO"){ echo "selected";} ?>>PROCESO</option>
                      <option value="INTERMEDIO"  <?php  if($estatus_seguimiento=="INTERMEDIO"){ echo "selected";} ?>>INTERMEDIO</option>
                      <option value="SALIDA"  <?php  if($estatus_seguimiento=="SALIDA"){ echo "selected";} ?>>SALIDA</option>
                  </select>
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
<script>
$(document).ready(function(){
  //alert('entra');
  $('#medicamentos').selectize();
  $('#presion_arterial').mask('999?/999?',{autoclear: false});
});
</script>
</html>