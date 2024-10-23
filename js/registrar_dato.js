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
                        <form action="php/datos/acciones/registrar_dato.php" method="POST">
                            <input type="hidden" name="tipo" value="1">    
                            <div class="form-group">
                                <label for="estado">Estado nuevo</label>
                                <input type="text" name="estado" placeholder="Estado a crear">
                            </div>
                            <button type="submit">Registrar estado</button>
                        </form>
                    `;
                    break;
                case 'colonia':
                    formularioContainer2.innerHTML = `
                        <h2>Dato a crear</h2>
                        <form action="php/datos/acciones/registrar_dato.php" method="POST">
                            <input type="hidden" name="tipo" value="2">    
                            <div class="form-group">
                                <label for="colonia">Colonia nueva</label>
                                <input type="text" name="colonia" placeholder="Colonia a crear">
                            </div>
                            <div class="form-group">
                                <label for="municipio">Municipio al que pertenece</label>
                                <select name="municipio" id="municipio">
                                    <option value="">Selecciona un municipio</option>
                                    <?php obtenerMunicipios($pdo); ?>
                                </select>
                            </div>
                            <button type="submit">Registrar estado</button>
                        </form>
                    `;

                    cargarMunicipios();
                    break;
                case 'municipio':
                    formularioContainer2.innerHTML = `
                        <h2>Dato a crear</h2>
                        <form action="php/datos/acciones/registrar_dato.php" method="POST">
                            <input type="hidden" name="tipo" value="3">
                            <div class="form-group">
                                <label for="municipio">Municipio nuevo</label>
                                <input type="text" name="municipio" placeholder="Municipio a crear">
                            </div>
                            <button type="submit">Registrar Municipio</button>
                        </form>
                    `;
                    break;
                case 'nivel':
                    formularioContainer2.innerHTML = `
                        <h2>Dato a crear</h2>
                        <form action="php/datos/acciones/registrar_dato.php" method="POST">
                            <input type="hidden" name="tipo" value="4">
                            <div class="form-group">
                                <label for="nivel">Nivel educativo nuevo</label>
                                <input type="text" name="nivel" placeholder="Nivel educativo a crear">
                            </div>
                            <button type="submit">Registrar nivel educativo</button>
                        </form>
                    `;
                    break;
                case 'grado':
                    formularioContainer2.innerHTML = `
                        <h2>Dato a crear</h2>
                        <form action="php/datos/acciones/registrar_dato.php" method="POST">
                            <input type="hidden" name="tipo" value="5">    
                            <div class="form-group">
                                <label for="grado">Grado nuevo</label>
                                <input type="text" name="grado" placeholder="Grado a crear">
                            </div>
                            <div class="form-group">
                                <label for="nivel2">Nivel escolar al que pertenece</label>
                                <select name="nivel2" id="nivel2">
                                    <option value="">Selecciona un nivel escolar</option>
                                    <?php obtenerNiveles($pdo); ?>
                                </select>
                            </div>
                            <button type="submit">Registrar estado</button>
                        </form>
                    `;

                    cargarNiveles();
                    break;
                case 'ciclo':
                    formularioContainer2.innerHTML = `
                        <h2>Dato a crear</h2>
                        <form action="php/datos/acciones/registrar_dato.php" method="POST">
                            <input type="hidden" name="tipo" value="6">
                            <div class="form-group">
                                <label for="ciclo">Ciclo escolar nuevo</label>
                                <input type="text" name="ciclo" placeholder="Ciclo escolar a crear">
                            </div>
                            <button type="submit">Registrar ciclo escolar</button>
                        </form>
                    `;
                    break;
                case 'promocion':
                    formularioContainer2.innerHTML = `
                        <h2>Dato a crear</h2>
                        <form action="php/datos/acciones/registrar_dato.php" method="POST">
                            <input type="hidden" name="tipo" value="7">
                            <div class="form-group">
                                <label for="promocion">Promoción nueva</label>
                                <input type="text" name="promocion" placeholder="Promoción a crear">
                            </div>
                            <button type="submit">Registrar promoción</button>
                        </form>
                    `;
                    break;
                case 'medio':
                    formularioContainer2.innerHTML = `
                        <h2>Dato a crear</h2>
                        <form action="php/datos/acciones/registrar_dato.php" method="POST">
                            <input type="hidden" name="tipo" value="8">
                            <div class="form-group">
                                <label for="medio">Medio de enterado nuevo</label>
                                <input type="text" name="medio" placeholder="Medio a crear">
                            </div>
                            <button type="submit">Registrar medio</button>
                        </form>
                    `;
                    break;
                case 'genero':
                        formularioContainer2.innerHTML = `
                            <h2>Dato a crear</h2>
                            <form action="php/datos/acciones/registrar_dato.php" method="POST">
                                <input type="hidden" name="tipo" value="9">
                                <div class="form-group">
                                    <label for="genero">Género nuevo</label>
                                    <input type="text" name="genero" placeholder="Género a crear">
                                </div>
                                <button type="submit">Registrar género</button>
                            </form>
                        `;
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
            const selectMunicipio = document.getElementById('municipio');
            selectMunicipio.innerHTML = '';
            if (data.error) {
                selectMunicipio.innerHTML = `<option value="">Error cargando municipios</option>`;
            } else {
                data.forEach(municipio => {
                    const option = document.createElement('option');
                    option.value = municipio.id;
                    option.textContent = municipio.descripcion;
                    selectMunicipio.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error al cargar los municipios:', error);
            const selectMunicipio = document.getElementById('municipio');
            selectMunicipio.innerHTML = `<option value="">Error al cargar municipios</option>`;
        });
}

function cargarNiveles() {
    fetch('php/datos/obtener_niveles.php')
        .then(response => response.json())
        .then(data => {
            const selectNivel = document.getElementById('nivel2');
            selectNivel.innerHTML = '';
            if (data.error) {
                selectNivel.innerHTML = `<option value="">Error cargando niveles educativos</option>`;
            } else {
                data.forEach(nivel => {
                    const option = document.createElement('option');
                    option.value = nivel.id;
                    option.textContent = nivel.descripcion;
                    selectNivel.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error al cargar los municipios:', error);
            const selectNivel = document.getElementById('nivel2');
            selectNivel.innerHTML = `<option value="">Error al cargar municipios</option>`;
        });
}