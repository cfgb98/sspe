<?php
use Dompdf\Dompdf;
require_once '../vendor/autoload.php';

// Crear una instancia de Dompdf
$dompdf = new Dompdf();

// Incluir el archivo de conexión y verificar la sesión
session_start();
if ($_SESSION['rol'] != 1) {
    header("location: ./");
}

include "../conexion.php";

// Obtener los datos de la tabla
$query = "SELECT s.*, p.nombre, p.apellido_paterno, p.apellido_materno, 
          CONCAT(m.nombre, ' ', m.apellido_paterno) as nombre_medico, 
          CONCAT(e.nombre, ' ', e.apellido_paterno) as nombre_enfermera, 
          u.nombre as nombre_usuario, u.apellido_paterno as ap_usuario, u.apellido_materno as am_usuario
          FROM seguimiento s
          INNER JOIN pacientes p ON s.idpaciente = p.idpaciente
          INNER JOIN medico md ON s.idmedico = md.idmedico
          INNER JOIN usuario m ON md.idusuario = m.idusuario
          INNER JOIN enfermeras enf ON s.idenfermera = enf.idenfermeras
          INNER JOIN usuario e ON enf.idusuario = e.idusuario
          INNER JOIN usuario u ON s.usuario_id = u.idusuario
          WHERE s.estatus = 1
          ORDER BY s.idseguimiento ASC";
$result = mysqli_query($conection, $query);

// Contenido HTML que deseas convertir a PDF
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lista de seguimientos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            word-break: break-all;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <section id="container">
        <h1>Lista de Seguimientos</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre del paciente</th>
                <th>Cuantos embarazos</th>
                <th>Cuantos partos</th>
                <th>Cuantos abortos</th>
                <th>Dilatacion</th>
                <th>Borramiento</th>
                <th>Amnios</th>
                <th>Frecuencia fetal</th>
                <th>Presión arterial</th>
                <th>Urgencias</th>
                <th>Nombre del médico</th>
                <th>Nombre de la enfermera</th>
                <th>Medicamentos</th>
                <th>Estatus seguimiento</th>
            </tr>
';
// Agregar los datos de la tabla al contenido HTML
while ($data = mysqli_fetch_array($result)) {
    $html .= '
            <tr>
                <td>' . (int)$data['idseguimiento'] . '</td>
                <td>' . $data['nombre'] . ' ' . $data['apellido_paterno'] . ' ' . $data['apellido_materno'] . '</td>
                <td>' . (int)$data['cuantos_embarazos'] . '</td>
                <td>' . (int)$data['cuantos_partos'] . '</td>
                <td>' . (int)$data['cuantos_abortos'] . '</td>
                <td>' . utf8_decode($data['dilatacion']) . '</td>
                <td>' . utf8_decode($data['borramiento']) . '</td>
                <td>' . utf8_decode($data['amnios']) . '</td>
                <td>' . $data['frecuencia_fetal'] . '</td>
                <td>' . utf8_decode($data['presion_arterial']) . '</td>
                <td>' . utf8_decode($data['urgencias']) . '</td>
                <td>' . $data['nombre_medico'] . '</td>
                <td>' . $data['nombre_enfermera'] . '</td>';

    // Medicamentos
    $query_medicamentos = "SELECT nombre_medicamento FROM medicamentos WHERE idmedicamento IN (SELECT idmedicamento FROM seguimiento WHERE idseguimiento = " . (int)$data['idseguimiento'] . ")";
    $result_medicamentos = mysqli_query($conection, $query_medicamentos);
    $medicamentos = '';
    while ($med = mysqli_fetch_array($result_medicamentos)) {
        $medicamentos .= utf8_decode($med['nombre_medicamento']) . ', ';
    }
    $medicamentos = rtrim($medicamentos, ', ');

    $html .= '<td>' . $medicamentos . '</td>
            <td>' . utf8_decode($data['estatus_seguimiento']) . '</td>
        </tr>';
}

$html .= '
        </table>
    </section>
</body>
</html>
';

// Cargar el HTML en el objeto Dompdf
$dompdf->loadHtml($html);

// (Opcional) Configurar el tamaño del papel y la orientación
$dompdf->setPaper('A4', 'landscape');

// Renderizar el HTML como PDF
$dompdf->render();

// Mostrar el PDF en el navegador
$dompdf->stream("lista_seguimientos.pdf", array("Attachment" => false));

// Cerrar la conexión a la base de datos
mysqli_close($conection);
?>
