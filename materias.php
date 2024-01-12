<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Matérias</title>
    <link rel="stylesheet" type="text/css" href="style-materia.css">
</head>
<body>
    <?php

    if (isset($_GET['materia-existente']) && $_GET['materia-existente'] == "true"){
        echo "<script type='text/javascript'>alert('Matéria já utilizada!";
        echo "Clique em OK para continuar!');</script>";
    }

    include 'connect-database.php';

    $sql = "SELECT * from disciplinas;";
    $result = mysqli_query($connection, $sql);
    $dados = mysqli_fetch_all($result);

    if (count($dados) > 1 ){
        $a = "Matérias";
    } else {$a = "Matéria";}

    ?>


    <nav>
        <h1>Modificar Matérias</h1>
        <input type="submit" value="Voltar" id="acoes" class="voltar">
    </nav>

    <section class="materias">
        <h2>Modificação de Matérias</h2>

        <div class="radio-toolbar" id="radio-toolbar">
            <input class="cadastrar" type="radio" name="tipo" id="radioCadastrar" value="Cadastrar">
            <label for="radioCadastrar">Cadastrar</label>

            <input class="editar" type="radio" name="tipo" id="radioEditar" value="Editar">
            <label for="radioEditar">Editar</label>

            <input class="excluir" type="radio" name="tipo" id="radioExcluir" value="Excluir">
            <label for="radioExcluir">Excluir</label>    
        </div>

        <section id="formCadastro" style="display: none;">
            <form action="manipularMaterias.php" method="post">
                <input type="hidden" value="Cadastrar" name="reg">
                <label for="">Matéria</label>
                <input type="text" name="materia-cadastro" id="materia" autocomplete="off" placeholder="Digite o nome de uma matéria...">
                <button type="submit">Cadastar</button>
            </form>
        </section>

        <section id="formEditar" style="display: none;">
            <form action="manipularMaterias.php" method="post">
                <input type="hidden" value="Editar" name="edit">
                <label for=""><?php print_r($a); ?> </label>
                <div class="div-select">
                    <select name="materias" id="materiasSelect">
                        <option value selected disabled>Selecione...</option>
                        <?php foreach ($dados as $item){
                            $b = $item[0];
                            echo "<option value='$b' name='$b'>$b</option>";
                        } ?>
                    </select>
                </div>
                <input type="text" id="output" name="materia-editar">
                <button type="submit">Salvar</button>
            </form>
        </section>

        <section id="formExcluir" style="display: none;">
            <form action="manipularMaterias.php" method="post">
                <input type="hidden" value="Excluir" name="del">
                <label for=""><?php print_r($a); ?></label>
                <div class="div-select">
                    <select name="materia-excluir" id="">
                        <option value selected disabled>Selecione...</option>
                        <?php foreach ($dados as $item) {
                            $b = $item[0];
                            echo "<option value='$b' name='$b'>$b</option>";
                        } ?>
                    </select>
                </div>
                <button type="submit">Excluir</button>
            </form>
        </section>
    </section>

    <script src="scriptM.js"></script>
</body>
</html>