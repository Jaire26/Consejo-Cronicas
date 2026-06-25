// Buscador Universal en tiempo real
document.getElementById('inputBusqueda').addEventListener('keyup', function() {
    let filtro = this.value.toLowerCase();
    
    // Busca automáticamente cualquier tarjeta que termine en "-card" (historia-card, cronica-card, etc.)
    let tarjetas = document.querySelectorAll('[class*="-card"]');

    tarjetas.forEach(function(tarjeta) {
        // Busca el primer título (h3) que encuentre dentro de la tarjeta
        let tituloElemento = tarjeta.querySelector('h3');
        
        if (tituloElemento) {
            let tituloText = tituloElemento.textContent.toLowerCase();
            if (tituloText.includes(filtro)) {
                tarjeta.style.display = ""; // Muestra si coincide
            } else {
                tarjeta.style.display = "none"; // Oculta si no coincide
            }
        }
    });
});