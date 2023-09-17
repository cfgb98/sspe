<?php 
    session_start();
    if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2 && $_SESSION['rol'] != 3) {
        header("location: ./");
    }
    include "../conexion.php";

    $busqueda = '';
    if (isset($_GET['busqueda'])) {
        $busqueda = $_GET['busqueda'];
    }

    $query_total = mysqli_query($conection, "SELECT COUNT(*) AS total_registro FROM seguimiento");
    $result_total = mysqli_fetch_array($query_total);
    $total_registro = $result_total['total_registro'];

    $por_pagina = 10;
    $total_paginas = ceil($total_registro / $por_pagina);

    if (isset($_GET['pagina'])) {
        $pagina = $_GET['pagina'];
    } else {
        $pagina = 1;
    }

    $desde = ($pagina - 1) * $por_pagina;

    $query = mysqli_query($conection, "SELECT s.idseguimiento, CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS nombre_paciente,
                                        CONCAT(mu.nombre, ' ', mu.apellido_paterno, ' ', mu.apellido_materno) AS nombre_medico,
                                        CONCAT(eu.nombre, ' ', eu.apellido_paterno, ' ', eu.apellido_materno) AS nombre_enfermera,
                                        m.nombre_medicamento, s.dilatacion, s.frecuencia_fetal, 
                                        s.presion_arterial, s.amnios, s.urgencias, s.borramiento, 
                                        s.cuantos_abortos, s.cuantos_embarazos, s.cuantos_partos, 
                                        s.estatus_seguimiento
                                    FROM seguimiento s
                                    INNER JOIN pacientes p ON s.idpaciente = p.idpaciente
                                    INNER JOIN usuario u ON s.idmedico = u.idusuario
                                    INNER JOIN medicamentos m ON s.idmedicamento = m.idmedicamento
                                    LEFT JOIN medico med ON s.idmedico = med.idmedico
                                    LEFT JOIN enfermeras enf ON s.idenfermera = enf.idenfermeras
                                    LEFT JOIN usuario mu ON med.idusuario = mu.idusuario
                                    LEFT JOIN usuario eu ON enf.idusuario = eu.idusuario
                                    WHERE (p.nombre LIKE '%$busqueda%' OR 
                                        mu.nombre LIKE '%$busqueda%' OR 
                                        eu.nombre LIKE '%$busqueda%' OR
                                        s.frecuencia_fetal LIKE '%$busqueda%' OR
                                        s.borramiento LIKE '%$busqueda%' OR
                                        s.amnios LIKE '%$busqueda%' OR
                                        s.presion_arterial LIKE '%$busqueda%' OR
                                        s.urgencias LIKE '%$busqueda%' OR
                                        m.nombre_medicamento LIKE '%$busqueda%')
                                    AND s.estatus = 1
                                    ORDER BY s.idseguimiento ASC LIMIT $desde, $por_pagina");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de seguimientos</title>
    <?php include "includes/scripts.php"; ?>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <h1>Lista de seguimientos</h1>
        
        <form action="buscar_seguimiento.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
            <input type="submit" value="Buscar" class="btn_search">
        </form>

        <table id="lista"  class="table table-striped">
			<thead>
            <tr>
                <th>ID Seguimiento</th>
                <th>Nombre Paciente</th>
                <th>Nombre Médico</th>
                <th>Nombre Enfermera</th>
                <th>Medicamento</th>
                <th>Dilataci&oacute;n</th>
                <th>Frecuencia Fetal</th>
                <th>Presi&oacute;n Arterial</th>
                <th>Amnios</th>
                <th>Urgencias</th>
                <th>Borramiento</th>
                <th>Cantidad de Abortos</th>
                <th>Cantidad de Embarazos</th>
                <th>Cantidad de Partos</th>
                <th>Estatus Seguimiento</th>
                <th>Acciones</th>
            </tr>
			</thead>
			<tbody>
            <?php 
                if ($query) {
                    while ($data = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td><?php echo $data["idseguimiento"]; ?></td>
                    <td><?php echo $data["nombre_paciente"]; ?></td>
                    <td><?php echo $data["nombre_medico"]; ?></td>
                    <td><?php echo $data["nombre_enfermera"]; ?></td>
                    <td><?php echo $data["nombre_medicamento"]; ?></td>
                    <td><?php echo $data["dilatacion"]; ?></td>
                    <td><?php echo $data["frecuencia_fetal"]; ?></td>
                    <td><?php echo $data["presion_arterial"]; ?></td>
                    <td><?php echo $data["amnios"]; ?></td>
                    <td><?php echo $data["urgencias"]; ?></td>
                    <td><?php echo $data["borramiento"]; ?></td>
                    <td><?php echo $data["cuantos_abortos"]; ?></td>
                    <td><?php echo $data["cuantos_embarazos"]; ?></td>
                    <td><?php echo $data["cuantos_partos"]; ?></td>
                    <td><?php echo $data["estatus_seguimiento"]; ?></td>
                    <td>
                        <a class="link_edit" href="editar_seguimiento.php?id=<?php echo $data["idseguimiento"]; ?>">Editar</a>
                        <?php if ($_SESSION['rol'] != 1 || $_SESSION['rol'] != 2) { ?>
                            |
                            <a class="link_delete" href="eliminar_confirmar_seguimiento.php?id=<?php echo $data["idseguimiento"]; ?>">Eliminar</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php 
                    }
                }
            ?>
		</tbody>
        </table>

        <?php 
            if ($total_registro != 0) {
        ?>
            <div class="paginador">
                <ul>
                    <?php 
                        if ($pagina != 1) {
                    ?>
                            <li><a href="?pagina=1&busqueda=<?php echo $busqueda; ?>">|<</a></li>
                            <li><a href="?pagina=<?php echo $pagina - 1; ?>&busqueda=<?php echo $busqueda; ?>"><<</a></li>
                    <?php 
                        }
                        for ($i = 1; $i <= $total_paginas; $i++) { 
                            if ($i == $pagina) {
                                echo '<li class="pageSelected">'.$i.'</li>';
                            } else {
                                echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
                            }
                        }
                        if ($pagina != $total_paginas) {
                    ?>
                            <li><a href="?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>">>></a></li>
                            <li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?> ">>|</a></li>
                    <?php 
                        } 
                    ?>
                </ul>
            </div>
        <?php } ?>
    </section>

    <a href="reporte_busqueda_seguimiento.php?busqueda=<?php echo $busqueda?>" class="btn_new"><i class="fa-solid fa-floppy-disk"></i>Guardar reporte</a>
    <?php include "includes/footer.php"; ?>
</body>
<script>
$(document).ready(function(){
   var table = new DataTable('#lista', {
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
    },
	});
});
</script>
</html>
