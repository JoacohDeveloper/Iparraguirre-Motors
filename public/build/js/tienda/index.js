//Prueba de infinite scroll



const cardContainer = document.querySelector(".card-container")

const Card = ({ id, nombre, año, precio, discount, discount_type, km, images }) => {

    const card = document.createElement("div")
    card.classList.add("card")
    card.setAttribute("aria-label", id)

    const card_image = document.createElement("div");
    card_image.classList.add("card_image")
    
    if(images.length == 0)
     card_image.style.backgroundImage = "url('/build/src/images/vehicles/default.jpg')";
    else{
     card_image.style.backgroundImage = `url('/build${images[0]?.url.split("/build")[1]}')`;
    }
    


    const card_info = document.createElement("div");
    card_info.classList.add("card_info")

    const text_name = document.createElement("p")
    const text_kmyear = document.createElement("p")

    text_name.textContent = `${nombre}`
    text_kmyear.textContent = `${año} | ${km}` 

    const contenedorPrecio = document.createElement("div");
    contenedorPrecio.classList.add("contenedor-precio");

    if (discount) {
        const precioOriginalHTML = document.createElement("p");
        const precioFinalHTML = document.createElement("p");
        precioOriginalHTML.classList.add("precioOriginal");
        precioFinalHTML.classList.add("precioFinal");
        
        let precioFinal;
        if (discount_type == "Dolares") {
            precioFinal = precio - discount;
        } else if (discount_type == "Porcentaje") {
            let montoDescuento = (precio * discount) / 100;
            precioFinal = precio - montoDescuento;
        }

        precioFinalHTML.textContent = `${Number(precioFinal).toLocaleString("en-US", { style: "currency", currency: "USD" })}`;
        precioOriginalHTML.textContent = `${Number(precio).toLocaleString("en-US", { style: "currency", currency: "USD" })}`;
    
        contenedorPrecio.appendChild(precioFinalHTML);
        contenedorPrecio.appendChild(precioOriginalHTML);
    } else {
        const precioHTML = document.createElement("p");
        precioHTML.classList.add("precio");
        precioHTML.textContent = `${Number(precio).toLocaleString("en-US", { style: "currency", currency: "USD" })}`;
        contenedorPrecio.appendChild(precioHTML);
    }    

    


    card_info.appendChild(text_name)
    card_info.appendChild(contenedorPrecio);
    card_info.appendChild(text_kmyear)

    card.appendChild(card_image)
    card.appendChild(card_info)

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
        if (cardContainer) cardContainer.appendChild(spinner);
        const url = location.origin + `/api/v1/vehicles?token=9fd4e0080bc6edc9f3c3853b5b1b6ecf${search ? "&name=" + search : ""}&page=${page}`

        const response = await fetch(url);
        spinner.remove();

        const data = await response.json();
        const oldData = JSON.parse(localStorage.getItem("tiendaItems")) ?? [];
        const newData = [...oldData, ...data];
        console.log(data);
        //localStorage.setItem("tiendaItems", JSON.stringify(newData));

        data.forEach(v => {
            const customV = {
                nombre: v.nombre,
                precio: v.precio,
                discount: v.discount,
                discount_type: v.discount_type,
                id: v.id,
                km: v.kilometros,
                año: v.year,
                images: v.vehicleImages
            };
            if (cardContainer) cardContainer.appendChild(Card(customV));
        });

        if (data.length > 0) {
            const lastId = data[data.length - 1].id;
            const lastEl = cardContainer?.querySelector(`[aria-label='${lastId}']`);

            if (cardContainer) return lastEl;
        }

        return null;
    };

    let page = 1;
    let lastEl = await cargarMasVehiculos(page);

    const observer = new IntersectionObserver(entries => {
        entries.forEach(async entry => {
            if (entry.isIntersecting) {
                observer.unobserve(lastEl);
                page++;
                localStorage.setItem("tiendaPage", JSON.stringify(page));
                lastEl = await cargarMasVehiculos(page);
                if (lastEl) observer.observe(lastEl);
            }
        });
    });

    if (lastEl) observer.observe(lastEl);
}








// Buscador

const data = ["Ferrari Vehicle", "Porsche Vehicle", "Bugatti Vehicle", "Ford Vehicle"]

const buscador = document.querySelector("#id_product-search__input")
const resultadoBusqueda = document.querySelector(".result-list")
const contenedorBuscador = document.querySelector(".search__input")

if (location.pathname === "/catalogo/vehiculos") {
    init();
}

contenedorBuscador.addEventListener("submit", async e => {
    e.preventDefault()
    ocultarBusqueda()

    if (cardContainer) {
        cardContainer.innerHTML = null
    }

    if (buscador.value) {
        if (location.pathname.includes("/catalogo/vehiculos")) {
            await handlerBusqueda(buscador?.value);
            const url = new URL(location.origin + "/catalogo/vehiculos");
            url.searchParams.set('search', buscador?.value);
            history.replaceState(null, null, url.toString());
        } else {
            const url = new URL(location.origin + "/catalogo/vehiculos");
            url.searchParams.set('search', buscador?.value);
            location.assign(url.toString());
        }
    } else {
        if (location.pathname === "/catalogo/vehiculos") {
            await init();
        } else {
            const url = new URL(location.origin + "/catalogo/vehiculos");
            history.replaceState(null, null, url.toString());
            await init();
        }
    }
})

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
    const url = new URL(location.origin + "/catalogo/vehiculos");

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

}


buscador.addEventListener("input", async () => await buscar())

async function buscar() {
    clearTimeout(timer);
    timer = setTimeout(async () => {
        resultadoBusqueda.innerHTML = null;
        if (buscador?.value?.length > 0) {
            try {
                const response = await fetch(location.origin + `/api/v1/vehicles?token=9fd4e0080bc6edc9f3c3853b5b1b6ecf&name=${buscador.value}`)
                if (response.ok) {
                    const data = await response.json();
                    if (!data?.message || data?.message !== "404") {
                        resultadoBusqueda.classList.remove("hidden");
                        const vehicles = Object.values(data);
                        const vehiclesName = vehicles.map(vehicle => vehicle?.nombre);
                        const vehiclesNomUnicos = new Set(vehiclesName);
                        const arregloNoRepetido = [...vehiclesNomUnicos];

                        arregloNoRepetido.forEach(vehicle => {
                            resultadoBusqueda.appendChild(ItemBusqueda(vehicle));
                        });

                        if (Object.values(data).length == 0) ocultarBusqueda();
                    } else {
                        ocultarBusqueda();
                    }
                }
            } catch (err) {
                console.error(err?.message);
            }
        } else {
            ocultarBusqueda();
            const url = new URL(location.origin + "/catalogo/vehiculos");
            history.replaceState(null, null, url.toString());
            if (!location.pathname.includes("/catalogo/vehiculos/results")) {
                await init();
            }
        }
    }, 300);
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


