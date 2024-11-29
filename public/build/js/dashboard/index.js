const aside = document.querySelector(".aside")

if (aside) {
    aside.addEventListener("click", e => {
        const viewMoreBtn = aside.querySelector(".more-information")

        if (e.target == viewMoreBtn || e.target.parentElement == viewMoreBtn) {
            aside.classList.toggle("stretch")
        }
    })

    const data = JSON.parse(localStorage.getItem("ddl")) || []

    const ddls = document.querySelectorAll(".dropDown-list")


    ddls.forEach(ddl => {
        const lsDdl = data.find(el => el?.element == ddl.ariaLabel)

        if (lsDdl) {
            const links = ddl.querySelector(".dropDown-links")

            if (!lsDdl?.isDeployed) {
                links.classList.add("dropDownNotDeployed")
            } else {
                links.classList.remove("dropDownNotDeployed")
            }

        }
    })


    const links = document.querySelectorAll(".dropDown-links")
    const asideElements = document.querySelectorAll(".aside-element")
    asideElements.forEach(el => {
        el.addEventListener("click", e => {

            if (!el.classList.contains("more-information")) aside.classList.add("stretch")

        })
    })
    links.forEach(link => {


        if (!link.classList.contains("dropDownNotDeployed")) {
            aside.classList.add("stretch")
        }
    })
}




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

if (chart1) {
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
                    data: [193, 73, 311, 143, 201, 177],
                    borderWidth: 1,
                },
                {
                    label: "Personas que compraron en meses",
                    data: [87, 109, 136, 123, 168, 182],
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
                    data: [56, 23, 140, 85, 97, 73],
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


        const ls = JSON.parse(localStorage.getItem("ddl")) || []

        const ddlObject = {
            element: ele.ariaLabel,
            isDeployed: !x.classList.contains("dropDownNotDeployed")
        };


        const ddlsModificado = ls.map(ddl => {
            if (ddl.element === ddlObject.element) {
                return ddlObject;
            } else {
                return ddl;
            }
        });


        if (!ls.some(ddl => ddl.element === ddlObject.element)) {

            const newData = [...ddlsModificado, ddlObject]
            localStorage.setItem("ddl", JSON.stringify(newData));
        } else {
            localStorage.setItem("ddl", JSON.stringify(ddlsModificado));
        }






    })
})

document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('.toggle-dropdown');

    toggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const dropdown = this.nextElementSibling;
            if (dropdown && dropdown.tagName === 'UL') {
                if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                    dropdown.style.display = 'block';
                } else {
                    dropdown.style.display = 'none';
                }
            }
        });
    });
});