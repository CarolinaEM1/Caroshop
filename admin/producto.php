<?php
//print_r($_POST);
//print_r($_GET);
include(__DIR__ .'/producto.class.php');
include(__DIR__ .'/marca.class.php');
$app = new Producto();
$appMarcas= new Marca();
$app->checkRol('Administrador', true);
$marcas=$appMarcas->getAll();
include(__DIR__ .'/views/header.php');
$action = (isset($_GET['action']) ? $_GET['action'] : null);
$id_producto = (isset($_GET['id_producto']) ? $_GET['id_producto'] : null);

$datos = array();
$alert=array();
switch ($action) {
    case 'delete':
        $fila = $app->delete($id_producto);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='producto  eliminado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo eliminar la producto';
        }
        $datos = $app->getAll();
        include(__DIR__ .'/views/alert.php');
        include(__DIR__ .'/views/producto/index.php');
        break;
    case 'create':
        $marcas=$appMarcas->getAll();
        include(__DIR__ .'/views/producto/form.php');
        break;
    case 'save':
        $datos = $_POST;
        $datos['fotografia']=$_FILES['fotografia']['name'];
        $fila = $app->insert($datos);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='producto guardado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo guardar la producto';
        }
        $datos = $app->getAll();
        include(__DIR__ .'/views/alert.php');
        include(__DIR__ .'/views/producto/index.php');
        break;
    case 'update':
        $datos = $app->getOne($id_producto);
        if(isset($datos['id_producto'])){
            include(__DIR__ .'/views/producto/form.php');
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No existe la producto indicado';
            $datos = $app->getAll();
            include(__DIR__ .'/views/alert.php');
            include(__DIR__ .'/views/producto/index.php');
        }
        break;
    case 'change':
        $datos = $_POST;
        $fila=$app->update($id_producto, $datos);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='producto actualizado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo actualizar la marc';
        }
        $datos = $app->getAll();
        include(__DIR__ .'/views/alert.php');
        include(__DIR__ .'/views/producto/index.php');
        //print_r($_POST);
        //print_r($_GET);
        break;
    default:
        $datos = $app->getAll();
        include(__DIR__ .'/views/producto/index.php');

}



