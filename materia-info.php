<!DOCTYPE html>
<html lang="en">
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

$materiaRequest = $_REQUEST['materia'];

$materia = strtr($materiaRequest, $caracteres_sem_acento);

include 'connect-database.php';

$m1 = $materia . "1";
$m2 = $materia . "2";
$m3 = $materia . "3";

$sql = "SELECT nome, matricula, $m1, $m2, $m3 FROM notas";
$result = mysqli_query($connection, $sql);
$dados = mysqli_fetch_all($result);

$avaliacao = array(
    "A" => "Aprovado",
    "R" => "Recuperação",
    "Rep" => "Reprovado",
    "I" => "Indisponível",
);

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matéria <?php echo $materiaRequest; ?></title>

    <link rel="stylesheet" type="text/css" href="style-pagmaterias.css">
</head>

<body>

    <section class="menu">
        <nav>
            <h1><?php echo $materiaRequest; ?></h1>

            <section id="acoes">
                <input type="submit" value="Voltar" class="voltar" id="voltar">
            </section>
        </nav>
    </section>

    <section>
        <table>
            <caption>Alunos</caption>
            <thead>
                <tr>
                    <th>Estudante</th>
                    <th>Número de Matrícula</th>
                    <th>1ᵃ Nota</th>
                    <th>2ᵃ Nota</th>
                    <th>3ᵃ Nota</th>
                    <th>Média</th>
                    <th>Avaliado</th>
                    <th>Editar Nota <br> Excluir Aluno</th>
                </tr>
            </thead>
            <!-- $item[2] = 2;$item[3] = 4;$item[4] = 5.9; ! teste ! -->
            <?php foreach ($dados as $item) { ?>
                <tr>
                    <th><?php print_r($item[0]); ?> </th>
                    <th><?php print_r($item[1]); ?> </th>
                    <td><?php if ($item[2] === NULL) {
                            print_r("Não Avaliado");
                        } else {
                            print_r($item[2]);
                        } ?> </td>
                    <td><?php if ($item[3] === NULL) {
                            print_r("Não Avaliado");
                        } else {
                            print_r($item[3]);
                        } ?> </td>
                    <td><?php if ($item[4] === NULL) {
                            print_r("Não Avaliado");
                        } else {
                            print_r($item[4]);
                        } ?> </td>
                    <td><?php if ($item[2] === NULL || $item[3] === NULL || $item[4] === NULL) {
                            print_r("Média Indisponível");
                            $avaliado = $avaliacao["I"];
                        } else {
                            $media = (floatval($item[2]) + floatval($item[3]) + floatval($item[4])) / 3;
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
                            print_r($media);
                        } ?> </td>
                    
                    <td><?php print_r($avaliado); ?></td>
                    <td>
                        <a href="detalhes-aluno.php?materia=<?php print_r($materiaRequest); ?>&matricula=<?php print_r($item[1]); ?>">Editar</a>
                        <strong>|</strong>
                        <a href="#">Excluir</a>
                    </td>
                </tr>
            <?php } ?>
            <tbody>
                <tr></tr>
            </tbody>
        </table>
    </section>
    <script src="scriptMaterias.js">
        
    </script>
</body>

</html>