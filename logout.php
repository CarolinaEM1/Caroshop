<?php
include __DIR__.'/admin/sistema.class.php';
$app=new Sistema();
$app->logout();
header("Location: login.php");

