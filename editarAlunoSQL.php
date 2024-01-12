<?php

include 'connect-database.php';

$nome = $_REQUEST['nome'];
$matricula = $_REQUEST['matricula'];
$matriculaAntiga = $_REQUEST['matriculaAntiga'];

$sql = "UPDATE alunos
        SET 
        nome = '$nome',
        matricula = $matricula
        where matricula = $matriculaAntiga";
$result = mysqli_query($connection, $sql);

if ($result) {
    $sql = "UPDATE notas
    SET 
    nome = '$nome',
    matricula = $matricula
    where matricula = $matriculaAntiga";
    $r = mysqli_query($connection, $sql);
    if ($r) {
        header("Location: index.php");
    }
}