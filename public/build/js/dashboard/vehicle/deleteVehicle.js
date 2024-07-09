const form_deleteVehicle = document.querySelector(".f_deletevehicle");

form_deleteVehicle.addEventListener("submit", submitEventHandler)

async function submitEventHandler(event) {
    event.preventDefault()

    const formdata = new FormData(form_deleteVehicle)
    const object = {};
    const error = [];
    formdata.forEach((value, key) => {
        object[key] = value
    });
    console.log(object)
    //Errores
    if(object.id.length == 0){
        error.push({
            title:"Failure",
            error:"El campo id se encuentra vacio"
        })
    }
        
    if(error.length != 0){
        addToast(error);
    } else {
        confirm("¿Estas seguro de que quieres borrar el vehiculo con el id " + object.id + "?");
        try{
            const response = await fetch("http://localhost:3000/dashboard/eliminar-vehiculo", {
                method: "POST",
                body: formdata
            })
            const data = await response.json();
            if (data?.errores) {
                const errors = Object?.values(data?.errores).map(err => {
                    const error = document.createElement("div");
                    error.classList.add("error")
                    error.textContent = err
                    return { title: "Failure", error: err }
                })
                addToast(errors);
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