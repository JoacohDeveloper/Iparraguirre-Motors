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
    dropzone.addEventListener("drop", e => {
        const files = e.dataTransfer.files;
        dropzone.classList.remove("drop-zone_active")
        // Checking if there are any files
        if (files.length) {
            // Assigning the files to the hidden input from the first step
            fileInupt.files = files;

            // Processing the files for previews (next step)
            handleFiles(files);
        }
    })
    const fileInupt = document.createElement("input")
    fileInupt.type = "file"
    fileInupt.multiple = true
    fileInupt.name = "images"
    fileInupt.hidden = true;
    fileInupt.setAttribute("accept", "jpg, png, webp, svg, jpeg")

    const text = document.createElement("p")
    text.textContent = "drag and drop images here"

    dropzone.appendChild(text)

    dropzone.appendChild(fileInupt)

    const filesUploaded = document.createElement("ul")

    let filesVar = []
    function handleFiles(files) {

        filesVar = [...filesVar, ...files]

        document.querySelector("ul").innerHTML = null;


        function filterUniqueFiles(files) {

            const fileNames = new Set();
            return files.filter(file => {
                const fileName = file.name;
                if (fileNames.has(fileName)) {
                    // Si el nombre ya existe, no lo incluimos en el nuevo array
                    return false;
                } else {
                    // Si es la primera vez que vemos este nombre, lo añadimos al Set y lo dejamos pasar
                    fileNames.add(fileName);
                    return true;
                }
            });
        }
        const uniqueFiles = filterUniqueFiles(filesVar)
        filesVar = uniqueFiles
        filesVar.forEach(file => {

            const reader = new FileReader();
            reader.readAsDataURL(file);

            // Once the file has been loaded, fire the processing
            reader.onloadend = function (e) {

                //intento de validacion de repetidos

                const preview = document.createElement('img');
                const li = document.createElement("li")
                const deleteBtn = document.createElement("div")
                deleteBtn.classList.add("deleteBtn")
                deleteBtn.addEventListener("click", () => {
                    li.remove()
                    return;
                })
                const img = document.createElement("img")
                img.src = "/build/src/images/trash.svg"
                deleteBtn.appendChild(img)
                li.appendChild(deleteBtn)
                li.appendChild(preview)

                preview.src = e.target.result;
                // Apply styling
                preview.classList.add('preview-image');
                filesUploaded.appendChild(li);
            }
        })

        // filesVar.forEach(file => {
        //     if(uniqueFiles.includes(file.name)) {

        //             }
        //         }
        //     }
        // })

        // for(const file of files) {


        //     const arrayNoRepetidos = [...new Set(filesVar)]

        //     arrayNoRepetidos.forEach(filev => {


        //         if(file.name == filev) {

        //         }
        //     })
        // }

    }


    contenedor.appendChild(dropzone)



    contenedor.appendChild(filesUploaded)


    return contenedor

}