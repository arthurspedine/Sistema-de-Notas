document.addEventListener("DOMContentLoaded", function() {
    const menu = document.getElementById("radio-toolbar");

    const formCadastrar = document.getElementById("formCadastro");
    const formEditar = document.getElementById("formEditar");
    const formExcluir = document.getElementById("formExcluir");

    menu.addEventListener('click', function(event){
        if (event.target.classList.contains('cadastrar')){
            formCadastrar.style.display = 'block';
            formEditar.style.display = 'none';
            formExcluir.style.display = 'none';
        } else if (event.target.classList.contains('editar')){
            formCadastrar.style.display = 'none';
            formEditar.style.display = 'block';
            formExcluir.style.display = 'none';
        } else if (event.target.classList.contains('excluir')){
            formCadastrar.style.display = 'none';
            formEditar.style.display = 'none';
            formExcluir.style.display = 'block';
        }
    });

    const back = document.getElementById('acoes');

    back.addEventListener('click', function(event){
        if (event.target.classList.contains("voltar")){
            window.location.href = 'index.php';
        }

    });

    var materiasSelect = document.getElementById('materiasSelect');
    var output = document.getElementById('output');

    materiasSelect.addEventListener('change', function() {
        output.value = materiasSelect.value;
    });
});