const aside = document.querySelector(".aside")

if (aside)
    aside.addEventListener("click", e => {
        const viewMoreBtn = aside.querySelector(".more-information")

        // console.log(e)
        if (e.target == viewMoreBtn || e.target.parentElement == viewMoreBtn) {
            aside.classList.toggle("stretch")
            // document.body.classList.toggle("fixed")
        }
    })


const account = document.querySelector(".account")
const notifications = document.querySelector(".notifications")

const subdropDownNotifications = document.querySelector(".notifications-dropdown")

const subdropDownAccount = document.querySelector(".account-dropdown")


if (account) {
    document.body.addEventListener("click", e => {
        if (e?.target == account || e?.target.parentElement == account) {
            const last = document.querySelector("visible")
            if (last) last.classList.remove("visible")
            subdropDownAccount?.classList?.add("visible")

        } else {
            subdropDownAccount?.classList?.remove("visible")
        }

        if (notifications) {
            if (e?.target == notifications || e?.target.parentElement == notifications) {
                const last = document.querySelector("visible")
                if (last) last.classList.remove("visible")
                subdropDownNotifications?.classList?.add("visible")

            } else {
                subdropDownNotifications?.classList?.remove("visible")
            }
        }
    })


}


//chart



const chart1 = document.getElementById("chart1");

if(chart1) {
    chart1.style.height = '100%';
chart1.style.width = '100%';
chart1.parentElement.style.position = "relative";

let typeChart = window.screen.width >= 1024 ? "line" : "bar"



new Chart(chart1, {
    type: typeChart,
    data: {
        labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio"],
        datasets: [
            {
                label: "Personas ingresadas en meses",
                data: [1000, 452, 2000743, 5, 2, 3],
                borderWidth: 1,
            },
            {
                label: "Personas que compraron en meses",
                data: [70, 2, 10, 5, 2, 3],
                borderWidth: 1,
            },
        ],
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
            },
        },
    },
});


const chart2 = document.getElementById("chart2");
chart2.style.height = '100%';
chart2.style.width = '100%';
chart2.parentElement.style.position = "relative";


new Chart(chart2, {
    type: "doughnut",
    data: {
        labels: ["Escritorio", "Movil", "Otros"],
        datasets: [
            {
                label: "Distribucion de dispositivos",
                data: [48, 36, 16],
                borderWidth: 1,
            }
        ],
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
            },
        },
    },
});


const chart3 = document.getElementById("chart3");
chart3.style.height = '100%';
chart3.style.width = '100%';
chart3.parentElement.style.position = "relative";


new Chart(chart3, {
    type: "bar",
    data: {
        labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio"],
        datasets: [
            {
                label: "Usuarios Registrados",
                data: [1000, 452, 20, 5, 2, 3],
                borderWidth: 1,
            }
        ],
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
            },
        },
    },
});
}



// Aside Ddl



const dropDownLists = document.querySelectorAll(".dropDown-list")



dropDownLists.forEach(ele => {
    ele.addEventListener("click", e => {
        const x = ele.querySelector(".dropDown-links")
        x.classList.toggle("dropDownNotDeployed")
       
        const data = JSON.parse(localStorage.getItem("ddl")) || []

        localStorage.setItem("ddl", JSON.stringify([...data, {element: ele.ariaLabel, deployed: !x.classList.contains("dropDownNotDeployed")}]))

    })
})