const formularioLogin = document.querySelector("#loginForm")

formularioLogin.addEventListener("submit", async (e) => {
    e.preventDefault()
    const dato = e.target[0].value; //Dato puede ser username o email
    const pass = e.target[1].value;
    const erroresClient = [];
    const nameRegex = /^[a-zA-Zà-úÀ-Ú]{2,}( [a-zA-Zà-úÀ-Ú]+)+$/;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    
    if (dato.length == 0) {
        erroresClient.push("Debes ingresar un usuario o correo electronico.");
    } else if (pass.length == 0) {
        erroresClient.push("Debes ingresar una contraseña.");
    }

    const errores = document.querySelector(".errores")
    errores.innerHTML = null

    if (erroresClient.length != 0) {
        const errors = erroresClient.map(err => {
            const error = document.createElement("div");
            error.classList.add("error")
            error.textContent = err

            // errores.appendChild(error)
            return { title: "Failure", error: err }
        })
        addToast(errors);
    } else {

        const spinner = document.createElement("div")
        spinner.classList.add("linear-loading") // o spinner
        const loaderSection = document.querySelector(".loader")
        loaderSection?.appendChild(spinner);
        const form_data = new FormData(e.target);


        try {
            const response = await fetch("http://localhost:3000/login", {
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

                    // errores.appendChild(error)

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