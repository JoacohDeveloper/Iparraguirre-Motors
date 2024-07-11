

const cards = document.querySelectorAll(".dropDown-card");



cards.forEach(card => {
    const btn = card.querySelector("button")
    btn.addEventListener("click", e => {
        btn.classList.toggle("twist")
        const content = card.querySelector(".content")
        content.classList.toggle("visible")
    })
}
)