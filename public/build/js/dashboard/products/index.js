
const ModalDelete = () => {
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
    modalTitle.textContent = "Eliminar Producto"

    modalHeader.appendChild(divSpacer)
    modalHeader.appendChild(modalTitle)
    modalHeader.appendChild(btnClose)

    btnClose.addEventListener("click", e => {
        toggleBackground()
        contenedor.remove()
    })

    const modalBody = document.createElement("section")
    modalBody.classList.add("modal-body")
    const delete_form = InputText("text", "Palabra de seguridad", "eliminar producto", "delete-input", "", "");

    const text = document.createElement("p")
    text.textContent = "¿Seguro que quieres eliminar este producto?"


    const submitInput = document.createElement("button")
    submitInput.textContent = "Confirmar"

    submitInput.addEventListener("click", e => {
        if (input.value != "eliminar producto") {
            addToast([{ title: "Failure", error: "debes ingresar la palabra de seguridad." }])
        }
    })

    modalBody.appendChild(delete_form)
    modalBody.appendChild(submitInput)

    contenedor.appendChild(modal)
    modal.appendChild(modalHeader)
    modal.appendChild(modalBody)
    return contenedor;
}


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


const ModalAdd = () => {
    const contenedor = document.createElement("div")

    contenedor.classList.add("modal-container")

    const modal = document.createElement("div")

    modal.classList.add("modal")
    modal.classList.add("modal_add")

    const modalHeader = document.createElement("section")

    modalHeader.classList.add("modal-header")

    const btnClose = document.createElement("button")

    const btnImage = document.createElement("img")
    btnImage.src = "/build/src/images/cross.svg"

    btnClose.appendChild(btnImage)

    const divSpacer = document.createElement("div")

    const modalTitle = document.createElement("h3")
    modalTitle.textContent = "Agregar Vehiculo"

    const vehicleform = document.createElement("form")
    vehicleform.classList.add("form_addvehicle")
    const inputs = [
        InputText("text", "Nombre", "Nombre", "nombre", "name", ""),
        InputSelect("Categoria", "categoria", ["De fabrica", "Modificados"], "categoria", ""),
        TextArea("Descripcion", "Escribe una descripcion sobre el vehiculo", "descripcion", "desc", ""),
        InputText("text", "Modelo", "Modelo", "modelo", "", ""),
        InputText("text", "Fabricante", "Fabricante", "fabricante", "", ""),
        InputText("number", "Año de fabricacion", "Año de fabricacion", "year", ""),
        InputText("text", "Color del vehiculo", "Color del vehiculo", "color", "", ""),
        InputText("text", "Matricula (ABC-1234)", "Matricula", "matricula", "", ""),
        InputSelect("Tipo de transmision", "tipo_transmision", ["Manual", "Automatica", "Secuencial"], "t_transmision", ""),
        InputSelect("Tipo de carroceria", "tipo_carroceria", ["Coupe", "Sedan", "Hatchback", "Cabrio", "Pick-up"], ""),
        InputSelect("Frenos ABS", "frenos_abs", ["Si", "No"], ""),
        InputSelect("Airbag", "airbag", ["Si", "No"], ""),
        InputSelect("Tipo de traccion", "traccion", ["Integral", "Trasera", "Delantera"], ""),
        InputSelect("Tipo de direccion", "direccion", ["Manual", "Hidraulica", "Electrica"], ""),
        InputSelect("Control de estabilidad", "control_estabilidad", ["Si", "No"], ""),
        InputSelect("Numero de puertas", "puertas", ["2", "3", "4", "5"], ""),
        InputText("text", "Tipo de combustible", "Tipo de combustible", "tipo_combustible", "", ""),
        InputText("number", "Precio (USD)", "Precio", "precio", ""),
        InputText("number", "Velocidad maxima (KM/H)", "Velocidad maxima", "velocidad_max", ""),
        InputText("number", "De 0 a 100 (segundos)", "De 0 a 100", "zero_to_houndred", ""),
        InputText("number", "Peso del vehiculo (kg)", "Peso del vehiculo (kg)", "peso", ""),
        InputText("number", "Kilometraje del vehiculo", "Kilometraje del vehiculo", "kilometros", ""),
        InputText("number", "Caballos de fuerza", "Caballos de fuerza", "caballos_fuerza", "")
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

    inputs.forEach(input => vehicleform.appendChild(input))

    const submitInput = document.createElement("button")
    submitInput.textContent = "Agregar"

    vehicleform.appendChild(ImageUploader())
    vehicleform.appendChild(submitInput)

    // vehicleform.addEventListener("submit", e => {
    //     e.preventDefault();
    //     const form_data = new FormData(vehicleform)

    //     console.log([...form_data])

    //     addToast([{ title: "error", error: "Message" }])
    // })

    modalBody.appendChild(vehicleform)



    vehicleform.addEventListener("submit", async e => {
        //El metodo para mostrar el usuario (error.push) va a ser cambiado, por lo tanto 
        //este metodo de corroboracion de errores no funciona pero tampoco tira error
        e.preventDefault()
        const formdata = new FormData(vehicleform)
        const object = {};
        const error = [];
        formdata.forEach((value, key) => {
            if (key !== 'image') {
                object[key] = value
            }
        });


        if (object.nombre.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo nombre se encuentra vacio"
            })
        } else if (object.categoria == "-Seleccione-") {
            error.push({
                title: "Failure",
                error: "El campo categoria es obligatorio"
            })
        } else if (object.descripcion.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo descripcion se encuentra vacio"
            })
        } else if (object.modelo.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo modelo se encuentra vacio"
            })
        } else if (object.fabricante.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo fabricante se encuentra vacio"
            })
        } else if (object.year.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo año de fabricacion se encuentra vacio"
            })
        } else if (object.color.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo color se encuentra vacio"
            })
        } else if (object.matricula.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo matricula se encuentra vacio"
            })
        } else if (object.tipo_transmision == "") {
            error.push({
                title: "Failure",
                error: "El campo tipo de transmision se encuentra vacio"
            })
        } else if (object.tipo_carroceria == "") {
            error.push({
                title: "Failure",
                error: "El campo tipo de carroceria se encuentra vacio"
            })
        } else if (object.FrenosABS == "") {
            error.push({
                title: "Failure",
                error: "El campo frenos ABS se encuentra vacio"
            })
        } else if (object.Airbag == "") {
            error.push({
                title: "Failure",
                error: "El campo airbag se encuentra vacio"
            })
        } else if (object.tipo_traccion == "") {
            error.push({
                title: "Failure",
                error: "El campo tipo de traccion se encuentra vacio"
            })
        } else if (object.tipo_direccion == "") {
            error.push({
                title: "Failure",
                error: "El campo tipo de direccion se encuentra vacio"
            })
        } else if (object.estabilidad == "") {
            error.push({
                title: "Failure",
                error: "El campo control de estabilidad se encuentra vacio"
            })
        } else if (object.puertas == "") {
            error.push({
                title: "Failure",
                error: "El campo numero de puertas se encuentra vacio"
            })
        } else if (object.tipo_combustible.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo tipo de combustible se encuentra vacio"
            })
        } else if (object.precio.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo precio se encuentra vacio"
            })
        } else if (object.velocidad_max.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo velocidad maxima se encuentra vacio"
            })
        } else if (object.zero_to_houndred.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo de 0 a 100 km/h se encuentra vacio"
            })
        } else if (object.peso.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo peso se encuentra vacio"
            })
        } else if (object.kilometros.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo kilometraje del vehiculo se encuentra vacio"
            })
        } else if (object.caballos_fuerza.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo caballos de fuerza se encuentra vacio"
            })
        }

        if (error.length != 0) {
            addToast(error);
        } else {
            try {
                const response = await fetch("http://localhost:3000/dashboard/agregar-vehiculo", {
                    method: "POST",
                    body: formdata
                })
                const data = await response.json();
                console.log(data)
                if (data?.errores) {
                    console.log("server errors")
                    const errors = Object?.values(data?.errores).map(err => {
                        const error = document.createElement("div");
                        error.classList.add("error")
                        error.textContent = err
                        return { title: "Failure", error: err }
                    })
                    addToast(errors);
                } else if (data?.message == "succesfuly") {
                    toggleBackground()
                    contenedor.remove()
                    document.querySelector(".product-search__input").querySelector("button").click()
                    Swal.fire({
                        title: "Exito",
                        text: "El vehiculo fue guardado",
                        icon: "success"
                    });
                    location.reload();
                }
            }
            catch (err) {
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

const ModalModificar = (data) => {
    data.frenos_abs = data.frenos_abs === "abs_si" ? "Si" : "No";
    data.airbag = data.airbag === "airbag_si" ? "Si" : "No";
    data.control_estabilidad = data.control_estabilidad === "est_si" ? "Si" : "No";
    const contenedor = document.createElement("div")

    contenedor.classList.add("modal-container")

    const modal = document.createElement("div")

    modal.classList.add("modal")
    modal.classList.add("modal_modificar")

    const modalHeader = document.createElement("section")

    modalHeader.classList.add("modal-header")

    const btnClose = document.createElement("button")

    const btnImage = document.createElement("img")
    btnImage.src = "/build/src/images/cross.svg"

    btnClose.appendChild(btnImage)

    const divSpacer = document.createElement("div")

    const modalTitle = document.createElement("h3")
    modalTitle.textContent = "Modificar Vehiculo"

    const modvehicleform = document.createElement("form")
    modvehicleform.classList.add("form_addvehicle")
    const inputs = [
        InputText("text", "Nombre", "Nombre", "nombre", "name", data.nombre),
        InputSelect("Categoria", "categoria", ["De fabrica", "Modificados"], "categoria", data.categoria),
        TextArea("Descripcion", "Escribe una descripcion sobre el vehiculo", "descripcion", "desc", data.descripcion),
        InputText("text", "Modelo", "Modelo", "modelo", "", data.modelo),
        InputText("text", "Fabricante", "Fabricante", "fabricante", "", data.fabricante),
        InputText("number", "Año de fabricacion", "Año de fabricacion", "year", "", data.year),
        InputText("text", "Color del vehiculo", "Color del vehiculo", "color", "", data.color),
        InputText("text", "Matricula (ABC-1234)", "Matricula", "matricula", "", data.matricula),
        InputSelect("Tipo de transmision", "tipo_transmision", ["Manual", "Automatica", "Secuencial"], "t_transmision", data.transmision),
        InputSelect("Tipo de carroceria", "tipo_carroceria", ["Coupe", "Sedan", "Hatchback", "Cabrio", "Pick-up"], "", data.tipo_carroceria),
        InputSelect("Frenos ABS", "frenos_abs", ["Si", "No"], "", data.frenos_abs),
        InputSelect("Airbag", "airbag", ["Si", "No"], "", data.airbag),
        InputSelect("Tipo de traccion", "traccion", ["Integral", "Trasera", "Delantera"], "", data.traccion),
        InputSelect("Tipo de direccion", "direccion", ["Manual", "Hidraulica", "Electrica"], "", data.direccion),
        InputSelect("Control de estabilidad", "control_estabilidad", ["Si", "No"], "", data.control_estabilidad),
        InputSelect("Numero de puertas", "puertas", ["2", "3", "4", "5"], "puertas", data.puertas),
        InputText("text", "Tipo de combustible", "Tipo de combustible", "tipo_combustible", "", data.tipo_combustible),
        InputText("number", "Precio (USD)", "Precio", "precio", "", data.precio),
        InputText("number", "Velocidad maxima (KM/H)", "Velocidad maxima", "velocidad_max", "", data.velocidad_max),
        InputText("number", "De 0 a 100 (segundos)", "De 0 a 100", "zero_to_houndred", "", data.zero_to_houndred),
        InputText("number", "Peso del vehiculo (kg)", "Peso del vehiculo (kg)", "peso", "", data.peso),
        InputText("number", "Kilometraje del vehiculo", "Kilometraje del vehiculo", "kilometros", "", data.kilometros),
        InputText("number", "Caballos de fuerza", "Caballos de fuerza", "caballos_fuerza", "", data.caballos_potencia)
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

    inputs.forEach(input => modvehicleform.appendChild(input))

    const submitInput = document.createElement("button")
    submitInput.textContent = "Actualizar"

    modvehicleform.appendChild(ImageUploader())
    modvehicleform.appendChild(submitInput)
    modalBody.appendChild(modvehicleform)

    modvehicleform.addEventListener("submit", async e => {
        e.preventDefault()
        const formdata = new FormData(modvehicleform)
        const object = {};
        const error = [];
        formdata.forEach((value, key) => {
            if (key !== 'image') {
                object[key] = value
            }
        });

        if (object.nombre.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo nombre se encuentra vacio"
            })
        } else if (object.categoria == "-Seleccione-") {
            error.push({
                title: "Failure",
                error: "El campo categoria es obligatorio"
            })
        } else if (object.descripcion.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo descripcion se encuentra vacio"
            })
        } else if (object.modelo.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo modelo se encuentra vacio"
            })
        } else if (object.fabricante.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo fabricante se encuentra vacio"
            })
        } else if (object.year.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo año de fabricacion se encuentra vacio"
            })
        } else if (object.color.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo color se encuentra vacio"
            })
        } else if (object.matricula.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo matricula se encuentra vacio"
            })
        } else if (object.tipo_transmision == "") {
            error.push({
                title: "Failure",
                error: "El campo tipo de transmision se encuentra vacio"
            })
        } else if (object.tipo_carroceria == "") {
            error.push({
                title: "Failure",
                error: "El campo tipo de carroceria se encuentra vacio"
            })
        } else if (object.FrenosABS == "") {
            error.push({
                title: "Failure",
                error: "El campo frenos ABS se encuentra vacio"
            })
        } else if (object.Airbag == "") {
            error.push({
                title: "Failure",
                error: "El campo airbag se encuentra vacio"
            })
        } else if (object.tipo_traccion == "") {
            error.push({
                title: "Failure",
                error: "El campo tipo de traccion se encuentra vacio"
            })
        } else if (object.tipo_direccion == "") {
            error.push({
                title: "Failure",
                error: "El campo tipo de direccion se encuentra vacio"
            })
        } else if (object.estabilidad == "") {
            error.push({
                title: "Failure",
                error: "El campo control de estabilidad se encuentra vacio"
            })
        } else if (object.puertas == "") {
            error.push({
                title: "Failure",
                error: "El campo numero de puertas se encuentra vacio"
            })
        } else if (object.tipo_combustible.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo tipo de combustible se encuentra vacio"
            })
        } else if (object.precio.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo precio se encuentra vacio"
            })
        } else if (object.velocidad_max.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo velocidad maxima se encuentra vacio"
            })
        } else if (object.zero_to_houndred.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo de 0 a 100 km/h se encuentra vacio"
            })
        } else if (object.peso.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo peso se encuentra vacio"
            })
        } else if (object.kilometros.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo kilometraje del vehiculo se encuentra vacio"
            })
        } else if (object.caballos_fuerza.length == 0) {
            error.push({
                title: "Failure",
                error: "El campo caballos de fuerza se encuentra vacio"
            })
        }

        if (error.length != 0) {
            addToast(error);
        } else {
            formdata.append('id', data.id);
            try {
                const response = await fetch("http://localhost:3000/dashboard/modificar-vehiculo", {
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
                    location.reload();
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


const handlerEliminar = (e) => {


    toggleBackground()
    document.body.appendChild(ModalDelete())

}

const handlerModificar = (e) => {
    const vehiculoID = e.currentTarget.id;
    toggleBackground();

    fetchVehiculoData(vehiculoID)
        .then(data => {
            document.body.appendChild(ModalModificar(data));
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
    const response = await fetch("http://localhost:3000/dashboard/obtener-vehiculo", {
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


const handlerAgregar = (e) => {
    toggleBackground()
    document.body.appendChild(ModalAdd())
}




const AgregarBtn = document.querySelector(".product-add__input")

if (AgregarBtn) {
    AgregarBtn.addEventListener("click", handlerAgregar)
}



