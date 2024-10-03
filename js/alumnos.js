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

function eliminarOpcion() {
    const selectGrado = document.getElementById("grado");
    const defaultOption = selectGrado.querySelector("option[value='']");
    
    // Eliminar la opción por defecto "Selecciona un grado"
    if (defaultOption) {
        defaultOption.remove();
    }
}

