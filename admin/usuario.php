<?php
//print_r($_POST);
//print_r($_GET);
include(__DIR__ .'/usuario.class.php');
$app = new Usuario();
include(__DIR__ .'/views/header.php');
$app->checkRol('Administrador', true);
$action = (isset($_GET['action']) ? $_GET['action'] : null);
$id_usuario = (isset($_GET['id_usuario']) ? $_GET['id_usuario'] : null);
$datos = array();
$roles=array();
$rolesSeleccionados = array();
$alert=array();
switch ($action) {
    case 'delete':
        $fila = $app->delete($id_usuario);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='usuario  eliminado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo eliminar la usuario';
        }
        $datos = $app->getAll();
        include(__DIR__ .'/views/alert.php');
        include(__DIR__ .'/views/usuario/index.php');
        break;
    case 'create':
        $roles=$app->getRoles();

        include(__DIR__ .'/views/usuario/form.php');
        break;
    case 'save':
        $datos = $_POST;
        $fila = $app->insert($datos);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='usuario guardado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo guardar la usuario';
        }
        $datos = $app->getAll();
        include(__DIR__ .'/views/alert.php');
        include(__DIR__ .'/views/usuario/index.php');
        break;
    case 'update':
        $datos = $app->getOne($id_usuario);
        $roles=$app->getRoles();
        $rolesSeleccionados=$app->getRolesOne($id_usuario);
        if(isset($datos['id_usuario'])){
            include(__DIR__ .'/views/usuario/form.php');
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No existe la usuario indicado';
            $datos = $app->getAll();
            include(__DIR__ .'/views/alert.php');
            include(__DIR__ .'/views/usuario/index.php');
        }
        break;
    case 'change':
        $datos = $_POST;
        $fila=$app->update($id_usuario, $datos);
        if($fila){
            $alert['tipo']='success';
            $alert['mensaje']='usuario actualizado correctamente';
        }else{
            $alert['tipo']='danger';
            $alert['mensaje']='No se pudo actualizar la marc';
        }
        $datos = $app->getAll();
        include(__DIR__ .'/views/alert.php');
        include(__DIR__ .'/views/usuario/index.php');
        //print_r($_POST);
        //print_r($_GET);
        break;
    default:
        $datos = $app->getAll();
        include(__DIR__ .'/views/usuario/index.php');

}


include(__DIR__ .'/views/footer.php');
