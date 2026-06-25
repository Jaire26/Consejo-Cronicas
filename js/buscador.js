// Buscador Universal en tiempo real con mensaje de "No encontrado"
document.getElementById('inputBusqueda').addEventListener('keyup', function() {
    let filtro = this.value.toLowerCase();
    
    // Detecta cualquier tarjeta que termine en "-card" o contenedores de galería
    let tarjetas = document.querySelectorAll('[class*="-card"], .gallery-item-container');
    let contenedorPadre = document.querySelector('.cards, .gallery, .feed-container');
    
    let encontrados = 0;

    tarjetas.forEach(function(tarjeta) {
        // Busca el título dentro de un h3 (normal u oculto)
        let tituloElemento = tarjeta.querySelector('h3');
        
        if (tituloElemento) {
            let tituloText = tituloElemento.textContent.toLowerCase();
            if (tituloText.includes(filtro)) {
                tarjeta.style.display = ""; // Muestra si coincide
                encontrados++;
            } else {
                tarjeta.style.display = "none"; // Oculta si no coincide
            }
        }
    });

    // Control del mensaje de "No se encontraron resultados"
    let mensajeNoResultados = document.getElementById('sin-resultados-busqueda');

    if (encontrados === 0) {
        // Si no existe el mensaje en la pantalla, lo creamos
        if (!mensajeNoResultados && contenedorPadre) {
            mensajeNoResultados = document.createElement('p');
            mensajeNoResultados.id = 'sin-resultados-busqueda';
            mensajeNoResultados.textContent = 'No se encontraron resultados para tu búsqueda.';
            mensajeNoResultados.style.cssText = 'grid-column: 1 / -1; text-align: center; color: #a66b37; font-weight: 500; padding: 30px; width: 100%; font-family: "Poppins", sans-serif;';
            contenedorPadre.appendChild(mensajeNoResultados);
        }
    } else {
        // Si vuelven a aparecer tarjetas, borramos el mensaje
        if (mensajeNoResultados) {
            mensajeNoResultados.remove();
        }
    }
});