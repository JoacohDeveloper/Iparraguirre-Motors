
localStorage.removeItem("edit-resume")

const main = document.body.querySelector("main")

const buttons = document.querySelectorAll(".button_settings");

buttons.forEach(button => button.addEventListener("click", formMenu))

async function formMenu({ target }) {
    const settingsContent = document.querySelector(".fit__content");
    settingsContent.classList.add("fixed");
    const container = document.querySelector(".container");

    const lastMenu = document.querySelector(".settings_forms");

    if (lastMenu) {
        lastMenu.remove();
    }

    const settings_formHTML = document.createElement("section");
    const form_containerHTMl = document.createElement("div");
    const form_close__settings_formHTML = document.createElement("div");
    const closeText = document.createElement("p");
    closeText.textContent = "X";
    form_close__settings_formHTML.classList.add("close__settings_forms");
    settings_formHTML.classList.add("settings_forms");
    form_containerHTMl.classList.add("form-container");
    form_close__settings_formHTML.appendChild(closeText);
    form_containerHTMl.appendChild(form_close__settings_formHTML);
    settings_formHTML.appendChild(form_containerHTMl);
    container.appendChild(settings_formHTML);

    await setFormEdit(target, form_containerHTMl);

    const removeForm = () => {
        settings_formHTML.classList.add("removed__settings_forms");
        setTimeout(() => {
            const settingsContent = document.querySelector(".fit__content");
            document.body.classList.remove("fixed");
            document.body.classList.remove("blured");
            settingsContent.classList.remove("fixed");
        }, 400);
    };

    form_close__settings_formHTML.addEventListener("click", removeForm);
    document.addEventListener("keydown", e => {
        if (e.key === 'Escape') removeForm();
    });
    settings_formHTML.addEventListener("click", e => {
        if (e.target === settings_formHTML) removeForm();
    });
}


function setResumeChanges(formdata, imgURL) {
    const fullnameAside = document.querySelector("#aside_fullname__id")
    const fullnameField = document.querySelector("#fullname__id") 
    const usernameField = document.querySelector("#username_resume") 
    const imgProfile = document.querySelector("#img_resume")
    const imgProfileNav = document.querySelector("#img_profile")
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

    fullnameAside.textContent = `${object.full_name}`
    fullnameField.textContent = `${object.full_name}`
    usernameField.textContent = `${object.username}`
    imgProfile.src = imgURL?.src;
    imgProfileNav.src = imgURL?.src;
}


async function setFormEdit(target, formContainer) {
    const headingTitle = document.createElement("h4")
    formContainer.appendChild(headingTitle);
    const formHTML = document.createElement("form")
    formHTML.enctype = "multipart/form-data";
    // el usuario que esta en la pagina
    const urlParams = new URLSearchParams(window.location.search);
    const uuid = urlParams.get('u');
    console.log(uuid)

    try {
        const response = await fetch(location.origin + `/customer/user-settings/usuario?u=${uuid}`);

        const data = await response.json();
        console.log(data)
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
                const response = await fetch(location.origin + "/customer/customer-settings/customer/modificar", {
                    method: "POST",
                    body: formdata
                })

                const data = await response.json()
                console.log(data)

                if (data?.message && data?.message == "error") {
                    const errors = document.createElement("div")
                    errors.classList.add("toasts")
                    formContainer.appendChild(errors);
                    const errores = Object.entries(data?.errores).map(err => {
                        return { title: "Failure", error: err[1] }
                    })
                    addToast(errores);
                } else if (!data?.file_uploaded) {
                     addToast([{ title: "Failure", error: "Ocurrió un error al cargar su imagen, intenta de nuevo más tarde." }]);
                } else if (data?.message == "successfuly") {
                    const previewImg = document.querySelector("#preview_edit_resume__img")
                    setResumeChanges(formdata, previewImg);
                    document.querySelector(".close__settings_forms")?.click()
                    location.reload();
                }

            } catch (error) {
                console.error(error)
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
            headingTitle.textContent = "Editar perfil";
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
            subtitle.textContent = "Informacion personal"
            subtitle.classList.add("edit-resume__subtitle")

            const submitBTN = document.createElement("button");

            submitBTN.type = "submit";
            submitBTN.textContent = "Actualizar cambios"

            const fullNameInputLabel = document.createElement("label");
            fullNameInputLabel.textContent = "Nombre completo"
            fullNameInputLabel.htmlFor = "fullname"
            const fullNameInput = document.createElement("input")
            fullNameInput.type = "text"
            fullNameInput.name = "full_name"
            fullNameInput.id = "fullname"
            fullNameInput.placeholder = "Nombre completo"
            fullNameInput.value = lastChanges?.fullname ?? data?.fullname;


            const usernameInputLabel = document.createElement("label");
            usernameInputLabel.textContent = "Nombre de usuario"
            usernameInputLabel.htmlFor = "username"
            const usernameInput = document.createElement("input")
            usernameInput.type = "text"
            usernameInput.name = "username"
            usernameInput.id = "username"
            usernameInput.placeholder = "Nombre de usuario"
            usernameInput.value = lastChanges?.username ?? data?.username;


            const emailInputLabel = document.createElement("label");
            emailInputLabel.textContent = "Correo electronico"
            emailInputLabel.htmlFor = "email"
            const emailInput = document.createElement("input")
            emailInput.type = "text"
            emailInput.name = "email"
            emailInput.id = "email"
            emailInput.placeholder = "Correo electronico"
            emailInput.value = data.email;

            const phoneInputLabel = document.createElement("label");
            phoneInputLabel.textContent = "Celular"
            phoneInputLabel.htmlFor = "phone"
            const phoneInput = document.createElement("input")
            phoneInput.type = "text"
            phoneInput.name = "phone"
            phoneInput.id = "phone"
            phoneInput.placeholder = "Celular"
            phoneInput.value = data.phone;

            formHTML.appendChild(bannerUser)
            formHTML.appendChild(subtitle)

            fullNameInputLabel.appendChild(fullNameInput)
            formHTML.appendChild(fullNameInputLabel)

            usernameInputLabel.appendChild(usernameInput)
            formHTML.appendChild(usernameInputLabel)

            emailInputLabel.appendChild(emailInput)
            formHTML.appendChild(emailInputLabel)

            phoneInputLabel.appendChild(phoneInput)
            formHTML.appendChild(phoneInputLabel)

            formHTML.appendChild(submitBTN)
        } else {
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
const menuItems = document.querySelectorAll("#profile, #cart, #wishlist, #change-pass, #delete-account");
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
            const response = await fetch(location.origin + "/customer/user-delete", {
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
    const errores = [];
    const passwordRegex = /^[^\s]{4,}$/;
    formdata.forEach((value, key) => {
        object[key] = value;
    });
    
    const fields = [
        { value: object.olderPassword, error: "Debes ingresar la contraseña actual de tu cuenta" },
        { value: object.password, regex: passwordRegex, error: "La nueva contraseña debe tener mínimo 4 caracteres y no contener espacios." },
        { value: object.repeatPassword, error: "Debes repetir la nueva contraseña de tu cuenta" }
    ];

    fields.forEach(field => {
        if (field.value.length == 0) {
            errores.push({ title: "Failure", error: field.error });
        }
    });

    if (object.password !== object.repeatPassword) {
        errores.push({ title: "Failure", error: "La contraseña repetida no coincide" });
    }

    if (errores.length != 0) {
        const firstError = errores[0];
        addToast([{ title: "Failure", error: firstError.error }]);
    } else {
        try {
            const response = await fetch(location.origin + "/customer/user-newPassword", {
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
        const response = await fetch(location.origin + "/customer/user-default-image");
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

/* Obtener y generar cards para los testDrive en caso de que el usuario tenga alguno */

const cardTestDriveContent = document.querySelector(".cardTestDrive_Container");

const testCard = ({ productID, reservedDate, createdAt }) => {
    const card = document.createElement("div");
    card.classList.add("test-drive-card");
    card.setAttribute("aria-label", productID);

    const cardContent = document.createElement("div");
    cardContent.classList.add("test-drive-card-content");

    const detailsContainer = document.createElement("div");
    detailsContainer.classList.add("test-drive-details");

    const productNameHTML = document.createElement("p");
    productNameHTML.textContent = `Producto: ${productID}`;

    const reservedDateHTML = document.createElement("p");
    reservedDateHTML.textContent = `Reserva: ${new Date(reservedDate).toLocaleDateString()}`;

    const createdAtHTML = document.createElement("p");
    createdAtHTML.textContent = `Creado: ${new Date(createdAt).toLocaleDateString()}`;

    detailsContainer.appendChild(productNameHTML);
    detailsContainer.appendChild(reservedDateHTML);
    detailsContainer.appendChild(createdAtHTML);

    cardContent.appendChild(detailsContainer);

    card.appendChild(cardContent);

    return card;
};

async function loadTestDrive() {
    const cargarTestDrives = async () => {
        try {
            const response = await fetch(location.origin + "/settings/getUserTestDrive");
            const data = await response.json();

            if (data?.errores) {
                const errors = Object?.values(data?.errores).map(err => {
                    const error = document.createElement("div");
                    error.classList.add("error");
                    error.textContent = err;
                    return { title: "Failure", error: err };
                });
                addToast(errors);
            } else if (data?.error) {
                const infoText = document.createElement("p");
                infoText.id = "exampleTXT_information";
                infoText.textContent = "No has reservado ningun test drive";
                if (cardTestDriveContent) cardTestDriveContent.appendChild(infoText);
            } else if (data?.testDrives && data.testDrives.length > 0) {
                data.testDrives.forEach(testDrive => {
                    const customT = {
                        productID: testDrive.productName,
                        reservedDate: testDrive.reservedDate,
                        createdAt: testDrive.createdAt
                    };
                    if (cardTestDriveContent) cardTestDriveContent.appendChild(testCard(customT));
                });
            }
        } catch (error) {
            console.error('Error al obtener los test drives:', error);
            addToast([{
                title: "Failure",
                error: "Ha ocurrido un error al cargar los test drives"
            }]);
        }
    };
    try {
        await cargarTestDrives();
    } catch (error) {
        console.error('Error general al cargar los test drives:', error);
    }
}

loadTestDrive();

function togglePassword(button) {
    const input = button.previousElementSibling;
    const img = button.querySelector('img');
    if (input.type === "password") {
        input.type = "text";
        img.src = '/build/src/images/closedEye.svg';
        img.alt = "Ocultar contraseña";
    } else {
        input.type = "password";
        img.src = '/build/src/images/eye.svg';
        img.alt = "Mostrar contraseña";
    }
}