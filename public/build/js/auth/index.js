const errores_div = document.querySelector(".errores");


const form_register = document.querySelector("#f_register")
if (form_register) {
    form_register.addEventListener("submit", e => {
        errores_div.innerHTML = null;
        const fullname = e.target[0].value;
        const username = e.target[1].value;
        const email = e.target[2].value;
        const pass = e.target[3].value;
        const rePass = e.target[4].value;
        const errores = [];


    })
}



const form_login = document.querySelector("#f_login")
if (form_login) {
    form_login.addEventListener("submit", e => {
        errores_div.innerHTML = null;
        if (errores.length != 0) {
            e.preventDefault()
            errores.forEach(error =>
                (errores_div.innerHTML += error))
        }
    })
}