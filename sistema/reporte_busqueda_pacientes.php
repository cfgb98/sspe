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
$busqueda = strtolower($_REQUEST['busqueda']);
			if(empty($busqueda))
			{
				header("location: lista_usuarios.php");
				mysqli_close($conection);
			}


// Obtener los datos de la tabla
$query  = mysqli_query($conection,"SELECT * FROM pacientes
WHERE (idpaciente LIKE '%$busqueda%' OR
       curp       LIKE '%$busqueda%' OR
       cod_postal LIKE '%$busqueda%' OR
       nombre LIKE '%$busqueda%' OR
          apellido_paterno LIKE '%$busqueda%' OR
       apellido_materno LIKE '%$busqueda%'	OR	
       estatus_paciente LIKE '%$busqueda%' OR
       telefono LIKE '%$busqueda%'
       )
AND
estatus = 1  ORDER BY idpaciente ");

$result =  $query;

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
    <title>Lista de pacientes buscados</title>
</head>
<body>
    <section id="container">
        <h1>Lista de pacientes buscados</h1>
        <table>
            <tr>
                
            <th>ID</th>
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
            <td>'. $data["idpaciente"].'</td>
            <td>'. $data["nombre"].'</td>
            <td>'.$data["apellido_paterno"].'</td>
            <td>'.$data["apellido_materno"].'</td>
            <td>'. $data["curp"].'</td>
            <td>'. $data["fecha_nacimiento"].'</td>
            <td>'. $data["domicilio"].'</td>
            <td>'. $data["telefono"].'</td>
            <td>'. $data["cod_postal"].'</td>
            <td>'. $data["estatus_paciente"].'</td>
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
$dompdf->stream("lista_busqueda_pacientes.pdf", array("Attachment" => false));

// Cerrar la conexión a la base de datos
mysqli_close($conection);
?>
