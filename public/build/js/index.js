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


    fetch("http://localhost:3000/api/v1/vehicles?token=9fd4e0080bc6edc9f3c3853b5b1b6ecf").then(response => response.json()).then(data => console.log(data))

}


//header

const brgMenu = document.querySelectorAll(".brgMenuHandler");
const mobileMenu = document.querySelector(".mobile-menu");

brgMenu.forEach(item => {
    item.addEventListener("click", () => {
        mobileMenu.classList.toggle("menu-disabled")
        document.body.classList.toggle("body-fixed")
    })
})


//loadtheme

const theme = JSON.parse(localStorage.getItem("theme"));
const themeToggler = document.querySelectorAll(".card__toggle")
const themeSwitcher = document.querySelectorAll("#themeSwitcher")

if (theme) {
    if (theme == 'dark') {
        document.body.classList.add("dark")
        themeSwitcher.forEach(el => el.checked = false)
    } else {
        document.body.classList.remove("dark")
        themeSwitcher.forEach(el => el.checked = true)
    }
}

themeToggler.forEach(el => themeTogglerEvent(el))

function themeTogglerEvent(el) {
    el.addEventListener("click", e => {
        if (!e?.target?.checked) {
            localStorage.setItem("theme", JSON.stringify('dark'))
            document.body.classList.add("dark")
            themeSwitcher.forEach(el => el.checked = false)
        } else {
            localStorage.setItem("theme", JSON.stringify('light'))
            document.body.classList.remove("dark")
            themeSwitcher.forEach(el => el.checked = true)
        }
    })
}