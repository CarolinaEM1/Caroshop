<?php
include __DIR__ . '/sistema.class.php';
$app = new Sistema();

$action = (isset($_GET['action'])) ? $_GET['action'] : null;
require_once __DIR__ . '/views/headerSinMenu.php';
switch ($action) {
    case 'logout':
        $app->logout();
        $type = 'success';
        $messge = 'saliendo del sistema';
        $app->alert($type, $messge);
        include __DIR__ . '/views/login/index.php';
        break;
    case 'login':
        $correo = (isset($_POST['correo'])) ? $_POST['correo'] : null;
        $password = (isset($_POST['password'])) ? $_POST['password'] : null;
        $login = $app->login($correo, $password);
        if ($login) {
            header('Location:index.php');
        } else {
            $type = 'danger';
            $messge = 'Usuario o contraseña incorrectos';
            $app->alert($type, $messge);
            include __DIR__ . '/views/login/index.php';
        }
        break;
    case 'forgot':
        include (__DIR__ . '/views/login/forgot.php');
        break;
    case 'reset':
        $correo = (isset($_POST['correo'])) ? $_POST['correo'] : null;
        $reset = $app->reset($correo);
        if ($reset) {
            $type = 'success';
            $messge = 'Se envio correo';
            $app->alert($type, $messge);
            include __DIR__ . '/views/login/index.php';
        } else {
            $type = 'danger';
            $messge = 'Correo no existe';
            $app->alert($type, $messge);
            include __DIR__ . '/views/login/index.php';
        }
        break;
    case 'recovery':
        if (isset($_GET['token'])) {
            $token=$_GET['token'];
            include __DIR__ . '/views/login/recovery.php';
        }
        break;
    case 'change_password':
        $password = (isset($_POST['password'])) ? $_POST['password'] : null;
        $token=$_GET['token'];
        $change= $app->recovery($token,$password);
        if($change){
            $type = 'success';
            $messge = 'Cambio de contraseña correctamente';
            $app->alert($type, $messge);
            include __DIR__ . '/views/login/index.php';
        }else{
            $type = 'danger';
            $messge = 'No se pudo guardar contraseña correctamente';
            $app->alert($type, $messge);
            include __DIR__ . '/views/login/index.php';
        }
        break;
    case 'registro':
        include __DIR__ . '/views/login/registro.php';
        break;
    default:
        include __DIR__ . '/views/login/index.php';

}