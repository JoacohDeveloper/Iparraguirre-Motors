

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
    const $price = document.querySelector(".price");
    const $description = document.querySelector(".description")

    const $contenedorImagenes = document.querySelector(".image-items")


    const urlParams = new URLSearchParams(window.location.search);
    const uuid = urlParams.get('product-id');

    const response = await fetch(`${window.location.origin}/api/v1/vehicles?token=9fd4e0080bc6edc9f3c3853b5b1b6ecf&id=${uuid}`)

    const product = await response.json();


    $title.textContent = product?.product?.nombre
    $price.textContent = product?.product.precio.toLocaleString("en-US", {
        style: 'currency',
        currency: 'USD'
    })

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

    const $basketBtn = document.querySelector("#basket")

    $basketBtn.addEventListener("click", e => {

        const ultimosProductos = JSON.parse(localStorage.getItem("basket")) || []
        const newProduct = { ...product.product, images: product.vehicleImages || [] }

        const yaExiste = ultimosProductos.find(product => product.product_id === newProduct.product_id)

        if (!yaExiste) {
            localStorage.setItem("basket", JSON.stringify([...ultimosProductos, newProduct]))
            basketScript()
        }
    })


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




loadProduct()