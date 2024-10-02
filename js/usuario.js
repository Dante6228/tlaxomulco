let modal = document.getElementById("editarDatosModal");
let btn = document.querySelector("a[href='#']");
let span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
    modal.style.display = "block";
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

span.onclick = function() {
    modal.style.animation = "animacionCierre 0.5s";
    setTimeout(function() {
        modal.style.display = "none";
        modal.style.animation = "";
    }, 500);
}