<?php
include __DIR__.'/admin/producto.class.php';
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<div class='container'><div class='empty-cart'>El carrito está vacío.</div></div>";
    exit();
}

$web = new Producto;
$productos = $web->getProductsByIds(array_keys($_SESSION['cart']));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <style>
 body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #fce4ec; /* Fondo rosa claro */
  margin: 0;
  padding: 0;
}

.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #ec407a; /* Rosa fuerte */
  padding: 15px 20px;
  color: #fff;
}

.navbar a {
  color: #fff;
  text-decoration: none;
  margin-left: 20px;
  font-weight: 500;
}

.navbar .logo {
  font-size: 1.6em;
  font-weight: bold;
}

.navbar .menu {
  display: flex;
}

.navbar .cart {
  font-size: 1.2em;
}

.container {
  width: 80%;
  margin: 30px auto;
  background: #fff;
  padding: 25px;
  border-radius: 10px;
  box-shadow: 0 6px 12px rgba(236, 64, 122, 0.1); /* Sombra rosa */
}

h2 {
  text-align: center;
  margin-bottom: 25px;
  color: #ad1457; /* Rosa oscuro */
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 25px;
}

table, th, td {
  border: 1px solid #f8bbd0; /* Borde rosa suave */
}

th, td {
  padding: 15px;
  text-align: left;
}

th {
  background-color: #ec407a; /* Rosa fuerte */
  color: #fff;
}

.empty-cart {
  text-align: center;
  font-size: 1.5em;
  color: #d81b60; /* Rosa brillante */
}

.checkout-button {
  display: flex;
  justify-content: flex-end;
}

.checkout-button a {
  background-color: #d81b60; /* Rosa brillante */
  color: #fff;
  padding: 12px 25px;
  text-decoration: none;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.checkout-button a:hover {
  background-color: #ad1457; /* Rosa oscuro */
}

    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">Caroshop</div>
    <div class="menu">
        <a href="index.php">Inicio</a>
    </div>
</div>

<div class="container">
    <h2>Carrito de Compras</h2>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalGeneral = 0;
            foreach ($productos as $producto) {
                $cantidad = $_SESSION['cart'][$producto['id_producto']];
                $precio = $producto['precio'];
                $total = $cantidad * $precio;
                $totalGeneral += $total;
                echo "<tr>
                        <td>{$producto['producto']}</td>
                        <td>{$cantidad}</td>
                        <td>\${$precio}</td>
                        <td>\${$total}</td>
                      </tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align:right">Total General:</th>
                <th>$<?php echo $totalGeneral; ?></th>
            </tr>
        </tfoot>
    </table>
    <div class="checkout-button">
        <a href="checkout.php">Proceder al Pago</a>
    </div>
</div>

</body>
</html>
