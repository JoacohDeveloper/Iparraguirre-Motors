const Spinner = () => {

    const spinnerSquare = document.createElement("div")
    spinnerSquare.classList.add("spinner-square")

    for (let i = 1; i <= 3; i++) {
        const square = document.createElement("div")
        square.classList.add(`square-${i}`)
        square.classList.add("square")
        spinnerSquare.appendChild(square)
    }

    return spinnerSquare
}

const cardContainer = document.querySelector(".card-container");

const Card = ({ slug, fullname, username, email, isAdmin, isEncargado, isFirstLog, isDeleted, imagen, createdAt, updatedAt }) => {
    const card = document.createElement("div");
    card.id = slug;

    const importantData = document.createElement("div");
    importantData.classList.add("important-container");

    const imageContainer = document.createElement("div");
    imageContainer.classList.add("image-container");

    const img = document.createElement("img");
    img.src = imagen.length === 0 ? "/build/src/images/users/default.jpg" : imagen;
    img.alt = `imagen de perfil de ${username}`;

    const contenedorInformacion = document.createElement("div");
    contenedorInformacion.classList.add("contenedor-informacion");

    const fullnameHTML = document.createElement("p");
    fullnameHTML.textContent = fullname ?? "Sin nombre";
    fullnameHTML.id = "full_name"

    const usernameHTML = document.createElement("p");
    usernameHTML.textContent = username ?? "indefinido";

    const emailHTML = document.createElement("p");
    emailHTML.textContent = email ?? "Sin Email";

    let rol = "Sin rol";
    if(isAdmin) rol = "Empleado"
    if(isEncargado) rol = "Encargado"
    if(isFirstLog) rol = "Sin acceso"
    if(isDeleted) rol = "Dado de baja"

    const rolHTML = document.createElement("p");
    rolHTML.textContent = rol;
    rolHTML.id = "rol"

    const registedHTML = document.createElement("p");
    registedHTML.textContent = createdAt ?? "No registrado";

    const updatedHTML = document.createElement("p");
    if(updatedAt === createdAt){
        updatedHTML.textContent = "No actualizado";
    } else {
        updatedHTML.textContent = updatedAt;
    }
    

    //Aqui vamos a agregar los iconos
    const usernameLabel = document.createElement("label");
    const usernameIcon = document.createElement("img");
    usernameIcon.src = "/build/src/images/user.svg";

    usernameLabel.appendChild(usernameIcon);
    usernameLabel.appendChild(usernameHTML);

    const emailLabel = document.createElement("label");
    const emailIcon = document.createElement("img");
    emailIcon.src = "/build/src/images/email.svg";

    emailLabel.appendChild(emailIcon);
    emailLabel.appendChild(emailHTML);

    const registedLabel = document.createElement("label");
    const registedIcon = document.createElement("img");
    registedIcon.src = "/build/src/images/created.svg";

    registedLabel.appendChild(registedIcon);
    registedLabel.appendChild(registedHTML);

    const updatedLabel = document.createElement("label");
    const updatedIcon = document.createElement("img");
    updatedIcon.src = "/build/src/images/updated.svg";

    updatedLabel.appendChild(updatedIcon);
    updatedLabel.appendChild(updatedHTML);

    contenedorInformacion.appendChild(usernameLabel);
    contenedorInformacion.appendChild(emailLabel);
    contenedorInformacion.appendChild(registedLabel);
    contenedorInformacion.appendChild(updatedLabel);

    imageContainer.appendChild(img);
    importantData.appendChild(imageContainer);
    importantData.appendChild(fullnameHTML);
    importantData.appendChild(rolHTML);

    card.classList.add("user-card");
    card.setAttribute("aria-label", slug);

    card.appendChild(importantData);
    card.appendChild(contenedorInformacion);

    const observer = new IntersectionObserver(items => {
        items.forEach(item => {
            if (item.isIntersecting) {
                item.target.classList.add("intersecting");
                observer.unobserve(card);
            }
        });
    });
    observer.observe(card);

    return card;
};


async function obtenerUsuarios() {
    const cargarUsuarios = async () => {
        const spinner = Spinner();
        if (cardContainer) cardContainer.appendChild(spinner);
        const url = location.origin + "/dashboard/user/getAll";

        const response = await fetch(url);
        spinner.remove();

        const data = await response.json();
        const oldData = JSON.parse(localStorage.getItem("userItems")) ?? [];
        const newData = [...oldData, ...data];
        console.log(data);

        const totalAdminHTML = document.querySelector("#p_totalCant");
        const cantMandatedHTML = document.querySelector("#p_cantMandated");
        const cantEmployeeHTML = document.querySelector("#p_cantEmployee");

        let totalAdmin = 0, cantEmployee = 0, cantMandated = 0;

        data.forEach(u => {
            const customU = {
                slug: u.slug,
                fullname: u.full_name,
                username: u.username,
                email: u.email,
                isAdmin: u.isAdmin,
                isEncargado: u.isEncargado,
                isFirstLog: u.isFirstLog,
                isDeleted: u.isDeleted,
                imagen: u.imagen,
                createdAt: u.createdAt,
                updatedAt: u.updatedAt
            };
            if (u.isEncargado) {
                cantMandated++;
            } else if (!u.isDeleted) {
                cantEmployee++;
            }
            if (u.isAdmin) {
                totalAdmin++;
            }
            if (cardContainer) cardContainer.appendChild(Card(customU));
        });
        totalAdminHTML.textContent = "Cantidad de administradores: " + totalAdmin;
        cantMandatedHTML.textContent = "Cantidad de encargados: " + cantMandated;
        cantEmployeeHTML.textContent = "Cantidad de empleados: " + cantEmployee;
    };
    try {
        await cargarUsuarios();
    } catch (error) {
        console.error('Error al obtener los usuarios:', error);
    }
}


obtenerUsuarios();


function reloadCards(){
    cardContainer.innerHTML = '';
    obtenerUsuarios();
}

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
        addToast([{ title: "Fail", error: firstError }]);
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
                const btn_swal = document.querySelector(".swal2-confirm");
                if(btn_swal){
                    btn_swal.addEventListener("click", () =>{
                        e.target[0].value = "";
                        e.target[1].value = "";
                        reloadCards();
                    })
                }
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