document.addEventListener("DOMContentLoaded", () => {
    const toggleThemeCheckbox = document.getElementById("toggleTheme");
    const body = document.documentElement;
    const themeLabel = document.getElementById("themeLabel");

    // Función para actualizar el texto
    function updateThemeLabel() {
        themeLabel.textContent = toggleThemeCheckbox.checked
            ? "Cambiar a modo claro"
            : "Cambiar a modo oscuro";
    }

    // Aplicar el tema guardado en localStorage
    if (localStorage.getItem("theme") === "dark") {
        body.classList.add("dark-mode");
        toggleThemeCheckbox.checked = true;
    }

    // Actualizar el texto del label al cargar
    updateThemeLabel();

    // Evento para cambiar el tema
    toggleThemeCheckbox.addEventListener("change", () => {
        if (toggleThemeCheckbox.checked) {
            body.classList.add("dark-mode");
            localStorage.setItem("theme", "dark");
        } else {
            body.classList.remove("dark-mode");
            localStorage.setItem("theme", "light");
        }

        // Actualizar el texto del label cuando cambia el tema
        updateThemeLabel();
    });
});
