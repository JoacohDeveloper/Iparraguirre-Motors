
localStorage.removeItem("edit-resume")

const main = document.body.querySelector("main")

const buttons = document.querySelectorAll(".button_settings");

buttons.forEach(button => button.addEventListener("click", formMenu))

function toggleBackground() {
    document.body.classList.toggle("fixed")
    document.body.classList.toggle("blured")
}
const resumeProfileImgHandleClick = () => {
    toggleBackground()

    const container = document.querySelector(".settingsContainer")

    const imgContainer = document.createElement("div")
    imgContainer.classList.add("imgContainer__big")
    const closeBtn = document.createElement("p")
    closeBtn.classList.add("closeBtn")
    closeBtn.textContent = "X"
    imgContainer.appendChild(closeBtn)
    container.appendChild(imgContainer)
    const img = document.createElement("img")
    img.src = resumeProfileImg.querySelector("img").src
    imgContainer.append(img)
    closeBtn.addEventListener("click", () => {
        toggleBackground()
        imgContainer.remove()

    })



}
const resumeProfileImg = document.querySelector(".profile-resume__image")
resumeProfileImg.addEventListener("click", resumeProfileImgHandleClick)


async function formMenu({ target }) {
    toggleBackground()
    const dashboardContent = document.querySelector(".dashboard-content")
    dashboardContent.classList.add("fixed")
    const container = document.querySelector(".settingsContainer")

    const lastMenu = document.querySelector(".settings_forms")

    if (lastMenu) {
        lastMenu.remove()

    }
    const settings_formHTML = document.createElement("section")
    const form_containerHTMl = document.createElement("div")

    //Contenedores para elementos
    const formHeader = document.createElement("div");
    formHeader.classList.add("haeder__settings_forms");

    const form_close__settings_formHTML = document.createElement("img")
    form_close__settings_formHTML.src = '/build/src/images/cross.svg'
    settings_formHTML.classList.add("settings_forms")
    form_containerHTMl.classList.add("form-container")
    formHeader.appendChild(form_close__settings_formHTML)
    form_containerHTMl.appendChild(formHeader)
    settings_formHTML.appendChild(form_containerHTMl);
    container.appendChild(settings_formHTML);

    await setFormEdit(target, form_containerHTMl);

    const removeForm = () => {
        settings_formHTML.classList.add("removed__settings_forms")
        setTimeout(() => {
            const dashboardContent = document.querySelector(".dashboard-content")
            document.body.classList.remove("fixed")
            document.body.classList.remove("blured")
            dashboardContent.classList.remove("fixed")
        }, 400);
    }
    form_close__settings_formHTML.addEventListener("click", removeForm)
    document.addEventListener("keydown", e => {
        if (e.key == 'Escape') removeForm()
    })
    settings_formHTML.addEventListener("click", e => {
        if (e.target == settings_formHTML) removeForm()
    })


}




function setResumeChanges(formdata, imgURL) {
    const fullnameField = document.querySelector("#fullname__id")
    const imgProfile = document.querySelector("#profile-img__id")
    const imgProfileNav = document.querySelector("#nav_profileImg__id")
    const navUsermane = document.querySelector("#nav_profileUsername__id")
    const firstNameField = document.querySelector("#firstname__id")
    const lastNameField = document.querySelector("#lastname__id")

    const object = {};
    formdata.forEach((value, key) => {
        if (key !== 'image') {
            object[key] = value
        }
    });

    const fullnameSplit = object.full_name.split(" ");
    firstNameField.textContent = fullnameSplit[0];
    const listOfSName = fullnameSplit.map((n, i) => {
        if (i > 0) return n
    })
    lastNameField.textContent = fullnameSplit.length > 2 ? listOfSName.join(" ") : fullnameSplit[1]

    fullnameField.textContent = `${object.full_name} - ${object.username}`
    navUsermane.textContent = `Welcome, ${object.username}.`
    imgProfile.src = imgURL.src;
    imgProfileNav.src = imgURL.src;
}


async function setFormEdit(target, formContainer) {



    const headingTitle = document.createElement("h4")
    formContainer.appendChild(headingTitle);
    const formHTML = document.createElement("form")
    formHTML.enctype = "multipart/form-data";
    // el usuario que esta en la pagina
    const urlParams = new URLSearchParams(window.location.search);
    const uuid = urlParams.get('u');

    try {
        const response = await fetch(location.origin + `/dashboard/user-settings/usuario?u=${uuid}`);

        const data = await response.json();
        if (data?.error) throw new Error(data?.error)

        formContainer.appendChild(formHTML)

        function previewChanges(object) {

            const imgFile = formHTML.querySelector("#image").files[0];

            const fileExtA = imgFile?.name.split(".")

            const fileExt = fileExtA[fileExtA?.length - 1]
            const MAX_SIZE = 1024 * 5 * 1024

            const validExt = ["jpg", "png", "webp", "jpeg"]
            const errors = document.createElement("div")
            errors.classList.add("toasts")
            formContainer.appendChild(errors);

            if (!validExt.includes(fileExt)) {

                addToast([{ title: "Failure", error: "El formato de archivo no es valido" }])
                return;
            } else if (imgFile.size >= MAX_SIZE) {
                addToast([{ title: "Failure", error: "El archivo es muy grande" }])
                return;
            }

            const preview = formHTML.querySelector("#preview_edit_resume__img")
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result;
                localStorage.setItem("edit-resume", JSON.stringify({ ...object, image: preview?.src }));
            }, false);

            if (imgFile) {
                reader.readAsDataURL(imgFile);
            } else {
                const lastLS = JSON.parse(localStorage.getItem("edit-resume"));
                localStorage.setItem("edit-resume", JSON.stringify({ ...lastLS, ...object }));
            }

        }

        formHTML.addEventListener("submit", async e => {
            e.preventDefault()

            try {
                const formdata = new FormData(formHTML)
                const response = await fetch(location.origin + "/dashboard/user-settings/usuario/modificar", {
                    method: "POST",
                    body: formdata
                })

                const data = await response.json()


                if (data?.message && data?.message == "error") {
                    const errors = document.createElement("div")
                    errors.classList.add("toasts")
                    formContainer.appendChild(errors);
                    const errores = Object.entries(data?.errores).map(err => {
                        return { title: "Failure", error: err[1] }
                    })
                    addToast(errores);
                } else if (!data?.file_uploaded) addToast([{ title: "Failure", error: "Ocurrió un error al cargar su imagen, intenta de nuevo más tarde." }]);
                else if (data?.message == "ok") {
                    const previewImg = document.querySelector("#preview_edit_resume__img")
                    setResumeChanges(formdata, previewImg);
                    document.querySelector(".close__settings_forms")?.click()
                    location.reload();
                }

            } catch (error) {
                addToast([{ title: "Failure", error: "Ocurrió un error, intenta de nuevo más tarde." }]);
            }

        })


        formHTML.addEventListener("change", e => {
            const formdata = new FormData(formHTML);

            const object = {};
            formdata.forEach((value, key) => {
                if (key !== 'image') {
                    object[key] = value
                }
            });
            previewChanges(object);
        })


        if (target.id == 'edit-resume' || target.parentElement.id == 'edit-resume') {

            const lastChanges = JSON.parse(localStorage.getItem("edit-resume"));
            headingTitle.textContent = "Resume";
            const inputImg = document.createElement("input")

            inputImg.type = "file"
            inputImg.name = "image"
            inputImg.id = "image"

            function loadURLToInputFiled(url) {
                getImgURL(url, (imgBlob) => {
                    let fileName = 'nuevaImagenUsuario.jpg'
                    let file = new File([imgBlob], fileName, { type: "image/jpeg", lastModified: new Date().getTime() }, 'utf-8');
                    let container = new DataTransfer();
                    container.items.add(file);
                    inputImg.files = container.files;

                })
            }

            function getImgURL(url, callback) {
                var xhr = new XMLHttpRequest();
                xhr.onload = function () {
                    callback(xhr.response);
                };
                xhr.open('GET', url);
                xhr.responseType = 'blob';
                xhr.send();
            }

            if (lastChanges?.image) {
                loadURLToInputFiled(lastChanges?.image)
            } else {
                loadURLToInputFiled(data?.imagen?.url ?? "/build/src/images/defaultUser.png");
            }

            const profileImg = document.createElement("img")
            profileImg.id = "preview_edit_resume__img"

            profileImg.alt = data?.imagen?.alt;

            profileImg.src = lastChanges?.image ?? data?.imagen?.url;

            const separator = document.createElement("div");
            separator.classList.add("edit-resume__sepearator")
            separator.appendChild(inputImg);
            separator.appendChild(profileImg);
            const bannerUser = document.createElement("section");
            bannerUser.classList.add("edit-resume__banner")
            bannerUser.appendChild(separator);

            const subtitle = document.createElement("p")
            subtitle.textContent = "Your Information"
            subtitle.classList.add("edit-resume__subtitle")

            const submitBTN = document.createElement("button");

            submitBTN.type = "submit";
            submitBTN.textContent = "Submit Changes"


            const usernameInputLabel = document.createElement("label");

            const usernameInput = document.createElement("input")
            usernameInputLabel.textContent = "Username"
            usernameInputLabel.htmlFor = "username"

            usernameInput.type = "text"
            usernameInput.name = "username"
            usernameInput.id = "username"
            usernameInput.placeholder = "Username"
            usernameInput.value = lastChanges?.username ?? data?.username;

            const fullNameInputLabel = document.createElement("label");

            const fullNameInput = document.createElement("input")
            fullNameInputLabel.textContent = "Full Name"
            fullNameInputLabel.htmlFor = "fullname"

            fullNameInput.type = "text"
            fullNameInput.name = "full_name"
            fullNameInput.id = "fullname"
            fullNameInput.placeholder = "Full Name"
            fullNameInput.value = lastChanges?.fullname ?? data?.fullname;

            const emailInputLabel = document.createElement("label");
            const emailInput = document.createElement("input")
            emailInputLabel.textContent = "Email"
            emailInputLabel.htmlFor = "email"

            emailInput.type = "text"
            emailInput.name = "email"
            emailInput.id = "email"
            emailInput.placeholder = "Email"
            emailInput.value = data.email;

            const summaryTextAreaLabel = document.createElement("label");

            const summaryTextArea = document.createElement("textarea")
            summaryTextAreaLabel.textContent = "Biografia"
            summaryTextAreaLabel.htmlFor = "Biografia"

            summaryTextArea.name = "bio"
            summaryTextArea.id = "bio"
            console.log(data)
            summaryTextArea.placeholder = "Escribe aqui tu biografia"
            summaryTextArea.textContent = data.bio;


            formHTML.appendChild(bannerUser)
            formHTML.appendChild(subtitle)

            formHTML.appendChild(fullNameInputLabel)
            formHTML.appendChild(fullNameInput)

            formHTML.appendChild(usernameInputLabel)
            formHTML.appendChild(usernameInput)

            formHTML.appendChild(emailInputLabel)
            formHTML.appendChild(emailInput)

            formHTML.appendChild(summaryTextAreaLabel)
            formHTML.appendChild(summaryTextArea)

            formHTML.appendChild(submitBTN)




        } else {
            //personal information
            headingTitle.textContent = "Personal Information";
        }



    } catch (error) {
        console.log(error)
    }

}

const steps = document.querySelector(".steps")
steps.addEventListener("click", e => {
    if (e.target.parentElement?.ariaLabel) {
        //console.log(e.target?.parentElement?.ariaLabel)
        localStorage.setItem("step", JSON.stringify(e.target?.parentElement?.ariaLabel ?? "step-1"))
        const step = e.target?.parentElement?.ariaLabel.split("-")[1];
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


/* Admin settings li selected */
const menuItems = document.querySelectorAll("#profile, #notifications, #security, #delete-account, #change-pass");
menuItems.forEach(item => {
    item.addEventListener("click", (event) => {
        menuItems.forEach(el => el.classList.remove("selected"));
        item.classList.add("selected");
    });
});

/* Delete user form */
document.querySelector('input[name="Nombre"]').setAttribute('autocomplete', 'new-name');
document.querySelector('input[name="Password"]').setAttribute('autocomplete', 'new-password');

const form_deleteAccount = document.querySelector(".form_deleteAccount");

form_deleteAccount.addEventListener("submit", submitEventHandler)

async function submitEventHandler(event) {
    event.preventDefault()
    const formdata = new FormData(form_deleteAccount)
    const object = {};
    const error = [];
    formdata.forEach((value, key) => {
        object[key] = value
    });
    console.log(object)
    //Errores
    if (object.Nombre.length == 0) {
        error.push({
            title: "Failure",
            error: "El campo nombre se encuentra vacio"
        })
    } else if (object.Password.length == 0) {
        error.push({
            title: "Failure",
            error: "El campo contraseña se encuentra vacio"
        })
    }
    if (error.length != 0) {
        addToast(error);
    } else {
        confirm("¿Estás seguro de que quieres borrar tu cuenta?");
        try {
            const response = await fetch(location.origin + "/dashboard/user-delete", {
                method: "POST",
                body: formdata
            });
            const data = await response.json();
            if (data?.errores) {
                const errors = Object?.values(data?.errores).map(err => {
                    const error = document.createElement("div");
                    error.classList.add("error");
                    error.textContent = err;
                    return { title: "Failure", error: err };
                });
                addToast(errors);
            } else if (data?.message == "successfuly") {
                Swal.fire({
                    title: "Éxito",
                    text: "Se ha borrado tu cuenta",
                    icon: "success"
                });
                const btn_swal = document.querySelector(".swal2-confirm");
                if(btn_swal){
                    btn_swal.addEventListener("click", () =>{
                        location.reload();
                    })
                }
            }
        } catch (err) {
            addToast([{
                title: "Failure",
                error: "Ha ocurrido un error"
            }]);
        }
    }
}



/* ChangePassword user form */
document.querySelector('input[name="olderPassword"]').setAttribute('autocomplete', 'olderPassword');
document.querySelector('input[name="password"]').setAttribute('autocomplete', 'password');
document.querySelector('input[name="repeatPassword"]').setAttribute('autocomplete', 'repeatPassword');

const form_changePassword = document.querySelector(".form_changePassword");

form_changePassword.addEventListener("submit", submitEventHandler2);

async function submitEventHandler2(event) {
    event.preventDefault();
    const formdata = new FormData(form_changePassword);
    const object = {};
    const error = [];
    formdata.forEach((value, key) => {
        object[key] = value;
    });

    // Errores
    if (object.olderPassword.length == 0) {
        error.push({
            title: "Failure",
            error: "Debes ingresar la contraseña actual de tu cuenta"
        });
    } else if (object.password.length == 0) {
        error.push({
            title: "Failure",
            error: "Debes ingresar la nueva contraseña de tu cuenta"
        });
    } else if (object.repeatPassword.length == 0) {
        error.push({
            title: "Failure",
            error: "Debes repetir la nueva contraseña de tu cuenta"
        });
    } else if (object.password !== object.repeatPassword) {
        error.push({
            title: "Failure",
            error: "La contraseña repetida no coincide"
        });
    }
    if (error.length != 0) {
        addToast(error);
    } else {
        try {
            const response = await fetch(location.origin + "/dashboard/user-newPassword", {
                method: "POST",
                body: formdata
            });
            const data = await response.json();
            if (data?.error) {
                
                addToast([{ title: "Failure", error: data.error}]);
                return
            } else if (data?.message == "successfuly") {
                Swal.fire({
                    title: "Éxito",
                    text: "Se ha cambiado tu contraseña",
                    icon: "success"
                });
                const btn_swal = document.querySelector(".swal2-confirm");
                if(btn_swal){
                    btn_swal.addEventListener("click", () =>{
                        location.reload();
                    })
                }
            }
        } catch (err) {
            addToast([{
                title: "Failure",
                error: "Ha ocurrido un error"
            }]);
        }
    }
}

const btn_defaultImage = document.querySelector(".delete-picture-configuration__edit");
if(btn_defaultImage) btn_defaultImage.addEventListener("click", defaultImage);

async function defaultImage(event) {
    event.preventDefault();
    try {
        const response = await fetch(location.origin + "/dashboard/user-default-image");
        const data = await response.json();
        console.log(data)
        if (data?.errores) {
            const errors = Object?.values(data?.errores).map(err => {
                const error = document.createElement("div");
                error.classList.add("error");
                error.textContent = err;
                return { title: "Failure", error: err };
            });
            addToast(errors);
        } else if (data?.message == "successfuly") {
            Swal.fire({
                title: "Éxito",
                text: "Se ha cambiado foto de perfil",
                icon: "success"
            });
            const btn_swal = document.querySelector(".swal2-confirm");
            if(btn_swal){
                btn_swal.addEventListener("click", () =>{
                    location.reload();
                })
            }
        }
    } catch (err) {
        addToast([{
            title: "Failure",
            error: "Ha ocurrido un error"
        }]);
    }
}