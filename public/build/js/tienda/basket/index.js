


const checkoutBtn = document.querySelector(".checkout-total");

const subTotal = document.querySelector(".subtotal");

checkoutBtn.addEventListener("click", () => {
    subTotal.classList.toggle("hidden")
})

