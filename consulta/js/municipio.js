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
    cargarOpciones('../php/alumnos/obtener_grados.php', `nivelEducativoId=${nivelEducativoId}`, "grado");
    limpiarSelect('nivel-educativo');
}

function cargarCiclos() {
    let gradoId = document.getElementById("grado").value;
    cargarOpciones('../php/alumnos/obtener_ciclos.php', `gradoId=${gradoId}`, "ciclo-escolar");
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
    const municipioId = document.getElementById("municipio").value;

    const tbody = document.querySelector("tbody");
    tbody.innerHTML = "";

    if (nivelEducativoId && gradoId && cicloId && municipioId) {
        const params = new URLSearchParams({
            nivelEducativoId: nivelEducativoId,
            gradoId: gradoId,
            cicloId: cicloId,
            municipioId: municipioId
        });

        try {
            const response = await fetch("../php/consulta/municipio.php", {
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
        Swal.fire({
            title: 'Faltan datos',
            text: 'Por favor, selecciona un nivel educativo, grado, ciclo escolar y colonia.',
            icon: 'warning',
            confirmButtonText: 'Aceptar'
        });
    }
}

function cargarDatosAlumnos(alumnos, tbody) {
    tbody.innerHTML = '';

    alumnos.forEach(alumno => {
        const row = `<tr>
                        <td>${alumno.nombre}</td>
                        <td>${alumno.Ap}</td>
                        <td>${alumno.Am}</td>
                        <td>${alumno.matricula}</td>
                        <td>${alumno.genero}</td>
                        <td>${alumno.municipio}</td>
                        <td>${alumno.colonia}</td>
                        <td>${alumno.medio_enterado}</td>
                        <td>${alumno.promocion}</td>
                        <td>${alumno.estado_alumno}</td>
                        <td style="display: none">${alumno.nivel_grado_ciclo_id}</td>
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
    const result = await Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esto eliminará al alumno de forma permanente.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    });
    
    if (result.isConfirmed) {
        try {
            const response = await fetch('../php/alumnos/eliminar_alumno.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${alumnoId}`
            });
    
            if (response.ok) {
                Swal.fire({
                    title: 'Alumno eliminado',
                    text: 'El alumno ha sido eliminado con éxito.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
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
    const alumnoId = encodeURIComponent(event.target.getAttribute('data-id'));
    window.location.href = `../actualizar_alumno.php?id=${alumnoId}&from=4`;
}

async function generarPDF() {
    const alumnos = [];
    const rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const alumno = {
            id: cells[11].querySelector('.update-btn').dataset.id,
            ngc: cells[10].innerText
        };
        alumnos.push(alumno);
    });

    if (alumnos.length === 0) {
        Swal.fire({
            title: 'Sin alumnos',
            text: 'No hay alumnos para generar el pdf.',
            icon: 'warning',
            confirmButtonText: 'Aceptar'
        });
        return;
    }

    const params = new URLSearchParams();
    params.append('alumnos', JSON.stringify(alumnos));

    try {
        const response = await fetch('../php/consulta/generar_pdf.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: params.toString()
        });

        if (!response.ok) {
            throw new Error('Error al generar el PDF');
        }

        // Descarga el PDF
        const blob = await response.blob();
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        const cicloSelect = document.getElementById('ciclo-escolar');
        const cicloTexto = cicloSelect.selectedOptions[0].text;
        a.download = `Listado_de_alumnos_por_municipio_de_alumno_${cicloTexto}.pdf`;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);

        window.location.href = '/tlaxomulco/consulta/municipio.php?mensaje=pdf';

    } catch (error) {
        console.error('Error:', error);
    }
}
