/**
 * author Joaquín Álvarez
 * created on 29-07-2024-00h-59m
 * github: https://github.com/JoacohDeveloper
*/

//Prueba de infinite scroll



const cardContainer = document.querySelector(".card-container")

const Card = ({ nombre, precio, id, imageUrl, año, modelo }) => {

    const card = document.createElement("div")
    card.id = id;
    const imageContainer = document.createElement("div")
    imageContainer.classList.add("image-container")

    const contenedorControllers = document.createElement("div")
    contenedorControllers.classList.add("contenedor-controllers")
    const btnModificar = document.createElement("button")
    const modificarImg = document.createElement("img")
    modificarImg.src = "/build/src/images/pencil.svg"

    const btnEliminar = document.createElement("button")
    const btnEliminarImg = document.createElement("img")
    btnEliminarImg.src = "/build/src/images/trash.svg"

    btnEliminar.appendChild(btnEliminarImg)
    btnModificar.appendChild(modificarImg)


    btnEliminar.addEventListener("click", handlerEliminar)

    btnModificar.addEventListener("click", handlerModificar)


    contenedorControllers.appendChild(btnModificar)
    contenedorControllers.appendChild(btnEliminar)


    const img = document.createElement("img")

    const contenedorInformacion = document.createElement("div")
    contenedorInformacion.classList.add("contenedor-informacion")

    const precioHTML = document.createElement("p")
    precioHTML.classList.add("precio")
    precioHTML.textContent = `${Number(precio).toLocaleString("en-US", { style: "currency", currency: "USD" })
        }`

    contenedorInformacion.appendChild(precioHTML)

    const contenedorNombre = document.createElement("div")
    contenedorNombre.classList.add("contenedor-datos")
    const nombreHTML = document.createElement("p")
    nombreHTML.textContent = nombre ?? "Dodge"

    const modeloHTML = document.createElement("p")
    modeloHTML.textContent = modelo ?? "Dodge"

    const añoHTML = document.createElement("p")
    añoHTML.textContent = año ?? "1969"

    contenedorNombre.appendChild(nombreHTML)
    contenedorNombre.appendChild(modeloHTML)
    contenedorNombre.appendChild(añoHTML)
    contenedorInformacion.appendChild(contenedorNombre)

    img.src = imageUrl ?? "/build/src/images/vehicles/Dodge-1969.png";
    img.alt = nombre;
    imageContainer.appendChild(img)

    card.classList.add("card")
    card.setAttribute("aria-label", id)

    card.appendChild(contenedorControllers)
    card.appendChild(imageContainer)

    card.appendChild(contenedorInformacion)

    const observer = new IntersectionObserver(items => {
        items.forEach(item => {
            if (item.isIntersecting) {
                item.target.classList.add("intersecting")
                observer.unobserve(card)
            }
        })
    })

    observer.observe(card)



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

async function init(search = null) {
    const cargarMasVehiculos = async (page) => {
        const spinner = Spinner();
        if (cardContainer) cardContainer.appendChild(spinner)
        const url = `http://localhost:3000/api/v1/vehicles?token=9fd4e0080bc6edc9f3c3853b5b1b6ecf${search ? "&name=" + search : ""}&page=${page}`

        const response = await fetch(url)
        spinner.remove()

        const data = await response.json();
        const oldData = JSON.parse(localStorage.getItem("tiendaItems")) ?? [];
        const newData = [...oldData, ...data]
        //localStorage.setItem("tiendaItems", JSON.stringify(newData))

        data.forEach(v => {
            const customV = {
                nombre: v.nombre,
                precio: 100,
                id: v.id,
                imageUrl: v.imagen,
                modelo: v.modelo,
                año: v.year
            }
            if (cardContainer) cardContainer.appendChild(Card(customV))
        })

        if (data.length > 0) {

            const lastId = data[data.length - 1].id

            const lastEl = cardContainer?.querySelector(`[aria-label='${lastId}']`)


            if (cardContainer)
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







// Buscador


const buscador = document.querySelector("#id_product-search__input")
const resultadoBusqueda = document.querySelector(".result-list")
const contenedorBuscador = document.querySelector(".search__input")

contenedorBuscador.addEventListener("submit", async e => {
    e.preventDefault()
    ocultarBusqueda()

    if (cardContainer) {
        cardContainer.innerHTML = null
    }


    if (buscador.value) {

        if (location.pathname.includes("/dashboard/products")) {

            await handlerBusqueda(buscador?.value)
            const url = new URL(location.origin + "/dashboard/products");
            url.searchParams.set('search', buscador?.value);
            history.replaceState(null, null, url.toString());
        }
        else {
            const url = new URL(location.origin + "/dashboard/products");
            url.searchParams.set('search', buscador?.value);
            location.assign(url.toString())
        }
    } else {
        const url = new URL(location.origin + "/dashboard/products");
        history.replaceState(null, null, url.toString());

        await init()
    }


})

async function cargarDefault() {

    await init()
}


async function handlerBusqueda(search) {
    await init(search)
    const resultados = cardContainer?.querySelector(".card")
    if (!resultados) {
        const nfound = document.createElement("p")
        nfound.textContent = "Not found"
        if (cardContainer) cardContainer.appendChild(nfound)
    }
}

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
    const url = new URL(location.origin + "/dashboard/products");

    url.searchParams.set("search", text)

    item.addEventListener("click", async e => {
        history.replaceState(null, null, url.toString());
        ocultarBusqueda()
        buscador.value = text
        contenedorBuscador.querySelector("button").click()
    })
    return item
}
let timer;

const urlParams = new URLSearchParams(window.location.search);
const querySearch = urlParams.get('search');

if (querySearch) {
    buscador.value = querySearch
    handlerBusqueda(querySearch)

} else {
    init("")
}


buscador.addEventListener("input", async () => await buscar())

async function buscar() {
    clearTimeout(timer)
    timer = setTimeout(async () => {
        resultadoBusqueda.innerHTML = null
        if (buscador?.value?.length > 0) {

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
            // const url = new URL(location.href);
            // url.searchParams.delete("search")
            // history.replaceState(null, null, url.toString());
        }
    }, 300)


}




const contenedorInputListado = document.querySelector(".product-search__input")


document.addEventListener("click", e => {

    if (!contenedorInputListado.contains(e.target))
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


