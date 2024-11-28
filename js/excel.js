document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");
    const fileInput = document.getElementById('excelFile');

    form.addEventListener("submit", async (e) => {
        // Verifica si se ha seleccionado un archivo
        if (!fileInput.files.length) {
            Swal.fire({
                title: 'Archivo no seleccionado',
                text: 'Por favor, selecciona un archivo de Excel.',
                icon: 'warning',
                confirmButtonText: 'Aceptar'
            });            
            e.preventDefault();  // Detiene el envío del formulario
        }
    });
});