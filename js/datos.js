async function filtrarDatos() {
    const datoSeleccionado = document.getElementById("dato").value;
    const tbody = document.getElementById("dataRows");

    if (datoSeleccionado === "") {
        Swal.fire({
            title: 'Dato incorrecto',
            text: 'Por favor, seleccione un dato válido.',
            icon: 'warning',
            confirmButtonText: 'Aceptar'
        });
    }

    limpiarSelect("dato");
    
    tbody.innerHTML = "";

    const fetchData = async (url, params) => {
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: params.toString()
            });

            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }

            return await response.json();
        } catch (error) {
            console.error('Error:', error);
            return null;
        }
    };

    const params = new URLSearchParams({ dato: datoSeleccionado });

    let datos = null;

    if (datoSeleccionado === "colonia") {
        datos = await fetchData("php/datos/obtener_colonias_datos.php", params);
        if (datos) {
            cargarColonias(datos, tbody);
        }
    } else {
        datos = await fetchData("php/datos/obtener_datos.php", params);
        if (datos) {
            cargarDatos(datos, tbody);
        }
    }
}

function cargarColonias(datos, tbody) {
    tbody.innerHTML = '';

    const thead = tbody.closest('table').querySelector('thead');
    thead.innerHTML = '';

    let headers = '<tr>';
    headers += `
    <th>Colonia</th>
    <th>Municipio</th>
    <th>Acciones</th>`;
    headers += '</tr>';
    thead.innerHTML = headers;

    datos.forEach(dato => {
        const row = document.createElement('tr');
        row.classList.add('animar');
        row.innerHTML = `
            <td>${dato.colonia}</td>
            <td>${dato.municipio}</td>
            <td>
                <button class="delete-btn" data-id="${dato.id}">Eliminar</button>
                <button class="update-btn" data-id="${dato.id}">Actualizar</button>
            </td>
        `;
        tbody.appendChild(row);
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', eliminarDato);
    });

    document.querySelectorAll('.update-btn').forEach(button => {
        button.addEventListener('click', actualizarDato);
    });
}

function cargarDatos(datos, tbody) {
    tbody.innerHTML = '';

    const thead = tbody.closest('table').querySelector('thead');
    thead.innerHTML = '';

    let headers = '<tr>';
    headers += `
    <th>Dato</th>
    <th>Acciones</th>`;
    headers += '</tr>';
    thead.innerHTML = headers;

    datos.forEach(dato => {
        const row = document.createElement('tr');
        row.classList.add('animar');
        row.innerHTML = `
            <td>${dato.descripcion}</td>
            <td>
                <button class="delete-btn" data-id="${dato.id}">Eliminar</button>
                <button class="update-btn" data-id="${dato.id}">Actualizar</button>
            </td>
        `;
        tbody.appendChild(row);
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', eliminarDato);
    });

    document.querySelectorAll('.update-btn').forEach(button => {
        button.addEventListener('click', actualizarDato);
    });
}

function limpiarSelect(id) {
    const select = document.getElementById(id);
    const option = select.querySelector("option[value='']");
    if (option) {
        option.disabled = true;
    }
}

async function eliminarDato(event) {
    const datoSeleccionado = document.getElementById("dato").value;
    const id = event.target.getAttribute('data-id');
    const result = await Swal.fire({
        title: 'ADVERTENCIA',
        text: '¿Estás seguro de eliminar este dato?\nEl hacer tal acción eliminará TODOS los registros asociados a dicho dato, incluyendo alumnos registrados o algún dato de cualquier otro tipo.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    });
    
    if (result.isConfirmed) {
        try {
            const response = await fetch('php/datos/eliminar_dato.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}&dato=${datoSeleccionado}`
            });
    
            if (response.ok) {
                Swal.fire({
                    title: '¡Eliminación exitosa!',
                    text: `${datoSeleccionado} eliminado con éxito.`,
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
                filtrarDatos();
            } else {
                throw new Error(`Error al eliminar ${datoSeleccionado}`);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }    
}

async function actualizarDato(event) {
    const datoSeleccionado = document.getElementById("dato").value;
    const id = event.target.getAttribute('data-id');

    switch (datoSeleccionado) {
        case "medio_enterado":
            window.location.href = `datos/medio_enterado.php?id=${encodeURIComponent(id)}`;
            break;
        case "municipio":
            window.location.href = `datos/municipio.php?id=${encodeURIComponent(id)}`;
            break;
        case "colonia":
            window.location.href = `datos/colonia.php?id=${encodeURIComponent(id)}`;
            break;
        case "promocion":
            window.location.href = `datos/promocion.php?id=${encodeURIComponent(id)}`;
            break;
        case "ciclo":
            window.location.href = `datos/ciclo.php?id=${encodeURIComponent(id)}`;
            break;
        case "estado":
            window.location.href = `datos/estado.php?id=${encodeURIComponent(id)}`;
            break;
        case "genero":
            window.location.href = `datos/genero.php?id=${encodeURIComponent(id)}`;
                break;
        default:
            Swal.fire({
                title: 'Dato incorrecto',
                text: 'Por favor, seleccione un dato válido.',
                icon: 'warning',
                confirmButtonText: 'Aceptar'
            });
            break;
    }
}
