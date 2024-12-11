<?php
//print_r($_POST);
//print_r($_GET);
include('tienda.class.php');
$app = new tienda();
include('views/header.php');
//$app->checkRol('Administrador', true);
$app->checkPrivilegio('Tienda', true);
$action = (isset($_GET['action']) ? $_GET['action'] : null);
$id_tienda = (isset($_GET['id_tienda']) ? $_GET['id_tienda'] : null);
$datos = array();
$alert=array();
switch ($action) {
    case 'delete':
        $fila = $app->delete($id_tienda);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='tienda  eliminado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo eliminar la tienda';
        }
        $datos = $app->getAll();
        include('views/alert.php');
        include('views/tienda/index.php');
        break;
    case 'create':
        include('views/tienda/form.php');
        break;
    case 'save':
        $datos = $_POST;
        $fila = $app->insert($datos);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='tienda guardado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo guardar la tienda';
        }
        $datos = $app->getAll();
        include('views/alert.php');
        include('views/tienda/index.php');
        break;
    case 'update':
        $datos = $app->getOne($id_tienda);
        if(isset($datos['id_tienda'])){
            include('views/tienda/form.php');
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No existe la tienda indicado';
            $datos = $app->getAll();
            include('views/alert.php');
            include('views/tienda/index.php');
        }
        break;
    case 'change':
        $datos = $_POST;
        $fila=$app->update($id_tienda, $datos);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='tienda actualizado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo actualizar la marc';
        }
        $datos = $app->getAll();
        include('views/alert.php');
        include('views/tienda/index.php');
        //print_r($_POST);
        //print_r($_GET);
        break;
    default:
        $datos = $app->getAll();
        include('views/tienda/index.php');

}


include('views/footer.php');
