<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Aluno</title>
    <link rel="stylesheet" type=text/css href="style-edicao.css">
</head>
<body>
    <?php

    include 'connect-database.php';

    if (isset($_GET['valor']) && $_GET['valor'] == "true") {
        echo "<script type='text/javascript'>alert('Nota nula, por favor digite uma nota existente!')</script>";
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
    
    $matricula = $_GET['matricula'];

    
    $materiaRequest = $_GET['materia'];

    $materia = strtr($materiaRequest, $caracteres_sem_acento);

    $m1 = $materia . "1";
    $m2 = $materia . "2";
    $m3 = $materia . "3";

    $sql = "SELECT nome, $m1, $m2, $m3 from notas where matricula = $matricula";
    $result = mysqli_query($connection, $sql);
    $dados = mysqli_fetch_all($result);
    $n1;
    $n2;
    $n3;
    foreach ($dados as $item) {
        $n1 = $item[1];
        $n2 = $item[2];
        $n3 = $item[3];
    }

    ?>

    <section class="menu">
        <nav>
            <h1>Edição do Aluno</h1>

            <a href="materia-info.php?materia=<?php echo $materiaRequest; ?>" class="voltar" id="voltar">Voltar</a>
        </nav>
    </section>
    
    <section class="main">
        <div>
            <h3>Nome:</h3>
            <span class="nome"><?php echo $dados[0][0]; ?></span>
            <br>
            <h3>Matrícula:</h3>
            <span class="matricula"><?php echo $matricula; ?></span>
        </div>
        <form action="notasAlunoSQL.php?materia=<?php echo $materiaRequest; ?>&matricula=<?php echo $matricula; ?>" method="post">
            <p>1ᵃ Nota</p>
            <input type="number" placeholder="Digite aqui..." value="<?php print_r($n1); ?>" name="valor1" step="0.1" min="0" max="10" oninput="validarValor(this)">
            <p for="">2ᵃ Nota</p>
            <input type="number" placeholder="Digite aqui..." value="<?php print_r($n2); ?>" name="valor2" step="0.1" min="0" max="10" oninput="validarValor(this)">
            <p for="">3ᵃ Nota</p>
            <input type="number" placeholder="Digite aqui..." value="<?php print_r($n3); ?>" name="valor3" step="0.1" min="0" max="10" oninput="validarValor(this)">
            <button type="submit">Confirmar</button>
        </form>
    </section>

    <script>
        function validarValor(input) {
            var valor = input.value;
            var comprimento = valor.length;
            if (input.value < 0){
                input.value = 0;
            } else if (input.value > 10.0) {
                input.value = 10.0;
            }
            if (comprimento > 4) {
                input.value = 0;
            }
        }
    </script>
</body>
</html>