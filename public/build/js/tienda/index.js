//Prueba de infinite scroll



const cardContainer = document.querySelector(".card-container")

const Card = ({ nombre, precio, id }) => {

    const card = document.createElement("div")
    card.classList.add("card")
    card.setAttribute("aria-label", id)
    const text = document.createElement("p")

    text.textContent = `Id: ${id} - Nombre: ${nombre} - Precio: $${precio}`

    card.appendChild(text)

    return card
}

const Spinner = () => {

    const spinnerSquare = document.createElement("div")
    spinnerSquare.classList.add("spinner-square")

    for (let i = 1; i <= 3; i++) {
        const square = document.createElement("div")
        square.classList.add(`square-${i}`)
        square.classList.add("square")
        spinnerSquare.appendChild(square)
    }

    return spinnerSquare
}

async function init() {
    const cargarMasVehiculos = async (page) => {
        const spinner = Spinner();
        cardContainer.appendChild(spinner)
        const response = await fetch(`http://localhost:3000/api/v1/vehicles?token=9fd4e0080bc6edc9f3c3853b5b1b6ecf&page=${page}`)
        spinner.remove()

        const data = await response.json();
        const oldData = JSON.parse(localStorage.getItem("tiendaItems")) ?? [];
        const newData = [...oldData, ...data]
        //localStorage.setItem("tiendaItems", JSON.stringify(newData))

        data.forEach(v => {
            const customV = {
                nombre: v.nombre,
                precio: 100,
                id: v.id
            }
            cardContainer.appendChild(Card(customV))
        })

        if (data.length > 0) {

            const lastId = data[data.length - 1].id

            const lastEl = cardContainer.querySelector(`[aria-label='${lastId}']`)

            return lastEl
        }

        return

    }


    let page = 1;
    let lastEl = await cargarMasVehiculos(page)

    const observer = new IntersectionObserver(entries => {
        entries.forEach(async entrie => {
            if (entrie.isIntersecting) {
                observer.unobserve(lastEl)
                page++;
                localStorage.setItem("tiendaPage", JSON.stringify(page))
                lastEl = await cargarMasVehiculos(page)
                if (lastEl) observer.observe(lastEl)
            }
        })
    })

    if (lastEl)
        observer.observe(lastEl)
}

//init()





// Buscador

const data = ["Ferrari Vehicle", "Porsche Vehicle", "Bugatti Vehicle", "Ford Vehicle"]

const buscador = document.querySelector("#id_product-search__input")
const resultadoBusqueda = document.querySelector(".result-list")
const contenedorBuscador = document.querySelector(".search__input")


const ItemBusqueda = (text) => {
    const item = document.createElement("div")
    const img = document.createElement("img")
    const p = document.createElement("p")
    p.textContent = text
    img.src = "/build/src/images/glass.svg"
    img.alt = "producto encontrado"
    item.classList.add("search-item")

    item.appendChild(img)
    item.appendChild(p)

    return item
}
let timer;

const urlParams = new URLSearchParams(window.location.search);
const querySearch = urlParams.get('search');

if (querySearch) {
    buscador.value = querySearch
    buscar()
}


buscador.addEventListener("input", async () => await buscar())

async function buscar() {
    clearTimeout(timer)
    timer = setTimeout(async () => {
        resultadoBusqueda.innerHTML = null
        if (buscador?.value?.length > 0) {

            history.replaceState(null, null, "/tienda" + `?search=${buscador?.value}`);

            try {
                const response = await fetch(`http://localhost:3000/api/v1/vehicles?token=9fd4e0080bc6edc9f3c3853b5b1b6ecf&name=${buscador.value}`)


                if (response.ok) {
                    const data = await response.json()
                    if (!data?.message || data?.message !== "404") {
                        resultadoBusqueda.classList.remove("hidden")

                        Object.values(data).forEach(vehicle => {
                            resultadoBusqueda.appendChild(ItemBusqueda(vehicle?.nombre))
                        })
                        if (Object.values(data).length == 0) ocultarBusqueda()
                    } else {
                        ocultarBusqueda()
                    }
                }

            } catch (err) {
                console.error(err?.message)
            }
        } else {
            ocultarBusqueda()
            history.replaceState(null, null, "/tienda")
        }
    }, 300)


}





buscador.addEventListener("focusout", e => {
    ocultarBusqueda()



})
buscador.addEventListener("focus", e => {

    const items = document.querySelectorAll(".search-item")

    if (items.length > 0)
        resultadoBusqueda.classList.remove("hidden")
})






function ocultarBusqueda() {
    resultadoBusqueda.classList.add("hidden")
}