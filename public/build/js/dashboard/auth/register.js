const formularioRegister = document.querySelector("#regForm")

formularioRegister.addEventListener("submit", async e => {
    e.preventDefault();

    const fullname = e.target[0].value;
    const username = e.target[1].value;
    const errores = [];
    const nameRegex = /^[a-zA-Zà-úÀ-Ú]{2,}( [a-zA-Zà-úÀ-Ú]+)+$/;
    const usernameRegex = /^[^\s]{5,}$/;

    const fields = [
        { value: fullname, regex: nameRegex, error: "Debes ingresar nombre y apellido." },
        { value: username, regex: usernameRegex, error: "Debes ingresar un usuario mayor a 4 caracteres y sin espacios." }
    ];

    fields.forEach(field => {
        if (!field.regex.test(field.value)) {
            errores.push(field.error);
        }
    });

    if (errores.length != 0) {
        const firstError = errores[0];
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
            const response = await fetch(location.origin + "/dashboard/registAdmin/regist", {
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
                toggleBackground();
                Swal.fire({
                    title: "Éxito",
                    text: "Se ha creado el usuario con username: " + username + " y contraseña: imotorsadmin" + username,
                    icon: "success"
                });
            }
        } catch (error) {
            addToast([{ title: "Error", error: "Ocurrió un error, intenta de nuevo más tarde." }]);
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