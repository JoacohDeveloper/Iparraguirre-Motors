const formularioRegister = document.querySelector("#regForm")

formularioRegister.addEventListener("submit", async e => {

    e.preventDefault();

    const fullname = e.target[0].value;
    const username = e.target[1].value;
    const errores = [];
    const nameRegex = /^[a-zA-Zà-úÀ-Ú]{2,}( [a-zA-Zà-úÀ-Ú]+)+$/;

    if (fullname.length <= 2) {
        errores.push("Debes ingresar tu nombre completo.");
    }  else if (!nameRegex.test(fullname)) {
        errores.push("Debes ingresar nombre y apellido.");
    } else if (username.length == 0) {
        errores.push("Debes ingresar un usuario.");
    } else if (username.length <= 4) {
        errores.push("Debes ingresar un usuario mayor a 4 caracteres.");
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
            const response = await fetch(location.origin + "/dashboard/registAdmin/regist", {
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
                toggleBackground();
                Swal.fire({
                    title: "Éxito",
                    text: "Se ha creado el usuario con username: " + username + " y contraseña: imotorsadmin" + username,
                    icon: "success"
                });
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

const toggleBackground = () => {

    const dashbaordContent = document.querySelector(".dashboard-content")

    dashbaordContent.classList.toggle("fixed")
    document.body.classList.toggle("blured")
}