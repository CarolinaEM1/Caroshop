<?php
session_start();
define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'ferreteria');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_PORT', '3306');

class Config {
   
    function getImageSize() {
        return 500000;
    }
    function getImageType() {
        return array('image/jpeg', 'image/png', 'image/x-png');
    }
  

}