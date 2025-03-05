document.addEventListener("DOMContentLoaded", () => {
    const toggleThemeBtn = document.getElementById("toggleTheme");
    const body = document.documentElement;

    // Aplicar el tema guardado en localStorage
    if (localStorage.getItem("theme") === "dark") {
        body.classList.add("dark-mode");
        if (toggleThemeBtn) toggleThemeBtn.textContent = "☀️";
    }

    // Cambiar el tema cuando se hace clic en el botón
    if (toggleThemeBtn) {
        toggleThemeBtn.addEventListener("click", () => {
            if (body.classList.contains("dark-mode")) {
                body.classList.remove("dark-mode");
                localStorage.setItem("theme", "light");
                toggleThemeBtn.textContent = "🌙";
            } else {
                body.classList.add("dark-mode");
                localStorage.setItem("theme", "dark");
                toggleThemeBtn.textContent = "☀️";
            }
        });
    }
});
