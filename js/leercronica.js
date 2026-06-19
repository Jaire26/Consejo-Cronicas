
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