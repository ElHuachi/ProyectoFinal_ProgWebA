// Función para cambiar entre temas claro y oscuro
function toggleTheme() {
    const body = document.body;

    // Si el cuerpo tiene la clase dark-theme, cambia a light-theme, y viceversa
    if (body.classList.contains("dark-theme")) {
        body.classList.remove("dark-theme");
        body.classList.add("light-theme");
    } else {
        body.classList.remove("light-theme");
        body.classList.add("dark-theme");
    }
}

// Escuchar el clic en el botón y cambiar el tema
const themeToggle = document.getElementById("theme-toggle");
themeToggle.addEventListener("click", toggleTheme);
