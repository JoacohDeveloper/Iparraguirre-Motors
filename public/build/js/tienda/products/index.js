

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
    const $image = document.querySelector("#image");
    const $title = document.querySelector(".title");
    const contenedorPrecio = document.querySelector(".contenedor-precio");
    const $description = document.querySelector(".description");
    const $contenedorImagenes = document.querySelector(".image-items");

    const urlParams = new URLSearchParams(window.location.search);
    const uuid = urlParams.get('product-id');

    let response = await fetch(`${window.location.origin}/api/v1/vehicles?token=9fd4e0080bc6edc9f3c3853b5b1b6ecf&id=${uuid}`);
    let product = await response.json();

    if (!product.product || product.status === 404) {
        response = await fetch(`${window.location.origin}/api/v1/refractions?token=9fd4e0080bc6edc9f3c3853b5b1b6ecf&id=${uuid}`);
        product = await response.json();

        if (product[0]?.product) {
            product = product[0];
        } else {
            console.error("Producto no encontrado");
            return;
        }
    }
    console.log(product)
    if (product.product) {
        if(product.product.categoria == "De fabrica" || product.product.categoria == "Modificados"){
            $title.textContent = product?.product?.nombre;
        } else {
            $title.textContent = product?.tipo_repuesto + " " + product?.product?.fabricante + " " + product?.product?.modelo;
        }
        

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

        $description.textContent = product?.product?.descripcion;

        if (product.vehicleImages?.length > 0) {
            $image.src = "/build/" + product?.vehicleImages[0]?.url.split("/build/")[1];
            $image.alt = product?.vehicleImages[0]?.alt;

            product?.vehicleImages.forEach((image, index) => {
                const url = "/build/" + image?.url.split("/build/")[1];
                const img = ImageItem({ url, alt: image?.alt });
                if (index == 0) {
                    img.classList.add("selected");
                }
                $contenedorImagenes.appendChild(img);
            });

            const $elements = $contenedorImagenes.querySelectorAll(".img-item");

            $elements.forEach($element => {
                $element.addEventListener("click", () => {
                    const selected = document.querySelector(".selected");

                    if (selected && selected != $element) {
                        selected.classList.remove("selected");
                    }
                    $element.classList.add("selected");
                    const $img = $element.querySelector("img");
                    $image.src = $img.src;
                    $image.alt = $img.alt;
                });
            });
        } else {
            const $imageSelector = document.querySelector(".image-selector");
            $imageSelector.style.display = "none";
            if(product.product.categoria == "De fabrica" || product.product.categoria == "Modificados"){
                $image.src = "/build/src/images/vehicles/default.jpg";
            } else {
                if(product.url_img){
                    $image.src = product.url_img;
                } else {
                    $image.src = "/build/src/images/refractions/default.jpg";
                }
            }
        }

        const optionsContainer = document.querySelector(".add-to-cart-container");
        const isNotSessionLogged = document.querySelector("#userIsNotLogged");

        if(product.product.categoria == "De fabrica" || product.product.categoria == "Modificados"){
            const testBtn = document.createElement("button");
            testBtn.textContent = "Reservar test drive";
            optionsContainer.appendChild(testBtn);
            
            testBtn.addEventListener("click", e => {
                if(isNotSessionLogged){
                    window.location.href = `/auth`;
                } else {
                    modalTest(product.product.product_id, product.product.nombre, product.year);
                    toggleBackground();
                }
            });
        } else {
            const qtyBtn = document.createElement("input");
            const basketBtn = document.createElement("button");

            qtyBtn.type = "number";
            qtyBtn.value = "1";
            qtyBtn.min = "1";
            qtyBtn.step = "1";
            basketBtn.textContent = "Añadir al carrito";

            optionsContainer.appendChild(qtyBtn);
            optionsContainer.appendChild(basketBtn);

            qtyBtn.addEventListener("input", function() {
                if (this.value < 1) {
                    this.value = 1;
                }
            });
            qtyBtn.addEventListener("keydown", function(e) {
                if (!((e.key >= 0 && e.key <= 9) || e.key === "Backspace" || e.key === "ArrowLeft" || e.key === "ArrowRight")) {
                    e.preventDefault();
                }
            });
            qtyBtn.addEventListener("change", function() {
                if (this.value < 1) {
                    this.value = 1;
                }
            });

            basketBtn.addEventListener("click", e => {
                if(isNotSessionLogged){
                    window.location.href = `/auth`;
                } else {
                    const ultimosProductos = JSON   .parse(localStorage.getItem("basket")) || [];
                    
                    const newProduct = { ...product.product, images: [{url:product?.url_img}]};

                    const yaExiste = ultimosProductos.find(product => product.product_id === newProduct.product_id);

                    
                    if (!yaExiste) {
                        localStorage.setItem("basket", JSON.stringify([...ultimosProductos, newProduct]));
                        basketScript();
                    }
                }
            });

        }
        moveArrows();
    } else {
        console.error("Producto no encontrado");
    }
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

function modalTest(itemID, itemName, itemYear){
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
      
        testContainer.classList.add('closing');
      
        setTimeout(() => {
          toggleBackground();
          if (inputDate) inputDate.remove();
          if (testContainer) testContainer.remove();
        }, 500);
    });
    
    //Implementamos los items del header al header
    containerHeader.appendChild(testTitle);
    containerHeader.appendChild(exitBtn);

    //Items del main
    const explicationText = document.createElement("p");
    const explicationText_redirect = document.createElement("a");
    
    explicationText.textContent = "Las reservas de test drive solo se aceptan si son en los proximos 7 dias. Le recomendamos leer las politicas de las pruebas de manejo para mas informacion.";
    explicationText_redirect.textContent = "Ver politica";
    explicationText_redirect.href = location.origin + "/";

    explicationText_Content.appendChild(explicationText);
    explicationText_Content.appendChild(explicationText_redirect);

    const labelDate = document.createElement("label");
    const textDate = document.createElement("p");
    const inputDate = document.createElement("input");
    textDate.textContent = "Fecha de reserva";
    inputDate.type = "date";
    inputDate.name = "date";

    labelDate.appendChild(textDate);
    labelDate.appendChild(inputDate);

    const inputSubmit = document.createElement("input");
    inputSubmit.type = "submit";
    inputSubmit.textContent = "Reservar"

    formTest.addEventListener("submit", async e => {
        e.preventDefault();

        const reservedDate = e.target[0].value;
        const errores = [];

        if (reservedDate == "") {
            errores.push("Debes ingresar una fecha para la prueba de manejo");
        }
        if (itemID == "") {
            errores.push("Ocurrio un error con el vehiculo");
        }

        if (errores.length != 0) {
            const firstError = errores[0];
            const error = document.createElement("div");
            error.classList.add("error");
            console.log("Hola")
            error.textContent = firstError;
            addToast([{ title: "Fail", error: firstError }]);
        } else {
            const spinner = document.createElement("div")
            spinner.classList.add("linear-loading") // o spinner
            const loaderSection = document.querySelector(".loader")
            loaderSection?.appendChild(spinner);
            const form_data = new FormData(e.target);
            
            const nameOfProduct = itemName + " " + itemYear;
            form_data.append('productID', itemID);
            form_data.append('productName', nameOfProduct);
            try {
                const response = await fetch(location.origin + "/catalogo/vehiculos/reserva", {
                    method: "POST",
                    body: form_data
                })
                const data = await response.json()

                if (data?.errores) {
                    const errors = Object?.values(data?.errores).map(err => {
                        const error = document.createElement("div");
                        error.classList.add("error")
                        error.textContent = err
                        return { title: "Failure", error: err }
                    })
                    addToast(errors);
                } else if (data?.message == "successfully") {
                    Swal.fire({
                        title: "Éxito",
                        text: "Se ha registrado la prueba con exito!",
                        icon: "success"
                    });
                    const btn_swal = document.querySelector(".swal2-confirm");
                    if(btn_swal){
                        btn_swal.addEventListener("click", () =>{
                            location.reload();
                        })
                    }
                }
            } catch (error) {
                console.log(error)
                addToast([{ title: "Failure", error: "Ocurrió un error, intenta de nuevo más tarde." }]);
            } finally {
                const spinner2 = loaderSection?.querySelector(".linear-loading")
                spinner2?.remove()
            }
        }
    });

    formTest.appendChild(labelDate);
    formTest.appendChild(inputSubmit);

    containerMain.appendChild(explicationText_Content);
    containerMain.appendChild(formTest);

    testContainer.appendChild(containerHeader);
    testContainer.appendChild(containerMain);

    productContainer.appendChild(testContainer);
}

const toggleBackground = () => {
    document.body.classList.toggle("fixed")
    document.body.classList.toggle("blured")
}

loadProduct()