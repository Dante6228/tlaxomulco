function actualizarFormulario() {
    const radios = document.querySelectorAll('input[name="opcion"]');
    let formularioContainer2 = document.querySelector('.container2');

    radios.forEach((radio) => {
        radio.addEventListener('change', function() {
            let valorSeleccionado = this.value;

            switch (valorSeleccionado) {
                case 'estado':
                    formularioContainer2.innerHTML = `
                        <h2>Dato a crear</h2>
                        <form id="form-estado" action="php/datos/acciones/registrar_dato.php" method="POST">
                            <input type="hidden" name="tipo" value="1">    
                            <div class="form-group">
                                <label for="estado">Estado nuevo</label>
                                <input type="text" name="estado" placeholder="Estado a crear">
                            </div>
                            <div>
                                <p id="error-estado" class="mensaje-error" style="color: red; font-size: 12px; display: none;">
                            </div>
                            <button type="submit">Registrar estado</button>
                        </form>
                    `;
                    agregarValidacion('form-estado', ['estado']);
                    break;
                case 'colonia':
                    formularioContainer2.innerHTML = `
                        <h2>Dato a crear</h2>
                        <form id="form-colonia" action="php/datos/acciones/registrar_dato.php" method="POST">
                            <input type="hidden" name="tipo" value="2">    
                            <div class="form-group">
                                <label for="colonia">Colonia nueva</label>
                                <input type="text" name="colonia" placeholder="Colonia a crear">
                            </div>
                            <div>
                                <p id="error-colonia" class="mensaje-error" style="color: red; font-size: 12px; display: none;">
                            </div>
                            <div class="form-group">
                                <label for="municipio2">Municipio al que pertenece</label>
                                <select name="municipio2" id="municipio2">
                                    <option value="">Selecciona un municipio</option>
                                </select>
                            </div>
                            <button type="submit">Registrar estado</button>
                        </form>
                    `;

                    cargarMunicipios();

                    agregarValidacion('form-colonia', ['colonia']);
                    break;
                case 'municipio':
                    formularioContainer2.innerHTML = `
                        <h2>Dato a crear</h2>
                        <form id="form-municipio" action="php/datos/acciones/registrar_dato.php" method="POST">
                            <input type="hidden" name="tipo" value="3">
                            <div class="form-group">
                                <label for="municipio3">Municipio nuevo</label>
                                <input type="text" name="municipio3" placeholder="Municipio a crear">
                            </div>
                            <div>
                                <p id="error-municipio3" class="mensaje-error" style="color: red; font-size: 12px; display: none;">
                            </div>
                            <button type="submit">Registrar Municipio</button>
                        </form>
                    `;

                    agregarValidacion('form-municipio', ['municipio3']);
                    break;
                case 'ciclo':
                    formularioContainer2.innerHTML = `
                        <h2>Dato a crear</h2>
                        <form id="form-ciclo" action="php/datos/acciones/registrar_dato.php" method="POST">
                            <input type="hidden" name="tipo" value="4">
                            <div class="form-group">
                                <label for="ciclo">Ciclo escolar nuevo</label>
                                <input type="text" name="ciclo" placeholder="2022-2023">
                            </div>
                            <div>
                                <p id="error-ciclo" class="mensaje-error" style="color: red; font-size: 12px; display: none;">
                            </div>
                            <button type="submit">Registrar ciclo escolar</button>
                        </form>
                    `;

                    agregarValidacion('form-ciclo', ['ciclo']);
                    break;
                case 'promocion':
                    formularioContainer2.innerHTML = `
                        <h2>Dato a crear</h2>
                        <form id="form-promocion" action="php/datos/acciones/registrar_dato.php" method="POST">
                            <input type="hidden" name="tipo" value="5">
                            <div class="form-group">
                                <label for="promocion">Promoción nueva</label>
                                <input type="text" name="promocion" placeholder="Promoción a crear">
                            </div>
                            <div>
                                <p id="error-promocion" class="mensaje-error" style="color: red; font-size: 12px; display: none;">
                            </div>
                            <button type="submit">Registrar promoción</button>
                        </form>
                    `;

                    agregarValidacion('form-promocion', ['promocion']);
                    break;
                case 'medio':
                    formularioContainer2.innerHTML = `
                        <h2>Dato a crear</h2>
                        <form id="form-medio" action="php/datos/acciones/registrar_dato.php" method="POST">
                            <input type="hidden" name="tipo" value="6">
                            <div class="form-group">
                                <label for="medio">Medio de enterado nuevo</label>
                                <input type="text" name="medio" placeholder="Medio a crear">
                            </div>
                            <div>
                                <p id="error-medio" class="mensaje-error" style="color: red; font-size: 12px; display: none;">
                            </div>
                            <button type="submit">Registrar medio</button>
                        </form>
                    `;

                    agregarValidacion('form-medio', ['medio']);
                    break;
                case 'genero':
                        formularioContainer2.innerHTML = `
                            <h2>Dato a crear</h2>
                            <form id="form-genero" action="php/datos/acciones/registrar_dato.php" method="POST">
                                <input type="hidden" name="tipo" value="7">
                                <div class="form-group">
                                    <label for="genero">Género nuevo</label>
                                    <input type="text" name="genero" placeholder="Género a crear">
                                </div>
                                <div>
                                    <p id="error-genero" class="mensaje-error" style="color: red; font-size: 12px; display: none;">
                                </div>
                                <button type="submit">Registrar género</button>
                            </form>
                        `;

                        agregarValidacion('form-genero', ['genero']);
                        break;
                default:
                    formularioContainer2.innerHTML = `
                        <strong>Selecciona alguna opción</strong>
                    `;
                    break;
            }
        });
    });
}

function cargarMunicipios() {
    fetch('php/datos/obtener_municipios.php')
        .then(response => response.json())
        .then(data => {
            console.log(data); // Agregado para depurar
            const selectMunicipio = document.getElementById('municipio2');
            console.log(selectMunicipio);
            selectMunicipio.innerHTML = '';
            data.forEach(municipio => {
                const option = document.createElement('option');
                option.value = municipio.id;
                option.textContent = municipio.descripcion;
                selectMunicipio.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error al cargar los municipios:', error);
            const selectMunicipio = document.getElementById('municipio2');
            selectMunicipio.innerHTML = `<option value="">Error al cargar municipios</option>`;
        });
}

function agregarValidacion(formId, campos) {
    const formulario = document.getElementById(formId);

    formulario.addEventListener('submit', (event) => {
        let valid = true;

        event.preventDefault();

        campos.forEach((campoId) => {
            const campo = formulario.querySelector(`[name="${campoId}"]`);
            const mensajeError = formulario.querySelector(`#error-${campoId}`);

            if (mensajeError) {
                mensajeError.style.display = 'none';
            }

            // Validar que el campo no esté vacío
            if (!campo.value.trim()) {
                valid = false;
                campo.style.borderColor = 'red';

                if (mensajeError) {
                    mensajeError.textContent = 'Este campo no puede estar vacío';
                    mensajeError.style.display = 'block';
                }

                campo.addEventListener('input', () => {
                    campo.style.borderColor = '';
                    if (mensajeError) mensajeError.style.display = 'none';
                });
            } else {
                campo.style.borderColor = '';
                if (mensajeError) mensajeError.style.display = 'none';
            }

            // Validar que solo acepte números en el campo "ciclo"
            if (campoId === 'ciclo' && !/^\d{4}-\d{4}$/.test(campo.value.trim())) {
                valid = false;
                campo.style.borderColor = 'red';

                if (mensajeError) {
                    mensajeError.textContent = 'El ciclo debe tener el formato YYYY-YYYY';
                    mensajeError.style.display = 'block';
                }

                campo.addEventListener('input', () => {
                    campo.style.borderColor = '';
                    if (mensajeError) mensajeError.style.display = 'none';
                });
            }
        });

        if (valid) {
            formulario.submit();
        }
    });
}

