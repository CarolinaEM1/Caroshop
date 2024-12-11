<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];
    

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$id_producto])) {
        $_SESSION['cart'][$id_producto] += $cantidad;
    } else {
        $_SESSION['cart'][$id_producto] = $cantidad;
    }

    header('Location: cart.view.php');
    exit();
}

