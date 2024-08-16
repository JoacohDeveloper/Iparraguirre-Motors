
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
const InputText = (type, label, placeholder, id) => {
    const inputLabel = document.createElement('label')
    const input = document.createElement('input')
    input.type = type
    input.id = id
    inputLabel.htmlFor = input.id

    inputLabel.textContent = label
    input.placeholder = placeholder

    inputLabel.appendChild(input)

    return inputLabel
}
const InputSelect = (label, id, values) => {
    const inputSelectLabel = document.createElement('label');
    const inputSelect = document.createElement('select');
    inputSelect.id = id;

    inputSelectLabel.htmlFor = id; 
    inputSelectLabel.textContent = label;
    
    // Añadir el select al label
    inputSelectLabel.appendChild(inputSelect);

    // Crear una opción para el valor "-Seleccione-"
    const defaultOption = document.createElement('option');
    defaultOption.textContent = '-Seleccione-';
    inputSelect.appendChild(defaultOption);

    // Añadir las opciones proporcionadas
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
        InputText("text", "Nombre", "Nombre", ""),
        InputText("text", "Descripcion", "Descripcion", ""),
        InputText("text", "Modelo", "Modelo", ""),
        InputText("text", "Fabricante", "Fabricante", ""),
        InputText("number", "Año de fabricacion", "Año de fabricacion", ""),
        InputText("text", "Color del vehiculo", "Color del vehiculo", ""),
        InputText("text", "Matricula", "Matricula", ""),
        InputSelect('Tipo de transmision', '', ['Manual', 'Automatica', 'Secuencial']),
        InputSelect('Tipo de carroceria', '', ['Coupe', 'Sedan', 'Hatchback', 'Cabrio', 'Pick-up']),
        InputSelect('Frenos ABS', '', ['Si', 'No']),
        InputSelect('Airbag', '', ['Si', 'No']),
        InputSelect('Tipo de traccion', '', ['Integral', 'Trasera', 'Delantera']),
        InputSelect('Tipo de direccion', '', ['Manual', 'Hidraulica', 'Electrica']),
        InputSelect('Control de estabilidad', '', ['Si', 'No']),
        InputSelect('Numero de puertas', '', ['2', '3', '4', '5']),
        InputText("text", "Tipo de combustible", "Tipo de combustible", ""),
        InputText("number", "Precio", "Precio", ""),
        InputText("number", "Velocidad maxima", "Velocidad maxima", ""),
        InputText("text", "De 0 a 100", "De 0 a 100", ""),
        InputText("number", "Peso del vehiculo (kg)", "Peso del vehiculo (kg)", ""),
        InputText("number", "Kilometraje del vehiculo", "Kilometraje del vehiculo", ""),
        InputText("number", "Caballos de fuerza", "Caballos de fuerza", "")
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

if(AgregarBtn) {
    AgregarBtn.addEventListener("click", handlerAgregar)
}


