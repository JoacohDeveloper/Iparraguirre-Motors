

const form = document.querySelector("#f_login")
const errores = document.querySelector(".errores");
form.addEventListener("submit", e => {
    const email = e.target[2].value;
    const pass = e.target[3].value;
    const rePass = e.target[4].value;

    if (email.length == 0) {
        const htmlError = `<div class='error'>el campo email es obligatorio</div>`;
        errores.innerHTML += htmlError;
        e.preventDefault()
    }

    if (pass != rePass)
        e.preventDefault();




})