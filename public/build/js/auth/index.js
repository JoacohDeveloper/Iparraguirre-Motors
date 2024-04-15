

const form = document.querySelector("#f_login")

form.addEventListener("submit", e => {
    const pass = e.target[3].value;
    const rePass = e.target[4].value;

    if (pass != rePass)
        e.preventDefault();



})