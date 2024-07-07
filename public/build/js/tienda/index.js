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
                lastEl = await cargarMasVehiculos(page)
                if (lastEl) observer.observe(lastEl)
            }
        })
    })

    if (lastEl)
        observer.observe(lastEl)
}

init()


