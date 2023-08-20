<?php
use Dompdf\Dompdf;
require_once '../vendor/autoload.php';
include "../conexion.php";

// Crear una instancia de Dompdf
$dompdf = new Dompdf();

// Obtener la búsqueda desde la URL
$busqueda = '';
if (isset($_GET['busqueda'])) {
    $busqueda = $_GET['busqueda'];
}

// Consulta para obtener los datos de la tabla
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
                                ORDER BY s.idseguimiento ASC");

// Contenido HTML que deseas convertir a PDF
$html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
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
    <title>Lista de seguimientos buscados</title>
</head>
<body>
    <section id="container">
        <h1>Lista de seguimientos buscados</h1>
        <table>
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
            </tr>';

// Agregar los datos de la tabla al contenido HTML
while ($data = mysqli_fetch_array($query)) {
    $html .= '
            <tr>
                <td>'. $data["idseguimiento"].'</td>
                <td>'. $data["nombre_paciente"].'</td>
                <td>'.$data["nombre_medico"].'</td>
                <td>'.$data["nombre_enfermera"].'</td>
                <td>'.$data["nombre_medicamento"].'</td>
                <td>'.$data["dilatacion"].'</td>
                <td>'.$data["frecuencia_fetal"].'</td>
                <td>'.$data["presion_arterial"].'</td>
                <td>'.$data["amnios"].'</td>
                <td>'.$data["urgencias"].'</td>
                <td>'.$data["borramiento"].'</td>
                <td>'.$data["cuantos_abortos"].'</td>
                <td>'.$data["cuantos_embarazos"].'</td>
                <td>'.$data["cuantos_partos"].'</td>
                <td>'.$data["estatus_seguimiento"].'</td>
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
$dompdf->stream("lista_busqueda_seguimientos.pdf", array("Attachment" => false));
?>
