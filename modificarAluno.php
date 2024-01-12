<?php

include "connect-database.php";

$tipo = $_REQUEST['cadastrar'];

if ($tipo != NULL) {
    $nome = $_REQUEST["nome"];
    $matricula = $_REQUEST["matricula"];

    if ($nome == "" or $matricula == "") {
        header("Location: index.php?matricula-existente=true");
        exit;
    }

    $alunos = "SELECT matricula from alunos;";
    $result = mysqli_query($connection, $alunos);
    $dados = mysqli_fetch_all($result);

    foreach ($dados as $item) {
        if ($item[0] == $matricula) {
            header("Location: index.php?matricula-existente=true");
            exit;
        }
    }

    $sql = "INSERT INTO alunos (nome, matricula) 
                VALUES ('$nome', $matricula);";
    $r = mysqli_query($connection, $sql);

    $sql1 = "INSERT INTO notas (nome, matricula)
                VALUES ('$nome', $matricula);";
    $r1 = mysqli_query($connection, $sql1);

    if ($r) {
        header("Location: index.php");
    } else {
        echo "Não foi possível inserir no banco de dados!";
    }
} else {
    $matricula = $_GET["matricula"];

    $sql = "DELETE FROM alunos WHERE matricula = $matricula";
    $result = mysqli_query($connection, $sql);

    $sql1 = "DELETE FROM notas WHERE matricula = $matricula";     
    $r1 = mysqli_query($connection, $sql1);

    if ($result){
        header("Location: index.php");
    } else {
        echo "Não foi possível excluir no banco de dados!";
    }
}
?>