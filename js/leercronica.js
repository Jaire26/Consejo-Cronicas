const cronicas = [

{
    id: 1,

    titulo: "Historias del Centro",

    autor: "Consejo Huejutlense",

    fecha: "24 Mayo 2026",

    imagen: "https://images.unsplash.com/photo-1524492449090-1abe1e3a209c?q=80&w=1200&auto=format&fit=crop",

    resumen: "Recuerdos y relatos sobre el antiguo Huejutla.",

    contenido: `
    
    Esta crónica relata los acontecimientos más importantes
    del antiguo Huejutla.

    Sus tradiciones, personajes y cultura forman parte
    de la memoria colectiva huasteca.

    `
}

];



const contenedor = document.querySelector(".cards");

cronicas.forEach(cronica => {

    contenedor.innerHTML += `

    <div class="card cronica-card">

        <img src="${cronica.imagen}">

        <div class="card-content">

            <span class="cronica-fecha">
                ${cronica.fecha}
            </span>

            <h3>
                ${cronica.titulo}
            </h3>

            <h4>
                Por: ${cronica.autor}
            </h4>

            <p class="cronica-resumen">
                ${cronica.resumen}
            </p>

            <button 
                class="btn-cronica"
                onclick="mostrarCronica(${cronica.id})"
            >
                Leer Crónica
            </button>

            <div 
                class="contenido-cronica"
                id="cronica-${cronica.id}"
            >

                <p>
                    ${cronica.contenido}
                </p>

            </div>

        </div>

    </div>

    `;
});



function mostrarCronica(id){

    const contenido =
    document.getElementById(`cronica-${id}`);

    contenido.classList.toggle("mostrar");

}