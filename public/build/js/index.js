const home_vid = document.querySelector("#bg_vid");

if (home_vid) {
    const btn = document.querySelector(".pause-button");

    btn.addEventListener("click", () => {
        const img = document.querySelector("#btn_img")
        const imgPath = img.currentSrc.split("/")

        const imgName = imgPath[imgPath.length - 1];


        if (imgName && imgName === "pause.svg") {
            img.src = img.currentSrc.replace(imgName, "play.svg")

            home_vid?.pause();
        } else if (imgName) {
            img.src = img.currentSrc.replace(imgName, "pause.svg")

            home_vid?.play();
        }

    })

    const arrow = document.querySelector(".down-arrow")
    let Yaxis = window.scrollY;
    const content = document.querySelector(".content");
    document.addEventListener("scroll", e => {
        Yaxis = window.scrollY;
        if (Yaxis > 0) {
            arrow.classList.add("disabled")
        }


    })

    if (Yaxis > 0) {
        arrow.classList.add("disabled")
    }

    arrow.addEventListener("click", () => {
        arrow.classList.add("disabled")
        content.scrollIntoView({ behavior: "smooth", block: "nearest" });

    })

    const banner = document.querySelector(".banner");
    const observer = new IntersectionObserver(items => {
        items.forEach(item => {
            if (!item.isIntersecting) {
                home_vid.classList.add("banner_stopFixed")
                home_vid.classList.remove("fixed")
                home_vid?.pause();
            } else {
                home_vid.classList.remove("banner_stopFixed")
                home_vid.classList.add("fixed")
                const img = document.querySelector("#btn_img")
                const imgPath = img.currentSrc.split("/")

                const imgName = imgPath[imgPath.length - 1];
                if (imgName && imgName == "pause.svg") {
                    home_vid?.play();
                }
            }
        })
    })

    observer.observe(banner);

    fetch(location.origin + "/api/v1/vehicles?token=9fd4e0080bc6edc9f3c3853b5b1b6ecf").then(response => response.json()).then(data => console.log(data))

}


//header

const brgMenu = document.querySelectorAll(".brgMenuHandler");
const mobileMenu = document.querySelector(".mobile-menu");

brgMenu.forEach(item => {
    item.addEventListener("click", () => {
        mobileMenu.classList.toggle("menu-disabled")
        document.body.classList.toggle("body-fixed")
        document.body.classList.toggle("blured")
    })
})


//loadtheme

const theme = JSON.parse(localStorage.getItem("theme"));
const themeToggler = document.querySelectorAll(".card__toggle")
const themeSwitcher = document.querySelectorAll("#themeSwitcher")

if (theme) {
    if (theme == 'dark') {
        document.body.classList.remove("dark")
        themeSwitcher.forEach(el => el.checked = false)
    } else {
        document.body.classList.add("dark")
        themeSwitcher.forEach(el => el.checked = true)
    }
}

themeToggler.forEach(el => themeTogglerEvent(el))

function themeTogglerEvent(el) {
    el.addEventListener("click", e => {
        if (!e?.target?.checked) {
            localStorage.setItem("theme", JSON.stringify('dark'))
            document.body.classList.remove("dark")
            themeSwitcher.forEach(el => el.checked = false)
        } else {
            localStorage.setItem("theme", JSON.stringify('light'))
            document.body.classList.add("dark")
            themeSwitcher.forEach(el => el.checked = true)
        }
    })
}



const refreshToasts = (newToast) => {
    const toastAll = document.querySelectorAll(".toast")
    // const toast = toastAll[toastAll.length - 1]

    // console.log(toast)
    // const progress = toast.querySelector(".progress")

    // setTimeout(() => {
    //     toast.remove();
    // }, 5000);

    // setTimeout(() => {
    //     progress.remove();
    // }, 5300);

    toastAll.forEach(toast => {

        const progress = toast.querySelector(".progress")

        setTimeout(() => {
            toast.remove();
        }, 5000);

        setTimeout(() => {
            progress.remove();
        }, 5300);

        toast.querySelector(".close").addEventListener("click", e => {
            setTimeout(() => {
                toast.querySelector(".progress").remove();
            }, 300);

            toast.remove();
        })
    })

}

const addToast = (errors) => {
    const toasts = document.querySelector(".toasts");
    toasts.innerHTML = "";

    errors.forEach(error => {
        const toastHTML = `
    <div class="toast active">
        <div class="toast-content">
            <i class="fas fa-solid fa-check check"></i>

            <div class="message">
                <span class="text text-1">${error.title}</span>
                <span class="text text-2">${error.error}</span>
            </div>
        </div>
        <button class="fa-solid fa-xmark close">x</button>

        <div class="progress active"></div>
    </div>`

        toasts.innerHTML += toastHTML
    })


    const newToast = toasts.childNodes[toasts.childNodes.length - 1]

    refreshToasts(newToast)
}

//Nav dropdown
const dropdown = document.querySelector('.dropdown');
const dropdownContent = document.querySelector('.dropdown-content');

if (dropdown) {
    dropdown.addEventListener('click', function (event) {
        event.preventDefault();
        if (dropdownContent.classList.contains('show')) {
            dropdownContent.classList.remove('show');
        } else {
            dropdownContent.classList.add('show');
        }
    });

    dropdownContent.addEventListener('click', function (event) {
        event.stopPropagation();
    });
    const dropdownLinks = document.querySelectorAll('.dropdown-content > a');
    dropdownLinks.forEach(link => {
        link.style.color = 'black';
    });
}



// BASKET


const ProductBasket = ({ product }) => {
    // Crear el <li> principal
    console.log(product)
    const { nombre, precio, stock, images, product_id } = product;

    const li = document.createElement('li');

    // Crear el div para la imagen del producto
    const divImage = document.createElement('div');
    divImage.classList.add('basket-product-image');

    // Crear el elemento img dentro del div de la imagen
    const imgProduct = document.createElement('img');


    if (images.length == 0) {
        imgProduct.src = '/build/src/images/vehicles/default.jpg';
        imgProduct.alt = 'default';
    } else {
        const img = "/build/" + images[0]?.url.split("/build/")[1]
        imgProduct.src = img;
        imgProduct.alt = images[0]?.alt;
    }

    // Añadir la imagen al div de la imagen
    divImage.appendChild(imgProduct);

    // Crear el div para la información del producto
    const divInfo = document.createElement('div');
    divInfo.classList.add('basket-product-info');

    // Crear el div de la fila (flex-row)
    const divRow1 = document.createElement('div');
    divRow1.classList.add('flex-row');

    // Crear el párrafo con la clase nombre
    const pNombre = document.createElement('p');
    pNombre.classList.add('nombre', 'crop');
    pNombre.textContent = nombre || "producto";

    // Crear el div para la imagen del delete
    const divDelete = document.createElement('div');
    divDelete.classList.add('delete');

    // Crear el elemento img del delete
    const imgDelete = document.createElement('img');


    imgDelete.src = '/build/src/images/trash.svg';
    imgDelete.alt = '';

    // Añadir la imagen del delete al div delete
    divDelete.appendChild(imgDelete);

    divDelete.addEventListener("click", e => {
        const products = JSON.parse(localStorage.getItem("basket")) || []

        const existe = products.find(product => product.product_id === product_id)

        if (existe) {
            const newProducts = products.filter(product => product.product_id !== existe?.product_id);
            localStorage.setItem("basket", JSON.stringify(newProducts));

            return basketScript()
        }
    })
    // Añadir el párrafo del nombre y el delete a la primera fila
    divRow1.appendChild(pNombre);
    divRow1.appendChild(divDelete);

    // Crear el segundo div de la fila (flex-row py-3)
    const divRow2 = document.createElement('div');
    divRow2.classList.add('flex-row', 'py-3');

    // Crear el párrafo para la cantidad
    const pCantidad = document.createElement('p');
    pCantidad.classList.add('cantidad');
    pCantidad.innerHTML = `${stock} <span>x</span>`;

    // Crear el párrafo para el precio
    const pPrecio = document.createElement('p');
    pPrecio.classList.add('precio');
    pPrecio.textContent = precio?.toLocaleString("en-US", {
        style: "currency",
        currency: "USD"
    });

    // Añadir cantidad y precio al div de la segunda fila
    divRow2.appendChild(pCantidad);
    divRow2.appendChild(pPrecio);

    // Añadir ambas filas al div de información del producto
    divInfo.appendChild(divRow1);
    divInfo.appendChild(divRow2);

    // Añadir la imagen y la información del producto al <li>
    li.appendChild(divImage);
    li.appendChild(divInfo);

    return li
}


function basketScript() {
    const products = JSON.parse(localStorage.getItem("basket")) || [];
    const $basket = document.querySelector(".basket")

    const $productContainer = document.querySelector("#basket-products-container")

    if ($productContainer) $productContainer.innerHTML = null;

    const $productsQty = document.getElementById("qty")
    if (products.length > 0) {
        $basket.classList.remove("empty")
        products.forEach(product => {
            $productContainer.appendChild(ProductBasket({ product }))
        })


    } else {
        $basket.classList.add("empty")
    }
    if (products.length > 9) {
        $productsQty.innerHTML = "+9"
    } else {
        $productsQty.innerHTML = products.length
    }




}




const $basket = document.querySelector(".basket")
if ($basket) {
    basketScript();
}