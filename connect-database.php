<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'gradescontrol';

$connection = mysqli_connect($host, $username, $password, $database);

if ($connection == false){
    print_r("Erro! ".mysqli_connect_error());
    exit;
}

?>