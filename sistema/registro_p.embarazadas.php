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
        $alert='';
        if(empty($_POST['curp']) || empty($_POST['domicilio']))
        {
            $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
        }else{
          
           
            $hora= cacha('hora');
            $nombre = cacha('nombre');
            $apellido1 = cacha('apellido1');
            $apellido2 = cacha('apellido2');
            $curp             = cacha('curp');
            $fecha_nacimiento = cacha('fecha_nacimiento');
            $domicilio        = cacha('domicilio');
            $telefono         = cacha('telefono');
            $cod_postal       = cacha('cod_postal');
            $estatus_paciente = cacha('estatus_paciente');
            $idusuario        = $_SESSION['idUser'];

                $query_insert = mysqli_query($conection,"INSERT INTO pacientes(nombre,apellido_paterno,apellido_materno,hora,curp,fecha_nacimiento,domicilio,telefono,cod_postal,estatus_paciente,idusuario)
                                                         VALUES('$nombre','$apellido1','$apellido2','$hora','$curp','$fecha_nacimiento','$domicilio','$telefono','$cod_postal','$estatus_paciente','$idusuario')");


                if($query_insert){
                       $alert='<p class="msg_save">Paciente guardada correctamente.</p>';
                      // header("location: lista_p.embarazadas.php");
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
              <h1><i class="fas fa-procedures"></i> Registro De Paciente</h1>
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
                  <input type="text" name="curp" id="curp" placeholder="Curp Completa" onchange="fecha_nac1(this.value)" required>
                  <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                  <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="" required >
                  <label for="domicilio">Domicilio</label>
                  <input type="text" name="domicilio" id="domicilio" placeholder="Domicilio Completa" required>
                  <label for="telefono">Telefono</label>
                  <input type="number" name="telefono" id="telefono" placeholder="Telefono" required>
                  <label for="cod_postal">Codigo Postal</label>
                  <input type="text" name="cod_postal" id="cod_postal" placeholder="Codigo Postal" required>
                  <label for="estatus_paciente" >Estatus</label>
                  <!--<input type="text" name="estatus_paciente" id="estatus_paciente" placeholder="Registro,Ingreso,Alta">--->
                  <select name="estatus_paciente" id="estatus_paciente">
                      <option value="Registro">REGISTRO</option>
                      <option value="Ingreso" selected>INGRESO</option>
                      <option value="Alta">ALTA</option>
                  </select>

                  <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> Guardar Paciente</button>
              </form>
          </div>
	</section>
    <a href="javascript: history.go(-1)" >Volver Atr&aacute;s</a>
	<?php include "includes/footer.php"; ?>
</body>
<script>
function fecha_nac1(curp){
	if(curp.length==18){
	//alert("va");	
	fecha = curp.substr(4, 6);
    dato = curp.substr(16, 1);
	var fec_nac=fechanac(fecha, dato);
	$('#fecha_nacimiento').val(fec_nac);
	}
}
function fechanac(fecha, dat) {
    var es = isNumber(dat);
    var nfecha = fecha.toString();
    if (es) {
        var nuevafecha = '19' + nfecha;
    } else {
        var nuevafecha = '20' + nfecha;
    }
    //alert(nuevafecha);
    var nuevafecha2 = nuevafecha.substr(0, 4) + '-' + nuevafecha.substr(4, 2) + '-' + nuevafecha.substr(6, 2);
    // alert(nuevafecha2);
    return nuevafecha2;
}
function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}
</script>
</html>