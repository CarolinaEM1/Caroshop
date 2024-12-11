<?php
//print_r($_POST);
//print_r($_GET);
include(__DIR__ .'/marca.class.php');
$app = new Marca();
include(__DIR__ .'/views/header.php');
$app->checkRol('Administrador', true);
$action = (isset($_GET['action']) ? $_GET['action'] : null);
$id_marca = (isset($_GET['id_marca']) ? $_GET['id_marca'] : null);
$datos = array();
$alert=array();
switch ($action) {
    case 'delete':
        $fila = $app->delete($id_marca);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='Marca  eliminado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo eliminar la Marca';
        }
        $datos = $app->getAll();
        include(__DIR__ .'/views/alert.php');
        include(__DIR__ .'/views/marca/index.php');
        break;
    case 'create':
        include(__DIR__ .'/views/marca/form.php');
        break;
    case 'save':
        $datos = $_POST;
        $fila = $app->insert($datos);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='marca guardado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo guardar la marca';
        }
        $datos = $app->getAll();
        include(__DIR__ .'/views/alert.php');
        include(__DIR__ .'/views/marca/index.php');
        break;
    case 'update':
        $datos = $app->getOne($id_marca);
        if(isset($datos['id_marca'])){
            include(__DIR__ .'/views/marca/form.php');
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No existe la marca indicado';
            $datos = $app->getAll();
            include(__DIR__ .'/views/alert.php');
            include(__DIR__ .'/views/marca/index.php');
        }
        break;
    case 'change':
        $datos = $_POST;
        $fila=$app->update($id_marca, $datos);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='Marca actualizado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo actualizar la marc';
        }
        $datos = $app->getAll();
        include(__DIR__ .'/views/alert.php');
        include(__DIR__ .'/views/marca/index.php');
        //print_r($_POST);
        //print_r($_GET);
        break;
    default:
        $datos = $app->getAll();
        include(__DIR__ .'/views/marca/index.php');

}


include(__DIR__ .'/views/footer.php');
