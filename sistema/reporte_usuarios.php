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
$query = "SELECT u.idusuario, u.apellido_paterno, u.apellido_materno, u.nombre, u.cedula, u.correo, u.usuario, r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE estatus = 1 ORDER BY u.idusuario ASC";
$result = mysqli_query($conection, $query);

// Contenido HTML que deseas convertir a PDF
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lista de usuarios</title>
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
        <h1>Lista de usuarios</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Nombre</th>
                <th>Cedula</th>
                <th>Correo</th>
                <th>Usuario</th>
                <th>Rol</th>
            </tr>
';
// Agregar los datos de la tabla al contenido HTML
while ($data = mysqli_fetch_array($result)) {
    $html .= '
            <tr>
                <td width="5%">' . $data["idusuario"] . '</td>
                <td width="15%">' . $data["apellido_paterno"] . '</td>
                <td width="15%">' . $data["apellido_materno"] . '</td>
                <td width="15%">' . $data["nombre"] . '</td>
                <td width="8%">' . $data["cedula"] . '</td>
                <td width="15%">' . $data["correo"] . '</td>
                <td width="10%">' . $data["usuario"] . '</td>
                <td width="10%">' . $data['rol'] . '</td>
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
$dompdf->stream("lista_usuarios.pdf", array("Attachment" => false));

// Cerrar la conexión a la base de datos
mysqli_close($conection);
?>
