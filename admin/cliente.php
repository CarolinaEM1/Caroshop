<?php
//print_r($_POST);
//print_r($_GET);
include('cliente.class.php');
$app = new Cliente();
include('views/header.php');
$app->checkRol('Administrador', true);

$action = (isset($_GET['action']) ? $_GET['action'] : null);
$id_cliente = (isset($_GET['id_cliente']) ? $_GET['id_cliente'] : null);
$datos = array();
$alert=array();
switch ($action) {
    case 'delete':
        $fila = $app->delete($id_cliente);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='cliente  eliminado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo eliminar la cliente';
        }
        $datos = $app->getAll();
        include('views/alert.php');
        include('views/cliente/index.php');
        break;
    case 'create':
        include('views/cliente/form.php');
        break;
    case 'save':
        $datos = $_POST;
        $fila = $app->insert($datos);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='cliente guardado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo guardar la cliente';
        }
        $datos = $app->getAll();
        include('views/alert.php');
        include('views/cliente/index.php');
        break;
    case 'update':
        $datos = $app->getOne($id_cliente);
        if(isset($datos['id_cliente'])){
            include('views/cliente/form.php');
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No existe la cliente indicado';
            $datos = $app->getAll();
            include('views/alert.php');
            include('views/cliente/index.php');
        }
        break;
    case 'change':
        $datos = $_POST;
        $fila=$app->update($id_cliente, $datos);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='cliente actualizado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo actualizar la marc';
        }
        $datos = $app->getAll();
        include('views/alert.php');
        include('views/cliente/index.php');
        //print_r($_POST);
        //print_r($_GET);
        break;
    default:
        $datos = $app->getAll();
        include('views/cliente/index.php');

}


include('views/footer.php');
