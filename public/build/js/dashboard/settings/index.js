

const main = document.body.querySelector("main")

const buttons = document.querySelectorAll(".button_settings");



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
    // el usuario que esta en la pagina
    const urlParams = new URLSearchParams(window.location.search);
    const uuid = urlParams.get('u');

    try {
        const response = await fetch(`http://localhost:3000/dashboard/user-settings/usuario?u=${uuid}`);

        const data = await response.json();
        if (data?.error) throw new Error(data?.error)


        formContainer.appendChild(formHTML)

        formHTML.addEventListener("submit", e => e.preventDefault())
        if (target.id == 'edit-resume' || target.parentElement.id == 'edit-resume') {
            headingTitle.textContent = "Resume";
            const inputImg = document.createElement("input")

            inputImg.type = "file"


            const profileImg = document.createElement("img")

            profileImg.src = data?.imagen?.url;
            profileImg.alt = data?.imagen?.alt;

            const separator = document.createElement("div");
            separator.classList.add("edit-resume__sepearator")
            separator.appendChild(inputImg);
            separator.appendChild(profileImg);



            formHTML.appendChild(separator)



        } else {
            //personal information
            headingTitle.textContent = "Personal Information";
        }



    } catch (error) {
        console.log(error)
    }


}