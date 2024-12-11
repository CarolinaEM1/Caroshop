<?php 
include __DIR__.'/admin/sistema.class.php';
include (__DIR__.'/admin/producto.class.php');

if(isset($_SESSION['validado']) && $_SESSION['validado']){
    $carrito = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    $web = new Producto;
    $total = 0;
    foreach($carrito as $id_producto => $cantidad) {
        $dato = $web->getOne($id_producto);
        $subtotal = $cantidad * $dato['precio'];
        $total += $subtotal;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Caroshop</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Inicio</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Checkout</h3>
                </div>
                <div class="card-body">
                    <h4>Total: <?php echo "$" . $total; ?></h4>
                    <form action="invoice.php" method="post">
                        <div class="form-group">
                            <label for="tarjeta">Número de tarjeta</label>
                            <input id="tarjeta" name="tarjeta" type="text" class="form-control" minlength="16" maxlength="16" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre de la tarjeta</label>
                            <input id="nombre" name="nombre" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha de Expiración</label>
                            <input id="fecha" name="fecha" placeholder="MM/AA" type="text" class="form-control" minlength="5" maxlength="5" required>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input id="cvv" name="cvv" placeholder="xxx" type="number" class="form-control" minlength="3" maxlength="3" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-danger">Cancelar y seguir comprando</a>
                            <button type="submit" class="btn btn-success" name="invoice">Confirmar Pago</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
} else {
    header("Location: login.php");
    exit();
}
?>
