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
    
    $matricula = $_GET['matricula'];
    $nome = $_GET['nome'];

    ?>

    <section class="menu">
        <nav>
            <h1>Edição do Aluno</h1>

            <a href="alunos.php" class="voltar" id="voltar">Voltar</a>
        </nav>
    </section>
    
    <section class="main">
        <form action="editarAlunoSQL.php" method="post">
            <input type="hidden" name="matriculaAntiga" value="<?php print_r($matricula); ?>">
            <h3>Nome:</h3>
            <input type="text" placeholder="Digite aqui..." value="<?php print_r($nome); ?>" name="nome" step="0.1" min="0" max="10" autocomplete="off" oninput="validarValor(this)">
            <br>
            <h3>Matrícula:</h3>
            <input type="number" placeholder="Digite aqui..." value="<?php print_r($matricula); ?>" name="matricula" step="0.1" min="1" autocomplete="off" oninput="validarValor(this)">
            <button type="submit">Confirmar</button>
        </form>
    </section>

    <script></script>
</body>
</html>