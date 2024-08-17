const form_addVehicle = document.querySelector(".form_addvehicle");

form_addVehicle.addEventListener("submit", submitEventHandler)

async function submitEventHandler(event) {
    event.preventDefault()

    const formdata = new FormData(form_addVehicle)
    const object = {};
    const error = [];
    formdata.forEach((value, key) => {
        object[key] = value
    });
    console.log(object)
    //Errores
    if(object.nombre.length == 0){
        error.push({
            title:"Failure",
            error:"El campo nombre se encuentra vacio"
        })
    } else if(object.descripcion.length == 0){
        error.push({
            title:"Failure",
            error:"El campo descripcion se encuentra vacio"
        })

    } else if(object.modelo.length == 0){
        error.push({
            title:"Failure",
            error:"El campo modelo se encuentra vacio"
        })

    } else if(object.fabricante.length == 0){
        error.push({
            title:"Failure",
            error:"El campo fabricante se encuentra vacio"
        })

    } else if(object.year.length == 0){
        error.push({
            title:"Failure",
            error:"El campo año de fabricacion se encuentra vacio"
        })

    } else if(object.color.length == 0){
        error.push({
            title:"Failure",
            error:"El campo color se encuentra vacio"
        })

    } else if(object.matricula.length == 0){
        error.push({
            title:"Failure",
            error:"El campo matricula se encuentra vacio"
        })
    } else if(object.tipo_transmision == ""){
        error.push({
            title:"Failure",
            error:"El campo tipo de transmision se encuentra vacio"
        })

    } else if(object.tipo_carroceria == ""){
        error.push({
            title:"Failure",
            error:"El campo tipo de carroceria se encuentra vacio"
        })

    } else if(object.FrenosABS == ""){
        error.push({
            title:"Failure",
            error:"El campo frenos ABS se encuentra vacio"
        })

    } else if(object.Airbag == ""){
        error.push({
            title:"Failure",
            error:"El campo airbag se encuentra vacio"
        })

    } else if(object.tipo_traccion == ""){
        error.push({
            title:"Failure",
            error:"El campo tipo de traccion se encuentra vacio"
        })

    } else if(object.tipo_direccion == ""){
        error.push({
            title:"Failure",
            error:"El campo tipo de direccion se encuentra vacio"
        })

    } else if(object.estabilidad == ""){
        error.push({
            title:"Failure",
            error:"El campo control de estabilidad se encuentra vacio"
        })

    } else if(object.puertas == ""){
        error.push({
            title:"Failure",
            error:"El campo numero de puertas se encuentra vacio"
        })

    } else if(object.tipo_combustible.length == 0){
        error.push({
            title:"Failure",
            error:"El campo tipo de combustible se encuentra vacio"
        })

    } else if(object.precio.length == 0){
        error.push({
            title:"Failure",
            error:"El campo precio se encuentra vacio"
        })

    } else if(object.velocidad_max.length == 0){
        error.push({
            title:"Failure",
            error:"El campo velocidad maxima se encuentra vacio"
        })

    } else if(object.zero_to_houndred.length == 0){
        error.push({
            title:"Failure",
            error:"El campo de 0 a 100 km/h se encuentra vacio"
        })

    } else if(object.peso.length == 0){
        error.push({
            title:"Failure",
            error:"El campo peso se encuentra vacio"
        })

    } else if(object.kilometros.length == 0){
        error.push({
            title:"Failure",
            error:"El campo kilometraje del vehiculo se encuentra vacio"
        })

    } else if(object.caballos_fuerza.length == 0){
        error.push({
            title:"Failure",
            error:"El campo caballos de fuerza se encuentra vacio"
        })
        

    }

        
    if(error.length != 0){
        addToast(error);
    } else {
        try{
            const response = await fetch("http://localhost:3000/dashboard/agregar-vehiculo", {
                method: "POST",
                body: formdata
            })
            const data = await response.json();
            if (data?.errores) {
                const errors = Object?.values(data?.errores).map(err => {
                    const error = document.createElement("div");
                    error.classList.add("error")
                    error.textContent = err

                    // errores.appendChild(error)

                    return { title: "Failure", error: err }
                })
                addToast(errors);

            } else if (data?.message == "succesfuly") {
                window.location.href = "/dashboard"
            }
        }
        catch(err){
            addToast([{
                title:"Failure",
                error:"Ha ocurrido un error"
            }]);
        }
    }
    
}