<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <style>
        /* Estilos CSS para la presentación del carrito */
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f8f8;
    color: #333;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

h1 {
    text-align: center;
    color: #444;
}

.cart-item {
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: hidden;
    margin-bottom: 20px;
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.cart-item img {
    max-width: 100px;
    float: left;
    margin-right: 20px;
}

.cart-item .product-details {
    padding: 20px;
}

.cart-item p {
    margin: 0;
    font-size: 18px;
    margin-bottom: 10px;
}

.quantity {
    display: inline-block;
    margin-right: 10px;
}

.quantity input {
    width: 40px;
    padding: 5px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 3px;
}

.total {
    text-align: right;
    margin-top: 20px;
}

.total p {
    font-size: 24px;
    margin: 0;
    color: #333;
}

.checkout-btn {
    display: block;
    width: 100%;
    padding: 15px;
    background-color: #ff69b4;  /* Rosa vibrante */
    color: #fff;
    text-align: center;
    text-decoration: none;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.checkout-btn:hover {
    background-color: #ff1493;  /* Rosa fuerte */
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Carrito de Compras</h1>
        <?php
        // Iniciar o reanudar la sesión

        // Verificar si hay productos en la sesión
        if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            // Conectar a la base de datos (reemplaza estos valores con los de tu configuración)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "ferreteria";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar la conexión
            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            $total = 0;

            // Recorrer los productos en la sesión
            foreach($_SESSION['cart'] as $productoId => $cantidad) {
                // Consulta SQL para obtener los detalles del producto
                $sql = "SELECT * FROM producto WHERE id_producto = $productoId";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Mostrar los datos del producto
                    $row = $result->fetch_assoc();
                    $productoProducto = $row['producto'];
                    $precioProducto = $row['precio'];
                    $fotografiaProducto ="uploads/productos/". $row['fotografia'];

                    $subtotal = $precioProducto * $cantidad;
                    $total += $subtotal;

                    // Mostrar el producto en el carrito
                    echo "<div class='cart-item'>";
                    echo "<img src='$fotografiaProducto' alt='$productoProducto'>";
                    echo "<div class='product-details'>";
                    echo "<p>$productoProducto</p>";
                    echo "<p>Precio: $precioProducto</p>";
                    echo "<div class='quantity'>Cantidad: <input type='number' value='$cantidad' min='1' max='99' onchange='updateQuantity($productoId, this.value)'></div>";
                    echo "<p>Subtotal: $subtotal</p>";
                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "<p>No se encontró el producto con ID: $productoId</p>";
                }
            }

            // Cerrar la conexión a la base de datos
            $conn->close();

            // Mostrar el total a pagar
            echo "<div class='total'>";
            echo "<p>Total a pagar: $total</p>";
            echo "</div>";

            // Mostrar botón de pago
            echo "<a href='login.php' class='checkout-btn'>Pagar</a>";
        } else {
            echo "<p class='empty-cart'>No hay productos en el carrito</p>";
        }
        ?>
    </div>

    <script>
        function updateQuantity(productId, newQuantity) {
            // Enviar una solicitud al servidor para actualizar la cantidad del producto en el carrito
            // Aquí puedes usar JavaScript o AJAX para enviar la información al servidor y actualizar la sesión de PHP
        }
    </script>
</body>
</html>
