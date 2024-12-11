<?php
//print_r($_POST);
//print_r($_GET);
include('empleado.class.php');
$app = new Empleado();
include('views/header.php');
$app->checkRol('Administrador', true);

$action = (isset($_GET['action']) ? $_GET['action'] : null);
$id_empleado = (isset($_GET['id_empleado']) ? $_GET['id_empleado'] : null);
$datos = array();
$alert=array();

switch ($action) {
    case 'delete':
        $fila = $app->delete($id_empleado);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='empleado  eliminado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo eliminar la empleado';
        }
        $datos = $app->getAll();
        include('views/alert.php');
        include('views/empleado/index.php');
        break;
    case 'create':
        include('views/empleado/form.php');
        break;
    case 'save':
        $datos = $_POST;
       
        $fila = $app->insert($datos);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='empleado guardado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo guardar la empleado';
        }
        $datos = $app->getAll();
        include('views/alert.php');
        include('views/empleado/index.php');
        break;
    case 'update':
        $datos = $app->getOne($id_empleado);
        if(isset($datos['id_empleado'])){
            include('views/empleado/form.php');
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No existe la empleado indicado';
            $datos = $app->getAll();
            include('views/alert.php');
            include('views/empleado/index.php');
        }
        break;
    case 'change':
        $datos = $_POST;
        $fila=$app->update($id_empleado, $datos);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='empleado actualizado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo actualizar la marc';
        }
        $datos = $app->getAll();
        include('views/alert.php');
        include('views/empleado/index.php');
        //print_r($_POST);
        //print_r($_GET);
        break;
    default:
        $datos = $app->getAll();
        include('views/empleado/index.php');

}


include('views/footer.php');
