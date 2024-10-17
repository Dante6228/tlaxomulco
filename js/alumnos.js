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
    tbody.innerHTML = '';

    alumnos.forEach(alumno => {
        const row = `<tr>
                        <td>${alumno.nombre}</td>
                        <td>${alumno.Ap}</td> <!-- Apellido paterno -->
                        <td>${alumno.Am}</td> <!-- Apellido materno -->
                        <td>${alumno.matricula}</td>
                        <td>${alumno.genero}</td> <!-- Género -->
                        <td>${alumno.municipio}</td> <!-- Municipio -->
                        <td>${alumno.colonia}</td> <!-- Colonia -->
                        <td>${alumno.medio_enterado}</td> <!-- Medio enterado -->
                        <td>${alumno.promocion}</td> <!-- Promoción -->
                        <td>${alumno.estado_alumno}</td> <!-- Estado del alumno -->
                        <td style="display: none">${alumno.nivel_grado_ciclo_id}</td> <!-- nivel_grado_ciclo_id oculto -->
                        <td>
                            <button class="delete-btn" data-id="${alumno.id}">Eliminar</button>
                            <button class="update-btn" data-id="${alumno.id}">Actualizar</button>
                        </td>
                    </tr>`;
        tbody.innerHTML += row;
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', eliminarAlumno);
    });

    document.querySelectorAll('.update-btn').forEach(button => {
        button.addEventListener('click', actualizarAlumno);
    });
}

async function eliminarAlumno(event) {
    const alumnoId = event.target.getAttribute('data-id');
    const confirmDelete = confirm("¿Estás seguro de que deseas eliminar este alumno?");
    
    if (confirmDelete) {
        try {
            const response = await fetch('php/eliminar_alumno.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${alumnoId}`
            });

            if (response.ok) {
                alert('Alumno eliminado con éxito.');
                mostrarAlumnos();
            } else {
                throw new Error('Error al eliminar el alumno');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
}

async function actualizarAlumno(event) {
    const alumnoId = event.target.getAttribute('data-id');
    window.location.href = `actualizar_alumno.php?id=${alumnoId}`;
}

function generarPDF() {
    const alumnos = [];
    const rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const alumno = {
            id: cells[11].querySelector('.update-btn').dataset.id,
            nombre: cells[0].innerText,
            Ap: cells[1].innerText,
            Am: cells[2].innerText,
            matricula: cells[3].innerText,
            genero: cells[4].innerText,
            municipio: cells[5].innerText,
            colonia: cells[6].innerText,
            medio_enterado: cells[7].innerText,
            promocion: cells[8].innerText,
            estado_alumno: cells[9].innerText,
            ngc: cells[10].innerText
        };
        alumnos.push(alumno);
    });

    if (alumnos.length === 0) {
        alert("No hay alumnos para generar el PDF.");
        return;
    }

    const params = new URLSearchParams();
    params.append('alumnos', JSON.stringify(alumnos));
    window.location.href = 'php/generar_pdf.php?' + params.toString();
}
