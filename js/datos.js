async function filtrarDatos() {
    const selectElement = document.getElementById("dato");
    const datoSeleccionado = selectElement.value;
    const section = document.getElementById("filter-section");

    if (datoSeleccionado === "") {
        Swal.fire({
            title: 'Dato incorrecto',
            text: 'Por favor, seleccione un dato válido.',
            icon: 'warning',
            confirmButtonText: 'Aceptar'
        });
        return;
    }

    limpiarSelect("dato");
    
    section.innerHTML = "";

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
        const municipios = await fetchData("php/datos/obtener_municipios.php", params);
        if (datos && municipios) {
            cargarColonias(datos, section, municipios);
        }
    } else {
        datos = await fetchData("php/datos/obtener_datos.php", params);
        if (datos) {
            cargarDatos(datos, section);
        }
    }
}

function cargarColonias(datos, container, municipios) {
    const datoSeleccionado = document.getElementById("dato").value;

    const selectElement = document.getElementById("dato");
    const textoSeleccionado = selectElement.selectedOptions[0].textContent;

    container.innerHTML = '';

    datos.forEach((dato, index) => {
        const card = document.createElement('div');
        card.classList.add('card');
        card.style.animationDelay = `${index * 0.1}s`;

        const municipioOptions = municipios.map(municipio => `
            <option value="${municipio.id}" ${municipio.id === dato.municipio_id ? 'selected' : ''}>
                ${municipio.descripcion}
            </option>
        `).join('');

        card.innerHTML = `
            <div class="icon">
                <img src="img/info.png" alt="Icono de información">
            </div>
            <div class="content">
                <h3>${dato.colonia}</h3>
                <p>Municipio: ${dato.municipio}</p>
                <div class="links">
                    <button class="delete-btn" data-id="${dato.id}">Eliminar</button>
                    <button class="update-btn" data-id="${dato.id}">Actualizar</button>
                </div>
            </div>
            <div class="update-form hidden">
                <form action="php/datos/acciones/actualizar_dato.php" method="POST">
                    <input type="hidden" name="tipo" value="${datoSeleccionado}" required>
                    <input type="hidden" name="id" value="${dato.id}" required>
                    <div class="form-group">
                        <div class="content2">
                            <h3>${dato.colonia}</h3>
                            <button class="action" type="button">X</button>
                        </div>
                        <div class="form-group2">
                            <label for="descripcion">${textoSeleccionado}</label>
                            <input type="text" id="descripcion" name="descripcion" value="${dato.colonia}" required>
                        </div>
                        <div class="form-group2">
                            <label for="municipio">Municipio</label>
                            <select id="municipio-${dato.id}" name="municipio" required>
                                ${municipioOptions}
                            </select>
                        </div>
                        <button type="submit">Actualizar</button>
                    </div>
                </form>
            </div>
        `;

        container.appendChild(card);
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', eliminarDato);
    });

    document.querySelectorAll('.update-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            const card = event.target.closest('.card');
            const content = card.querySelector('.content');
            const updateForm = card.querySelector('.update-form');
            content.classList.add('hidden');
            updateForm.classList.remove('hidden');
            card.classList.add('modal');
        });
    });

    document.querySelectorAll('.action').forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const card = event.target.closest('.card');
            const content = card.querySelector('.content');
            const updateForm = card.querySelector('.update-form');
            content.classList.remove('hidden');
            updateForm.classList.add('hidden');
            card.classList.remove('modal');
        });
    });
}

function cargarDatos(datos, container) {
    const datoSeleccionado = document.getElementById("dato").value;

    const selectElement = document.getElementById("dato");
    const textoSeleccionado = selectElement.selectedOptions[0].textContent;

    container.innerHTML = '';

    datos.forEach((dato, index) => {
        const card = document.createElement('div');
        card.classList.add('card');
        card.style.animationDelay = `${index * 0.1}s`;

        card.innerHTML = `
            <div class="icon">
                <img src="img/info.png" alt="Icono de información">
            </div>
            <div class="content">
                <h3>${dato.descripcion}</h3>
                <p></p>
                <div class="links">
                    <button class="delete-btn" data-id="${dato.id}">Eliminar</button>
                    <button class="update-btn" data-id="${dato.id}" data-descripcion="${dato.descripcion}">Actualizar</button>
                </div>
            </div>
            <div class="update-form hidden">
                <form action="php/datos/acciones/actualizar_dato.php" method="POST">
                <input type="hidden" name="tipo" value="${datoSeleccionado}" required>
                <input type="hidden" name="id" value="${dato.id}" required>
                <div class="form-group">
                    <div class="content2">
                        <h3>${dato.descripcion}</h3>
                        <button class="action" type="button">X</button>
                    </div>
                        <div>
                            <label for="descripcion">${textoSeleccionado}</label>
                            <input type="text" id="descripcion" name="descripcion" placeholder="Nuevo dato" required>
                            </div>
                        <button type="submit">Actualizar</button>
                    </div>
                </form>
            </div>
        `;

        container.appendChild(card);
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', eliminarDato);
    });

    document.querySelectorAll('.update-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            const card = event.target.closest('.card');
            const content = card.querySelector('.content');
            const updateForm = card.querySelector('.update-form');
            content.classList.add('hidden');
            updateForm.classList.remove('hidden');
            card.classList.add('modal');
        });
    });

    document.querySelectorAll('.action').forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const card = event.target.closest('.card');
            const content = card.querySelector('.content');
            const updateForm = card.querySelector('.update-form');
            content.classList.remove('hidden');
            updateForm.classList.add('hidden');
            card.classList.remove('modal');
        });
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
                const selectElement = document.getElementById("dato");
                const textoSeleccionado = selectElement.selectedOptions[0].textContent;
                Swal.fire({
                    title: '¡Eliminación exitosa!',
                    text: `${textoSeleccionado} eliminado con éxito.`,
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
