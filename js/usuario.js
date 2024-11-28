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

document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");
    const usuario = document.getElementById("nuevoUsuario");
    const contrasena = document.getElementById("nuevaContraseña");
    const nombre = document.getElementById("nuevoNombre");
    const errorNomUs = document.getElementById("nombreUs-error"); 
    const errorNom = document.getElementById("nombre-error");
    const errorCon = document.getElementById("contrasena-error");

    form.addEventListener("submit", async (e) => {
        let valid = true;

        e.preventDefault();

        // Validación del nombre de usuario
        if (!nombre.value.trim()) {
            document.getElementById("nombreUs-error").innerText = "Por favor, complete el campo de nombre de usuario.";
            nombre.classList.add("input-error");
            errorNomUs.classList.add("error-message");
            valid = false;
        } else {
            errorNom.innerText = ""; // Limpiar errores
            nombre.classList.remove("input-error");
            errorNomUs.classList.remove("error-message");
        }

        // Validación del nombre
        if (!usuario.value.trim()) {
            document.getElementById("nombre-error").innerText = "Por favor, complete el campo de nombre.";
            usuario.classList.add("input-error");
            errorNom.classList.add("error-message");
            valid = false;
        } else {
            errorNom.innerText = ""; // Limpiar errores
            usuario.classList.remove("input-error");
            errorNom.classList.remove("error-message");
        }

        // Validación del campo de contraseña
        if (!contrasena.value.trim()) {
            document.getElementById("contrasena-error").innerText = "Por favor, complete el campo de contraseña.";
            errorCon.classList.add("error-message");
            contrasena.classList.add("input-error");
            valid = false;
        } else {
            errorCon.innerText = ""; // Limpiar errores
            errorCon.classList.remove("error-message");
            contrasena.classList.remove("input-error");
        }

        if (valid) {
            form.submit();
        }
    });
});