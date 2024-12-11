<?php
header('Content-Type: application/json; charset=utf-8');
include __DIR__ . '/producto.class.php';

$action = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
$id_producto = isset($_GET['id_producto']) ? $_GET['id_producto'] : null;
class Api extends Producto
{
    public function read()
    {
        $data = $this->getAll();
        echo json_encode($data);
    }
    public function readOne($id_producto)
    {
        $data = $this->getOne($id_producto);
        echo json_encode($data);
    }
    public function create($datos)
    {
        $data = $this->insert($datos);
        if ($data) {
            $datos['mensaje'] = "El pedido se agrego";
        } else {
            $datos['mensaje'] = "El pedido no se agrego";
        }
        echo json_encode($datos);
    }

    public function deleteOne($id_producto)
    {
        $data = $this->delete($id_producto);
        if ($data) {
            $datos['mensaje'] = "El producto se eliminó";
        } else {
            $datos['mensaje'] = "El producto no se eliminó";
        }
        echo json_encode($datos);
    }
    public function updateOne($id_producto,$datos){
        $data=$this->update($id_producto,$datos);
        if ($data) {
            $datos['mensaje'] = "El producto se actualizó";
        } else {
            $datos['mensaje'] = "El producto se actualizó";
        }
        echo json_encode($datos);
    }
}

$app = new Api();

switch ($action) {
    case 'POST':
        $datos=array();
        $datos['producto']=$_POST['producto'];
        $datos['id_marca']=$_POST['id_marca'];
        $datos['precio']=$_POST['precio'];
        if(isset($_GET['id_producto'])){
            $id_producto=$_GET['id_producto'];
            $app->updateOne($id_producto,$datos);
        }else{
            $app->create($datos);
        }      
        break;
    case 'DELETE':
        $app->deleteOne($id_producto);
        break;
    default:
        if (isset($id_producto)) {
            $app->readOne($id_producto);
        } else {
            $app->read();
        }
        break;

}
