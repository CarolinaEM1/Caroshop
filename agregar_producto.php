<?php
session_start();

// Verificar si se recibió el ID del producto
if(isset($_POST['id_producto'])) {
    $productId = $_POST['id_producto'];
    echo $productId;

    $_SESSION['cart'][] = $productId;
    
    echo 'Producto agregado al carrito';
}
