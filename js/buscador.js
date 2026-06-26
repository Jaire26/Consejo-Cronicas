// Buscador Universal - Versión Definitiva Adaptada (Admin y Público)
document.getElementById('inputBusqueda').addEventListener('keyup', function() {
    let filtro = this.value.toLowerCase().trim();
    
    // Selecciona tarjetas de catálogo, contenedores de administración y las imágenes directas de la galería pública
    let tarjetas = document.querySelectorAll('.card:not(.admin-card), [class*="-card"]:not(.admin-card), .gallery-item-container, .gallery img');
    let contenedorPadre = document.querySelector('.cards, .gallery, .feed-container, .feed-grid');
    
    let encontrados = 0;

    tarjetas.forEach(function(tarjeta) {
        let tituloText = "";

        // CASO 1: Si es una imagen directa de la galería pública, leemos su atributo 'data-title'
        if (tarjeta.tagName.toLowerCase() === 'img' && tarjeta.getAttribute('data-title')) {
            tituloText = tarjeta.getAttribute('data-title').toLowerCase().trim();
        } 
        // CASO 2: Si es una tarjeta común (Historia, Crónicas, etc.), buscamos sus etiquetas de encabezado
        else {
            let tituloElemento = tarjeta.querySelector('.historia-titulo, .galeria-titulo, h3, h2');
            if (tituloElemento) {
                tituloText = tituloElemento.textContent.toLowerCase().trim();
            }
        }
        
        // Ejecutamos el filtro si logramos obtener un título válido
        if (tituloText !== "") {
            if (tituloText.includes(filtro)) {
                tarjeta.style.setProperty('display', '', 'important'); // Restaura el estilo original (Grid/Flex)
                encontrados++;
            } else {
                tarjeta.style.setProperty('display', 'none', 'important'); // Oculta el elemento
            }
        }
    });

    // Limpieza total del mensaje de error anterior
    let mensajeExistente = document.getElementById('sin-resultados-busqueda');
    if (mensajeExistente) {
        mensajeExistente.remove();
    }

    // Si el conteo real de coincidencias es 0, inyectamos el mensaje perfectamente centrado
    if (encontrados === 0 && contenedorPadre) {
        let mensajeNoResultados = document.createElement('p');
        mensajeNoResultados.id = 'sin-resultados-busqueda';
        mensajeNoResultados.textContent = 'No se encontraron resultados para tu búsqueda.';
        
        // Estilos CSS que rompen el Grid/Flexbox para forzar al mensaje a centrarse abajo
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