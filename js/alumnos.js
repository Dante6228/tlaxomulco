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
    let nivelEducativoId = document.getElementById("nivel-educativo").value;
    cargarOpciones('php/obtener_grados.php', `nivelEducativoId=${nivelEducativoId}`, "grado");
    limpiarSelect('nivel-educativo');
}

function cargarCiclos() {
    let gradoId = document.getElementById("grado").value;
    cargarOpciones('php/obtener_ciclos.php', `gradoId=${gradoId}`, "ciclo-escolar");
    limpiarSelect('grado');
}

function limpiarSelect(id) {
    const select = document.getElementById(id);
    const option = select.querySelector("option[value='']");
    if (option) {
        option.disabled = true;
    }
}

async function mostrarAlumnos() {
    const nivelEducativoId = document.getElementById("nivel-educativo").value;
    const gradoId = document.getElementById("grado").value;
    const cicloId = document.getElementById("ciclo-escolar").value;

    const tbody = document.querySelector("tbody");
    tbody.innerHTML = "";

    if (nivelEducativoId && gradoId && cicloId) {
        const params = new URLSearchParams({
            nivelEducativoId: nivelEducativoId,
            gradoId: gradoId,
            cicloId: cicloId
        });

        try {
            const response = await fetch("php/obtener_alumnos.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: params
            });

            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }

            const alumnos = await response.json();
            cargarDatosAlumnos(alumnos, tbody);
        } catch (error) {
            console.error('Error:', error);
        }
    } else {
        alert("Por favor, selecciona un nivel educativo, grado y ciclo escolar.");
    }
}

function cargarDatosAlumnos(alumnos, tbody) {
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

