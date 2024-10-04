function cargarGrados() {
    // Obtener el ID del nivel educativo seleccionado
    let nivelEducativoId = document.getElementById("nivel-educativo").value;

    // Seleccionar el elemento <select> de "Grado" y limpiar sus opciones
    const selectGrado = document.getElementById("grado");
    selectGrado.innerHTML = ""; // Limpiar el select de grados

    // Eliminar el option por defecto en el nivel educativo
    const selectNivel = document.getElementById("nivel-educativo");
    const defaultOption = selectNivel.querySelector("option[value='']");
    if (defaultOption) {
        defaultOption.remove(); // Esto elimina el option "Selecciona un nivel"
    }

    // Comprobar si hay un nivel educativo seleccionado
    if (nivelEducativoId) {
        // Crear el objeto XMLHttpRequest
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "php/obtener_grados.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Llenar el select de grados con la respuesta del servidor
                selectGrado.innerHTML = xhr.responseText;
            }
        };

        // Enviar la petición con el ID del nivel educativo
        xhr.send("nivelEducativoId=" + nivelEducativoId);
    }
}

function eliminarOpcionGrado() {
    const selectGrado = document.getElementById("grado");
    const defaultOption = selectGrado.querySelector("option[value='']");
    
    // Eliminar la opción por defecto "Selecciona un grado"
    if (defaultOption) {
        defaultOption.remove();
    }
}

function cargarCiclos() {
    const gradoId = document.getElementById("grado").value;  // Obtener el ID del grado seleccionado
    const cicloSelect = document.getElementById("ciclo-escolar"); // Seleccionar el elemento <select> de ciclos

    // Limpiar las opciones previas
    cicloSelect.innerHTML = "<option value=''>Selecciona un ciclo</option>";

    if (gradoId) {
        // Hacer la petición AJAX
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "php/obtener_ciclos.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Llenar el select de ciclos con la respuesta del servidor
                cicloSelect.innerHTML += xhr.responseText;
            }
        };

        // Enviar la petición con el ID del grado
        xhr.send("gradoId=" + gradoId);
    }
}

function eliminarOpcionCiclo() {
    const cicloSelect = document.getElementById("ciclo-escolar");
    const defaultOption = cicloSelect.querySelector("option[value='']");
    
    // Eliminar la opción por defecto "Selecciona un ciclo"
    if (defaultOption) {
        defaultOption.remove();
    }
}

function mostrarAlumnos() {
    const nivelEducativoId = document.getElementById("nivel-educativo").value;
    const gradoId = document.getElementById("grado").value;
    const cicloId = document.getElementById("ciclo-escolar").value;

    // Seleccionar el tbody de la tabla
    const tbody = document.querySelector("tbody");
    tbody.innerHTML = ""; // Limpiar el tbody antes de mostrar nuevos registros

    if (nivelEducativoId && gradoId && cicloId) {
        // Crear el objeto XMLHttpRequest
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "php/obtener_alumnos.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Obtener la respuesta del servidor
                const alumnos = JSON.parse(xhr.responseText);
                
                // Llenar el tbody con los registros de alumnos
                alumnos.forEach(alumno => {
                    const row = `<tr>
                                    <td>${alumno.nombre}</td>
                                    <td>${alumno.matricula}</td>
                                    <td>
                                        <button class="delete-btn">Eliminar</button>
                                        <button class="update-btn">Actualizar</button>
                                    </td>
                                </tr>`;
                    tbody.innerHTML += row;
                });
            }
        };

        // Enviar la petición con los IDs seleccionados
        xhr.send(`nivelEducativoId=${nivelEducativoId}&gradoId=${gradoId}&cicloId=${cicloId}`);
    } else {
        alert("Por favor, selecciona un nivel educativo, grado y ciclo escolar.");
    }
}
