function ImageUploader() {

    const contenedor = document.createElement("div")

    contenedor.classList.add("imageUploader-container")

    // DROPZONE

    const dropzone = document.createElement("div")
    dropzone.classList.add("imageUploader-dropzone")

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
        // console.log(e)
    }

    dropzone.addEventListener('dragover', preventDefaults);
    dropzone.addEventListener('dragenter', preventDefaults);
    dropzone.addEventListener('dragleave', preventDefaults);

    dropzone.addEventListener("dragenter", () => {
        dropzone.classList.add("drop-zone_active")
    })

    dropzone.addEventListener("dragover", () => {
        dropzone.classList.add("drop-zone_active")
    })

    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove("drop-zone_active")
    });

    dropzone.addEventListener("dragend", () => dropzone.classList.remove("drop-zone_active"))

    dropzone.addEventListener('drop', preventDefaults);


    const text = document.createElement("p")
    text.textContent = "drag and drop images here"

    dropzone.appendChild(text)


    const filesUploaded = document.createElement("ul")

    const fileInupt = document.createElement("input")
    fileInupt.type = "file"
    fileInupt.multiple = true
    fileInupt.hidden = true;
    fileInupt.name = "imagen"
    fileInupt.setAttribute("accept", "jpg, png, webp, svg, jpeg")


    dropzone.appendChild(fileInupt)

    let container = new DataTransfer();
    dropzone.addEventListener("drop", e => {
        const files = e.dataTransfer.files;
        dropzone.classList.remove("drop-zone_active")

        if (files.length) {

            [...files].forEach(file => {

                const lastFiles = [...fileInupt.files]

                if (lastFiles.some((lf) => {
                    if (lf.name == file.name) return file
                })) {
                    addToast([{ Title: "repetido", error: "imagen ya existe" }])
                    return
                } else {
                    container.items.add(file)
                    fileInupt.files = container.files;
                    console.log(fileInupt.files)
                    handleFiles(file)
                }

            })

        }
    })



    function handleFiles(file) {




        const reader = new FileReader();
        reader.readAsDataURL(file)
        reader.onloadend = (e => {

            const preview = document.createElement('img');
            const li = document.createElement("li")
            const deleteBtn = document.createElement("div")
            deleteBtn.classList.add("deleteBtn")
            deleteBtn.addEventListener("click", () => {
                li.remove()
                console.log(file)

                const lastItems = [...fileInupt.files]

                const nuevosItems = lastItems.map(item => {
                    if (item.lastModified !== file.lastModified) return item
                })
                container = new DataTransfer()

                nuevosItems.forEach(item => {
                    if (item) container.items.add(item)
                })
                fileInupt.files = container.files;

                console.log(fileInupt.files)
                return;
            })
            const img = document.createElement("img")
            img.src = "/build/src/images/trash.svg"
            deleteBtn.appendChild(img)
            li.appendChild(deleteBtn)
            li.appendChild(preview)

            preview.src = e.target.result;

            preview.classList.add('preview-image');
            filesUploaded.appendChild(li);
        })



    }



    contenedor.appendChild(dropzone)



    contenedor.appendChild(filesUploaded)


    return contenedor

}