const addButton = document.querySelector(".product-add_text");
addButton.textContent = "Agregar repuesto";

const ErrorComp = (text) => {
    const errorContainer = document.createElement("div");
    errorContainer.classList.add("error-input-container");
    const errorText = document.createElement("p");
    errorText.textContent = text;
    errorContainer.appendChild(errorText);
    return errorContainer;
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

const TextArea = (label, placeholder, name, id, value) => {
    const inputTextLabel = document.createElement('label');
    const textarea = document.createElement('textarea');
    textarea.name = name;
    textarea.id = id;
    textarea.placeholder = placeholder;
    textarea.value = value;
    inputTextLabel.htmlFor = id;
    inputTextLabel.textContent = label;
    inputTextLabel.appendChild(textarea);
    return inputTextLabel;
}

const ModalAgregar = async () => {
    const contenedor = document.createElement("div");
    contenedor.classList.add("modal-container");

    const modal = document.createElement("div");
    modal.classList.add("modal", "modal_modificar");

    const modalHeader = document.createElement("section");
    modalHeader.classList.add("modal-header");

    const btnClose = document.createElement("button");
    const btnImage = document.createElement("img");
    btnImage.src = "/build/src/images/cross.svg";
    btnClose.appendChild(btnImage);

    const divSpacer = document.createElement("div");
    const modalTitle = document.createElement("h3");
    modalTitle.textContent = "Modificar Vehiculo";

    const addRefractionForm = document.createElement("form");
    addRefractionForm.classList.add("form_addvehicle");

    const inputs = [
        InputText("text", "Tipo de repuesto", "Tipo de repuesto", "tipo", "", ""),
        InputText("text", "Fabricante", "Fabricante", "fabricante", "", ""),
        InputText("text", "Modelo", "Modelo", "modelo", "", ""),
        InputText("text", "Origen", "Origen", "origen", "", ""),
        TextArea("Descripcion", "Escribe una descripcion sobre el vehiculo", "descripcion", "desc", ""),
        InputText("number", "Precio (USD)", "Precio", "precio", "", ""),
        InputText("number", "Stock (Unidad)", "Stock", "stock", "", ""),
        InputText("number", "Peso del paquete (g)", "Peso del paquete (g)", "peso", "", "")
    ];

    modalHeader.appendChild(divSpacer);
    modalHeader.appendChild(modalTitle);
    modalHeader.appendChild(btnClose);

    btnClose.addEventListener("click", e => {
        toggleBackground();
        contenedor.remove();
    });

    const modalBody = document.createElement("section");
    modalBody.classList.add("modal-body");

    inputs.forEach(input => addRefractionForm.appendChild(input));

    const submitInput = document.createElement("button");
    submitInput.textContent = "Actualizar";
    addRefractionForm.appendChild(await ImageUploader());
    addRefractionForm.appendChild(submitInput);

    modalBody.appendChild(addRefractionForm);

    addRefractionForm.addEventListener("submit", async e => {
        e.preventDefault();
        const formdata = new FormData(addRefractionForm);
        const object = {};
        const error = [];

        formdata.forEach((value, key) => {
            if (key !== 'image') {
                object[key] = value;
            }
        });

        if (object.tipo.length === 0) {
            error.push({ title: "Failure", error: "El campo tipo de repuesto se encuentra vacío" });
        } else if (object.fabricante.length === 0) {
            error.push({ title: "Failure", error: "El campo fabricante se encuentra vacío" });
        } else if (object.modelo.length === 0) {
            error.push({ title: "Failure", error: "El campo modelo se encuentra vacío" });
        } else if (object.origen.length === 0) {
            error.push({ title: "Failure", error: "El campo origen se encuentra vacío" });
        } else if (object.descripcion.length === 0) {
            error.push({ title: "Failure", error: "El campo descripción se encuentra vacío" });
        } else if (object.precio.length === 0) {
            error.push({ title: "Failure", error: "El campo precio se encuentra vacío" });
        } else if (object.stock.length === 0) {
            error.push({ title: "Failure", error: "El campo stock se encuentra vacío" });
        } else if (object.peso.length === 0) {
            error.push({ title: "Failure", error: "El campo peso se encuentra vacío" });
        }

        if (error.length !== 0) {
            addToast(error);
        } else {
            const name = object.tipo + " " + object.fabricante + " " + object.modelo + " " + object.origen;
            //formdata.append('id', object.id);
            formdata.append('nombre', name);
            try {
                const response = await fetch(location.origin + "/dashboard/agregar-repuesto", {
                    method: "POST",
                    body: formdata
                });
                const data = await response.json();
                if (data?.errores) {
                    const errors = Object.values(data.errores).map(err => {
                        return { title: "Failure", error: err };
                    });
                    addToast(errors);
                } else if (data?.status === "success") {
                    toggleBackground();
                    contenedor.remove();
                    Swal.fire({
                        title: "Éxito",
                        text: "El repuesto fue agregado exitosamente",
                        icon: "success"
                    });
                    const btn_swal = document.querySelector(".swal2-confirm");
                    if (btn_swal) {
                        btn_swal.addEventListener("click", () => {
                            document.querySelector(".product-search__input").querySelector("button").click();
                        });
                    }
                } else if (data?.status === "error") {
                    addToast([{ title: "Failure", error: data.message || "Ha ocurrido un error" }]);
                }
            } catch (err) {
                console.error(err);
                addToast([{ title: "Failure", error: "Ha ocurrido un error" }]);
            }
            
        }
    });

    contenedor.appendChild(modal);
    modal.appendChild(modalHeader);
    modal.appendChild(modalBody);

    return contenedor;
};

const toggleBackground = () => {
    const dashboardContent = document.querySelector(".dashboard-content");
    dashboardContent.classList.toggle("fixed");
    document.body.classList.toggle("blured");
};

const handlerAgregar = async (e) => {
    toggleBackground();
    const modal = await ModalAgregar();
    document.body.appendChild(modal);
};

const handlerEliminar = (e) => {
    toggleBackground()
    document.body.appendChild(ModalDelete())
}

const handlerModificar = (e) => {
    toggleBackground()
    document.body.appendChild(ModalModificar())
}

if (addButton) {
    addButton.addEventListener("click", handlerAgregar);
}
