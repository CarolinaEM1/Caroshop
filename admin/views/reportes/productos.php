<?php
$content = "
<!DOCTYPE html>
<html lang='es'>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title>Listado de Productos</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #eaeaea;
        text-align: center; /* Centrar todo el contenido */
    }
    .container {
        max-width: 800px;
        margin: 50px auto; /* Margen superior e inferior de 50px y centrado horizontalmente */
        padding: 25px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        border: 1px solid #ddd; /* Borde sutil */
    }
    h1, p, table, .datos-empresa {
        margin-left: 20px; /* Margen izquierdo para el contenido interno */
        margin-right: 20px; /* Margen derecho para el contenido interno */
        margin-bottom: 20px;
    }
    h1 {
        color: #5D647B;
    }
    p, .datos-empresa p {
        color: #6c757d;
    }
    table {
        width: calc(100% - 40px); /* Ajuste de ancho para considerar los márgenes */
        border-collapse: collapse;
    }
    th, td {
        padding: 15px;
        text-align: left;
        border-bottom: 2px solid #dee2e6;
    }
    th {
        background-color: #f8f9fa;
        color: #495057;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    tr:hover {
        background-color: #dddfe2;
    }
    .logo, .datos-empresa {
        display: block;
        margin: 0 auto; 
    }
    .logo {
        max-width: 180px;
        margin-bottom: 30px;
    }
    .datos-empresa {
        max-width: 800px;
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px; /* Margen inferior para la sección de datos de la empresa */
    }
</style>
</head>
<body>
<div class='container'>
    <img src='../images/logo.jpg' alt='Logo' class='logo'>
    <h1>Listado de Productos</h1>
    <p>Se encontraron " . count($datos) . " productos</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Producto</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
";
foreach ($datos as $dato) {
    $content .= "
            <tr>
                <td>".$dato['id_producto']."</td>
                <td>".$dato['marca']."</td>
                <td>".$dato['producto']."</td>
                <td>$".$dato['precio']."</td>
            </tr>
    ";
}
$content .= "
        </tbody>
    </table>
    <div class='datos-empresa'>
        <p><strong>Nombre de la Empresa:</strong> Tu Empresa S.A.</p>
        <p><strong>Dirección:</strong> Calle Falsa 123, Ciudad, País</p>
        <p><strong>Teléfono:</strong> +1 234 567 8900</p>
        <p><strong>Email:</strong> contacto@tuempresa.com</p>
    </div>
</div>
</body>
</html>
";
?>
