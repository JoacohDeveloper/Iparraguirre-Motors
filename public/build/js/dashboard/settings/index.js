
<<<<<<< HEAD
localStorage.removeItem("edit-resume")
=======
>>>>>>> d_changes/add-settings-view

const main = document.body.querySelector("main")

const buttons = document.querySelectorAll(".button_settings");


<<<<<<< HEAD
=======

>>>>>>> d_changes/add-settings-view
buttons.forEach(button => button.addEventListener("click", formMenu))


async function formMenu({ target }) {

    document.body.classList.add("fixed")

    const dashboardContent = document.querySelector(".dashboard-content")

    dashboardContent.classList.add("fixed")

    document.body.classList.add("blured")

    const container = document.querySelector(".settingsContainer")

    const lastMenu = document.querySelector(".settings_forms")

    if (lastMenu) {
        lastMenu.remove()

    }
    const settings_formHTML = document.createElement("section")
    const form_containerHTMl = document.createElement("div")
    const form_close__settings_formHTML = document.createElement("div")
    const closeText = document.createElement("p")
    closeText.textContent = "X";
    form_close__settings_formHTML.classList.add("close__settings_forms")
    settings_formHTML.classList.add("settings_forms")
    form_containerHTMl.classList.add("form-container")
    form_close__settings_formHTML.appendChild(closeText)
    form_containerHTMl.appendChild(form_close__settings_formHTML)
    settings_formHTML.appendChild(form_containerHTMl);
    container.appendChild(settings_formHTML);

    await setFormEdit(target, form_containerHTMl);

    const removeForm = () => {
        settings_formHTML.classList.add("removed__settings_forms")

        setTimeout(() => {
            const dashboardContent = document.querySelector(".dashboard-content")
            document.body.classList.remove("fixed")
            dashboardContent.classList.remove("fixed")
            document.body.classList.remove("blured")
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



async function setFormEdit(target, formContainer) {



    const headingTitle = document.createElement("h4")
    formContainer.appendChild(headingTitle);
    const formHTML = document.createElement("form")
<<<<<<< HEAD
    formHTML.enctype = "multipart/form-data";
=======
>>>>>>> d_changes/add-settings-view
    // el usuario que esta en la pagina
    const urlParams = new URLSearchParams(window.location.search);
    const uuid = urlParams.get('u');

    try {
        const response = await fetch(`http://localhost:3000/dashboard/user-settings/usuario?u=${uuid}`);

        const data = await response.json();
        if (data?.error) throw new Error(data?.error)

<<<<<<< HEAD
        formContainer.appendChild(formHTML)

        function previewChanges(object) {
            const imgFile = formHTML.querySelector("#image").files[0];
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
                const response = await fetch("http://localhost:3000/dashboard/user-settings/usuario/modificar", {
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
                    document.querySelector(".close__settings_forms")?.click()
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

=======

        formContainer.appendChild(formHTML)

        formHTML.addEventListener("submit", e => e.preventDefault())
        if (target.id == 'edit-resume' || target.parentElement.id == 'edit-resume') {
>>>>>>> d_changes/add-settings-view
            headingTitle.textContent = "Resume";
            const inputImg = document.createElement("input")

            inputImg.type = "file"
<<<<<<< HEAD
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

=======


            const profileImg = document.createElement("img")

            profileImg.src = data?.imagen?.url;
            profileImg.alt = data?.imagen?.alt;

>>>>>>> d_changes/add-settings-view
            const separator = document.createElement("div");
            separator.classList.add("edit-resume__sepearator")
            separator.appendChild(inputImg);
            separator.appendChild(profileImg);
<<<<<<< HEAD
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

            const summaryTextAreaLabel = document.createElement("label");

            const summaryTextArea = document.createElement("textarea")
            summaryTextAreaLabel.textContent = "Summary"
            summaryTextAreaLabel.htmlFor = "summary"

            summaryTextArea.name = "summary"
            summaryTextArea.id = "summary"
            summaryTextArea.placeholder = "Summary"
            summaryTextArea.textContent = lastChanges?.summary ?? data?.fullname + " aca va el summary";


            formHTML.appendChild(bannerUser)
            formHTML.appendChild(subtitle)

            formHTML.appendChild(usernameInputLabel)
            formHTML.appendChild(usernameInput)

            formHTML.appendChild(fullNameInputLabel)
            formHTML.appendChild(fullNameInput)

            formHTML.appendChild(summaryTextAreaLabel)
            formHTML.appendChild(summaryTextArea)

            formHTML.appendChild(submitBTN)

=======



            formHTML.appendChild(separator)
>>>>>>> d_changes/add-settings-view



        } else {
            //personal information
            headingTitle.textContent = "Personal Information";
        }



    } catch (error) {
        console.log(error)
    }


}