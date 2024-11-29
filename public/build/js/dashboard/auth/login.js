const formularioLogin = document.querySelector("#loginForm")

formularioLogin.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dato = e.target[0].value; // Dato puede ser username o email
    const pass = e.target[1].value;
    const erroresClient = [];
    const datoRegex = /^[^\s]{4,}$/;

    if (!datoRegex.test(dato)) {
        erroresClient.push("El usuario o correo electrónico debe tener al menos 4 caracteres y no contener espacios.");
    }
    if (pass.length == 0) {
        erroresClient.push("Debes ingresar una contraseña.");
    }

    const errores = document.querySelector(".errores");
    errores.innerHTML = null;

    if (erroresClient.length != 0) {
        const firstError = erroresClient[0];
        const error = document.createElement("div");
        error.classList.add("error");
        error.textContent = firstError;
        addToast([{ title: "Error", error: firstError }]);
    } else {
        const spinner = document.createElement("div")
        spinner.classList.add("linear-loading")
        const loaderSection = document.querySelector(".loader")
        loaderSection?.appendChild(spinner);
        const form_data = new FormData(e.target);
        try {
            const response = await fetch(location.origin + "/dashboard/login", {
                method: "POST",
                body: form_data
            })
            const data = await response.json()
            if (data?.errores) {
                const errors = Object?.values(data?.errores).map(err => {
                    const error = document.createElement("div");
                    error.classList.add("error")
                    error.textContent = err
                    return { title: "Error", error: err }
                })
                addToast(errors);
            } else if (data?.message == "successfully") {
                window.location.href = "/dashboard"
            }
        } catch (error) {
            addToast([{ title: "Error", error: "Ocurrió un error, intenta de nuevo más tarde." }]);
        } finally {
            const spinner2 = loaderSection?.querySelector(".linear-loading")
            spinner2?.remove()
        }
    }

})