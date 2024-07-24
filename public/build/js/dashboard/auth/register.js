const formularioRegister = document.querySelector("#regForm")

formularioRegister.addEventListener("submit", async e => {

    e.preventDefault();

    const fullname = e.target[0].value;
    const username = e.target[1].value;
    const email = e.target[2].value;
    const pass = e.target[3].value;
    const rePass = e.target[4].value;
    const errores = [];
    const nameRegex = /^[a-zA-Zà-úÀ-Ú]{2,}( [a-zA-Zà-úÀ-Ú]+)+$/;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (fullname.length <= 2) {
        errores.push("Debes ingresar tu nombre completo.");
    }  else if (!nameRegex.test(fullname)) {
        errores.push("Debes ingresar nombre y apellido.");
    } else if (username.length == 0) {
        errores.push("Debes ingresar un usuario.");
    } else if (username.length <= 4) {
        errores.push("Debes ingresar un usuario mayor a 4 caracteres.");
    } else if (email.length == 0) {
        errores.push("Debes ingresar un email.");
    } else if (!emailRegex.test(email)) {
        errores.push("Formato de email inválido.");
    } else if (pass.length == 0) {
        errores.push("Debes ingresar una contraseña.");
    } else if (pass.length <= 3 || rePass.length <= 3) {
        errores.push("La contraseña debe tener minimo 4 caracteres.");
    } else if (pass != rePass) {
        errores.push("Las contraseñas no son iguales.");
    }

    if (errores.length != 0) {
        e.preventDefault()
        const errors = errores.map(err => {
            const error = document.createElement("div");
            error.classList.add("error")
            error.textContent = err

            return { title: "Fail", error: err }
        })

        addToast(errors)

    } else {
        const spinner = document.createElement("div")
        spinner.classList.add("linear-loading") // o spinner
        const loaderSection = document.querySelector(".loader")
        loaderSection?.appendChild(spinner);
        const form_data = new FormData(e.target);


        try {
            const response = await fetch("http://localhost:3000/dashboard/register", {
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
                window.location.href = "/dashboard"
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