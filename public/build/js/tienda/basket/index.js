


const checkoutBtn = document.querySelector(".checkout-total");

const subTotal = document.querySelector(".subtotal");

checkoutBtn.addEventListener("click", () => {
    subTotal.classList.toggle("hidden")
})

function createSubtotalItem({ quantity, title, price }) {
    const subtotalItem = document.createElement('div');
    subtotalItem.classList.add('subtotal-item');

    const qtyElement = document.createElement('p');
    qtyElement.classList.add('qty');
    qtyElement.innerHTML = `x <span>${quantity}</span>`;

    const titleElement = document.createElement('p');
    titleElement.classList.add('prod-title');
    titleElement.textContent = title;

    const priceElement = document.createElement('p');
    priceElement.classList.add('prod-price');
    priceElement.innerHTML = `${(Number(price * quantity)).toLocaleString("es-UY", {
        currency: "USD",
        style: "currency"
    })}`;

    subtotalItem.appendChild(qtyElement);
    subtotalItem.appendChild(titleElement);
    subtotalItem.appendChild(priceElement);

    return subtotalItem;
}

function createCartItem({
    prod_info,
    imageUrl,
    title,
    category,
    price,
    qty = 1,
    minQty = 1,
    maxQty = 5,
    onRemove
}) {

    const cartItem = document.createElement('div');
    cartItem.classList.add('cart-item');

    const itemImage = document.createElement('div');
    itemImage.classList.add('item-image');
    const img = document.createElement('img');
    img.src = imageUrl || '/build/src/images/Refractions/default.jpg';
    img.alt = '';
    itemImage.appendChild(img);

    const itemInformation = document.createElement('div');
    itemInformation.classList.add('item-information');

    const itemInformationText = document.createElement('div');
    itemInformationText.classList.add('item-information-text');
    const titleElement = document.createElement('p');
    titleElement.classList.add('item-title');
    titleElement.textContent = title;
    const categoryElement = document.createElement('p');
    categoryElement.classList.add('item-category');
    categoryElement.textContent = category;
    itemInformationText.appendChild(titleElement);
    itemInformationText.appendChild(categoryElement);

    const itemActions = document.createElement('div');
    itemActions.classList.add('item-actions');
    const removeItem = document.createElement('div');
    removeItem.classList.add('remove-item');
    const removeIcon = document.createElement('img');
    removeIcon.src = '/build/src/images/trash.svg';
    removeIcon.alt = '';
    const removeText = document.createElement('p');
    removeText.textContent = 'Eliminar del carrito';
    removeItem.appendChild(removeIcon);
    removeItem.appendChild(removeText);

    if (onRemove) {
        removeItem.addEventListener('click', onRemove);
    }

    itemActions.appendChild(removeItem);
    itemInformation.appendChild(itemInformationText);
    itemInformation.appendChild(itemActions);

    const itemPrice = document.createElement('div');
    itemPrice.classList.add('item-price');

    const itemQty = document.createElement('div');
    itemQty.classList.add('item-qty');
    const label = document.createElement('label');
    label.htmlFor = 'qty';
    label.textContent = 'Amount';
    const input = document.createElement('input');
    input.addEventListener("input", e => {
        const reg = /^[1-5]$/;

        if (!reg.test(Number(e?.target.value)))
            e.target.value = 1

        qty = e.target.value
        priceElement.textContent = `${(Number(price * qty)).toLocaleString("es-UY", {
            currency: "USD",
            style: "currency"
        })}`;
        reloadSubTotal()

        const localStorageProducts = JSON.parse(localStorage.getItem("basket")) || []

        const productIndex = localStorageProducts.findIndex(product => {
            return product?.product_id == prod_info?.product_id && product?.forUser == prod_info?.user_uuid
        })

        if (productIndex !== -1) {
            // Actualiza el stock del producto
            localStorageProducts[productIndex].stock = qty;

            // Guarda el arreglo actualizado en localStorage
            localStorage.setItem("basket", JSON.stringify(localStorageProducts));
        } else {
            console.warn("Producto no encontrado en el carrito.");
        }


    })
    input.type = 'number';
    input.id = 'qty';
    input.min = minQty;
    input.max = maxQty;
    input.value = qty;
    itemQty.appendChild(label);
    itemQty.appendChild(input);

    const itemValue = document.createElement('div');
    itemValue.classList.add('item-value');
    const priceElement = document.createElement('p');
    priceElement.textContent = `${(Number(price * qty)).toLocaleString("es-UY", {
        currency: "USD",
        style: "currency"
    })}`;
    itemValue.appendChild(priceElement);

    itemPrice.appendChild(itemQty);
    itemPrice.appendChild(itemValue);

    cartItem.appendChild(itemImage);
    cartItem.appendChild(itemInformation);
    cartItem.appendChild(itemPrice);

    return cartItem;
}

async function getProducts() {
    const response = await fetch(`${location.origin}/auth/session_user`)
    const data = await response.json();

    const productsGeneral = JSON.parse(localStorage.getItem("basket")) || [];

    const products = productsGeneral.filter(product => {
        return product?.forUser == data?.session_uuid;
    })



    if (products.length == 0) {
        const basketContainer = document.querySelector(".basket-container")

        basketContainer.innerHTML = null;

        const noProducts = document.createElement("p")
        const link = document.createElement("a")

        const contenedor = document.createElement("div")
        contenedor.classList.add("no-products")
        noProducts.textContent = "No hay productos aún."
        link.textContent = "¡Busca productos para llenar el carrito!"
        link.href = `${location.origin}/catalogo/refraction`
        contenedor.appendChild(noProducts)
        contenedor.appendChild(link)

        basketContainer.appendChild(contenedor)
    } else {


        const cartItems = document.querySelector(".cart-items")
        cartItems.innerHTML = null;
        const subtotalItems = document.querySelector(".subtotal")
        const totalPricing = document.querySelector(".total-pricing")

        const totalPrice = products.reduce((acc, product) => {
            return acc += product?.precio * product?.stock
        }, 0)

        totalPricing.textContent = `${(totalPrice).toLocaleString("es-UY", {
            currency: "USD",
            style: "currency"
        })}`;

        products.forEach(product => {
            const onRemove = () => {

                const existe = products.find(prod => prod.product_id === product?.product_id && product.forUser === data?.session_uuid)

                if (existe) {
                    const newProducts = products.filter(product => product.product_id !== existe?.product_id);
                    localStorage.setItem("basket", JSON.stringify(newProducts));
                    getProducts();
                    return basketScript()
                }
            }
            cartItems.appendChild(createCartItem(
                {
                    prod_info: { user_uuid: data?.session_uuid, product_id: product?.product_id },
                    imageUrl: product?.images[0]?.url,
                    title: product?.nombre,
                    category: product?.categoria,
                    price: product?.precio,
                    qty: product?.stock,
                    onRemove
                }
            ))
            subtotalItems.appendChild(createSubtotalItem({
                price: product?.precio,
                quantity: product?.stock,
                title: product?.nombre
            }))
        })




    }
}

getProducts();

async function reloadSubTotal() {
    const response = await fetch(`${location.origin}/auth/session_user`)
    const data = await response.json();

    const productsGeneral = JSON.parse(localStorage.getItem("basket")) || [];

    const products = productsGeneral.filter(product => {
        return product?.forUser == data?.session_uuid;
    })

    const subtotalItems = document.querySelector(".subtotal")
    subtotalItems.innerHTML = null
    const totalPricing = document.querySelector(".total-pricing")

    const totalPrice = products.reduce((acc, product) => {
        return acc += product?.precio * product?.stock
    }, 0)

    totalPricing.textContent = `${(totalPrice).toLocaleString("es-UY", {
        currency: "USD",
        style: "currency"
    })}`;

    products.forEach(product => {
        subtotalItems.appendChild(createSubtotalItem({
            price: product?.precio,
            quantity: product?.stock,
            title: product?.nombre
        }))
    })
}