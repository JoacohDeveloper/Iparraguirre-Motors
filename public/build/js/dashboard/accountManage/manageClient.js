//Variables de contenedor:
const cardCustomerContent = document.querySelector(".card-container"); // Contenedor donde se generan las cartas de todos los clientes
const interactionsMessageContent = document.querySelector(".interactions-message"); //Contenedor donde se presenta el cliente seleccionado para ver sus interacciones.
const interactionCardContent = document.querySelector(".interactions-cardContainer"); //Contenedor donde se generan las cartas con las interacciones del cliente seleccionado
interactionCardContent.style.display = "none";

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

const Card = ({ slug, fullname, username, email, phone, isDeleted, imagen, createdAt, updatedAt }) => {
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

    const phoneHTML = document.createElement("p");
    const formatPhone = (phone) => {
        if (!phone) return "Sin Celular";
        return phone.replace(/(.{3})/g, "$1 ");
    };
    phoneHTML.textContent = formatPhone(phone);


    let rol = "Sin rol";
    if(isDeleted){
        rol = "Dado de baja"
    } else {
        rol = "Cliente";
    }

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

    const phoneLabel = document.createElement("label");
    const phoneIcon = document.createElement("img");
    phoneIcon.src = "/build/src/images/phone.svg";

    phoneLabel.appendChild(phoneIcon);
    phoneLabel.appendChild(phoneHTML);

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
    contenedorInformacion.appendChild(phoneLabel);
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
    const btn_viewStats = document.createElement("button");

    btn_delete.textContent = "Eliminar"
    btn_delete.id = slug;
    btn_delete.addEventListener("click", () => handlerEliminar(email));

    btn_active.textContent = "Reactivar"
    btn_active.id = slug;
    btn_active.addEventListener("click", () => handlerReactivar(email));

    btn_viewStats.textContent = "Ver estadísticas";
    btn_viewStats.id = slug;
    btn_viewStats.addEventListener('click', () => handlerViewUserInfo(email));

    if (rol === "Dado de baja"){
        contenedorOptions.appendChild(btn_active);
    } else {
        contenedorOptions.appendChild(btn_delete);
    }
    
    contenedorOptions.appendChild(btn_viewStats);

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

//Utilizamos "interactions" refiriendonos a las interacciones que tuvo
//el cliente con la pagina (compras, test drive, consultas, etc)
const interactionsCard = ({ interactionID, interactionOwner, interactionType, interactionCost, productName, productType, productLink, isPrivate, interactionDate }) => {
    const interactionsCard = document.createElement("div");
    interactionsCard.classList.add("interactions-card");
    interactionsCard.id = interactionID;

    const cardHeader = document.createElement("div");
    cardHeader.classList.add("interactions-cardHeader");
    const cardMain = document.createElement("div");
    cardMain.classList.add("interactions-cardMain");
    const cardFooter = document.createElement("div");
    cardFooter.classList.add("interactions-cardFooter");

    const labelID = document.createElement("label");
    labelID.classList.add("labelID");
    const idText = document.createElement("p");
    const idHTML = document.createElement("p");
    idText.textContent = "Interaction";
    idHTML.textContent = "#" + interactionID ?? "#0000";
    idText.id = "txt_ID"
    idHTML.id = "html_ID"
    labelID.appendChild(idText);
    labelID.appendChild(idHTML);

    const labelType = document.createElement("label");
    labelType.classList.add("labelType");
    const typeText = document.createElement("p");
    const typeHTML = document.createElement("p");
    typeText.textContent = "Tipo:";
    typeHTML.textContent = interactionType ?? "Indefinido";
    labelType.appendChild(typeText);
    labelType.appendChild(typeHTML);

    if(interactionCost == 0) interactionCost = "Sin costo";
    const labelCost = document.createElement("label");
    labelCost.classList.add("labelCost");
    const costText = document.createElement("p");
    const costHTML = document.createElement("p");
    costText.textContent = "Precio:";
    costHTML.textContent = interactionCost ?? "Sin costo";
    labelCost.appendChild(costText);
    labelCost.appendChild(costHTML);

    if(interactionType == "Compra" || interactionType == "Prueba de manejo"){
        var labelProductType = document.createElement("label");
        labelProductType.classList.add("labelProductName");
        const productTypeText = document.createElement("p");
        const productTypeHTML = document.createElement("p");
        productTypeText.textContent = "Tipo de producto:";
        productTypeHTML.textContent = productType ?? "Indefinido";
        labelProductType.appendChild(productTypeText);
        labelProductType.appendChild(productTypeHTML);

        var labelProductName = document.createElement("label");
        labelProductName.classList.add("labelProductName");
        const productNameText = document.createElement("p");
        const productNameHTML = document.createElement("p");
        productNameText.textContent = "Producto:";
        productNameHTML.textContent = productName ?? "Indefinido";
        labelProductName.appendChild(productNameText);
        labelProductName.appendChild(productNameHTML);

        var btn_link = document.createElement("button");
        btn_link.textContent = "Ver producto";
        btn_link.addEventListener('click', function() {
            window.location.href = productLink;
        });
    }
    
    const registedHTML = document.createElement("p");
    registedHTML.textContent = interactionDate ?? "Sin registro";

    cardMain.appendChild(labelType);
    if (typeof labelProductType !== 'undefined') cardMain.appendChild(labelProductType);
    if (typeof labelProductName !== 'undefined') cardMain.appendChild(labelProductName);
    cardMain.appendChild(labelCost);

    cardFooter.appendChild(registedHTML);
    if (typeof btn_link !== 'undefined') cardFooter.appendChild(btn_link);

    const interactionsCardImage = document.createElement("div");
    interactionsCardImage.classList.add("interactions-cardImage");

    const contenedorOptions = document.createElement("div");
    contenedorOptions.classList.add("options-container");

    const btn_deleteInteraction = document.createElement("button");
    btn_deleteInteraction.id = interactionID;
    btn_deleteInteraction.addEventListener('click', () => handlerDeleteInteraction(interactionID));

    const deleteIcon = document.createElement("img");
    deleteIcon.src = "/build/src/images/trash.svg";
    btn_deleteInteraction.appendChild(deleteIcon);

    contenedorOptions.appendChild(btn_deleteInteraction);

    cardHeader.appendChild(labelID);
    cardHeader.appendChild(btn_deleteInteraction);
    interactionsCard.appendChild(cardHeader);
    interactionsCard.appendChild(cardMain);
    interactionsCard.appendChild(cardFooter);

    const observer = new IntersectionObserver(items => {
        items.forEach(item => {
            if (item.isIntersecting) {
                item.target.classList.add("intersecting");
                observer.unobserve(interactionsCard);
            }
        });
    });
    observer.observe(interactionsCard);

    return interactionsCard;
};

async function handlerViewUserInfo(userEmail) {
    interactionCardContent.style.display = "flex";
    try {
        const response = await fetch(location.origin + `/dashboard/manageClient/getOtherClient?email=${userEmail}`);
        const data = await response.json();
        if (data.response === "error") {
            addToast([{ title: "Error", error: "Ha ocurrido un error" }]);
        } else {
            const dato = data.response;
            interactionsMessageContent.innerHTML= ""; //Limpiamos el contenedor que guarda los mensajes
            interactionCardContent.innerHTML = ""; //Limpiamos las cartas ya existentes
            if (dato === "") {
                //Mostramos un mensaje avisando que algo no funciono.
                const mensaje = document.createElement('p');
                mensaje.textContent = "Error"
                interactionsMessageContent.appendChild(mensaje) 
            } else {
                const fullnameHTML = document.createElement('h4');
                fullnameHTML.textContent = dato['\u0000*\u0000full_name'] ?? "N/A";
                
                const usernameHTML = document.createElement('p');
                usernameHTML.textContent = dato['\u0000*\u0000email'] ?? "N/A";
                
                const createdHTML = document.createElement('p');
                createdHTML.textContent = dato['\u0000*\u0000createdAt'] ?? "N/A";
                
                //Se muestran los datos base del usuario en el contenedor de interacciones, para mostrar de manera sencilla
                //a quien estamos revisando.
                interactionsMessageContent.appendChild(fullnameHTML);
                interactionsMessageContent.appendChild(usernameHTML);
                interactionsMessageContent.appendChild(createdHTML);

                await getInteractions(dato['\u0000*\u0000uuid']);
            }
        }
    } catch (error) {
        console.error("Error:", error);
        addToast([{ title: "Error", error: "Ha ocurrido un error" }]);
    }
}

async function obtenerUsuarios() {
    const cargarUsuarios = async () => {
        const spinner = Spinner();
        if (cardCustomerContent) cardCustomerContent.appendChild(spinner);
        const url = location.origin + "/dashboard/client/getAll";

        const response = await fetch(url);
        spinner.remove();

        const data = await response.json();
        const oldData = JSON.parse(localStorage.getItem("userItems")) ?? [];
        const newData = [...oldData, ...data];

        const totalCustomerHTML = document.querySelector("#p_totalCant");

        let totalCustomer = 0;

        data.forEach(async u => {
            const customU = {
                slug: u.slug,
                fullname: u.full_name,
                username: u.username,
                email: u.email,
                phone: u.phone,
                isDeleted: u.isDeleted,
                imagen: u.imagen,
                createdAt: u.createdAt,
                updatedAt: u.updatedAt
            };
            totalCustomer++;
            if (cardCustomerContent) cardCustomerContent.appendChild(Card(customU));
        });
        totalCustomerHTML.textContent = "Cantidad de clientes: " + totalCustomer;
    };
    try {
        await cargarUsuarios();
    } catch (error) {
        console.error('Error al obtener los usuarios:', error);
    }
}

async function getInteractions(userUUID) {
    const loadInteractions = async () => {
        const spinner = Spinner();
        if (interactionCardContent) interactionCardContent.appendChild(spinner);
        const url = location.origin + `/dashboard/manageClient/getInteractions?uuid=${userUUID}`;

        const response = await fetch(url);
        spinner.remove();

        const data = await response.json();
        if(data.interactions === null){
            const emptyInteractionsHTML = document.createElement("h5");
            emptyInteractionsHTML.textContent = "Este usuario no tiene interacciones todavia";
            if (interactionCardContent) interactionCardContent.appendChild(emptyInteractionsHTML);
        } else {
            data.interactions.forEach( i => {
                const customI = {
                    interactionID: i.interactionID,
                    interactionOwner: i.interactionOwner,
                    interactionType: i.interactionType,
                    interactionCost: i.interactionCost,
                    productName: i.productName,
                    productType: i.productType,
                    productLink: i.productLink,
                    isPrivate: i.isPrivate,
                    interactionDate: i.interactionDate
                };
                if (interactionCardContent) interactionCardContent.appendChild(interactionsCard(customI));
            });
        }
        
    };
    try {
        await loadInteractions();
    } catch (error) {
        console.error('Error al obtener los usuarios:', error);
    }
}

obtenerUsuarios();


function reloadCards(){
    cardCustomerContent.innerHTML = ''; //Reiniciamos el contenedor que muestra todos los clientes.
    interactionCardContent.innerHTML = ''; //Reiniciamos el contenedor con las interacciones de cliente seleccionado.
    interactionsMessageContent.innerHTML = ''; //Reiniciamos el contenedor con la informacion del cliente seleccionado.

    //Volvemos a cargar los usuarios para actualizar cualquier dato modificado.
    obtenerUsuarios();

    interactionCardContent.style.display = "none"; //Ocultamos el contenedor de interacciones porque esta vacio.
    //Volvemos a crear el mensaje default y lo colocamos donde va por defecto.
    const defaultMessage = document.createElement("p");
    defaultMessage.textContent = "Selecciona un cliente para ver su informacion de cuenta";
    defaultMessage.id = "interactions-welcomeText";
    interactionsMessageContent.appendChild(defaultMessage);
}

async function handlerEliminar(userEmail) {
    try {
        const response = await fetch(location.origin + `/dashboard/manageClient/getOtherClient?email=${userEmail}`);
        const data = await response.json();
        
        if (data.response === "error") {
            addToast([{
                title: "Error",
                error: "Ha ocurrido un error"
            }]);
        } else {
            toggleBackground();
            document.body.appendChild(ModalDelete(data.response));
        }
    } catch (error) {
        console.error("Error:", error);
        addToast([{
            title: "Error",
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
    text.textContent = "¿Seguro que quieres eliminar este cliente?"


    const submitInput = document.createElement("button")
    submitInput.textContent = "Confirmar"

    submitInput.addEventListener("click", async e => {
        const inputSecuredWord = document.querySelector("#securedWord");
        if (inputSecuredWord.value != "quitar acceso") {
            addToast([{ title: "Error", error: "Debes ingresar la palabra de seguridad." }]);
        } else {
            try {
                const response = await fetch(location.origin + `/dashboard/manageClient/forceDelete?uuid=${userUUID}`);
                const data = await response.json();
    
                if (data.message == "successfully") {
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
                    addToast([{ title: "Error", error: "Ha ocurrido un error" }]);
                }
            } catch (error) {
                console.error("Error:", error);
                addToast([{ title: "Error", error: "Ha ocurrido un error al procesar la solicitud" }]);
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
        const response = await fetch(location.origin + `/dashboard/manageClient/getOtherClient?email=${userEmail}`);
        const data = await response.json();
        
        if (data.response === "error") {
            addToast([{
                title: "Error",
                error: "Ha ocurrido un error"
            }]);
        } else {
            toggleBackground();
            document.body.appendChild(ModalReactivar(data.response));
        }
    } catch (error) {
        console.error("Error:", error);
        addToast([{
            title: "Error",
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
            addToast([{ title: "Error", error: "Debes ingresar la palabra de seguridad." }]);
        } else {
            try {
                const response = await fetch(location.origin + `/dashboard/manageClient/forceActive?uuid=${userUUID}`);
                const data = await response.json();
    
                if (data.message == "successfully") {
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
                    addToast([{ title: "Error", error: "Ha ocurrido un error" }]);
                }
            } catch (error) {
                console.error("Error:", error);
                addToast([{ title: "Error", error: "Ha ocurrido un error al procesar la solicitud" }]);
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

async function handlerDeleteInteraction(idOfInteraction) {
    toggleBackground();
    document.body.appendChild(ModalDeleteInteraction(idOfInteraction));
}

const ModalDeleteInteraction = (id) => {
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
    modalTitle.textContent = "Eliminar interaccion #" + id;

    modalHeader.appendChild(divSpacer)
    modalHeader.appendChild(modalTitle)
    modalHeader.appendChild(btnClose)

    btnClose.addEventListener("click", e => {
        toggleBackground()
        contenedor.remove()
    })

    const modalBody = document.createElement("section")
    modalBody.classList.add("modal-body")
    const delete_form = InputText("text", "Palabra de seguridad: eliminar interaccion", "eliminar interaccion", "active-input", "securedWord", "");

    const text = document.createElement("p")
    text.textContent = "¿Seguro quieres eliminar esta interaccion?"


    const submitInput = document.createElement("button")
    submitInput.textContent = "Confirmar"

    submitInput.addEventListener("click", async e => {
        const inputSecuredWord = document.querySelector("#securedWord");
        if (inputSecuredWord.value != "eliminar interaccion") {
            addToast([{ title: "Error", error: "Debes ingresar la palabra de seguridad." }]);
        } else {
            try {
                const response = await fetch(location.origin + `/dashboard/manageClient/deleteInteraction?id=${id}`);
                const data = await response.json();
    
                if (data.message == "successfully") {
                    contenedor.remove();
                    Swal.fire({
                        title: "Éxito",
                        text: "Se elimino la interaccion #" + id,
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
                    addToast([{ title: "Error", error: "Ha ocurrido un error" }]);
                }
            } catch (error) {
                console.error("Error:", error);
                addToast([{ title: "Error", error: "Ha ocurrido un error al procesar la solicitud" }]);
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