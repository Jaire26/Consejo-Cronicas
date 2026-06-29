document.addEventListener("DOMContentLoaded", function () {

    const input = document.getElementById("inputBusqueda");

    if (!input) return;

    input.addEventListener("keyup", function () {

        const filtro = this.value.toLowerCase().trim();

        // Todos los tipos de tarjetas del sistema
        const tarjetas = document.querySelectorAll(`
            .opcion-card,
            .feed-card,
            .tarjeta-admin,
            .tarjeta-entrevista,
            .card:not(.admin-card),
            .gallery-item-container
        `);

        const contenedor =
            document.querySelector(".opciones-grid") ||
            document.querySelector(".feed-container") ||
            document.querySelector(".noticias") ||
            document.querySelector(".gallery") ||
            document.querySelector(".cards") ||
            document.querySelector(".feed-grid");

        // Eliminar mensaje anterior
        const anterior = document.getElementById("sin-resultados-busqueda");
        if (anterior) anterior.remove();

        let encontrados = 0;

        tarjetas.forEach(function (tarjeta) {

            let titulo = "";

            const h2 = tarjeta.querySelector("h2");
            const h3 = tarjeta.querySelector("h3");

            if (h2) {
                titulo = h2.textContent.toLowerCase();
            } else if (h3) {
                titulo = h3.textContent.toLowerCase();
            }

            if (titulo.includes(filtro) || filtro === "") {

                if (tarjeta.classList.contains("opcion-card")) {
                    tarjeta.style.display = "block";
                } else {
                    tarjeta.style.display = "";
                }

                encontrados++;

            } else {

                tarjeta.style.display = "none";

            }

        });

        if (encontrados === 0 && filtro !== "" && contenedor) {

            const mensaje = document.createElement("p");

            mensaje.id = "sin-resultados-busqueda";
            mensaje.textContent = "No se encontraron resultados para tu búsqueda.";

            mensaje.style.textAlign = "center";
            mensaje.style.width = "100%";
            mensaje.style.padding = "25px";
            mensaje.style.color = "#7C3F20";
            mensaje.style.fontWeight = "600";

            contenedor.appendChild(mensaje);

        }

    });

});