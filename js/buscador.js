// Buscador Universal - Versión Definitiva (Admin y Público)
document.getElementById('inputBusqueda').addEventListener('keyup', function() {
    let filtro = this.value.toLowerCase().trim();
    
    // Selecciona tarjetas públicas (.card), de admin ([class*="-card"]) e imágenes (.gallery-item-container)
    // Excluye explícitamente la tarjeta de agregar contenido del administrador (.admin-card)
    let tarjetas = document.querySelectorAll('.card:not(.admin-card), [class*="-card"]:not(.admin-card), .gallery-item-container');
    let contenedorPadre = document.querySelector('.cards, .gallery, .feed-container, .feed-grid');
    
    let encontrados = 0;

    tarjetas.forEach(function(tarjeta) {
        // Busca el elemento del título de forma precisa (clases específicas o etiquetas de encabezado)
        let tituloElemento = tarjeta.querySelector('.historia-titulo, .galeria-titulo, h3, h2');
        
        if (tituloElemento) {
            let tituloText = tituloElemento.textContent.toLowerCase().trim();
            
            // Filtra y compara ÚNICAMENTE por el texto del título
            if (tituloText.includes(filtro)) {
                tarjeta.style.setProperty('display', '', 'important'); // Restaura el estilo CSS original (Grid/Flexbox)
                encontrados++;
            } else {
                tarjeta.style.setProperty('display', 'none', 'important'); // Oculta por completo la tarjeta
            }
        }
    });

    // Limpieza total del mensaje de error anterior
    let mensajeExistente = document.getElementById('sin-resultados-busqueda');
    if (mensajeExistente) {
        mensajeExistente.remove();
    }

    // Si el conteo real de coincidencias es 0, inyectamos el mensaje perfectamente estructurado
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