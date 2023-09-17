<?php 
    session_start();
    if ($_SESSION['rol'] != 1) {
        header("location: ./");
    }

    include "../conexion.php";

    if (!empty($_POST)) {
        $idseguimiento = $_POST['idseguimiento'];

        $query_delete = mysqli_query($conection, "UPDATE seguimiento SET estatus = 0 WHERE idseguimiento = $idseguimiento ");

        if ($query_delete) {
            header("location: lista_seguimiento.php");
        } else {
            echo "Error al eliminar";
        }
    }

    if (empty($_REQUEST['idseguimiento'])) {
        header("location: lista_seguimiento.php");
    } else {
        $idseguimiento = $_REQUEST['idseguimiento'];

        $query = mysqli_query($conection, "SELECT s.idseguimiento, p.idpaciente, p.nombre, p.apellido_paterno, p.apellido_materno
            FROM seguimiento s
            INNER JOIN pacientes p ON s.idpaciente = p.idpaciente
            WHERE s.idseguimiento = $idseguimiento");
        $result = mysqli_num_rows($query);

        if ($result > 0) {
            while ($data = mysqli_fetch_array($query)) {
                $nombre = $data['nombre'] . ' ' . $data['apellido_paterno'] . ' ' . $data['apellido_materno'];
            }
        } else {
            header("location: lista_seguimiento.php");
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Eliminar Usuario</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="data_delete">
            <i class="fas fa-user-md fa-7x" style="color: red"></i>
            <br>
            <br>
            <h2>¿Est&aacute; seguro de eliminar el siguiente registro?</h2>
            <p>Nombre de la paciente: <span><?php echo $nombre; ?></span></p>

            <form method="POST" action="">
                <input type="hidden" name="idseguimiento" value="<?php echo $idseguimiento; ?>">
                <a href="lista_seguimiento.php" class="btn_cancel"><i class="fa-solid fa-ban"></i> Cancelar</a>
                <button type="submit" class="btn_ok"><i class="fa-solid fa-trash-can"></i> Eliminar</button>
            </form>
        </div>
    </section>
    <?php mysqli_close($conection); ?>
    <?php include "includes/footer.php"; ?>
</body>
</html>
