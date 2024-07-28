/**
 * author Joaquín Álvarez
 * created on 27-07-2024-21h-58m
 * github: https://github.com/JoacohDeveloper
 */

const form = document.querySelector("form");
const codeInput = document.querySelector("#codigo");

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    try {
        if (codeInput.value == "")
            throw new Error("El codigo es un campo obligatorio.");

        const response = await fetch(`http://${window.location.host}/dashboard/verificar`, {
            method: "POST",
            body: new FormData(form)
        })

        // if (!response.ok) throw new Error("Error al conectarse al servidor.")

        const data = await response.json();

        if (data?.error) throw new Error(data?.error)

        if (!data?.successfully) {
            throw new Error("Error al conectarse al servidor.")
        }

        window.location.href = "/dashboard"

    } catch (err) {
        addToast([{ title: "Failure", error: err?.message }]);
    }
});
