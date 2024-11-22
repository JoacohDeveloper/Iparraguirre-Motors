const newDataForm = document.querySelector("#newInfo")

newDataForm.addEventListener("submit", async e => {
    e.preventDefault();

    const username = e.target[0].value;
    const email = e.target[1].value;
    const pass = e.target[2].value;
    const rePass = e.target[4].value;
    const errores = [];
    const usernameRegex = /^[^\s]{5,}$/;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const passwordRegex = /^(?=.*[A-Z])(?=.*\d)[^\s]{6,}$/;

    const fields = [
        { value: username, regex: usernameRegex, error: "Debes ingresar un usuario mayor a 4 caracteres y sin espacios." },
        { value: email, regex: emailRegex, error: "Formato de email inválido." },
        { value: pass, regex: passwordRegex, error: "La contraseña debe tener mínimo 6 caracteres, una mayuscula, un numero y sin espacios." }
    ];

    fields.forEach(field => {
        if (!field.regex.test(field.value)) {
            errores.push(field.error);
        }
    });

    if (pass !== rePass) {
        errores.push("Las contraseñas no son iguales.");
    }
    if (errores.length != 0) {
        const firstError = errores[0];
        const error = document.createElement("div");
        error.classList.add("error");
        error.textContent = firstError;
        addToast([{ title: "Error", error: firstError }]);
    } else {
        const spinner = document.createElement("div")
        spinner.classList.add("linear-loading") // o spinner
        const loaderSection = document.querySelector(".loader")
        loaderSection?.appendChild(spinner);
        const form_data = new FormData(e.target);

        try {
            const response = await fetch(location.origin + "/dashboard/user-settings/usuario/modificarDefault", {
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
                    return { title: "Error", error: err }
                })
                addToast(errors);
            } else if (data?.message == "successfully") {
                Swal.fire({
                    title: "Éxito",
                    text: "Se han actualizado tus datos",
                    icon: "success"
                });
                const btn_swal = document.querySelector(".swal2-confirm");
                if(btn_swal){
                    btn_swal.addEventListener("click", () =>{
                        location.reload();
                    })
                }
            }
        } catch (error) {
            console.log(error)
            addToast([{ title: "Error", error: "Ocurrió un error, intenta de nuevo más tarde." }]);
        } finally {
            const spinner2 = loaderSection?.querySelector(".linear-loading")
            spinner2?.remove()
        }
    }
})

function togglePassword(button) {
    const input = button.previousElementSibling;
    const img = button.querySelector('img');
    if (input.type === "password") {
        input.type = "text";
        img.src = '/build/src/images/eye.svg';
        img.alt = "Ocultar contraseña";
    } else {
        input.type = "password";
        img.src = '/build/src/images/closedEye.svg';
        img.alt = "Mostrar contraseña";
    }
}