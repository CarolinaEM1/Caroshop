<?php
header('Content-Type: application/json; charset=utf-8');
$file_path = __DIR__ . '/order.class.php';

if (file_exists($file_path)) {
    include $file_path;
} else {
    echo json_encode(['error' => 'File order.class.php not found at ' . $file_path]);
    exit;
}

$action = (isset($_GET['action'])) ? $_GET['action'] : null;

class Api extends Pedidos
{
    public function read()
    {
        $datos = $this->getAll();
        echo json_encode($datos);
    }

    public function readOne($id_venta)
    {
        $datos = $this->getOne($id_venta);
        if ($datos) {
            echo json_encode($datos);
        } else {
            echo json_encode(['mensaje' => "No se ha encontrado el pedido especificado"]);
        }
    }

    public function deleteOne($id_venta)
    {
        $filas = $this->delete($id_venta);
        if ($filas) {
            echo json_encode(['mensaje' => "El pedido se ha eliminado"]);
        } else {
            echo json_encode(['mensaje' => "No se pudo eliminar el pedido"]);
        }
    }

    public function create($datos)
    {
        $filas = $this->insert($datos);
        if ($filas) {
            echo json_encode(['mensaje' => "El pedido se ha añadido correctamente"]);
        } else {
            echo json_encode(['mensaje' => "No se pudo añadir el pedido"]);
        }
    }

    public function update($id_venta, $datos)
    {
        $filas = $this->modify($id_venta, $datos);
        if ($filas) {
            echo json_encode(['mensaje' => "El pedido se ha actualizado correctamente"]);
        } else {
            echo json_encode(['mensaje' => "No se pudo actualizar el pedido"]);
        }
    }
}

$app = new Api();
$input = json_decode(file_get_contents('php://input'), true);

switch ($action) {
    case 'save':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $app->create($input);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            if (isset($input['id_venta'])) {
                $app->update($input['id_venta'], $input);
            } else {
                echo json_encode(['mensaje' => "ID de venta no especificado para la actualización"]);
            }
        }
        break;
    case 'delete':
        if (isset($_GET['id_venta'])) {
            $app->deleteOne($_GET['id_venta']);
        } else {
            echo json_encode(['mensaje' => "ID de venta no especificado para la eliminación"]);
        }
        break;
    case 'get':
    default:
        if (isset($_GET['id_venta'])) {
            $app->readOne($_GET['id_venta']);
        } else {
            $app->read();
        }
        break;
}
?>