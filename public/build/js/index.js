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


// Carrito
const ProductBasket = ({ product }) => {
    const { nombre, precio, stock, images, product_id } = product;

    const li = document.createElement('li');

    const divImage = document.createElement('div');
    divImage.classList.add('basket-product-image');

    const imgProduct = document.createElement('img');


    if (images.length == 0) {
        imgProduct.src = '/build/src/images/vehicles/default.jpg';
        imgProduct.alt = 'default';
    } else {
        const img = "/build/" + images[0]?.url.split("/build/")[1]
        imgProduct.src = img;
        imgProduct.alt = images[0]?.alt;
    }

    divImage.appendChild(imgProduct);

    const divInfo = document.createElement('div');
    divInfo.classList.add('basket-product-info');

    const divRow1 = document.createElement('div');
    divRow1.classList.add('flex-row');

    const pNombre = document.createElement('p');
    pNombre.classList.add('nombre', 'crop');
    pNombre.textContent = nombre || "producto";

    const divDelete = document.createElement('div');
    divDelete.classList.add('delete');

    const imgDelete = document.createElement('img');

    imgDelete.src = '/build/src/images/trash.svg';
    imgDelete.alt = '';

    divDelete.appendChild(imgDelete);

    divDelete.addEventListener("click", async e => {
        const products = JSON.parse(localStorage.getItem("basket")) || []
        const response = await fetch(`${location.origin}/auth/session_user`)
        const data = await response.json();
        const existe = products.find(product => product.product_id === product_id && product.forUser === data?.session_uuid)

        if (existe) {
            const newProducts = products.filter(product => product.product_id !== existe?.product_id);
            localStorage.setItem("basket", JSON.stringify(newProducts));

            return basketScript()
        }
    })

    divRow1.appendChild(pNombre);
    divRow1.appendChild(divDelete);

    const divRow2 = document.createElement('div');
    divRow2.classList.add('flex-row', 'py-3');

    const pCantidad = document.createElement('p');
    pCantidad.classList.add('cantidad');
    pCantidad.innerHTML = `${stock} <span>x</span>`;

    const pPrecio = document.createElement('p');
    pPrecio.classList.add('precio');
    pPrecio.textContent = precio?.toLocaleString("en-US", {
        style: "currency",
        currency: "USD"
    });

    divRow2.appendChild(pCantidad);
    divRow2.appendChild(pPrecio);

    divInfo.appendChild(divRow1);
    divInfo.appendChild(divRow2);

    li.appendChild(divImage);
    li.appendChild(divInfo);

    return li
}

async function basketScript() {
    const response = await fetch(`${location.origin}/auth/session_user`)
    const data = await response.json();

    const productsGeneral = JSON.parse(localStorage.getItem("basket")) || [];

    const products = productsGeneral.filter(product => {
        return product?.forUser == data?.session_uuid;
    })

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