
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
    const delete_form = InputText("text", "Palabra de seguridad", "eliminar producto", "delete-input");




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
//genera las casillas en las que el administrador debe escribir y las otras dos generan los select y options
//del select en donde en administrador selecciona la opcion en base al vehiculo que se esta agregando
const InputText = (type, label, placeholder, name) => {
    const inputLabel = document.createElement('label')
    const input = document.createElement('input')
    input.type = type
    input.name = name

    inputLabel.textContent = label
    input.placeholder = placeholder

    inputLabel.appendChild(input)

    return inputLabel
}
const TextArea = (label, placeholder, name) => {
    const inputLabel = document.createElement('label');
    const textarea = document.createElement('textarea');
    textarea.name = name;

    inputLabel.textContent = label;
    textarea.placeholder = placeholder;

    inputLabel.appendChild(textarea);

    return inputLabel;
}

const InputSelect = (label, name, values) => {
    const inputSelectLabel = document.createElement('label');
    const inputSelect = document.createElement('select');
    inputSelect.name = name;
    inputSelectLabel.textContent = label;
    inputSelectLabel.appendChild(inputSelect);

    // Crear una opción para el valor por defecto
    const defaultOption = document.createElement('option');
    defaultOption.textContent = '-Seleccione-';
    inputSelect.appendChild(defaultOption);

    values.forEach(value => {
        const optionElement = document.createElement('option');
        optionElement.value = value;
        optionElement.textContent = value;
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
        InputText("text", "Nombre", "Nombre", "nombre"),
        TextArea('Descripcion', 'Escribe una descripcion sobre el vehiculo', 'descripcion'),
        InputText("text", "Modelo", "Modelo", "modelo"),
        InputText("text", "Fabricante", "Fabricante", "fabricante"),
        InputText("number", "Año de fabricacion", "Año de fabricacion", "year"),
        InputText("text", "Color del vehiculo", "Color del vehiculo", "color"),
        InputText("text", "Matricula", "Matricula", "matricula"),
        InputSelect("Tipo de transmision", "tipo_transmision", ["Manual", "Automatica", "Secuencial"]),
        InputSelect("Tipo de carroceria", "tipo_carroceria", ["Coupe", "Sedan", "Hatchback", "Cabrio", "Pick-up"]),
        InputSelect("Frenos ABS", "frenos_abs", ["Si", "No"]),
        InputSelect("Airbag", "airbag", ["Si", "No"]),
        InputSelect("Tipo de traccion", "traccion", ["Integral", "Trasera", "Delantera"]),
        InputSelect("Tipo de direccion", "direccion", ["Manual", "Hidraulica", "Electrica"]),
        InputSelect("Control de estabilidad", "control_estabilidad", ["Si", "No"]),
        InputSelect("Numero de puertas", "puertas", ["2", "3", "4", "5"]),
        InputText("text", "Tipo de combustible", "Tipo de combustible", "tipo_combustible"),
        InputText("number", "Precio", "Precio", "precio"),
        InputText("number", "Velocidad maxima", "Velocidad maxima", "velocidad_max"),
        InputText("text", "De 0 a 100", "De 0 a 100", "zero_to_houndred"),
        InputText("number", "Peso del vehiculo (kg)", "Peso del vehiculo (kg)", "peso"),
        InputText("number", "Kilometraje del vehiculo", "Kilometraje del vehiculo", "kilometros"),
        InputText("number", "Caballos de fuerza", "Caballos de fuerza", "caballos_fuerza")
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

    inputs.forEach(input => {
        const inputLabel = document.createElement('label');
        const div = document.createElement('div');
        div.classList.add('input-underline');
        inputLabel.appendChild(input);
        inputLabel.appendChild(div);
        vehicleform.appendChild(inputLabel);
    });





    const submitInput = document.createElement("button")
    submitInput.textContent = "Agregar"

    vehicleform.appendChild(ImageUploader())
    vehicleform.appendChild(submitInput)

    vehicleform.addEventListener("submit", e => {
        e.preventDefault();
        const form_data = new FormData(vehicleform)

        console.log([...form_data])

        addToast([{ Title: "error", error: "Message" }])
    })

    modalBody.appendChild(vehicleform)

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

}


const handlerAgregar = (e) => {
    toggleBackground()
    document.body.appendChild(ModalAdd())
}




const AgregarBtn = document.querySelector(".product-add__input")

if (AgregarBtn) {
    AgregarBtn.addEventListener("click", handlerAgregar)

}


