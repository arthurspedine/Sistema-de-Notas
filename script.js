document.addEventListener('DOMContentLoaded', function() {

    var cells = document.querySelectorAll("td");

    cells.forEach(function(cell){
        if (cell.textContent === "Recuperação"){
            cell.classList.add("rep");
        } else if (cell.textContent === "Reprovado") {
            cell.classList.add("r");
        } else if (cell.textContent === "Aprovado") {
            cell.classList.add("a");
        } else if (cell.textContent === "Indisponível") {
            cell.classList.add("i");
        }
    });

    const menu = document.getElementById('acoes');
    
    menu.addEventListener('click', function(event){
        if (event.target.classList.contains('alunos')){
            window.location.href = 'alunos.php';
        } else if (event.target.classList.contains('materias')){
            window.location.href = 'materias.php';
        } else {
            window.location.href = 'index.php';
        }
    });
    
    const cadastros = document.getElementById('cadastrar');
    const formAluno = document.getElementById('cadastroAluno');

    cadastros.addEventListener('click', function(event) {
        if (event.target.classList.contains('alunocadastrar')) {
            if (formAluno.style.display == 'block'){
                formAluno.style.display = 'none';
            } else {
                formAluno.style.display = 'block';
            }
            
        }
    });
});