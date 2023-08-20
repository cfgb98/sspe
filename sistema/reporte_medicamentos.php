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
$query = "SELECT * FROM medicamentos WHERE estatus = 1 ORDER BY idmedicamento ASC";
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
    <title>Lista de Medicamentos</title>
</head>
<body>
    <section id="container">
        <h1>Lista de Medicamentos</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Folio</th>
                <th>Nombre del Medicamento</th>
                <th>Via de Administracion</th>
                <th>Observaciones</th>
                <th>Fecha de Caducidad</th>
            </tr>
';
// Agregar los datos de la tabla al contenido HTML
while ($data = mysqli_fetch_array($result)) {
    $html .= '
            <tr>
                <td>' . $data["idmedicamento"] . '</td>
                <td>' . $data["folio"] . '</td>
                <td>' . $data["nombre_medicamento"] . '</td>
                <td>' . $data["via_administracion"] . '</td>
                <td>' . $data["observaciones"] . '</td>
                <td>' . $data["fecha_caducidad"] . '</td>
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
$dompdf->stream("lista_medicamentos.pdf", array("Attachment" => false));

// Cerrar la conexión a la base de datos
mysqli_close($conection);
?>
