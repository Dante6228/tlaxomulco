document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");
    const fileInput = document.getElementById('excelFile');

    form.addEventListener("submit", async (e) => {
        // Verifica si se ha seleccionado un archivo
        if (!fileInput.files.length) {
            alert('Por favor, selecciona un archivo de Excel.');
            e.preventDefault();  // Detiene el envío del formulario
        }
    });
});