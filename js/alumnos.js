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
    cargarOpciones('php/alumnos/obtener_grados.php', `nivelEducativoId=${nivelEducativoId}`, "grado");
    limpiarSelect('nivel-educativo');
}

function cargarCiclos() {
    let gradoId = document.getElementById("grado").value;
    cargarOpciones('php/alumnos/obtener_ciclos.php', `gradoId=${gradoId}`, "ciclo-escolar");
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
            const response = await fetch("php/alumnos/obtener_alumnos.php", {
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
            text: 'Por favor, selecciona un nivel educativo, grado y ciclo escolar.',
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
            const response = await fetch('php/alumnos/eliminar_alumno.php', {
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
    window.location.href = `actualizar_alumno.php?id=${alumnoId}&from=0`;
}

async function generarPDF() {
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
        const response = await fetch('php/alumnos/generar_pdf.php', {
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
        a.download = 'Listado_de_Alumnos.pdf';
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);

        window.location.href = 'alumnos.php?mensaje=pdf';

    } catch (error) {
        console.error('Error:', error);
    }
}

async function generarExcel() {
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
        Swal.fire({
            title: 'Sin alumnos',
            text: 'No hay alumnos para generar el excel.',
            icon: 'warning',
            confirmButtonText: 'Aceptar'
        });
        return;
    }

    const params = new URLSearchParams();
    params.append('alumnos', JSON.stringify(alumnos));

    try {
        const response = await fetch('php/excel/generar_excel.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: params.toString()
        });

        if (!response.ok) {
            throw new Error('Error al generar el excel');
        }

        // Descarga el excel
        const blob = await response.blob();
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = 'Listado_de_Alumnos.xlsx';
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);

        window.location.href = 'alumnos.php?mensaje=excel';

    } catch (error) {
        console.error('Error:', error);
    }
}

function mostrarInfo() {
    Swal.fire({
        title: "Información",
        html: `
            <p style="font-size: 16px; line-height: 1.6;">En esta sección de la aplicación web se cuentan con distintas funciones:</p><br>
            <ul style="text-align: left; font-size: 15px; line-height: 1.6;">
                <li><strong style="color: #3085d6;">📌 Registrar nuevo alumno:</strong> Permite registrar un nuevo alumno en la base de datos llenando un formulario.</li>
                <li><strong style="color: #3085d6;">📥 Importar archivo Excel:</strong> Permite importar un archivo Excel con los datos de los alumnos que se llenó previamente <strong>(Se recomienda usar el Excel generado por el botón 'Generar Excel de importación')</strong>.</li>
                <li><strong style="color: #3085d6;">📤 Generar Excel de importación:</strong> Descarga un archivo Excel con el formato necesario para importar alumnos, donde solo tendrá que colocar los datos necesarios y posteriormente importar el Excel.</li>
                <li><strong style="color: #3085d6;">🔍 Mostrar Alumnos:</strong> Muestra los alumnos que coinciden con los filtros seleccionados.</li>
                <li><strong style="color: #3085d6;">📄 Generar PDF:</strong> Descarga un archivo PDF con la lista de alumnos filtrados.</li>
                <li><strong style="color: #3085d6;">📊 Generar Excel:</strong> Descarga un archivo Excel con la lista de alumnos filtrados.</li>
            </ul>
        `,
        icon: "info",
        confirmButtonText: "Entendido",
        confirmButtonColor: "#3085d6",
        background: "#f4f7fb",
        width: "70%",
        padding: "20px",
        showConfirmButton: true
    });
}
