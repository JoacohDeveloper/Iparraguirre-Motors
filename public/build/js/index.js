

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
    const Yaxis = window.scrollY;
    const content = document.querySelector(".content");
    if (Yaxis == 0) {
        document.addEventListener("scroll", e => {

            if (Yaxis > 0) {
                arrow.classList.add("disabled")
            }
        })
    } else {
        arrow.classList.add("disabled")
    }

    arrow.addEventListener("click", () => {
        arrow.classList.add("disabled")
        content.scrollIntoView({ behavior: "smooth", block: "nearest" });

    })

}