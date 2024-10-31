

const ImageItem = ({ url, alt }) => {
    const contenedor = document.createElement("div")
    contenedor.classList.add("img-item")


    const img = document.createElement("img")

    img.src = url
    img.alt = alt

    contenedor.appendChild(img)

    return contenedor
}

async function loadProduct() {
    const $image = document.querySelector("#image")
    const $title = document.querySelector(".title")
    const contenedorPrecio = document.querySelector(".contenedor-precio");
    const $description = document.querySelector(".description")

    const $contenedorImagenes = document.querySelector(".image-items")

    const urlParams = new URLSearchParams(window.location.search);
    const uuid = urlParams.get('product-id');

    const response = await fetch(`${window.location.origin}/api/v1/vehicles?token=9fd4e0080bc6edc9f3c3853b5b1b6ecf&id=${uuid}`)

    const product = await response.json();
    
    $title.textContent = product?.product?.nombre;

    if (product.product.discount) {
        const precioOriginalHTML = document.createElement("p");
        const precioFinalHTML = document.createElement("p");
        const descuentoHTML = document.createElement("div");
        precioOriginalHTML.id = "precioOriginal";
        precioFinalHTML.id = "precioFinal";
        descuentoHTML.id = "descuento";

        let precioFinal;
        if (product.product.discount_type == "Dolares") {
            precioFinal = product.product.precio - product.product.discount;
            descuentoHTML.textContent = "-" + product.product.discount + " USD";
        } else if (product.product.discount_type == "Porcentaje") {
            let montoDescuento = (product.product.precio * product.product.discount) / 100;
            precioFinal = product.product.precio - montoDescuento;
            descuentoHTML.textContent = "-" + product.product.discount + "%";
        }

        precioFinalHTML.textContent = `${Number(precioFinal).toLocaleString("en-US", { style: "currency", currency: "USD" })}`;
        precioOriginalHTML.textContent = `${Number(product.product.precio).toLocaleString("en-US", { style: "currency", currency: "USD" })}`;

        const labelDiscount = document.createElement("label");
        labelDiscount.appendChild(precioOriginalHTML);
        labelDiscount.appendChild(descuentoHTML);

        contenedorPrecio.appendChild(precioFinalHTML);
        contenedorPrecio.appendChild(labelDiscount);
    } else {
        const precioHTML = document.createElement("p");
        precioHTML.id = "precio";
        precioHTML.textContent = `${Number(product.product.precio).toLocaleString("en-US", { style: "currency", currency: "USD" })}`;
        contenedorPrecio.appendChild(precioHTML);
    }

    $description.textContent = product?.product?.descripcion

    if (product.vehicleImages.length > 0) {
        $image.src = "/build/" + product?.vehicleImages[0]?.url.split("/build/")[1]
        $image.alt = product?.vehicleImages[0]?.alt

        product?.vehicleImages.forEach((image, index) => {
            const url = "/build/" + image?.url.split("/build/")[1]
            const img = ImageItem({ url, alt: image?.alt })
            if (index == 0) {
                img.classList.add("selected")
            }
            $contenedorImagenes.appendChild(img)
        })

        const $elements = $contenedorImagenes.querySelectorAll(".img-item");

        $elements.forEach($element => {
            $element.addEventListener("click", () => {
                const selected = document.querySelector(".selected")

                if (selected && selected != $element) {
                    selected.classList.remove("selected")
                }
                $element.classList.add("selected")
                const $img = $element.querySelector("img")
                $image.src = $img.src
                $image.alt = $img.alt
            })
        })
    } else {
        const $imageSelector = document.querySelector(".image-selector")
        $imageSelector.style.display = "none";
        $image.src = "/build/src/images/vehicles/default.jpg"
    }

    const optionsContainer = document.querySelector(".add-to-cart-container");

    if(product.product.categoria == "De fabrica" || product.product.categoria == "Modificados"){
        const testBtn = document.createElement("button");
        testBtn.textContent = "Reservar test drive";
        optionsContainer.appendChild(testBtn);
        
        testBtn.addEventListener("click", e => {
            modalTest();
            toggleBackground();
        })
    } else {
        const qtyBtn = document.createElement("input");
        const basketBtn = document.createElement("button");

        qtyBtn.type = "number";
        qtyBtn.value = "1";
        basketBtn.textContent = "Añadir al carrito";

        optionsContainer.appendChild(qtyBtn);
        optionsContainer.appendChild(basketBtn);

        basketBtn.addEventListener("click", e => {
            const ultimosProductos = JSON.parse(localStorage.getItem("basket")) || []
            const newProduct = { ...product.product, images: product.vehicleImages || [] }

            const yaExiste = ultimosProductos.find(product => product.product_id === newProduct.product_id)

            if (!yaExiste) {
                localStorage.setItem("basket", JSON.stringify([...ultimosProductos, newProduct]))
                basketScript()
            }
        })
    }
    moveArrows()
}


function moveArrows() {
    const $leftBtn = document.querySelector(".left");
    const $rightBtn = document.querySelector(".right");
    const $contenedorImagenes = document.querySelector(".image-items")
    const $elements = $contenedorImagenes.querySelectorAll(".img-item");

    const $firstEl = $elements[0];

    let margin = 0;
    const MAX = 3 * $elements.length * -1
    const MIN = 0;

    if ($elements.length > 3) {
        $leftBtn.addEventListener("click", (e) => {

            if (margin < MIN) {
                margin += 3;
                $firstEl.style.marginLeft = `${margin}rem`;
            }

        })

        $rightBtn.addEventListener("click", (e) => {

            if (margin > MAX) {
                margin -= 3;
                $firstEl.style.marginLeft = `${margin}rem`;
            }
        })
    }
}

const productContainer = document.querySelector(".product-container")

function modalTest(){
    const testContainer = document.createElement("div"); //Contenedor principal
    testContainer.classList.add("test-Container");
    const containerHeader = document.createElement("div"); //Encabezado del contenedor
    containerHeader.classList.add("test-header")
    const containerMain = document.createElement("div"); //Resto del contenedor
    containerMain.classList.add("test-main")
    const explicationText_Content = document.createElement("div"); //Contenedor con informacion para el cliente
    explicationText_Content.classList.add("explication-main");
    const formTest = document.createElement("form"); //Formulario de reserva
    formTest.classList.add("form-main");

    //Items del header
    const testTitle = document.createElement("h4");
    testTitle.textContent = "Reserva de test drive";

    const exitBtn = document.createElement("button");
    exitBtn.classList.add("test-exit");
    const exitIcon = document.createElement("img");
    exitIcon.src = "/build/src/images/cross.svg";
    exitIcon.alt = "Icono de cierre para el formulario";
    
    exitBtn.appendChild(exitIcon);
    exitBtn.addEventListener("click", e => {
        e.preventDefault();
        toggleBackground();
        if(inputDate) inputDate.remove();
        if(testContainer) testContainer.remove();
    })
    //Implementamos los items del header al header
    containerHeader.appendChild(testTitle);
    containerHeader.appendChild(exitBtn);

    //Items del main
    const explicationText = document.createElement("p");
    const explicationText_redirect = document.createElement("a");
    
    explicationText.textContent = "Las reservas de test drive solo se aceptan si son en los proximos 7 dias. Mandar una reserva no te asegura que sea aceptada, la misma puede ser rechazada. Le recomendamos leer las politicas de los test drive para mas seguridad.";
    explicationText_redirect.textContent = "Ver politica";
    explicationText_redirect.href = location.origin + "/";

    explicationText_Content.appendChild(explicationText);
    explicationText_Content.appendChild(explicationText_redirect);

    const labelDate = document.createElement("label");
    const textDate = document.createElement("p");
    const inputDate = document.createElement("input");
    textDate.textContent = "Fecha de reserva";
    inputDate.type = "date";

    labelDate.appendChild(textDate);
    labelDate.appendChild(inputDate);

    const inputSubmit = document.createElement("input");
    inputSubmit.type = "submit";
    inputSubmit.textContent = "Reservar"

    formTest.appendChild(labelDate);
    formTest.appendChild(inputSubmit);

    containerMain.appendChild(explicationText_Content);
    containerMain.appendChild(formTest);

    testContainer.appendChild(containerHeader);
    testContainer.appendChild(containerMain);

    productContainer.appendChild(testContainer);
}

const toggleBackground = () => {
    productContainer.classList.toggle("fixed")
    document.body.classList.toggle("blured")
}

loadProduct()