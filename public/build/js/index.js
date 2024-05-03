

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
            } else {
                home_vid.classList.remove("banner_stopFixed")
                home_vid.classList.add("fixed")
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
    })
})