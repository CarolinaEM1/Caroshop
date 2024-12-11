<?php
//print_r($_POST);
//print_r($_GET);
include (__DIR__ . '/rol.class.php');
$app = new Rol();
include (__DIR__ . '/views/header.php');
$app->checkRol('Administrador', true);
$action = (isset($_GET['action']) ? $_GET['action'] : null);
$id_rol = (isset($_GET['id_rol']) ? $_GET['id_rol'] : null);
$datos = array();
$privilegios=array();
$alert = array();
switch ($action) {
    case 'delete':
        $fila = $app->delete($id_rol);
        if ($fila) {
            $alert['tipo'] = 'success';
            $alert['mensaje'] = 'rol  eliminado correctamente';
        } else {
            $alert['tipo'] = 'danger';
            $alert['mensaje'] = 'No se pudo eliminar la rol';
        }
        $datos = $app->getAll();
        include (__DIR__ . '/views/alert.php');
        include (__DIR__ . '/views/rol/index.php');
        break;
    case 'create':
        $privilegios=$app->getPrivilegios();
        include (__DIR__ . '/views/rol/form.php');
        break;
    case 'save':
        $datos = $_POST;
        $fila = $app->insert($datos);
        if ($fila) {
            $alert['tipo'] = 'success';
            $alert['mensaje'] = 'rol guardado correctamente';
        } else {
            $alert['tipo'] = 'danger';
            $alert['mensaje'] = 'No se pudo guardar la rol';
        }
        $datos = $app->getAll();
        include (__DIR__ . '/views/alert.php');
        include (__DIR__ . '/views/rol/index.php');
        break;
    case 'update':
        $datos = $app->getOne($id_rol);
        // En tu controlador rol.php
        $privilegios=$app->getPrivilegios();
        $privilegiosSeleccionados = $app->getRolesPrivileges($id_rol);

        if (isset($datos['id_rol'])) {
            include (__DIR__ . '/views/rol/form.php');
        } else {
            $alert['tipo'] = 'danger';
            $alert['mensaje'] = 'No existe la rol indicado';
            $datos = $app->getAll();
            include (__DIR__ . '/views/alert.php');
            include (__DIR__ . '/views/rol/index.php');
        }
        break;
    case 'change':
        $datos = $_POST;
        $fila = $app->update($id_rol, $datos);
        if ($fila) {
            $alert['tipo'] = 'success';
            $alert['mensaje'] = 'rol actualizado correctamente';
        } else {
            $alert['tipo'] = 'danger';
            $alert['mensaje'] = 'No se pudo actualizar la marc';
        }
        $datos = $app->getAll();
        include (__DIR__ . '/views/alert.php');
        include (__DIR__ . '/views/rol/index.php');
        //print_r($_POST);
        //print_r($_GET);
        break;
    default:
        $datos = $app->getAll();
        include (__DIR__ . '/views/rol/index.php');

}


include (__DIR__ . '/views/footer.php');
