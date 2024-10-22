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

if(dropdown){
    dropdown.addEventListener('click', function(event) {
        event.preventDefault();
        if (dropdownContent.classList.contains('show')) {
            dropdownContent.classList.remove('show');
        } else {
            dropdownContent.classList.add('show');
        }
    });
    
    dropdownContent.addEventListener('click', function(event) {
        event.stopPropagation();
    });
    const dropdownLinks = document.querySelectorAll('.dropdown-content > a');
    dropdownLinks.forEach(link => {
      link.style.color = 'black';
    });
}

