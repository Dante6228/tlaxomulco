async function cargarOpciones(url, parametros, selectId) {
    const selectElement = document.getElementById(selectId);

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: parametros
        });

        const data = await response.text();
        selectElement.innerHTML = data;
    } catch (error) {
        console.error('Error:', error);
    }
}

function cargarGrados() {
    let nivelEducativoId = document.getElementById("nivel_escolar").value;
    cargarOpciones('php/alumnos/obtener_grados.php', `nivelEducativoId=${nivelEducativoId}`, "grado");
    limpiarSelect('nivel_escolar');
}


function cargarColonias() {
    let municipio = document.getElementById("municipio").value;
    cargarOpciones('php/alumnos/obtener_colonias.php', `municipio=${municipio}`, "colonia");
    limpiarSelect('municipio')
}

function limpiarSelect(id) {
    const select = document.getElementById(id);
    const option = select.querySelector("option[value='']");
    if (option) {
        option.disabled = true;
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");
    const nombre = document.getElementById("nombre");
    const ap = document.getElementById("ap");
    const am = document.getElementById("am");
    const matricula = document.getElementById("matricula");
    const selects = ["genero", "medio_enterado", "ciclo", "nivel_escolar", "grado", "municipio", "colonia", "estado", "promocion"];
    const errorNom = document.getElementById("nombre-error");
    const errorMat = document.getElementById("matricula-error");
    const errorMat2 = document.getElementById("matricula-error2");
    const error = document.getElementById("error-general");

    form.addEventListener("submit", async (e) => {
        let valid = true;  // Inicialmente se asume que es válido

        e.preventDefault();

        const nameRegex = /^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/;  // Expresión regular que permite solo letras

        // Validación del nombre
        if (!nombre.value.trim() || !ap.value.trim() || !am.value.trim()) {
            document.getElementById("nombre-error").innerText = "Por favor, completa todos los campos de nombre.";
            nombre.classList.add("input-error");
            ap.classList.add("input-error");
            am.classList.add("input-error");
            errorNom.classList.add("error-message");
            valid = false;
        } else if (!nameRegex.test(nombre.value.trim()) || !nameRegex.test(ap.value.trim()) || !nameRegex.test(am.value.trim())) {
            document.getElementById("nombre-error").innerText = "El nombre solo puede contener letras.";
            nombre.classList.add("input-error");
            ap.classList.add("input-error");
            am.classList.add("input-error");
            errorNom.classList.add("error-message");
            valid = false;
        } else {
            errorNom.innerText = ""; // Limpiar errores
            nombre.classList.remove("input-error");
            ap.classList.remove("input-error");
            am.classList.remove("input-error");
            errorNom.classList.remove("error-message");
        }

        // Validación del campo de matrícula (asegura que solo contenga números)
        if (!/^\d+$/.test(matricula.value)) {
            document.getElementById("matricula-error").innerText = "La matricula debe ir con números.";
            errorMat.classList.add("error-message");
            matricula.classList.add("input-error");
            valid = false;
        } else {
            errorMat.innerText = ""; // Limpiar errores
            errorMat.classList.remove("error-message");
            matricula.classList.remove("input-error");
        }

        // Verificación de matrícula en el servidor
        try {
            const response = await fetch("php/alumnos/obtener_matricula.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `matricula=${encodeURIComponent(matricula.value)}`,
            });

            const data = await response.text();

            if (data.includes("ya existe")) {
                errorMat2.innerText = "La matrícula ya está registrada.";
                errorMat2.classList.add("error-message");
                matricula.classList.add("input-error");
                valid = false;
            } else {
                errorMat2.innerText = ""; // Limpiar errores
                errorMat2.classList.remove("error-message");
                matricula.classList.remove("input-error");
            }
        } catch (error) {
            console.error("Error al comprobar matrícula:", error);
            valid = false;
        }

        // Validación de los select
        selects.forEach(selectId => {
            const selectElement = document.getElementById(selectId);
            if (!selectElement.value) {
                document.getElementById("error-general").innerText = `Por favor, selecciona una opción en el campo ${selectElement.previousElementSibling.innerText}.`;
                error.classList.add('error-message');
                selectElement.classList.add('input-error');
                valid = false;
            } else {
                error.innerText = ""; // Limpiar errores
                error.classList.remove('error-message');
                selectElement.classList.remove('input-error');
            }
        });

        if (valid) {
            form.submit();
        }
    });
});

