<?php
require 'vendor/autoload.php'; // Asegúrate de incluir Dompdf

include __DIR__.'/admin/sistema.class.php';


if (!isset($_SESSION['correo'])) {
    header('Location: login.php');
    exit();
}

$app = new Sistema;
$app->checkRole('Cliente');
$app->conect(); 
$correo = $_SESSION['correo'];
$conn = $app->conn;

$sql = "SELECT v.id_venta, v.fecha, GROUP_CONCAT(p.producto SEPARATOR ', ') AS productos
        FROM venta v
        JOIN venta_detalle vd ON v.id_venta = vd.id_venta
        JOIN producto p ON vd.id_producto = p.id_producto
        JOIN cliente c ON v.id_cliente = c.id_cliente
        JOIN usuario u ON c.id_usuario = u.id_usuario
        WHERE u.correo = :correo
        GROUP BY v.id_venta, v.fecha
        ORDER BY v.fecha DESC";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
$stmt->execute();
$ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Función para generar PDF
function generarPDF($id_venta, $fecha, $productos) {
    $dompdf = new Dompdf\Dompdf();
    $html = "
    <html>
    <head>
        <style>
            body {
                font-family: 'Arial', sans-serif;
            }
            .container {
                width: 80%;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h1 {
                text-align: center;
                color: #333;
            }
            .details {
                margin-bottom: 20px;
            }
            .details p {
                margin: 5px 0;
            }
            .footer {
                text-align: center;
                font-size: 0.8em;
                color: #777;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>Detalles de la Venta</h1>
            <div class='details'>
                <p><strong>Venta ID:</strong> $id_venta</p>
                <p><strong>Fecha:</strong> $fecha</p>
                <p><strong>Productos:</strong> $productos</p>
            </div>
            <div class='footer'>
                <p>&copy; " . date('Y') . " Mi Ferretería. Todos los derechos reservados.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("venta_$id_venta.pdf", ["Attachment" => false]);
}

if (isset($_GET['pdf'])) {
    $id_venta = $_GET['pdf'];
    foreach ($ventas as $venta) {
        if ($venta['id_venta'] == $id_venta) {
            generarPDF($venta['id_venta'], $venta['fecha'], $venta['productos']);
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Compras</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #007bff;
            padding: 10px 20px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .venta {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .venta:last-child {
            border-bottom: none;
        }
        .venta h2 {
            font-size: 1.2em;
            color: #007bff;
            margin: 0;
        }
        .venta p {
            margin: 5px 0;
        }
        .no-compras {
            text-align: center;
            color: #999;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            font-size: 1em;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-pdf {
            background-color: #28a745;
        }
        .btn-pdf:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="navbar-brand">
        <a href="index.php">Mi Ferretería</a>
    </div>
    <div class="navbar-menu">
        <a href="index.php">Inicio</a>
        <a href="perfil.php">Perfil</a>
        <a href="logout.php">Cerrar sesión</a>
    </div>
</div>

<div class="container">
    <h1>Historial de Compras</h1>
    <?php if ($ventas): ?>
        <?php foreach ($ventas as $venta): ?>
            <div class="venta">
                <div>
                    <h2>Venta ID: <?php echo htmlspecialchars($venta['id_venta']); ?></h2>
                    <p><strong>Fecha:</strong> <?php echo htmlspecialchars($venta['fecha']); ?></p>
                    <p><strong>Productos:</strong> <?php echo htmlspecialchars($venta['productos']); ?></p>
                </div>
                <div>
                    <a href="?pdf=<?php echo htmlspecialchars($venta['id_venta']); ?>" target="_blank" class="btn btn-pdf"><i class="fas fa-file-pdf"></i> Generar PDF</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-compras">No has realizado ninguna compra.</p>
    <?php endif; ?>
    <a href="index.php" class="btn"><i class="fas fa-arrow-left"></i> Volver al inicio</a>
</div>

</body>
</html>
