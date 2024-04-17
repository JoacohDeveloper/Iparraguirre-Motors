const errores_div = document.querySelector(".errores");


const form_register = document.querySelector("#f_register")
if(form_register){
    form_register.addEventListener("submit", e => {
        errores_div.innerHTML = null;
        const fullname = e.target[0].value;
        const username = e.target[1].value;
        const email = e.target[2].value;
        const pass = e.target[3].value;
        const rePass = e.target[4].value;
        const errores = [];
    
        if(fullname.length <= 2){
            errores.push("<div class='error'>Debes ingresar tu nombre completo.</div>");
        } else if(username.length == 0){
            errores.push("<div class='error'>Debes ingresar un usuario.</div>");
        } else if (username.length <= 4) {
            errores.push("<div class='error'>Debes ingresar un usuario mayor a 4 caracteres.</div>");
        } else if (email.length == 0) {
            errores.push("<div class='error'>Debes ingresar un email.</div>");
        } else if (pass.length == 0){
            errores.push("<div class='error'>Debes ingresar una contraseña.</div>");
        } else if (pass.length <= 3 || rePass.length <= 3){
            errores.push("<div class='error'>La contraseña debe tener minimo 4 caracteres.</div>");
        } else if (pass != rePass){
            errores.push("<div class='error'>Las contraseñas no son iguales.</div>");
        }
        if(errores.length != 0){
            e.preventDefault()
            errores.forEach(error => 
                (errores_div.innerHTML += error))
        }
    })
}



const form_login = document.querySelector("#f_login")
if (form_login){
    form_login.addEventListener("submit", e => {
        errores_div.innerHTML = null;
        const dato = e.target[0].value; //Dato puede ser username o email
        const pass = e.target[1].value;
        const errores = [];
    
        if(dato.length == 0){
            errores.push("<div class='error'>Debes ingresar un usuario o correo electronico.</div>");
        } else if(username.length <= 4){
            errores.push("<div class='error'>Debes ingresar un usuario o correo electronico valido.</div>");
        } else if (pass.length == 0){
            errores.push("<div class='error'>Debes ingresar una contraseña.</div>");
        } else if (pass.length <= 3){
            errores.push("<div class='error'>Debes ingresar una contraseña valida.</div>");
        }
        if(errores.length != 0){
            e.preventDefault()
            errores.forEach(error => 
                (errores_div.innerHTML += error))
        }
    })
}