document.addEventListener('DOMContentLoaded', function () {
    
    const menu = document.getElementById('acoes');

    menu.addEventListener('click', function(event) {
        if (event.target.classList.contains('voltar')){
            window.location.href = "index.php";
        }
    });

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
});

