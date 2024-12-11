<?php
//print_r($_POST);
//print_r($_GET);
include(__DIR__ .'/privilegio.class.php');
$app = new Privilegio();
include(__DIR__ .'/views/header.php');
$app->checkRol('Administrador', true);
$action = (isset($_GET['action']) ? $_GET['action'] : null);
$id_privilegio = (isset($_GET['id_privilegio']) ? $_GET['id_privilegio'] : null);
$datos = array();
$alert=array();
switch ($action) {
    case 'delete':
        $fila = $app->delete($id_privilegio);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='privilegio  eliminado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo eliminar la privilegio';
        }
        $datos = $app->getAll();
        include(__DIR__ .'/views/alert.php');
        include(__DIR__ .'/views/privilegio/index.php');
        break;
    case 'create':
        include(__DIR__ .'/views/privilegio/form.php');
        break;
    case 'save':
        $datos = $_POST;
        $fila = $app->insert($datos);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='privilegio guardado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo guardar la privilegio';
        }
        $datos = $app->getAll();
        include(__DIR__ .'/views/alert.php');
        include(__DIR__ .'/views/privilegio/index.php');
        break;
    case 'update':
        $datos = $app->getOne($id_privilegio);
        if(isset($datos['id_privilegio'])){
            include(__DIR__ .'/views/privilegio/form.php');
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No existe la privilegio indicado';
            $datos = $app->getAll();
            include(__DIR__ .'/views/alert.php');
            include(__DIR__ .'/views/privilegio/index.php');
        }
        break;
    case 'change':
        $datos = $_POST;
        $fila=$app->update($id_privilegio, $datos);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='privilegio actualizado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo actualizar la marc';
        }
        $datos = $app->getAll();
        include(__DIR__ .'/views/alert.php');
        include(__DIR__ .'/views/privilegio/index.php');
        //print_r($_POST);
        //print_r($_GET);
        break;
    default:
        $datos = $app->getAll();
        include(__DIR__ .'/views/privilegio/index.php');

}


include(__DIR__ .'/views/footer.php');
