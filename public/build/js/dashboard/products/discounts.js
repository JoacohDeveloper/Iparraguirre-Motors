//Estas 3 const sirven para generar label que contienen las casillas del formulario agregar vehiculo. El primero
//genera las casillas en las que el administrador debe escribir datos especificos. En el segundo se genera el
//area de texto que utilizamos para escribir la descripcion y en el tercero se general los select con las options
//del mismo. De esta manera se crean todos los elementos html necesarios para el formulario de agregar producto
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


const ModalAddDiscount = (data) => {
    const contenedor = document.createElement("div")
    document.body.classList.add("fixed")

    contenedor.classList.add("modal-container")

    const modal = document.createElement("div")

    modal.classList.add("modal")
    modal.classList.add("modal_add-discount")

    const modalHeader = document.createElement("section")

    modalHeader.classList.add("modal-header")

    const btnClose = document.createElement("button")

    const btnImage = document.createElement("img")
    btnImage.src = "/build/src/images/cross.svg"

    btnClose.appendChild(btnImage)

    const divSpacer = document.createElement("div")

    const modalTitle = document.createElement("h3")
    modalTitle.textContent = ("Agregar descuento a " + data.nombre)

    const modalAddDiscount = document.createElement("form")
    modalAddDiscount.classList.add("form_addvehicle")
    const inputs = [
        InputSelect("Tipo de descuento", "type", ["Dolares", "Porcentaje"], "tipo"),
        InputText("text", "Descuento", "Descuento", "descuento", "descuento", "")//,
        // InputText("date", "¿Cuando inicia?", "startDate",),
        // InputText("date", "¿Cuando finaliza?", "endDate",)
    ];

    modalHeader.appendChild(divSpacer)
    modalHeader.appendChild(modalTitle)
    modalHeader.appendChild(btnClose)

    btnClose.addEventListener("click", e => {
        toggleBackground()
        contenedor.remove()
    })

    const modalBody = document.createElement("section")
    modalBody.classList.add("modal-body")

    inputs.forEach(input => modalAddDiscount.appendChild(input))

    const submitInput = document.createElement("button")
    submitInput.textContent = "Agregar descuento"

    modalAddDiscount.appendChild(submitInput)
    modalBody.appendChild(modalAddDiscount)

    modalAddDiscount.addEventListener("submit", async e => {
        e.preventDefault()
        const formdata = new FormData(modalAddDiscount)
        const object = {};
        const error = [];
        formdata.forEach((value, key) => {
            if (key !== 'image') {
                object[key] = value
            }
        });

        if (object.type == "-Seleccione-" ) {
            error.push({
                title: "Failure",
                error: "El campo tipo de descuento se encuentra vacio"
            })
        } else if (object.descuento.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo descuento es obligatorio"
            })
        }

        if (error.length != 0) {
            addToast(error);
        } else {
            formdata.append('id', data.id);
            try {
                const response = await fetch(location.origin + "/dashboard/discount-vehiculo", {
                    method: "POST",
                    body: formdata
                });
                const data = await response.json();
                if (data?.errores) {
                    const errors = Object.values(data.errores).map(err => {
                        const error = document.createElement("div");
                        error.classList.add("error");
                        error.textContent = err;
                        return { title: "Failure", error: err };
                    });
                    addToast(errors);
                } else if (data?.message == "successfuly") {
                    toggleBackground();
                    contenedor.remove();
                    Swal.fire({
                        title: "Éxito",
                        text: "Se ha aplicado el descuento",
                        icon: "success"
                    });
                    const btn_swal = document.querySelector(".swal2-confirm");
                    if(btn_swal){
                        btn_swal.addEventListener("click", () =>{
                            document.querySelector(".product-search__input").querySelector("button").click();
                        })
                    }
                } else if (data?.error) {
                    document.body.classList.add("fixed")
                    addToast([{
                        title: "Failure",
                        error: "Ha ocurrido un error"
                    }]);
                }
            } catch (err) {
                console.log(err);
                document.body.classList.add("fixed")
                addToast([{
                    title: "Failure",
                    error: "Ha ocurrido un error"
                }]);
            }
        }
    })
    contenedor.appendChild(modal)

    modal.appendChild(modalHeader)
    modal.appendChild(modalBody)
    return contenedor;
}

const ModalRemoveDiscount = (data) => {
    const contenedor = document.createElement("div")

    contenedor.classList.add("modal-container")

    const modal = document.createElement("div")

    modal.classList.add("modal")
    modal.classList.add("modal_add-discount")

    const modalHeader = document.createElement("section")

    modalHeader.classList.add("modal-header")

    const btnClose = document.createElement("button")

    const btnImage = document.createElement("img")
    btnImage.src = "/build/src/images/cross.svg"

    btnClose.appendChild(btnImage)

    const divSpacer = document.createElement("div")

    const modalTitle = document.createElement("h3")
    modalTitle.textContent = ("Eliminar descuento de " + data.nombre)

    const modalRemoveDiscount = document.createElement("form")
    modalRemoveDiscount.classList.add("form_addvehicle")
    const input = InputText("text", "", "Ingresar palabra", "secureword", "secureword", "")


    modalHeader.appendChild(divSpacer)
    modalHeader.appendChild(modalTitle)
    modalHeader.appendChild(btnClose)

    btnClose.addEventListener("click", e => {
        toggleBackground()
        contenedor.remove()
    })

    const modalBody = document.createElement("section")
    modalBody.classList.add("modal-body")

    const secureword = document.createElement("p")
    secureword.textContent = ("Palabra de seguridad: eliminar descuento")

    modalRemoveDiscount.appendChild(secureword)
    modalRemoveDiscount.appendChild(input)

    const submitInput = document.createElement("button")
    submitInput.textContent = "Confirmar"

    modalRemoveDiscount.appendChild(submitInput)
    modalBody.appendChild(modalRemoveDiscount)

    modalRemoveDiscount.addEventListener("submit", async e => {
        e.preventDefault()
        const formdata = new FormData(modalRemoveDiscount)
        const object = {};
        const error = [];
        formdata.forEach((value, key) => {
            if (key !== 'image') {
                object[key] = value
            }
        });

        if (object.secureword.length == 0) {
            error.push({
                title: "Failure",
                error: "Debes ingresar la palabra de seguridad"
            })
        } else if (object.secureword != "eliminar descuento") {
            error.push({
                title: "Failure",
                error: "La palabra de seguridad es incorrecta"
            })
        }

        if (error.length != 0) {
            addToast(error);
        } else {
            formdata.append('id', data.id);
            try {
                const response = await fetch(location.origin + "/dashboard/delete-discount-vehiculo", {
                    method: "POST",
                    body: formdata
                });
                const data = await response.json();
                if (data?.errores) {
                    const errors = Object.values(data.errores).map(err => {
                        const error = document.createElement("div");
                        error.classList.add("error");
                        error.textContent = err;
                        return { title: "Failure", error: err };
                    });
                    addToast(errors);
                } else if (data?.message == "successfuly") {
                    toggleBackground();
                    contenedor.remove();
                    Swal.fire({
                        title: "Éxito",
                        text: "Se ha eliminado el descuento",
                        icon: "success"
                    });
                    const btn_swal = document.querySelector(".swal2-confirm");
                    if(btn_swal){
                        btn_swal.addEventListener("click", () =>{
                            document.querySelector(".product-search__input").querySelector("button").click();
                        })
                    }
                } else if (data?.error) {
                    addToast([{
                        title: "Failure",
                        error: "Ha ocurrido un error"
                    }]);
                }
            } catch (err) {
                console.log(err);
                addToast([{
                    title: "Failure",
                    error: "Ha ocurrido un error"
                }]);
            }
        }
    })
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


const handlerAgregar = (e) => {
    const vehiculoID = e.currentTarget.id;
    toggleBackground();

    fetchVehiculoData(vehiculoID)
        .then(data => {
            document.body.appendChild(ModalAddDiscount(data));
        })
        .catch(err => {
            addToast([{
                title: "Failure",
                error: "Ha ocurrido un error"
            }]);
        });
};

const handlerEliminar = (e) => {
    const vehiculoID = e.currentTarget.id;
    toggleBackground();

    fetchVehiculoData(vehiculoID)
        .then(data => {
            document.body.appendChild(ModalRemoveDiscount(data));
        })
        .catch(err => {
            addToast([{
                title: "Failure",
                error: "Ha ocurrido un error"
            }]);
        });
};

const fetchVehiculoData = async (vehiculoID) => {
    const formdata = new FormData();
    formdata.append("id", vehiculoID);
    const response = await fetch(location.origin + "/dashboard/obtener-vehiculo", {
        method: "POST",
        body: formdata
    });
    if (!response.ok) {
        addToast([{
            title: "Failure",
            error: "Ha ocurrido un error"
        }]);
    }
    return await response.json();
};