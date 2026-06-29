// Buscador Universal - Versión Definitiva Libre de Errores
document.getElementById('inputBusqueda').addEventListener('keyup', function() {
    let filtro = this.value.toLowerCase().trim();

    // Seleccionamos las tarjetas y las imágenes directas
    let tarjetas = document.querySelectorAll('.opcion-card, .card:not(.admin-card), [class*="-card"]:not(.admin-card), .tarjeta-entrevista:not(.admin-card), .gallery-item-container, .gallery img');

    let contenedorPadre = document.querySelector('.opciones-grid, .cards, .gallery, .feed-container, .feed-grid, .noticias');

    // 1. Limpieza absoluta inmediata de cualquier mensaje de error anterior
    let mensajeExistente = document.getElementById('sin-resultados-busqueda');
    if (mensajeExistente) {
        mensajeExistente.remove();
    }

    // 2. Si el buscador está vacío, mostramos todo y detenemos el script
    if (filtro === "") {
        tarjetas.forEach(function(tarjeta) {
            tarjeta.style.setProperty('display', '', 'important');
        });
        return;
    }

    let encontrados = 0;

    tarjetas.forEach(function(tarjeta) {
        let tituloText = "";

        // CASO A: Imagen directa (Galería Pública)
        if (tarjeta.tagName.toLowerCase() === 'img') {
            let dataTitle = tarjeta.getAttribute('data-title');
            if (dataTitle) {
                tituloText = dataTitle.toLowerCase().trim();
            } else if (tarjeta.getAttribute('alt')) {
                tituloText = tarjeta.getAttribute('alt').toLowerCase().trim();
            }
        }
        // CASO B: Tarjetas comunes
        else {
            let tituloElemento = tarjeta.querySelector('.historia-titulo, .galeria-titulo, .titulo-entrevista, h3, h2');

            if (tituloElemento) {
                tituloText = tituloElemento.textContent.toLowerCase().trim();
            }
        }

        // Evaluamos si el texto coincide con lo escrito
        if (tituloText !== "") {

            if (tituloText.includes(filtro)) {
                tarjeta.style.setProperty('display', '', 'important');
                encontrados++;
            } else {
                tarjeta.style.setProperty('display', 'none', 'important');
            }

        } else {
            tarjeta.style.setProperty('display', 'none', 'important');
        }

    });

    // Mostrar mensaje si no hay resultados
    if (encontrados === 0 && contenedorPadre) {

        let mensajeNoResultados = document.createElement('p');

        mensajeNoResultados.id = 'sin-resultados-busqueda';
        mensajeNoResultados.textContent = 'No se encontraron resultados para tu búsqueda.';

        mensajeNoResultados.style.cssText = `
            grid-column: 1 / -1 !important;
            display: block !important;
            width: 100% !important;
            text-align: center !important;
            color: #a66b37 !important;
            font-weight: 500 !important;
            padding: 50px 10px !important;
            font-family: 'Poppins', sans-serif !important;
            clear: both !important;
            flex-basis: 100% !important;
        `;

        contenedorPadre.appendChild(mensajeNoResultados);
    }

});