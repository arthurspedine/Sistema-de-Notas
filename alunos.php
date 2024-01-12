<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Alunos</title>
    <link rel="stylesheet" type="text/css" href="style-modificar.css">
</head>

<body>
    <?php

    if (isset($_GET['dados-nulos']) && $_GET['dados-nulos'] == "true") {
        echo "<script type='text/javascript'>alert('Erro! Dados inválidos ou nulos!');</script>";
    }


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

    $sql = "SELECT * from disciplinas";
    $result = mysqli_query($connection, $sql);
    $dados = mysqli_fetch_all($result);

    $materias = array();

    foreach ($dados as $row) {
        $materias[] = $row;
    }

    $sql = "SELECT * FROM alunos";
    $result = mysqli_query($connection, $sql);
    $dados = mysqli_fetch_all($result);

    $m1 = "";
    $m2 = "";
    $m3 = "";

    $avaliacao = array(
        "A" => "Aprovado",
        "R" => "Recuperação",
        "Rep" => "Reprovado",
        "I" => "Indisponível",
    );

    ?>
    <nav>
        <h1>Modificar Alunos</h1>
        <input type="submit" value="Voltar" id="acoes" class="voltar">
    </nav>

    <input type="submit" value="Cadastrar Aluno" id="cadastrar" class="alunocadastrar">
    <div id="cadastroAluno" style="display: none">
        <table>
            <caption>Cadastrar Aluno</caption>
            <form action="cadastrarAluno.php" method="post">
                <input type="hidden" value="Cadastrar" name="cadastrar">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Matrícula</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="nome" autocomplete="off" placeholder="Digite o nome..."></td>
                        <td><input type="number" name="matricula" autocomplete="off" placeholder="Digite um número..."></td>
                    </tr>
                    <tr>
                        <td colspan="2"><button type="submit">Cadastrar</button></td>
                    </tr>
                </tbody>
            </form>
        </table>
    </div>
    <section>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Matrícula</th>
                    <?php foreach ($materias as $materia) { ?>
                        <th><?php echo $materia[0]; ?></th>
                    <?php } ?>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dados as $item) { ?>
                    <tr>
                        <th><?php print_r($item[1]); ?></th>
                        <th><?php print_r($item[2]); ?></th>

                        <?php
                        for ($i = 0; $i < count($materias); $i++) {
                            $a = 1;
                            if ($a != 0) {
                                $materia = $materias[$i][0];
                                $nMateria = strtr($materia, $caracteres_sem_acento);

                                $m1 = $nMateria . "1";
                                $m2 = $nMateria . "2";
                                $m3 = $nMateria . "3";

                                $sql = "SELECT $m1, $m2, $m3 FROM notas where matricula = $item[2]";
                                $result = mysqli_query($connection, $sql);
                                $dados1 = mysqli_fetch_all($result);

                                foreach ($dados1 as $value) {
                                    if ($value[0] === NULL || $value[1] === NULL || $value[2] === NULL) {
                                        $avaliado = $avaliacao["I"];
                                    } else {
                                        $media = (floatval($value[0]) + floatval($value[1]) + floatval($value[2])) / 3;
                                        $media = number_format($media, 2);

                                        switch ($media) {
                                            case $media >= 6:
                                                $avaliado = $avaliacao["A"]; // * APROVADO
                                                break;
                                            case $media > 4:
                                                $avaliado = $avaliacao["R"]; // ! Recuperação
                                                break;
                                            case $media <= 4:
                                                $avaliado = $avaliacao["Rep"]; // ! Reprovado
                                                break;
                                            default:
                                                $avaliado = $avaliacao["I"]; // Indisponível
                                                break;
                                        }
                                    }
                                } ?>

                                <td><?php print_r($avaliado); ?></td>
                        <?php
                                $a = 0;
                            }
                        }
                        ?>
                        <td>
                            <a href="editarAluno.php?nome=<?php print_r($item[1]); ?>&matricula=<?php print_r($item[2]); ?>">Editar</a>
                            <strong>|</strong>
                            <a id="" name="del" href="/modificarAluno.php?matricula=<?php print_r($item[2]); ?>">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>

    <script src="script.js"></script>
</body>

</html>