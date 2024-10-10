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
    cargarOpciones('php/obtener_grados.php', `nivelEducativoId=${nivelEducativoId}`, "grado");
    limpiarSelect('nivel_escolar');
}


function cargarColonias() {
    let municipio = document.getElementById("municipio").value;
    cargarOpciones('php/obtener_colonias.php', `municipio=${municipio}`, "colonia");
    limpiarSelect('municipio')
}

function limpiarSelect(id) {
    const select = document.getElementById(id);
    const option = select.querySelector("option[value='']");
    if (option) {
        option.disabled = true;
    }
}
