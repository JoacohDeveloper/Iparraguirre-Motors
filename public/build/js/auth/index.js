const formularioLogin = document.querySelector("#loginForm")

formularioLogin.addEventListener("submit", async (e) => {
    e.preventDefault();
    const log_dato = e.target[0].value; // Dato puede ser username o email
    const log_pass = e.target[1].value;
    const errores = [];
    const datoRegex = /^[^\s]{4,}$/;

    if (log_dato.length == 0) {
        errores.push("Debes ingresar un usuario o correo electrónico.");
    } else if (!datoRegex.test(log_dato)) {
        errores.push("El usuario o correo electrónico debe tener al menos 4 caracteres y no contener espacios.");
    }
    if (log_pass.length == 0) {
        errores.push("Debes ingresar una contraseña.");
    }

    if (errores.length != 0) {
        const firstError = errores[0];
        const error = document.createElement("div");
        error.classList.add("error");
        error.textContent = firstError;
        addToast([{ title: "Failure", error: firstError }]);
    } else {
        const spinner = document.createElement("div")
        spinner.classList.add("linear-loading") // o spinner
        const loaderSection = document.querySelector(".loader")
        loaderSection?.appendChild(spinner);
        const form_data = new FormData(e.target);
        try {
            const response = await fetch(location.origin + "/auth/login", {
                method: "POST",
                body: form_data
            })
            const data = await response.json()
            console.log(data)
            if (data?.errores) {
                const errors = Object?.values(data?.errores).map(err => {
                    const error = document.createElement("div");
                    error.classList.add("error")
                    error.textContent = err
                    return { title: "Failure", error: err }
                })
                addToast(errors);
            } else if (data?.message == "succesfuly") {
                console.log(data)
                window.location.href = "/"
            }
        } catch (error) {
            addToast([{ title: "Failure", error: "Ocurrió un error, intenta de nuevo más tarde." }]);
        } finally {
            const spinner2 = loaderSection?.querySelector(".linear-loading")
            spinner2?.remove()
        }
    }
})

const formularioRegister = document.querySelector("#regForm")

formularioRegister.addEventListener("submit", async e => {
    e.preventDefault();
    const reg_fullname = e.target[0].value;
    const reg_username = e.target[1].value;
    const reg_email = e.target[2].value;
    const reg_phone = e.target[3].value;
    const reg_pass = e.target[4].value;
    const reg_rePass = e.target[5].value;
    const errores = [];

    const nameRegex = /^[a-zA-Zà-úÀ-Ú]{2,}( [a-zA-Zà-úÀ-Ú]+)+$/;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const phoneRegex = /^[0-9]{9}$/;
    const passwordRegex = /^[^\s]{4,}$/;

    const fields = [
        { value: reg_fullname, regex: nameRegex, error: "Debes ingresar nombre y apellido." },
        { value: reg_username, regex: /.{5,}/, error: "Debes ingresar un usuario mayor a 4 caracteres." },
        { value: reg_email, regex: emailRegex, error: "Formato de email inválido." },
        { value: reg_phone, regex: phoneRegex, error: "Debes ingresar un número de celular válido." },
        { value: reg_pass, regex: passwordRegex, error: "La contraseña debe tener mínimo 4 caracteres y no contener espacios." }
    ];

    fields.forEach(field => {
        if (!field.regex.test(field.value)) {
            errores.push(field.error);
        }
    });

    if (reg_fullname.length <= 2) {
        errores.push("Debes ingresar tu nombre completo.");
    }
    if (reg_username.length == 0) {
        errores.push("Debes ingresar un usuario.");
    }
    if (reg_email.length == 0) {
        errores.push("Debes ingresar un email.");
    }
    if (reg_phone.length == 0) {
        errores.push("Debes ingresar un número de celular.");
    }
    if (reg_pass.length == 0) {
        errores.push("Debes ingresar una contraseña.");
    }
    if (reg_pass != reg_rePass) {
        errores.push("Las contraseñas no son iguales.");
    }

    if (errores.length != 0) {
        e.preventDefault();
        const firstError = errores[0];
        const error = document.createElement("div");
        error.classList.add("error");
        error.textContent = firstError;
        addToast([{ title: "Fail", error: firstError }]);
    } else {
        const spinner = document.createElement("div")
        spinner.classList.add("linear-loading") // o spinner
        const loaderSection = document.querySelector(".loader")
        loaderSection?.appendChild(spinner);
        const form_data = new FormData(e.target);
        try {
            const response = await fetch(location.origin + "/auth/register", {
                method: "POST",
                body: form_data
            })
            const data = await response.json()
            console.log(response)
            console.log(data)
            if (data?.errores) {
                const errors = Object?.values(data?.errores).map(err => {
                    const error = document.createElement("div");
                    error.classList.add("error")
                    error.textContent = err
                    return { title: "Failure", error: err }
                })
                addToast(errors);
            } else if (data?.message == "succesfuly") {
                window.location.href = "/"
            }
        } catch (error) {
            console.log(error)
            addToast([{ title: "Failure", error: "Ocurrió un error, intenta de nuevo más tarde." }]);
        } finally {
            const spinner2 = loaderSection?.querySelector(".linear-loading")
            spinner2?.remove()
        }
    }
})


//Se ejecutan las funciones
document.getElementById("btn__iniciar-sesion").addEventListener("click", iniciarSesion);
document.getElementById("btn__registrarse").addEventListener("click", register);
window.addEventListener("resize", anchoPage);

//Se declaran las variables
var contenedor_login_register = document.querySelector(".contenedor__login-register");
var caja_trasera_login = document.querySelector(".caja__trasera-login");
var caja_trasera_register = document.querySelector(".caja__trasera-register");

    //FUNCIONES

function anchoPage(){

    if (window.innerWidth > 850){
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "block";
    }else{
        caja_trasera_register.style.display = "block";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.display = "none";
        formularioLogin.style.display = "flex";
        contenedor_login_register.style.left = "0px";
        formularioRegister.style.display = "none";   
    }
}

anchoPage();


    function iniciarSesion(){
        if (window.innerWidth > 850){
            formularioLogin.style.display = "flex";
            contenedor_login_register.style.left = "60px";
            formularioRegister.style.display = "none";
            caja_trasera_register.style.opacity = "1";
            caja_trasera_login.style.opacity = "0";
        }else{
            formularioLogin.style.display = "flex";
            contenedor_login_register.style.left = "0px";
            formularioRegister.style.display = "none";
            caja_trasera_register.style.display = "block";
            caja_trasera_login.style.display = "none";
        }
    }

    function register(){
        if (window.innerWidth > 850){
            formularioRegister.style.display = "flex";
            contenedor_login_register.style.left = "525px";
            formularioLogin.style.display = "none";
            caja_trasera_register.style.opacity = "0";
            caja_trasera_login.style.opacity = "1";
        }else{
            formularioRegister.style.display = "flex";
            contenedor_login_register.style.left = "0px";
            formularioLogin.style.display = "none";
            caja_trasera_register.style.display = "none";
            caja_trasera_login.style.display = "block";
            caja_trasera_login.style.opacity = "1";
        }
}


const p_logIn = document.querySelector("#p_logIn")
const p_signUp = document.querySelector("#p_signUp")

p_signUp.addEventListener("click", mobileRegister);
p_logIn.addEventListener("click", mobileIniciarSesion);

function mobileIniciarSesion(){
    formularioLogin.style.display = "flex";
    formularioRegister.style.display = "none";
}

function mobileRegister(){
    formularioLogin.style.display = "none";
    formularioRegister.style.display = "flex";
}
