<?php
include __DIR__ . '/order.class.php';
$app = new Pedidos();
include (__DIR__ . '/views/header.php');

//$app->checkRol('Administrator', true);
$action = (isset($_GET['action']) ? $_GET['action'] : null);
$id_venta = (isset($_GET['id_venta']) ? $_GET['id_venta'] : null);
switch ($action) {
    case 'delete':
        $fila = $app->delete($id_venta);
        if ($fila) {
            $alert['tipo'] ='success';
            $alert['mensaje'] = 'Venta eliminada correctamente';
        }
        else {
            $alert['tipo'] ='danger';
            $alert['mensaje'] = 'No se pudo eliminar la venta';
        }
        $app->alert($alert['tipo'], $alert['mensaje']);
        $datos = $app->getAll();
        include __DIR__ . '/views/orders/index.php';
        break;
    default:
        $datos = $app->getAll();
        include __DIR__ . '/views/orders/index.php';
        break;
}

include (__DIR__ . '/views/footer.php');
