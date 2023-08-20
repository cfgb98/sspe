<?php
use Dompdf\Dompdf;
require_once '../vendor/autoload.php';

// Crear una instancia de Dompdf
$dompdf = new Dompdf();

// Incluir el archivo de conexión y verificar la sesión
session_start();
if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2 && $_SESSION['rol'] != 3) {
    header("location: ./");
}

include "../conexion.php";

// Obtener los datos de la tabla
$query = "SELECT * FROM pacientes WHERE estatus = 1 ORDER BY idpaciente ASC";
$result = mysqli_query($conection, $query);

// Contenido HTML que deseas convertir a PDF
$html = '
<!DOCTYPE html>
<html lang="en">
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
    <title>Lista de Pacientes Embarazadas</title>
</head>
<body>
    <section id="container">
        <h1>Lista de Pacientes Embarazadas</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Hora</th>
                <th>Nombre</th>
                <th>Apellido paterno</th>
                <th>Apellido materno</th>
                <th>CURP</th>
                <th>Fecha de Nacimiento</th>
                <th>Domicilio</th>
                <th>Telefono</th>
                <th>Codigo Postal</th>
                <th>Estatus de Paciente</th>
            </tr>
';
// Agregar los datos de la tabla al contenido HTML
while ($data = mysqli_fetch_array($result)) {
    $html .= '
            <tr>
                <td>' . $data["idpaciente"] . '</td>
                <td>' . $data["hora"] . '</td>
                <td>' . $data["nombre"] . '</td>
                <td>' . $data["apellido_paterno"] . '</td>
                <td>' . $data["apellido_materno"] . '</td>
                <td>' . $data["curp"] . '</td>
                <td>' . $data["fecha_nacimiento"] . '</td>
                <td>' . $data["domicilio"] . '</td>
                <td>' . $data["telefono"] . '</td>
                <td>' . $data["cod_postal"] . '</td>
                <td>' . $data["estatus_paciente"] . '</td>
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
$dompdf->stream("lista_pacientes_embarazadas.pdf", array("Attachment" => false));

// Cerrar la conexión a la base de datos
mysqli_close($conection);
?>
