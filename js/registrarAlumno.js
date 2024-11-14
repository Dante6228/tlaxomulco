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
    const error = document.getElementById("error-general");
    
    form.addEventListener("submit", (e) => {
        let valid = true;
        
        const nameRegex = /^[A-Za-záéíóúÁÉÍÓÚñÑ]+$/;  // Expresión regular que permite solo letras

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
        }
        
        // Validación del campo de matrícula (asegura que solo contenga números)
        if (!/^\d+$/.test(matricula.value)) {
            document.getElementById("matricula-error").innerText = "La matricula debe ir con números.";
            errorMat.classList.add("error-message");
            matricula.classList.add("input-error");
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
            }
        });

        if (!valid) {
            e.preventDefault(); // Evita que se envíe el formulario si hay errores
        }
    });
});
