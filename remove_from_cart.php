<?php
session_start();

$id = $_POST['id'];

if (isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($id) {
        return $item['id'] !== $id;
    });
}

echo json_encode($_SESSION['cart']);
