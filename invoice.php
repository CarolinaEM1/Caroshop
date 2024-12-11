<?php
include __DIR__ . '/admin/sistema.class.php';
$datos = $_POST;
$app = new Sistema;
$app->checkRole('Administrador');

try {
    //CONEXIÓN a la base de datos
    $app->conect();
    //Iniciar transacción
    $app->conn->beginTransaction();
    //PRREGUNTAR si existe el carrito en session
    if (isset($_SESSION['cart'])) {
        $correo = $_SESSION['correo'];
        //BUSCAR id_cliente a partir del correo
        $sql = "SELECT id_cliente FROM cliente c
                JOIN usuario u ON c.id_usuario = u.id_usuario
                WHERE correo = :correo;";
        $stmt = $app->conn->prepare($sql);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        //GUARDAR id_cliente
        $usuario = $stmt->fetchAll();
        if (isset($usuario[0])) {
            $id_usuario = $usuario[0]['id_usuario'];
            $id_empleado = 1;
            $id_tienda = 1;
            $sql = "INSERT INTO venta(id_tienda, id_empleado, id_cliente, fecha) 
                    VALUES (:id_tienda, :id_empleado, :id_cliente, now());";
            $stmt = $app->conn->prepare($sql);
            $stmt->bindParam(':id_tienda', $id_tienda, PDO::PARAM_INT);
            $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            $filas = $stmt->rowCount();
            if ($filas) {
                $sql = "SELECT v.id_venta FROM venta v
                        WHERE v.id_cliente = :id_cliente
                        ORDER BY 1 DESC LIMIT 1;";
                $stmt = $app->conn->prepare($sql);
                $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $venta = $stmt->fetchAll();
                if (isset($venta[0])) {
                    $id_venta = $venta[0]['id_venta'];
                    $carrito = $_SESSION['cart'];
                    $filas = 0;
                    foreach ($carrito as $key => $value) {
                        $id_producto = $key;
                        $cantidad = $value;
                        $sql = "INSERT INTO venta_detalle(id_venta, id_producto, cantidad) 
                                VALUES (:id_venta, :id_producto, :cantidad);";
                        $stmt = $app->conn->prepare($sql);
                        $stmt->bindParam(':id_venta', $id_venta, PDO::PARAM_INT);
                        $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
                        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
                        $stmt->execute();
                        $filas += $stmt->rowCount();
                    }
                    if ($filas) {
                        $app->conn->commit();
                        unset($_SESSION['cart']);
                        $app->alert('success', '');
                        $sql = "SELECT CONCAT(c.nombre, ' ', c.primer_apellido, ' ', c.segundo_apellido) AS nombre,
                                u.correo 
                                FROM cliente c 
                                JOIN usuario u ON c.id_usuario = u.id_usuario
                                WHERE u.correo = :correo;";
                        $stmt = $app->conn->prepare($sql);
                        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
                        $stmt->execute();
                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        $cliente = $stmt->fetchAll();
                        $nombre = $cliente[0]['nombre'];
                        $app->alert('success', '');
                        $mensaje = "Estimado $nombre, su compra ha sido realizada con éxito, 
                                    puede recoger su pedido en nuestra tienda. Muchas Gracias.";
                       // $app->sendMail($correo, $nombre, "Compra realizada con éxito", $mensaje);
                        echo "<div class='notification success'>
                                <h1>¡Compra realizada con éxito!</h1>
                                <p>Estimado $nombre, su compra ha sido realizada con éxito. Puede recoger su pedido en nuestra tienda. Muchas gracias por su preferencia.</p>
                                <a href='historial.php' class='btn'>Volver al Inicio</a>
                              </div>";
                    } else {
                        $app->alert('danger', 'No se pudo completar la compra');
                        $app->conn->rollBack();
                    }
                } else {
                    $app->alert('danger', 'No se pudo completar la compra');
                    $app->conn->rollBack();
                }
            } else {
                $app->alert('danger', 'Tu compra no se pudo realizar');
                $app->conn->rollBack();
            }
        } else {
            $app->alert('danger', 'No está registrado como cliente');
            $app->conn->rollBack();
        }
    } else {
        $app->alert('danger', 'El carrito está vacío');
        $app->conn->rollBack();
    }
} catch (Exception $e) {
    echo $e->getMessage();
    $app->conn->rollBack();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .notification {
            text-align: center;
            max-width: 600px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .notification h1 {
            margin-bottom: 20px;
        }

        .notification p {
            margin-bottom: 30px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

</body>

</html>