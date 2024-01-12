<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Notas</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <?php

    if (isset($_GET['matricula-existente']) && $_GET['matricula-existente'] == "true") {
        echo "<script type='text/javascript'>alert('Número de Matrícula já utilizado!";
        echo "Clique em OK para continuar!');</script>";
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

    $sql = "SELECT * FROM disciplinas";
    $result = mysqli_query($connection, $sql);
    $dados = mysqli_fetch_all($result);

    $materias = array();

    foreach ($dados as $row) {
        $materias[] = $row;
    }

    $sql = "SELECT * from alunos";
    $result = mysqli_query($connection, $sql);
    $dados = mysqli_fetch_all($result);

    $m1 = "";
    $m2 = "";
    $m3 = "";

    $media = 0;

    $avaliacao = array(
        "A" => "Aprovado",
        "R" => "Recuperação",
        "Rep" => "Reprovado",
        "I" => "Indisponível",
    );

    ?>

    <main>
        <section class="menu">
            <nav>
                <h1>Notas dos Estudantes</h1>
                <ul>
                    <?php foreach ($materias as $item) {
                        echo "<li><a class='a' href='materia-info.php?materia=$item[0]'>$item[0]</a></li>";
                    } ?>
                </ul>
                <section id="acoes">
                    <input class="alunos" id="cadastros" type="submit" value="Modificar Alunos">
                    <input class="materias" id="cadastros" type="submit" value="Modificar Matérias">
                </section>
            </nav>
        </section>

        <section>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Matrícula</th>
                        <?php foreach ($materias as $materia) { ?>
                            <th><?php echo $materia[0]; ?></th>
                            <th>Média</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dados as $item) {
                        $matricula = $item[2]; ?>
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

                                    $sql = "SELECT $m1, $m2, $m3 FROM notas WHERE matricula = $matricula";
                                    $result = mysqli_query($connection, $sql);
                                    $dados1 = mysqli_fetch_all($result);

                                    foreach ($dados1 as $value) {
                                        if ($value[0] === NULL || $value[1] === NULL || $value[2] === NULL) {
                                            $avaliado = $avaliacao["I"];
                                            $media = "Valor Indisponível";
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
                                    <td><?php print_r($media); ?></td>
                            <?php
                                    $a = 0;
                                }
                            }
                            ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </main>
    <script src="script.js"></script>
</body>

</html>