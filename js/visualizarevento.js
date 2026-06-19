document.addEventListener("DOMContentLoaded", function() {
    const tarjetas = document.querySelectorAll(".evento-foto-clic");
    const visor = document.getElementById("viewer");
    const imagenVisor = document.getElementById("viewer-img");
    const botonCerrar = document.getElementById("close-viewer");

    // Detectar si estás en la carpeta admin o en la raíz pública de forma automática
    const esAdmin = window.location.pathname.includes("admin");
    const rutaBase = esAdmin ? "../img/" : "img/";

    tarjetas.forEach(tarjeta => {
        tarjeta.addEventListener("click", function() {
            const nombreImagen = this.getAttribute("data-src");
            
            // Asigna la ruta correcta y muestra el visor flotante
            imagenVisor.src = rutaBase + nombreImagen;
            visor.style.display = "flex";
            document.body.style.overflow = "hidden"; // Bloquea el scroll de fondo
        });
    });

    // Función para cerrar el visor
    function cerrar() {
        visor.style.display = "none";
        document.body.style.overflow = "auto"; // Devuelve el scroll normal
    }

    if(botonCerrar) botonCerrar.addEventListener("click", cerrar);
    
    if(visor) {
        visor.addEventListener("click", function(e) {
            if (e.target === viewer) {
                cerrar(); // Cierra si haces clic en el fondo negro
            }
        });
    }
});