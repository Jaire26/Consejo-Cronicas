document.addEventListener("DOMContentLoaded", function() {
    // Ahora busca directamente las etiquetas de imagen con la clase
    const imagenes = document.querySelectorAll(".evento-foto-clic");
    const visor = document.getElementById("viewer");
    const imagenVisor = document.getElementById("viewer-img");
    const botonCerrar = document.getElementById("close-viewer");

    // Detectar automáticamente si estás en la carpeta admin o en la raíz pública
    const esAdmin = window.location.pathname.includes("admin");
    const rutaBase = esAdmin ? "../img/" : "img/";

    imagenes.forEach(img => {
        img.addEventListener("click", function() {
            const nombreImagen = this.getAttribute("data-src");
            
            // Cambia la imagen del visor y lo despliega
            imagenVisor.src = rutaBase + nombreImagen;
            visor.style.display = "flex";
            document.body.style.overflow = "hidden"; // Quita el scroll de la web atrás
        });
    });

    // Función para cerrar el visor
    function cerrar() {
        visor.style.display = "none";
        document.body.style.overflow = "auto"; // Devuelve el scroll
    }

    if(botonCerrar) botonCerrar.addEventListener("click", cerrar);
    
    if(visor) {
        visor.addEventListener("click", function(e) {
            if (e.target === visor) {
                cerrar(); // Cerrar si hacen clic al fondo negro
            }
        });
    }
});