<?php
//controlador
include('doctores.class.php');
$app = new Doctores;
/*$id_doctor=$_GET['id_doctor'];
$datos= $app->getOne($id_doctor);
print_r ($datos);
$filas= $app->delete($id_doctor);
echo $filas;
$datos= $app->getOne($id_doctor);
print_r($datos);
*/

$doctor['nombre']='Chuck';
$doctor['primer_apellido']='Norris';
$doctor['segundo_apellido']='Castañeda';
$doctor['fotografia']='chuck.jpg';
$fila=$app->update(6,$doctor);
echo $fila;