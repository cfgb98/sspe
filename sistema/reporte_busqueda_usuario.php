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
$query  = mysqli_query($conection,"SELECT u.idusuario, u.apellido_paterno,u.apellido_materno,u.nombre,u.cedula, u.correo, u.usuario, r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol 
WHERE 
( u.idusuario LIKE '%$busqueda%' OR
    u.apellido_paterno LIKE '%$busqueda%' OR 
    u.apellido_materno LIKE '%$busqueda%' OR  
    u.nombre LIKE '%$busqueda%' OR 
    u.correo LIKE '%$busqueda%' OR 
    u.usuario LIKE '%$busqueda%' OR 
    r.rol    LIKE  '%$busqueda%') 
AND
estatus = 1 ORDER BY u.idusuario ASC");

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
    <title>Lista de usuarios buscados</title>
</head>
<body>
    <section id="container">
        <h1>Lista de usuarios buscados</h1>
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
            <td>'. $data["idusuario"].'</td>
            <td>'. $data["apellido_paterno"].'</td>
            <td>'.$data["apellido_materno"].'</td>
            <td>'.$data["nombre"].'</td>
            <td>'. $data["cedula"].'</td>
            <td>'. $data["correo"].'</td>
            <td>'. $data["usuario"].'</td>
            <td>'. $data["rol"].'</td>
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
$dompdf->stream("lista_busqueda_usuarios.pdf", array("Attachment" => false));

// Cerrar la conexión a la base de datos
mysqli_close($conection);
?>
