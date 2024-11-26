const cards = document.querySelectorAll(".dropDown_card");

cards.forEach(card => {
    const btn = card.querySelector("button");
    btn.addEventListener("click", e => {
        cards.forEach(c => {
            const otherContent = c.querySelector(".dropDown_card-content");
            const otherBtn = c.querySelector("button");
            if (otherBtn !== btn) {
                otherContent.classList.remove("visible");
                otherBtn.classList.remove("twist");
            }
        });

        const content = card.querySelector(".dropDown_card-content");
        btn.classList.toggle("twist");
        content.classList.toggle("visible");
    });
});