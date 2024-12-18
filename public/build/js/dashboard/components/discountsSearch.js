const cardContainer = document.querySelector(".card-container");

const Card = ({ nombre, precio, discount, discount_type, id, images, año, modelo, fabricante, createdAt }) => {

    const card = document.createElement("div");
    card.id = id;
    card.classList.add("card");
    card.setAttribute("aria-label", id);

    const imageContainer = document.createElement("div");
    imageContainer.classList.add("image-container");

    const contenedorControllers = document.createElement("div");
    contenedorControllers.classList.add("contenedor-controllers");

    const btnDiscount = document.createElement("button");
    const discountImg = document.createElement("img");
    btnDiscount.id = id;
    discountImg.src = "/build/src/images/plus.svg";
    btnDiscount.appendChild(discountImg);

    btnDiscount.addEventListener("click", (e) => {
        handlerAgregarDiscount(e);
    });

    const btnNoDiscount = document.createElement("button");
    const noDiscountImg = document.createElement("img");
    btnNoDiscount.id = id;
    noDiscountImg.src = "/build/src/images/trash.svg";
    btnNoDiscount.appendChild(noDiscountImg);

    btnNoDiscount.addEventListener("click", handlerEliminarDiscount);

    if (discount === 0 || discount === null) {
        contenedorControllers.appendChild(btnDiscount);
    } else {
        contenedorControllers.appendChild(btnNoDiscount);
    }

    const contenedorInformacion = document.createElement("div");
    contenedorInformacion.classList.add("contenedor-informacion");

    const contenedorPrecio = document.createElement("div");
    contenedorPrecio.classList.add("contenedor-precio");

    if (discount) {
        const precioOriginalHTML = document.createElement("p");
        const precioFinalHTML = document.createElement("p");
        precioOriginalHTML.classList.add("precioOriginal");
        precioFinalHTML.classList.add("precioFinal");

        let precioFinal;
        if (discount_type === "Dolares") {
            precioFinal = precio - discount;
        } else if (discount_type === "Porcentaje") {
            const montoDescuento = (precio * discount) / 100;
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

    const contenedorNombre = document.createElement("div");
    contenedorNombre.classList.add("contenedor-datos");
    const nombreHTML = document.createElement("p");
    nombreHTML.textContent = nombre ?? "Dodge Charger 69";

    const fabricanteHTML = document.createElement("p");
    fabricanteHTML.textContent = fabricante ?? "Dodge";

    const modeloHTML = document.createElement("p");
    modeloHTML.textContent = modelo ?? "Charger";

    const añoHTML = document.createElement("p");
    añoHTML.textContent = año ?? "1969";

    contenedorNombre.appendChild(nombreHTML);
    contenedorNombre.appendChild(fabricanteHTML);
    contenedorNombre.appendChild(modeloHTML);
    contenedorNombre.appendChild(añoHTML);

    const formattedCreatedAt = formatDate(createdAt);
    const createdHTML = document.createElement("p");
    createdHTML.textContent = formattedCreatedAt;

    contenedorPrecio.appendChild(createdHTML);

    contenedorInformacion.appendChild(contenedorNombre);
    contenedorInformacion.appendChild(contenedorPrecio);

    if (images.length === 0) {
        imageContainer.style.backgroundImage = "url('/build/src/images/vehicles/default.jpg')";
    } else {
        imageContainer.style.backgroundImage = `url('/build${images[0]?.url.split("/build")[1]}')`;
    }

    card.appendChild(contenedorControllers);
    card.appendChild(imageContainer);
    card.appendChild(contenedorInformacion);

    const observer = new IntersectionObserver(items => {
        items.forEach(item => {
            if (item.isIntersecting) {
                item.target.classList.add("intersecting");
                observer.unobserve(card);
            }
        });
    });

    observer.observe(card);

    return card;
};


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
        const url = location.origin + `/api/v1/vehicles?token=9fd4e0080bc6edc9f3c3853b5b1b6ecf${search ? "&name=" + search : ""}&page=${page}`

        const response = await fetch(url)
        spinner.remove()

        const data = await response.json();
        const oldData = JSON.parse(localStorage.getItem("tiendaItems")) ?? [];
        const newData = [...oldData, ...data]

        data.forEach(v => {
            const customV = {
                nombre: v.product.nombre,
                precio: v.product.precio,
                discount: v.product.discount,
                discount_type: v.product.discount_type,
                id: v.vehicle_id,
                imageUrl: v.imagen,
                fabricante: v.product.fabricante,
                modelo: v.product.modelo,
                año: v.product.year,
                createdAt: v.product.createdAt,
                images: v.vehicleImages
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

        if (location.pathname.includes("/dashboard/discounts/vehicle")) {

            await handlerBusqueda(buscador?.value)
            const url = new URL(location.origin + "/dashboard/discounts/vehicle");
            url.searchParams.set('search', buscador?.value);
            history.replaceState(null, null, url.toString());
        }
        else {
            const url = new URL(location.origin + "/dashboard/discounts/vehicle");
            url.searchParams.set('search', buscador?.value);
            location.assign(url.toString())
        }
    } else {
        const url = new URL(location.origin + "/dashboard/discounts/vehicle");
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
    const url = new URL(location.origin + "/dashboard/discounts/vehicle");

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
                const response = await fetch(location.origin + `/api/v1/vehicles?token=9fd4e0080bc6edc9f3c3853b5b1b6ecf&name=${buscador.value}`)

                if (response.ok) {
                    const data = await response.json()
                    if (!data?.message || data?.message !== "404") {
                        resultadoBusqueda.classList.remove("hidden")

                        const vehicles = Object.values(data)
                        const vehiclesName = vehicles.map(vehicles => vehicles?.product?.nombre)
                        const vehiclesNomUnicos = new Set(vehiclesName)
                        const arregloNoRepetido = [...vehiclesNomUnicos]

                        arregloNoRepetido.forEach(vehicle => {
                            resultadoBusqueda.appendChild(ItemBusqueda(vehicle))
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

// Función para formatear la fecha
function formatDate(dateString) {
    const [datePart, timePart] = dateString.split(' ');
    const [year, month, day] = datePart.split('-');
    const formattedDate = `${timePart} ${day}/${month}/${year}`;

    return formattedDate;
}

function ocultarBusqueda() {
    resultadoBusqueda.classList.add("hidden")
}


