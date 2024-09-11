function ImageUploader() {
    const contenedor = document.createElement("div");

    contenedor.classList.add("imageUploader-container");

    // DROPZONE

    const dropzone = document.createElement("div");
    dropzone.classList.add("imageUploader-dropzone");

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    dropzone.addEventListener("dragover", preventDefaults);
    dropzone.addEventListener("dragenter", preventDefaults);
    dropzone.addEventListener("dragleave", preventDefaults);

    dropzone.addEventListener("dragenter", () => {
        dropzone.classList.add("drop-zone_active");
    });

    dropzone.addEventListener("dragover", () => {
        dropzone.classList.add("drop-zone_active");
    });

    dropzone.addEventListener("dragleave", () => {
        dropzone.classList.remove("drop-zone_active");
    });

    dropzone.addEventListener("dragend", () =>
        dropzone.classList.remove("drop-zone_active")
    );

    dropzone.addEventListener("drop", preventDefaults);

    const text = document.createElement("p");
    text.textContent = "drag and drop images here";

    dropzone.appendChild(text);

    const filesUploaded = document.createElement("ul");

    const fileInupt = document.createElement("input");
    fileInupt.type = "file";
    fileInupt.multiple = true;
    fileInupt.hidden = true;
    fileInupt.name = "imagen[]";
    fileInupt.setAttribute("accept", "jpg, png, webp, svg, jpeg");

    dropzone.appendChild(fileInupt);

    const buttonOpenFilePicker = document.createElement("button");

    buttonOpenFilePicker.classList.add("filepicker");
    buttonOpenFilePicker.textContent = "Or select from local";
    buttonOpenFilePicker.addEventListener("click", (e) => {
        e.preventDefault();
        fileInupt.click();
    });

    let container = new DataTransfer();
    fileInupt.addEventListener("change", (e) => {
        e.preventDefault();
        const files = [...e.target.files];
        validarDT(files, container);
    });

    dropzone.appendChild(buttonOpenFilePicker);

    dropzone.addEventListener("drop", (e) => {
        dropzone.classList.remove("drop-zone_active");
        const files = [...e.dataTransfer.files];
        const items = [...e.dataTransfer.items];
        try {
            items.forEach((item) => {
                if (item.kind == "file") {
                    if (item.webkitGetAsEntry() == null) {
                        throw new Error(item.getAsFile().name);
                    }
                }
            });
            validarDT(files, container);
        } catch (error) {
            addToast([
                {
                    title: "origen de datos",
                    error: `imagen "${error?.message}" no valida`,
                },
            ]);
            return;
        }
    });

    function validarDT(files, container) {
        try {
            if (files.length) {
                files.forEach((file) => {
                    const lastFiles = [...container.files];
                    const repetido = lastFiles.some((lf) => {
                        if (lf.name == file.name) return file;
                    });

                    if (repetido) {
                        throw new Error(file.name);
                    } else {
                        container.items.add(file);
                        handleFiles(file);
                    }
                });
            }
        } catch (error) {
            addToast([
                { title: "repetido", error: `imagen "${error.message}" ya existe` },
            ]);
            return;
        }
    }

    function handleFiles(file) {
        fileInupt.files = container.files;
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onloadend = (e) => {
            const preview = document.createElement("img");
            const li = document.createElement("li");
            const deleteBtn = document.createElement("div");
            deleteBtn.classList.add("deleteBtn");
            deleteBtn.addEventListener("click", () => {
                li.remove();
                const lastItems = [...container.files];
                const index = lastItems.findIndex((lfile) => lfile.name === file.name);
                container.items.remove(index);
                fileInupt.files = container.files;
                return;
            });
            const img = document.createElement("img");
            img.src = "/build/src/images/trash.svg";
            deleteBtn.appendChild(img);
            li.appendChild(deleteBtn);
            li.appendChild(preview);
            preview.src = e.target.result;
            preview.classList.add("preview-image");
            filesUploaded.appendChild(li);
        };
    }

    contenedor.appendChild(dropzone);

    contenedor.appendChild(filesUploaded);

    return contenedor;
}
