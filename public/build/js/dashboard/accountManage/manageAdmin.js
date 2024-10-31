function isMasterAccount(userEmail) {
    if(userEmail === "iparraguirremotors@contact.shop") return true
    return false
}

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

const Card = ({ slug, fullname, username, email, userType, isFirstLog, isDeleted, imagen, createdAt, updatedAt, wasDisabled, wasMaster }) => {
    const card = document.createElement("div");
    card.id = slug;

    const importantData = document.createElement("div");
    importantData.classList.add("important-container");

    const imageContainer = document.createElement("div");
    imageContainer.classList.add("image-container");

    const img = document.createElement("img");
    img.src = imagen.length === 0 ? "/build/src/images/users/default.jpg" : imagen;
    img.alt = `imagen de perfil de ${username}`;

    img.onerror = () => {
        img.src = "/build/src/images/users/default.jpg";
    }    

    const contenedorInformacion = document.createElement("div");
    contenedorInformacion.classList.add("contenedor-informacion");

    const fullnameHTML = document.createElement("p");
    fullnameHTML.textContent = fullname ?? "Sin nombre";
    fullnameHTML.id = "full_name"

    const usernameHTML = document.createElement("p");
    usernameHTML.textContent = username ?? "indefinido";

    const emailHTML = document.createElement("p");
    emailHTML.textContent = email ?? "Sin Email";
    
    let rol;
    if(userType == "Root") rol = "Empresa";
    if(userType == "Encargado") rol = "Encargado";
    if(userType == "Empleado") rol = "Empleado";
    if(isFirstLog == true) rol = "Sin uso";
    if(isDeleted == true) rol = "Dado de baja";

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

    const contenedorOptions = document.createElement("div");
    contenedorOptions.classList.add("options-container");

    const btn_delete = document.createElement("button");
    const btn_active = document.createElement("button");
    const btn_changeRol = document.createElement("button");

    btn_delete.textContent = "Eliminar"
    btn_active.textContent = "Reactivar"
    btn_changeRol.textContent = "Cambiar rol"

    if (isDeleted == true){
        contenedorOptions.appendChild(btn_active);
    } else {
        contenedorOptions.appendChild(btn_delete);
    }
    
    contenedorOptions.appendChild(btn_changeRol);

    if(wasDisabled){
        btn_delete.setAttribute("disabled", "");
        btn_active.setAttribute("disabled", "");
        btn_changeRol.setAttribute("disabled", "");

        btn_delete.id = "disabled-button_myAccount";
        btn_active.id = "disabled-button_myAccount";
        btn_changeRol.id = "disabled-button_myAccount";

        btn_changeRol.classList.add("emplyeeCard_options-disabled");
        btn_active.classList.add("emplyeeCard_options-disabled");
        btn_delete.classList.add("emplyeeCard_options-disabled");
    } else if(wasMaster){
        btn_delete.setAttribute("disabled", "");
        btn_active.setAttribute("disabled", "");
        btn_changeRol.setAttribute("disabled", "");

        btn_delete.id = "disabled-button_Master";
        btn_active.id = "disabled-button_Master";
        btn_changeRol.id = "disabled-button_Master";

        btn_changeRol.classList.add("emplyeeCard_options-disabled");
        btn_active.classList.add("emplyeeCard_options-disabled");
        btn_delete.classList.add("emplyeeCard_options-disabled");
    } else {
        btn_changeRol.id = slug;
        btn_active.id = slug;
        btn_delete.id = slug;
        btn_changeRol.classList.add("emplyeeCard_options");
        btn_active.classList.add("emplyeeCard_options");
        btn_delete.classList.add("emplyeeCard_options");

        btn_changeRol.addEventListener("click", () => handlerChangeRol(email));
        btn_active.addEventListener("click", () => handlerReactivar(email));
        btn_delete.addEventListener("click", () => handlerEliminar(email));
    }
        
    card.appendChild(importantData);
    card.appendChild(contenedorInformacion);
    card.appendChild(contenedorOptions);

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

        const totalAdminHTML = document.querySelector("#p_totalCant");
        const cantMandatedHTML = document.querySelector("#p_cantMandated");
        const cantEmployeeHTML = document.querySelector("#p_cantEmployee");

        let totalAdmin = 0, cantEmployee = 0, cantMandated = 0;

        data.forEach(async u => {
            // Corroborar si el usuario es el mismo que la sesión
            const isCurrentUser = await isMyUser(u.email);

            // Corroborar si el usuario es la cuenta maestra
            const isMaster = isMasterAccount(u.email);

            const customU = {
                slug: u.slug,
                fullname: u.full_name,
                username: u.username,
                email: u.email,
                userType: u.userType,
                isFirstLog: u.isFirstLog,
                isDeleted: u.isDeleted,
                imagen: u.imagen,
                createdAt: u.createdAt,
                updatedAt: u.updatedAt,
                wasDisabled: isCurrentUser,
                wasMaster: isMaster
            };
            
            if (u.userType == "Root" || u.userType == "Encargado") {
                cantMandated++;
            } else if (!u.isDeleted) {
                cantEmployee++;
            }
            if (u.userType == "Root" || u.userType == "Encargado" || u.userType == "Empleado") {
                totalAdmin++;
            }
            totalAdminHTML.textContent = "Cantidad de administradores: " + totalAdmin;
            cantEmployeeHTML.textContent = "Cantidad de empleados: " + cantEmployee;
            cantMandatedHTML.textContent = "Cantidad de encargados: " + cantMandated;
            
            if (cardContainer) cardContainer.appendChild(Card(customU));
        });
    };
    try {
        await cargarUsuarios();
    } catch (error) {
        console.error('Error al obtener los usuarios:', error);
    }
}

async function isMyUser(userEmail) {
    try {
        const response = await fetch(location.origin + `/dashboard/manageEmployee/getOtherAdmin?email=${userEmail}`);
        const data = await response.json();

        if (data.response === "error") {
            addToast([{ title: "Failure", error: "Ha ocurrido un error" }]);
            return false;
        } else if (data.response === "MyUser") {
            return true;
        } else {
            return false;
        }
    } catch (error) {
        console.error("Error:", error);
        addToast([{ title: "Failure", error: "Ha ocurrido un error" }]);
        return false;
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
                        toggleBackground();
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

async function handlerEliminar(userEmail) {
    try {
        const response = await fetch(location.origin + `/dashboard/manageEmployee/getOtherAdmin?email=${userEmail}`);
        const data = await response.json();
        
        if (data.response === "error") {
            addToast([{
                title: "Failure",
                error: "Ha ocurrido un error"
            }]);
        } else {
            toggleBackground();
            document.body.appendChild(ModalDelete(data.response));
        }
    } catch (error) {
        console.error("Error:", error);
        addToast([{
            title: "Failure",
            error: "Ha ocurrido un error"
        }]);
    }
}

const InputText = (type, label, placeholder, name, id, value) => {
    const inputLabel = document.createElement('label');
    const input = document.createElement('input');
    input.type = type;
    input.name = name;
    input.id = id;
    input.placeholder = placeholder;
    input.value = value;

    inputLabel.htmlFor = id;
    inputLabel.textContent = label;

    inputLabel.appendChild(input);
    return inputLabel;
}

const ModalDelete = (data) => {
    //Como los datos del Model son protected, tuve que implementar esto para eliminar caracteres
    //de "data" que rompian el flujo de datos.
    const userUUID = data['\u0000*\u0000uuid'];
    const userFullname = data['\u0000*\u0000full_name']
    
    const contenedor = document.createElement("div")
    contenedor.classList.add("modal-container")

    const modal = document.createElement("div")
    modal.classList.add("modal")

    const modalHeader = document.createElement("section")
    modalHeader.classList.add("modal-header")

    const btnClose = document.createElement("button")

    const btnImage = document.createElement("img")
    btnImage.src = "/build/src/images/cross.svg"

    btnClose.appendChild(btnImage)

    const divSpacer = document.createElement("div")

    const modalTitle = document.createElement("h3")
    modalTitle.textContent = "Eliminar " + userFullname;

    modalHeader.appendChild(divSpacer)
    modalHeader.appendChild(modalTitle)
    modalHeader.appendChild(btnClose)

    btnClose.addEventListener("click", e => {
        toggleBackground()
        contenedor.remove()
    })

    const modalBody = document.createElement("section")
    modalBody.classList.add("modal-body")
    const delete_form = InputText("text", "Palabra de seguridad: quitar acceso", "quitar acceso", "delete-input", "securedWord", "");

    const text = document.createElement("p")
    text.textContent = "¿Seguro que quieres eliminar este administrador?"


    const submitInput = document.createElement("button")
    submitInput.textContent = "Confirmar"

    submitInput.addEventListener("click", async e => {
        const inputSecuredWord = document.querySelector("#securedWord");
        if (inputSecuredWord.value != "quitar acceso") {
            addToast([{ title: "Failure", error: "Debes ingresar la palabra de seguridad." }]);
        } else {
            try {
                const response = await fetch(location.origin + `/dashboard/manageEmployee/forceDelete?uuid=${userUUID}`);
                const data = await response.json();
    
                if (data.message == "successfuly") {
                    contenedor.remove();
                    Swal.fire({
                        title: "Éxito",
                        text: "Se le ha bloqueado el acceso a " + userFullname,
                        icon: "success"
                    });
                    const btn_swal = document.querySelector(".swal2-confirm");
                    if (btn_swal) {
                        btn_swal.addEventListener("click", () => {
                            inputSecuredWord.value = "";
                            toggleBackground();
                            reloadCards();
                        });
                    }
                } else {
                    addToast([{ title: "Failure", error: "Ha ocurrido un error" }]);
                }
            } catch (error) {
                console.error("Error:", error);
                addToast([{ title: "Failure", error: "Ha ocurrido un error al procesar la solicitud" }]);
            }
        }
    });
    modalBody.appendChild(text);
    modalBody.appendChild(delete_form)
    modalBody.appendChild(submitInput)

    contenedor.appendChild(modal)
    modal.appendChild(modalHeader)
    modal.appendChild(modalBody)

    return contenedor;
}

async function handlerReactivar(userEmail) {
    try {
        const response = await fetch(location.origin + `/dashboard/manageEmployee/getOtherAdmin?email=${userEmail}`);
        const data = await response.json();
        
        if (data.response === "error") {
            addToast([{
                title: "Failure",
                error: "Ha ocurrido un error"
            }]);
        } else {
            toggleBackground();
            document.body.appendChild(ModalReactivar(data.response));
        }
    } catch (error) {
        console.error("Error:", error);
        addToast([{
            title: "Failure",
            error: "Ha ocurrido un error"
        }]);
    }
}

const ModalReactivar = (data) => {
    //Como los datos del Model son protected, tuve que implementar esto para eliminar caracteres
    //de "data" que rompian el flujo de datos.
    const userUUID = data['\u0000*\u0000uuid'];
    const userFullname = data['\u0000*\u0000full_name']
    
    const contenedor = document.createElement("div")
    contenedor.classList.add("modal-container")

    const modal = document.createElement("div")
    modal.classList.add("modal")

    const modalHeader = document.createElement("section")
    modalHeader.classList.add("modal-header")

    const btnClose = document.createElement("button")

    const btnImage = document.createElement("img")
    btnImage.src = "/build/src/images/cross.svg"

    btnClose.appendChild(btnImage)

    const divSpacer = document.createElement("div")

    const modalTitle = document.createElement("h3")
    modalTitle.textContent = "Reactivar " + userFullname;

    modalHeader.appendChild(divSpacer)
    modalHeader.appendChild(modalTitle)
    modalHeader.appendChild(btnClose)

    btnClose.addEventListener("click", e => {
        toggleBackground()
        contenedor.remove()
    })

    const modalBody = document.createElement("section")
    modalBody.classList.add("modal-body")
    const delete_form = InputText("text", "Palabra de seguridad: conceder acceso", "conceder acceso", "active-input", "securedWord", "");

    const text = document.createElement("p")
    text.textContent = "¿Seguro quieres conceder acceso a esta cuenta?"


    const submitInput = document.createElement("button")
    submitInput.textContent = "Confirmar"

    submitInput.addEventListener("click", async e => {
        const inputSecuredWord = document.querySelector("#securedWord");
        if (inputSecuredWord.value != "conceder acceso") {
            addToast([{ title: "Failure", error: "Debes ingresar la palabra de seguridad." }]);
        } else {
            try {
                const response = await fetch(location.origin + `/dashboard/manageEmployee/forceActive?uuid=${userUUID}`);
                const data = await response.json();
    
                if (data.message == "successfuly") {
                    contenedor.remove();
                    Swal.fire({
                        title: "Éxito",
                        text: "Se le ha devuelto el acceso a " + userFullname,
                        icon: "success"
                    });
                    const btn_swal = document.querySelector(".swal2-confirm");
                    if (btn_swal) {
                        btn_swal.addEventListener("click", () => {
                            inputSecuredWord.value = "";
                            toggleBackground();
                            reloadCards();
                        });
                    }
                } else {
                    addToast([{ title: "Failure", error: "Ha ocurrido un error" }]);
                }
            } catch (error) {
                console.error("Error:", error);
                addToast([{ title: "Failure", error: "Ha ocurrido un error al procesar la solicitud" }]);
            }
        }
    });
    modalBody.appendChild(text) 
    modalBody.appendChild(delete_form) 
    modalBody.appendChild(submitInput)

    contenedor.appendChild(modal)
    modal.appendChild(modalHeader)
    modal.appendChild(modalBody)

    return contenedor;
}

const InputSelect = (label, name, values, id, selectedValue) => {
    const inputSelectLabel = document.createElement('label');
    const inputSelect = document.createElement('select');
    inputSelect.name = name;
    inputSelect.id = id;

    inputSelectLabel.textContent = label;
    inputSelectLabel.htmlFor = id;
    inputSelectLabel.appendChild(inputSelect);

    // Crear una opción para el valor por defecto
    const defaultOption = document.createElement('option');
    defaultOption.textContent = '-Seleccione-';
    inputSelect.appendChild(defaultOption);

    values.forEach(value => {
        const optionElement = document.createElement('option');
        optionElement.value = value;
        optionElement.textContent = value;
        if (value == selectedValue) {
            optionElement.selected = true;
        }
        inputSelect.appendChild(optionElement);
    });

    return inputSelectLabel;
}

async function handlerChangeRol(userEmail) {
    try {
        const response = await fetch(location.origin + `/dashboard/manageEmployee/getOtherAdmin?email=${userEmail}`);
        const data = await response.json();
        
        if (data.response === "error") {
            addToast([{
                title: "Failure",
                error: "Ha ocurrido un error"
            }]);
        } else {
            toggleBackground();
            document.body.appendChild(ModalRol(data.response));
        }
    } catch (error) {
        console.error("Error:", error);
        addToast([{
            title: "Failure",
            error: "Ha ocurrido un error"
        }]);
    }
}

const ModalRol = (data) => {
    //Como los datos del Model son protected, tuve que implementar esto para eliminar caracteres
    //de "data" que rompian el flujo de datos.
    const userUUID = data['\u0000*\u0000uuid'];
    const userFullname = data['\u0000*\u0000full_name']
    const userActualRol = data['\u0000*\u0000userType']
    
    const contenedor = document.createElement("div")
    contenedor.classList.add("modal-container")

    const modal = document.createElement("div")
    modal.classList.add("modal")

    const modalHeader = document.createElement("section")
    modalHeader.classList.add("modal-header")

    const btnClose = document.createElement("button")

    const btnImage = document.createElement("img")
    btnImage.src = "/build/src/images/cross.svg"

    btnClose.appendChild(btnImage)

    const divSpacer = document.createElement("div")

    const modalTitle = document.createElement("h3")
    modalTitle.textContent = "Cambiar rol de " + userFullname;

    modalHeader.appendChild(divSpacer)
    modalHeader.appendChild(modalTitle)
    modalHeader.appendChild(btnClose)

    btnClose.addEventListener("click", e => {
        toggleBackground()
        contenedor.remove()
    })

    const modalBody = document.createElement("section")
    modalBody.classList.add("modal-body")
    const delete_form = InputSelect("Seleccione el rol", "changeRol", ["Empleado", "Encargado"], "selectRol");

    const text = document.createElement("p")
    text.textContent = "Actualmente es " + userActualRol;

    const submitInput = document.createElement("button")
    submitInput.textContent = "Confirmar"
    console.log(userActualRol)
    submitInput.addEventListener("click", async e => {
        const inputSelectRol = document.querySelector("#selectRol");
        if (inputSelectRol.value == "-Seleccione-") {
            addToast([{ title: "Failure", error: "Debes ingresar un rol para poder cambiarlo." }]);
        } else if(inputSelectRol.value == userActualRol){
            addToast([{ title: "Failure", error: "Este usuario ya es " + userActualRol }]);
        } else {
            try {
                console.log(inputSelectRol.value)
                const response = await fetch(location.origin + `/dashboard/manageEmployee/forceChangeRol?uuid=${userUUID}&rol=${inputSelectRol.value}`);
                const data = await response.json();
    
                if (data.message == "successfuly") {
                    contenedor.remove();
                    Swal.fire({
                        title: "Éxito",
                        text: "Ahora " + userFullname + " es un " + inputSelectRol.value.toLowerCase(),
                        icon: "success"
                    });
                    const btn_swal = document.querySelector(".swal2-confirm");
                    if (btn_swal) {
                        btn_swal.addEventListener("click", () => {
                            toggleBackground();
                            reloadCards();
                        });
                    }
                } else {
                    addToast([{ title: "Failure", error: "Ha ocurrido un error" }]);
                }
            } catch (error) {
                console.error("Error:", error);
                addToast([{ title: "Failure", error: "Ha ocurrido un error al procesar la solicitud" }]);
            }
        }
    });
    modalBody.appendChild(text)
    modalBody.appendChild(delete_form)
    modalBody.appendChild(submitInput)

    contenedor.appendChild(modal)
    modal.appendChild(modalHeader)
    modal.appendChild(modalBody)

    return contenedor;
}

const toggleBackground = () => {

    const dashbaordContent = document.querySelector(".dashboard-content")

    dashbaordContent.classList.toggle("fixed")
    document.body.classList.toggle("blured")
}