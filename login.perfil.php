<?php
include __DIR__.'/admin/sistema.class.php';
$datos=$_POST;
$app=new Sistema;
//print_r($_SESSION);
//print_r($_POST);
//die;
if($app->validateEmail($datos['correo'])){
    if($app->login($datos['correo'],$datos['contrasena'])){
        header("Location: checkout.php");
    }else{
        header("Location: login.php");
    }
}else{
    header("Location: login.php");
}
?>