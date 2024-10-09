

const ErrorComp = (text) => {



    const errorContainer = document.createElement("div")
    errorContainer.classList.add("error-input-container")
    const errorText = document.createElement("p")
    errorText.textContent = text;

    errorContainer.appendChild(errorText)

    return errorContainer
}



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

const prueba = location.origin + "/dashboard/agregar-vehiculo"
console.log(prueba)

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

const ModalAdd = async () => {
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

    const detailsSectionInputs = [
        InputText("text", "Nombre", "Nombre", "nombre", "name", ""),
        InputSelect("Categoria", "categoria", ["De fabrica", "Modificados"], "categoria", ""),
        TextArea("Descripcion", "Escribe una descripcion sobre el vehiculo", "descripcion", "desc", ""),
    ]

    const detailsSectionInputs2 = [
        InputText("text", "Modelo", "Modelo", "modelo", "", ""),
        InputText("text", "Fabricante", "Fabricante", "fabricante", "", ""),
        InputText("number", "Año de fabricacion", "Año de fabricacion", "year", ""),
    ]

    const specsSectionInputs = [
        InputText("text", "Color del vehiculo", "Color del vehiculo", "color", "", ""),
        InputText("text", "Matricula (ABC-1234)", "Matricula", "matricula", "", ""),
        InputSelect("Tipo de transmision", "tipo_transmision", ["Manual", "Automatica", "Secuencial"], "t_transmision", ""),
        InputSelect("Tipo de carroceria", "tipo_carroceria", ["Coupe", "Sedan", "Hatchback", "Cabrio", "Pick-up"], ""),
        InputSelect("Frenos ABS", "frenos_abs", ["Si", "No"], ""),
    ]

    const specsSectionInputs2 = [
        InputSelect("Airbag", "airbag", ["Si", "No"], ""),
        InputSelect("Tipo de traccion", "traccion", ["Integral", "Trasera", "Delantera"], ""),
        InputSelect("Tipo de direccion", "direccion", ["Manual", "Hidraulica", "Electrica"], ""),
        InputSelect("Control de estabilidad", "control_estabilidad", ["Si", "No"], ""),
        InputSelect("Numero de puertas", "puertas", ["2", "3", "4", "5"], ""),
    ]

    const perfSectionInputs = [
        InputText("text", "Tipo de combustible", "Tipo de combustible", "tipo_combustible", "", ""),
        InputText("number", "Precio (USD)", "Precio", "precio", ""),
        InputText("number", "Velocidad maxima (KM/H)", "Velocidad maxima", "velocidad_max", ""),
        InputText("number", "De 0 a 100 (segundos)", "De 0 a 100", "zero_to_houndred", ""),

    ]
    const perfSectionInputs2 = [
        InputText("number", "Peso del vehiculo (kg)", "Peso del vehiculo (kg)", "peso", ""),
        InputText("number", "Kilometraje del vehiculo", "Kilometraje del vehiculo", "kilometros", ""),
        InputText("number", "Caballos de fuerza", "Caballos de fuerza", "caballos_fuerza", "")
    ]


    //cambio de seccion

    async function envioForm() {
        let formdata = new FormData(vehicleform)
        const object = {};
        const error = [];


        formdata.forEach((value, key) => {
            if (key === 'imagen[]') {
                if (value.name !== '') {
                    object[key] = value
                }
            } else {
                object[key] = value
            }
        });

        if (!object["imagen[]"]) {
            formdata = new FormData()
            Object.entries(object).forEach(data => {
                formdata.append(data[0], data[1])
            })
        }


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
                botonSiguiente.disabled = true;
                const response = await fetch(location.origin + "/dashboard/agregar-vehiculo", {
                    method: "POST",
                    body: formdata
                });

                botonSiguiente.disabled = false;

                const data = await response.json();
                console.log(data);

                if (data.status === "error") {
                    console.log("Server errors:", data.message);
                    const errors = data.detalles || [data.message];

                    errors.forEach(err => {
                        console.log("Error:", err);
                    });

                    const errorElements = errors.map(err => {
                        const error = document.createElement("div");
                        error.classList.add("error");
                        error.textContent = err;
                        return error;
                    });
                    addToast(errorElements);
                } else if (data.status === "success") {
                    contenedor.remove();

                    document.querySelector(".dashboard-content").classList.remove("fixed");
                    document.body.classList.remove("blured");
                    Swal.fire({
                        title: "Éxito",
                        text: "El vehículo fue guardado",
                        icon: "success"
                    });
                    const btn_swal = document.querySelector(".swal2-confirm");
                    if (btn_swal) {
                        btn_swal.addEventListener("click", () => {
                            document.querySelector(".product-search__input").querySelector("button").click();
                        })
                    }
                }
            } catch (err) {
                console.error("Error en la petición:", err);
                addToast([{
                    title: "Failure",
                    error: "Ha ocurrido un error"
                }]);
            }

        }
    }

    vehicleform.addEventListener("submit", async e => {
        //El metodo para mostrar el usuario (error.push) va a ser cambiado, por lo tanto 
        //este metodo de corroboracion de errores no funciona pero tampoco tira error
        e.preventDefault()

    })


    function cambiarSeccion(stepActual, stepSiguiente) {

        function validar(inputs) {
            inputs.forEach(input => {
                input.classList.remove("error")
                input.parentElement.querySelector(".error-input-container")?.remove()
            })
            const errores = []
            inputs.forEach(input => {
                const error = ErrorComp("")
                const errorText = error.querySelector("p")

                if (input.tagName == "INPUT" || input.tagName == "TEXTAREA") {

                    if (input.value == "") {
                        input.classList.add("error")
                        errorText.textContent = `el campo ${input.parentElement.textContent.toLowerCase()} no puede estar vacio`
                        input.parentElement.appendChild(error)
                        errores.push({
                            input,
                            error: errorText.textContent
                        })
                    } else {
                        input.classList.remove("error")
                        input.parentElement.querySelector(".error-input-container")?.remove()

                    }
                } else if (input.tagName == "SELECT") {
                    if (input.selectedIndex == 0) {
                        input.classList.add("error")
                        errorText.textContent = `debes seleccionar un elemento`
                        input.parentElement.appendChild(error)
                        errores.push({
                            input,
                            error: errorText.textContent
                        })
                    } else {
                        input.classList.remove("error")
                        input.parentElement.querySelector(".error-input-container")?.remove()
                    }

                }


            })

            return errores;
        }
        let inputsLabels;
        let inputs;
        let errores;
        //verificar si se puede enviar
        if (stepSiguiente == "4") {
            // console.log("pagina final")
            inputsLabels = [...detailsSectionInputs, ...detailsSectionInputs2,
            ...specsSectionInputs, ...specsSectionInputs2,
            ...perfSectionInputs, ...perfSectionInputs2
            ]

            inputs = inputsLabels.map(label => label.childNodes[1])

            errores = validar(inputs)
            if (errores.length == 0) {

                botonSiguiente.disabled = false;
                botonSiguiente.type = "submit"
            } else {
                botonSiguiente.disabled = true;
                botonSiguiente.type = ""
            }


        }

        //validar que cada seccion este done
        const btnActual = tabsBtns.querySelector(`[aria-label='step-${stepActual}']`)

        switch (+stepActual) {
            case 1:

                inputsLabels = [...detailsSectionInputs, ...detailsSectionInputs2]

                inputs = inputsLabels.map(label => label.childNodes[1])

                //validar inputs de seccion detalles    
                errores = validar(inputs)

                if (errores.length == 0) {
                    btnActual.classList.add("done")
                } else {
                    btnActual.classList.remove("done")
                }

                break;
            case 2:

                inputsLabels = [...specsSectionInputs, ...specsSectionInputs2]

                inputs = inputsLabels.map(label => label.childNodes[1])

                //validar inputs de seccion detalles    
                errores = validar(inputs)

                if (errores.length == 0) {
                    btnActual.classList.add("done")
                } else {
                    btnActual.classList.remove("done")
                }
                break;
            case 3:
                inputsLabels = [...perfSectionInputs, ...perfSectionInputs2]

                inputs = inputsLabels.map(label => label.childNodes[1])

                //validar inputs de seccion detalles    
                errores = validar(inputs)

                if (errores.length == 0) {
                    btnActual.classList.add("done")
                } else {
                    btnActual.classList.remove("done")
                }
                break;
            case 4:
                btnActual.classList.add("done")

                break;
            default: {

            }

        }

    }


    modalHeader.appendChild(divSpacer)
    modalHeader.appendChild(modalTitle)
    modalHeader.appendChild(btnClose)

    btnClose.addEventListener("click", e => {
        toggleBackground()
        contenedor.remove()
    })

    const modalBody = document.createElement("section")
    modalBody.classList.add("modal-body")


    //---------------------- TABS
    const tabsBtns = document.createElement("div")
    tabsBtns.classList.add("tabs-container")

    const tabButton = document.createElement("button");
    tabButton.classList.add("selected")
    tabButton.ariaLabel = "step-1"


    tabButton.textContent = "Detalles del Vehiculo"

    const tabButton2 = document.createElement("button");
    tabButton2.ariaLabel = "step-2"
    tabButton2.textContent = "Especificaciones de Rendimiento"

    const tabButton3 = document.createElement("button");
    tabButton3.ariaLabel = "step-3"

    tabButton3.textContent = "Especificaciones Técnicas"

    const tabButton4 = document.createElement("button");
    tabButton4.ariaLabel = "step-4"

    tabButton4.textContent = "Agregar Imagenes"

    tabButton.id = "details"
    tabButton2.id = "perf"
    tabButton3.id = "specs"
    tabButton4.id = "image-selector"

    tabsBtns.appendChild(tabButton)
    tabsBtns.appendChild(tabButton2)
    tabsBtns.appendChild(tabButton3)
    tabsBtns.appendChild(tabButton4)



    modalBody.appendChild(tabsBtns)

    //---------------------------------


    //--------------------DETAILS-----------------
    const detailsSection = document.createElement("section")

    const detailsSectionTitle = document.createElement("p")
    detailsSectionTitle.textContent = "Detalles del Vehiculo"
    const detailsSectionLabelContainer = document.createElement("article")
    const detailsSectionLabels = document.createElement("div")
    const detailsSectionLabels2 = document.createElement("div")
    detailsSection.appendChild(detailsSectionTitle)
    detailsSection.appendChild(detailsSectionLabelContainer)


    detailsSectionLabelContainer.appendChild(detailsSectionLabels)
    detailsSectionLabelContainer.appendChild(detailsSectionLabels2)
    detailsSection.classList.add("settingsStepVisible")

    detailsSection.setAttribute("aria-step", "1")

    detailsSectionInputs.forEach(input => detailsSectionLabels.appendChild(input))
    detailsSectionInputs2.forEach(input => detailsSectionLabels2.appendChild(input))
    //---------------------------------------------------------------------------

    const specSectionLabelContainer = document.createElement("article")
    const specSectionLabels = document.createElement("div")
    const specSectionLabels2 = document.createElement("div")
    const specSection = document.createElement("section")
    const specSectionTitle = document.createElement("p")
    specSectionTitle.textContent = "Especificaciones de Rendimiento"
    specSection.appendChild(specSectionTitle)
    specSection.appendChild(specSectionLabelContainer)

    specSectionLabelContainer.appendChild(specSectionLabels)
    specSectionLabelContainer.appendChild(specSectionLabels2)

    specsSectionInputs.forEach(input => specSectionLabels.appendChild(input))
    specsSectionInputs2.forEach(input => specSectionLabels2.appendChild(input))

    specSection.setAttribute("aria-step", "2")
    //------------------------------------
    const perfSection = document.createElement("section")

    const perfSectionTitle = document.createElement("p")
    perfSectionTitle.textContent = "Especificaciones Tecnicas"
    perfSection.appendChild(perfSectionTitle)
    const perfSectionLabelContainer = document.createElement("article")
    const perfSectionLabels = document.createElement("div")
    const perfSectionLabels2 = document.createElement("div")
    perfSection.appendChild(perfSectionLabelContainer)

    perfSectionLabelContainer.appendChild(perfSectionLabels)
    perfSectionLabelContainer.appendChild(perfSectionLabels2)

    perfSectionInputs.forEach(input => perfSectionLabels.appendChild(input))
    perfSectionInputs2.forEach(input => perfSectionLabels2.appendChild(input))

    perfSection.setAttribute("aria-step", "3")

    const imageSection = document.createElement("section")

    const imageSectionTitle = document.createElement("p")
    imageSectionTitle.textContent = "Agregar Imagenes"
    imageSection.appendChild(imageSectionTitle)

    imageSection.appendChild(await ImageUploader())
    imageSection.setAttribute("aria-step", "4")

    vehicleform.appendChild(detailsSection)
    vehicleform.appendChild(specSection)
    vehicleform.appendChild(perfSection)
    vehicleform.appendChild(imageSection)

    tabsBtns.addEventListener("click", e => {
        if (e.target.ariaLabel) {
            localStorage.setItem("step", JSON.stringify(e.target?.ariaLabel ?? "step-1"))
            const step = e.target?.ariaLabel.split("-")[1];
            setSettingSection(step)
        }
    })

    function setSettingSection(step) {
        const section = document.querySelector(`[aria-step="${step}"]`)
        const previus = document.querySelector(".settingsStepVisible")
        if (section) {
            if (previus && section != previus) {
                previus.classList.remove("settingsStepVisible")
                section.classList.add("settingsStepVisible")
            }

        }
    }

    const modalFooter = document.createElement("section")
    modalFooter.classList.add("modal-footer")

    const botonVolver = document.createElement("button")
    botonVolver.classList.add("modal-footer_volver")
    const botonSiguiente = document.createElement("button")
    botonSiguiente.classList.add("modal-footer_siguiente")
    botonVolver.textContent = "Atras"
    botonSiguiente.textContent = "Siguiente"
    botonVolver.disabled = true;

    botonSiguiente.addEventListener("click", () => {

        if (botonSiguiente.classList.contains("button-enviar")) {
            envioForm()
        }

    })

    function switchSelected(item) {
        const step = item.ariaLabel.substring(5, 6);
        const lastItem = [...menuItems].find(el => el.classList.contains("selected"))
        menuItems.forEach(el => el.classList.remove("selected"));
        const lastStep = lastItem.ariaLabel.substring(5, 6);
        item.classList.add("selected");
        cambiarSeccion(lastStep, step);
        if (item.ariaLabel == "step-1") {
            botonVolver.disabled = true;
            botonSiguiente.disabled = false;
            botonSiguiente.classList.remove("button-enviar")
            botonSiguiente.textContent = "Siguiente"
        } else if (item.ariaLabel == "step-4") {
            botonVolver.disabled = false;
            botonSiguiente.textContent = "Enviar"
            botonSiguiente.classList.add("button-enviar")
        } else {
            botonSiguiente.disabled = false;
            botonVolver.disabled = false;
            botonSiguiente.textContent = "Siguiente"
            botonSiguiente.classList.remove("button-enviar")
        }

    }
    const menuItems = tabsBtns.querySelectorAll("*")
    menuItems.forEach(item => item.addEventListener("click", () => {
        switchSelected(item)
    }));

    const submitInput = document.createElement("button")
    submitInput.textContent = "Agregar"

    //vehicleform.appendChild(ImageUploader())
    // vehicleform.appendChild(submitInput)

    // vehicleform.addEventListener("submit", e => {
    //     e.preventDefault();
    //     const form_data = new FormData(vehicleform)

    //     console.log([...form_data])

    //     addToast([{ title: "error", error: "Message" }])
    // })

    modalBody.appendChild(vehicleform)




    contenedor.appendChild(modal)

    modal.appendChild(modalHeader)
    modal.appendChild(modalBody)

    modal.appendChild(modalFooter)


    botonVolver.addEventListener("click", e => {

        const tabActual = tabsBtns.querySelector(".selected")

        switchSelected(tabActual)

        const stepActual = +tabActual.ariaLabel.substring(5, 6);

        if (stepActual > 1) {
            const stepSiguiente = stepActual - 1
            cambiarSeccion(stepActual, stepSiguiente)

            tabsBtns.querySelector(`[aria-label='step-${stepSiguiente}']`).click()

        }



    })

    botonSiguiente.addEventListener("click", e => {
        const tabActual = tabsBtns.querySelector(".selected")

        switchSelected(tabActual)

        const stepActual = +tabActual.ariaLabel.substring(5, 6);

        if (stepActual < 4) {
            const stepSiguiente = stepActual + 1
            cambiarSeccion(stepActual, stepSiguiente)

            tabsBtns.querySelector(`[aria-label='step-${stepSiguiente}']`).click()

        }
    })


    modalFooter.appendChild(botonVolver)
    modalFooter.appendChild(botonSiguiente)

    vehicleform.querySelectorAll("input,  textarea, select")
        .forEach(input => {
            input.addEventListener("change", e => {
                const error = ErrorComp("")
                const errorText = error.querySelector("p")

                if (e.target.tagName == "INPUT" || e.target.tagName == "TEXTAREA") {

                    if (e.target.value == "") {
                        e.target.classList.add("error")
                        errorText.textContent = `el campo ${e.target.parentElement.textContent.toLowerCase()} no puede estar vacio`
                        e.target.parentElement.appendChild(error)
                    } else {
                        e.target.classList.remove("error")
                        e.target.parentElement.querySelector(".error-input-container")?.remove()

                    }
                } else if (e.target.tagName == "SELECT") {
                    if (e.target.selectedIndex == 0) {
                        e.target.classList.add("error")
                        errorText.textContent = `debes seleccionar un elemento`
                        e.target.parentElement.appendChild(error)
                    } else {
                        e.target.classList.remove("error")
                        e.target.parentElement.querySelector(".error-input-container")?.remove()

                    }
                }
            })
        })

    return contenedor;
}



const ModalModificar = async (data) => {
    console.log(data)
    data.frenos_abs = data.frenos_abs === "abs_si" ? "Si" : "No";
    data.airbag = data.airbag === "airbag_si" ? "Si" : "No";
    data.control_estabilidad = data.control_estabilidad === "est_si" ? "Si" : "No";

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
    modalTitle.textContent = "Modificar Vehiculo"

    const vehicleform = document.createElement("form")

    const inputId = document.createElement("input")
    inputId.name = "id"
    inputId.type = "hidden"
    inputId.value = data.id;


    vehicleform.appendChild(inputId)
    vehicleform.classList.add("form_addvehicle")

    const detailsSectionInputs = [
        InputText("text", "Nombre", "Nombre", "nombre", "name", data.nombre),
        InputSelect("Categoria", "categoria", ["De fabrica", "Modificados"], "categoria", data.categoria),
        TextArea("Descripcion", "Escribe una descripcion sobre el vehiculo", "descripcion", "desc", data.descripcion),
    ]

    const detailsSectionInputs2 = [
        InputText("text", "Modelo", "Modelo", "modelo", "", data.modelo),
        InputText("text", "Fabricante", "Fabricante", "fabricante", "", data.fabricante),
        InputText("number", "Año de fabricacion", "Año de fabricacion", "year", "", data.year),
    ]

    const specsSectionInputs = [
        InputText("text", "Color del vehiculo", "Color del vehiculo", "color", "", data.color),
        InputText("text", "Matricula (ABC-1234)", "Matricula", "matricula", "", data.matricula),
        InputSelect("Tipo de transmision", "tipo_transmision", ["Manual", "Automatica", "Secuencial"], "t_transmision", data.transmision),
        InputSelect("Tipo de carroceria", "tipo_carroceria", ["Coupe", "Sedan", "Hatchback", "Cabrio", "Pick-up"], "", data.tipo_carroceria),
        InputSelect("Frenos ABS", "frenos_abs", ["Si", "No"], "", data.frenos_abs),
    ]

    const specsSectionInputs2 = [
        InputSelect("Airbag", "airbag", ["Si", "No"], "", data.airbag),
        InputSelect("Tipo de traccion", "traccion", ["Integral", "Trasera", "Delantera"], "", data.traccion),
        InputSelect("Tipo de direccion", "direccion", ["Manual", "Hidraulica", "Electrica"], "", data.direccion),
        InputSelect("Control de estabilidad", "control_estabilidad", ["Si", "No"], "", data.control_estabilidad),
        InputSelect("Numero de puertas", "puertas", ["2", "3", "4", "5"], "", data.puertas),
    ]

    const perfSectionInputs = [
        InputText("text", "Tipo de combustible", "Tipo de combustible", "tipo_combustible", "", data.tipo_combustible),
        InputText("number", "Precio (USD)", "Precio", "precio", "", data.precio),
        InputText("number", "Velocidad maxima (KM/H)", "Velocidad maxima", "velocidad_max", "", data.velocidad_max),
        InputText("number", "De 0 a 100 (segundos)", "De 0 a 100", "zero_to_houndred", "", data.zero_to_houndred),

    ]
    const perfSectionInputs2 = [
        InputText("number", "Peso del vehiculo (kg)", "Peso del vehiculo (kg)", "peso", "", data.peso),
        InputText("number", "Kilometraje del vehiculo", "Kilometraje del vehiculo", "kilometros", "", data.kilometros),
        InputText("number", "Caballos de fuerza", "Caballos de fuerza", "caballos_fuerza", "", data.caballos_potencia)
    ]




    //cambio de seccion

    async function envioForm() {
        let formdata = new FormData(vehicleform)
        const object = {};
        const error = [];


        formdata.forEach((value, key) => {
            if (key === 'imagen[]') {
                if (value.name !== '') {
                    object[key] = value
                }
            } else {
                object[key] = value
            }
        });

        if (!object["imagen[]"]) {
            formdata = new FormData()
            Object.entries(object).forEach(data => {
                formdata.append(data[0], data[1])
            })
        }


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
                const response = await fetch(location.origin + "/dashboard/modificar-vehiculo", {
                    method: "POST",
                    body: formdata
                });

                botonSiguiente.disabled = false;

                const data = await response.json();

                if (data?.error) {

                    addToast([{ title: "error", error: data?.error }]);
                } else if (data?.message === "successfuly") {
                    contenedor.remove();

                    document.querySelector(".dashboard-content").classList.remove("fixed");
                    document.body.classList.remove("blured");
                    Swal.fire({
                        title: "Éxito",
                        text: "El vehículo fue guardado",
                        icon: "success"
                    });
                    const btn_swal = document.querySelector(".swal2-confirm");
                    if (btn_swal) {
                        btn_swal.addEventListener("click", () => {
                            document.querySelector(".product-search__input").querySelector("button").click();
                        })
                    }
                }
            } catch (err) {
                console.error("Error en la petición:", err);
                addToast([{
                    title: "Failure",
                    error: "Ha ocurrido un error"
                }]);
            }

        }
    }

    vehicleform.addEventListener("submit", async e => {
        //El metodo para mostrar el usuario (error.push) va a ser cambiado, por lo tanto 
        //este metodo de corroboracion de errores no funciona pero tampoco tira error
        e.preventDefault()

    })


    function cambiarSeccion(stepActual, stepSiguiente) {

        function validar(inputs) {
            inputs.forEach(input => {
                input.classList.remove("error")
                input.parentElement.querySelector(".error-input-container")?.remove()
            })
            const errores = []
            inputs.forEach(input => {
                const error = ErrorComp("")
                const errorText = error.querySelector("p")

                if (input.tagName == "INPUT" || input.tagName == "TEXTAREA") {

                    if (input.value == "") {
                        input.classList.add("error")
                        errorText.textContent = `el campo ${input.parentElement.textContent.toLowerCase()} no puede estar vacio`
                        input.parentElement.appendChild(error)
                        errores.push({
                            input,
                            error: errorText.textContent
                        })
                    } else {
                        input.classList.remove("error")
                        input.parentElement.querySelector(".error-input-container")?.remove()

                    }
                } else if (input.tagName == "SELECT") {
                    if (input.selectedIndex == 0) {
                        input.classList.add("error")
                        errorText.textContent = `debes seleccionar un elemento`
                        input.parentElement.appendChild(error)
                        errores.push({
                            input,
                            error: errorText.textContent
                        })
                    } else {
                        input.classList.remove("error")
                        input.parentElement.querySelector(".error-input-container")?.remove()
                    }

                }


            })

            return errores;
        }
        let inputsLabels;
        let inputs;
        let errores;
        //verificar si se puede enviar
        if (stepSiguiente == "4") {
            // console.log("pagina final")
            inputsLabels = [...detailsSectionInputs, ...detailsSectionInputs2,
            ...specsSectionInputs, ...specsSectionInputs2,
            ...perfSectionInputs, ...perfSectionInputs2
            ]

            inputs = inputsLabels.map(label => label.childNodes[1])

            errores = validar(inputs)
            if (errores.length == 0) {

                botonSiguiente.disabled = false;
                botonSiguiente.type = "submit"
            } else {
                botonSiguiente.disabled = true;
                botonSiguiente.type = ""
            }


        }

        //validar que cada seccion este done
        const btnActual = tabsBtns.querySelector(`[aria-label='step-${stepActual}']`)

        switch (+stepActual) {
            case 1:

                inputsLabels = [...detailsSectionInputs, ...detailsSectionInputs2]

                inputs = inputsLabels.map(label => label.childNodes[1])

                //validar inputs de seccion detalles    
                errores = validar(inputs)

                if (errores.length == 0) {
                    btnActual.classList.add("done")
                } else {
                    btnActual.classList.remove("done")
                }

                break;
            case 2:

                inputsLabels = [...specsSectionInputs, ...specsSectionInputs2]

                inputs = inputsLabels.map(label => label.childNodes[1])

                //validar inputs de seccion detalles    
                errores = validar(inputs)

                if (errores.length == 0) {
                    btnActual.classList.add("done")
                } else {
                    btnActual.classList.remove("done")
                }
                break;
            case 3:
                inputsLabels = [...perfSectionInputs, ...perfSectionInputs2]

                inputs = inputsLabels.map(label => label.childNodes[1])

                //validar inputs de seccion detalles    
                errores = validar(inputs)

                if (errores.length == 0) {
                    btnActual.classList.add("done")
                } else {
                    btnActual.classList.remove("done")
                }
                break;
            case 4:
                btnActual.classList.add("done")

                break;
            default: {

            }

        }

    }


    modalHeader.appendChild(divSpacer)
    modalHeader.appendChild(modalTitle)
    modalHeader.appendChild(btnClose)

    btnClose.addEventListener("click", e => {
        toggleBackground()
        contenedor.remove()
    })

    const modalBody = document.createElement("section")
    modalBody.classList.add("modal-body")


    //---------------------- TABS
    const tabsBtns = document.createElement("div")
    tabsBtns.classList.add("tabs-container")

    const tabButton = document.createElement("button");
    tabButton.classList.add("selected")
    tabButton.ariaLabel = "step-1"


    tabButton.textContent = "Detalles del Vehiculo"

    const tabButton2 = document.createElement("button");
    tabButton2.ariaLabel = "step-2"
    tabButton2.textContent = "Especificaciones de Rendimiento"

    const tabButton3 = document.createElement("button");
    tabButton3.ariaLabel = "step-3"

    tabButton3.textContent = "Especificaciones Técnicas"

    const tabButton4 = document.createElement("button");
    tabButton4.ariaLabel = "step-4"

    tabButton4.textContent = "Agregar Imagenes"

    tabButton.id = "details"
    tabButton2.id = "perf"
    tabButton3.id = "specs"
    tabButton4.id = "image-selector"

    tabsBtns.appendChild(tabButton)
    tabsBtns.appendChild(tabButton2)
    tabsBtns.appendChild(tabButton3)
    tabsBtns.appendChild(tabButton4)



    modalBody.appendChild(tabsBtns)

    //---------------------------------


    //--------------------DETAILS-----------------
    const detailsSection = document.createElement("section")

    const detailsSectionTitle = document.createElement("p")
    detailsSectionTitle.textContent = "Detalles del Vehiculo"
    const detailsSectionLabelContainer = document.createElement("article")
    const detailsSectionLabels = document.createElement("div")
    const detailsSectionLabels2 = document.createElement("div")
    detailsSection.appendChild(detailsSectionTitle)
    detailsSection.appendChild(detailsSectionLabelContainer)


    detailsSectionLabelContainer.appendChild(detailsSectionLabels)
    detailsSectionLabelContainer.appendChild(detailsSectionLabels2)
    detailsSection.classList.add("settingsStepVisible")

    detailsSection.setAttribute("aria-step", "1")

    detailsSectionInputs.forEach(input => detailsSectionLabels.appendChild(input))
    detailsSectionInputs2.forEach(input => detailsSectionLabels2.appendChild(input))
    //---------------------------------------------------------------------------

    const specSectionLabelContainer = document.createElement("article")
    const specSectionLabels = document.createElement("div")
    const specSectionLabels2 = document.createElement("div")
    const specSection = document.createElement("section")
    const specSectionTitle = document.createElement("p")
    specSectionTitle.textContent = "Especificaciones de Rendimiento"
    specSection.appendChild(specSectionTitle)
    specSection.appendChild(specSectionLabelContainer)

    specSectionLabelContainer.appendChild(specSectionLabels)
    specSectionLabelContainer.appendChild(specSectionLabels2)

    specsSectionInputs.forEach(input => specSectionLabels.appendChild(input))
    specsSectionInputs2.forEach(input => specSectionLabels2.appendChild(input))

    specSection.setAttribute("aria-step", "2")
    //------------------------------------
    const perfSection = document.createElement("section")

    const perfSectionTitle = document.createElement("p")
    perfSectionTitle.textContent = "Especificaciones Tecnicas"
    perfSection.appendChild(perfSectionTitle)
    const perfSectionLabelContainer = document.createElement("article")
    const perfSectionLabels = document.createElement("div")
    const perfSectionLabels2 = document.createElement("div")
    perfSection.appendChild(perfSectionLabelContainer)

    perfSectionLabelContainer.appendChild(perfSectionLabels)
    perfSectionLabelContainer.appendChild(perfSectionLabels2)

    perfSectionInputs.forEach(input => perfSectionLabels.appendChild(input))
    perfSectionInputs2.forEach(input => perfSectionLabels2.appendChild(input))

    perfSection.setAttribute("aria-step", "3")

    const imageSection = document.createElement("section")

    const imageSectionTitle = document.createElement("p")
    imageSectionTitle.textContent = "Agregar Imagenes"
    imageSection.appendChild(imageSectionTitle)

    imageSection.appendChild(await ImageUploader(data.vehicleImages))
    imageSection.setAttribute("aria-step", "4")

    vehicleform.appendChild(detailsSection)
    vehicleform.appendChild(specSection)
    vehicleform.appendChild(perfSection)
    vehicleform.appendChild(imageSection)

    tabsBtns.addEventListener("click", e => {
        if (e.target.ariaLabel) {
            localStorage.setItem("step", JSON.stringify(e.target?.ariaLabel ?? "step-1"))
            const step = e.target?.ariaLabel.split("-")[1];
            setSettingSection(step)
        }
    })

    function setSettingSection(step) {
        const section = document.querySelector(`[aria-step="${step}"]`)
        const previus = document.querySelector(".settingsStepVisible")
        if (section) {
            if (previus && section != previus) {
                previus.classList.remove("settingsStepVisible")
                section.classList.add("settingsStepVisible")
            }

        }
    }

    const modalFooter = document.createElement("section")
    modalFooter.classList.add("modal-footer")

    const botonVolver = document.createElement("button")
    botonVolver.classList.add("modal-footer_volver")
    const botonSiguiente = document.createElement("button")
    botonSiguiente.classList.add("modal-footer_siguiente")
    botonVolver.textContent = "Atras"
    botonSiguiente.textContent = "Siguiente"
    botonVolver.disabled = true;

    botonSiguiente.addEventListener("click", () => {

        if (botonSiguiente.classList.contains("button-enviar")) {
            envioForm()
        }

    })

    function switchSelected(item) {
        const step = item.ariaLabel.substring(5, 6);
        const lastItem = [...menuItems].find(el => el.classList.contains("selected"))
        menuItems.forEach(el => el.classList.remove("selected"));
        const lastStep = lastItem.ariaLabel.substring(5, 6);
        item.classList.add("selected");
        cambiarSeccion(lastStep, step);
        if (item.ariaLabel == "step-1") {
            botonVolver.disabled = true;
            botonSiguiente.disabled = false;
            botonSiguiente.classList.remove("button-enviar")
            botonSiguiente.textContent = "Siguiente"
        } else if (item.ariaLabel == "step-4") {
            botonVolver.disabled = false;
            botonSiguiente.textContent = "Enviar"
            botonSiguiente.classList.add("button-enviar")
        } else {
            botonSiguiente.disabled = false;
            botonVolver.disabled = false;
            botonSiguiente.textContent = "Siguiente"
            botonSiguiente.classList.remove("button-enviar")
        }

    }
    const menuItems = tabsBtns.querySelectorAll("*")
    menuItems.forEach(item => item.addEventListener("click", () => {
        switchSelected(item)
    }));

    const submitInput = document.createElement("button")
    submitInput.textContent = "Agregar"

    //vehicleform.appendChild(ImageUploader())
    // vehicleform.appendChild(submitInput)

    // vehicleform.addEventListener("submit", e => {
    //     e.preventDefault();
    //     const form_data = new FormData(vehicleform)

    //     console.log([...form_data])

    //     addToast([{ title: "error", error: "Message" }])
    // })

    modalBody.appendChild(vehicleform)




    contenedor.appendChild(modal)

    modal.appendChild(modalHeader)
    modal.appendChild(modalBody)

    modal.appendChild(modalFooter)


    botonVolver.addEventListener("click", e => {

        const tabActual = tabsBtns.querySelector(".selected")

        switchSelected(tabActual)

        const stepActual = +tabActual.ariaLabel.substring(5, 6);

        if (stepActual > 1) {
            const stepSiguiente = stepActual - 1
            cambiarSeccion(stepActual, stepSiguiente)

            tabsBtns.querySelector(`[aria-label='step-${stepSiguiente}']`).click()

        }



    })

    botonSiguiente.addEventListener("click", e => {
        const tabActual = tabsBtns.querySelector(".selected")

        switchSelected(tabActual)

        const stepActual = +tabActual.ariaLabel.substring(5, 6);

        if (stepActual < 4) {
            const stepSiguiente = stepActual + 1
            cambiarSeccion(stepActual, stepSiguiente)

            tabsBtns.querySelector(`[aria-label='step-${stepSiguiente}']`).click()

        }
    })


    modalFooter.appendChild(botonVolver)
    modalFooter.appendChild(botonSiguiente)

    vehicleform.querySelectorAll("input,  textarea, select")
        .forEach(input => {
            input.addEventListener("change", e => {
                const error = ErrorComp("")
                const errorText = error.querySelector("p")

                if (e.target.tagName == "INPUT" || e.target.tagName == "TEXTAREA") {

                    if (e.target.value == "") {
                        e.target.classList.add("error")
                        errorText.textContent = `el campo ${e.target.parentElement.textContent.toLowerCase()} no puede estar vacio`
                        e.target.parentElement.appendChild(error)
                    } else {
                        e.target.classList.remove("error")
                        e.target.parentElement.querySelector(".error-input-container")?.remove()

                    }
                } else if (e.target.tagName == "SELECT") {
                    if (e.target.selectedIndex == 0) {
                        e.target.classList.add("error")
                        errorText.textContent = `debes seleccionar un elemento`
                        e.target.parentElement.appendChild(error)
                    } else {
                        e.target.classList.remove("error")
                        e.target.parentElement.querySelector(".error-input-container")?.remove()

                    }
                }
            })
        })

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
        .then(async data => {
            document.body.appendChild(await ModalModificar(data));
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
    const response = await fetch(location.origin + "/api/v1/vehicles?token=9fd4e0080bc6edc9f3c3853b5b1b6ecf&id=" + vehiculoID);
    if (!response.ok) {
        addToast([{
            title: "Failure",
            error: "Ha ocurrido un error"
        }]);
    }
    return await response.json();
};


const handlerAgregar = async (e) => {
    toggleBackground()
    document.body.appendChild(await ModalAdd())
}




const AgregarBtn = document.querySelector(".product-add__input")

if (AgregarBtn) {
    AgregarBtn.addEventListener("click", handlerAgregar)
}



