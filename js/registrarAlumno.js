function cargarGrados() {
    // Obtener el ID del nivel educativo seleccionado
    let nivelEducativoId = document.getElementById("nivel_escolar").value;

    // Seleccionar el elemento <select> de "Grado" y limpiar sus opciones
    const selectGrado = document.getElementById("grado");
    selectGrado.innerHTML = "";

    // Eliminar el option por defecto en el nivel educativo
    const selectNivel = document.getElementById("nivel_escolar");
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

function cargarColonias() {
    // Obtener el ID del municipio
    let municipio = document.getElementById("municipio").value;

    // Seleccionar el elemento <select> de "Colonia" y limpiar sus opciones
    const selectColonia = document.getElementById("colonia");
    selectColonia.innerHTML = "";

    // Eliminar el option por defecto en el municipio
    const selectMunicipio = document.getElementById("municipio");
    const defaultOption = selectMunicipio.querySelector("option[value='']");
    if (defaultOption) {
        defaultOption.remove();
    }

    // Comprobar si hay un municipio seleccionado
    if (municipio) {
        // Crear el objeto XMLHttpRequest
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "php/obtener_colonias.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Llenar el select de grados con la respuesta del servidor
                selectColonia.innerHTML = xhr.responseText;
            }
        };

        // Enviar la petición con el ID del nivel educativo
        xhr.send("municipio=" + municipio);
    }
}