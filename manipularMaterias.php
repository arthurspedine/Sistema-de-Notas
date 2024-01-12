<?php

$caracteres_sem_acento = array(
    'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'Â' => 'Z', 'Â' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
    'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
    'Ï' => 'I', 'Ñ' => 'N', 'Å' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
    'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
    'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
    'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'Å' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
    'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'ƒ' => 'f',
    'Ä' => 'a', 'î' => 'i', 'â' => 'a', 'È' => 's', 'È' => 't', 'Ä' => 'A', 'Î' => 'I', 'Â' => 'A', 'È' => 'S', 'È' => 'T',
);

include 'connect-database.php';

$tipo = $_REQUEST['reg'];
$tipo1 = $_REQUEST['edit'];
$tipo2 = $_REQUEST['del'];

if ($tipo != NULL) {
    $materia = $_REQUEST['materia-cadastro'];
    $novoTipo = strtr($materia, $caracteres_sem_acento);
    $novoTipo = mysqli_real_escape_string($connection, $novoTipo);
    $sql = "SELECT COUNT(*) as count FROM disciplinas WHERE materia = '$novoTipo'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row['count'] > 0) {
        header("Location: materias.php?materia-existente=true");
    } else {

        $materia = mysqli_real_escape_string($connection, $materia);
        $sql = "INSERT INTO disciplinas (materia) VALUES ('$materia')";
        $r = mysqli_query($connection, $sql);
        if ($r) {
            $m = strtr($materia, $caracteres_sem_acento);
            for ($i = 1; $i <= 3; $i++) {
                $materia = $m.$i;
                $sql = "ALTER TABLE notas
                    ADD $materia DECIMAL(3,2) NULL";
                $r1 = mysqli_query($connection, $sql);
            }
            if ($r1){
                header("Location: index.php");
            } else {
                echo "Não foi possível inserir no banco de dados!";
            }
        } else {
            echo "Não foi possível inserir no banco de dados!";
        }
    }
}

if ($tipo1 != NULL) {
    $materia = $_REQUEST['materias'];
    $materiaNova = $_REQUEST['materia-editar'];

    $sql = "UPDATE disciplinas SET
            materia = '$materiaNova'
            WHERE materia = '$materia'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        $m = strtr($materia, $caracteres_sem_acento);
        $m1 = strtr($materiaNova, $caracteres_sem_acento);
        for ($i = 1; $i <= 3; $i++){
            $materiaA = $m.$i;
            $materiaN = $m1.$i;
            $sql = "ALTER TABLE notas
                    CHANGE $materiaA $materiaN DECIMAL(3,2) NULL";
            $r = mysqli_query($connection, $sql);
        }
        if ($r) {
            header("Location: index.php");
        } else {
            echo "Não foi possível editar o item no banco de dados!";
        }
    } else {
        echo "Não foi possível editar o item no banco de dados!";
    }
}

if ($tipo2 != NULL) {

    $materia = $_REQUEST['materia-excluir'];
    $sql = "DELETE FROM disciplinas WHERE materia = '$materia'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        $m = strtr($materia, $caracteres_sem_acento);
        for ($i = 1; $i <= 3; $i++){
            $materia = $m.$i;
            $sql = "ALTER TABLE notas
                    DROP COLUMN $materia";
            $r = mysqli_query($connection, $sql);
        }
        if ($r){
            header("Location: index.php");
        } else {
            echo "Não foi possível excluir no banco de dados!";
        }
    } else {
        echo "Não foi possível excluir no banco de dados!";
    }
}
