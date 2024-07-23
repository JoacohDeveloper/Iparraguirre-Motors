<div class="container">
    <style>
        #_form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            width: 60%;
            padding-left: 2rem;
        }

        p {
            width: 100%;
            margin-bottom: 2rem;
            padding-left: 2rem;

        }

        .container {
            flex-direction: column;
        }

        button {
            padding: .6rem;
            border: 1px solid #202020;
            border-radius: .2rem;
            color: #202020;

            max-width: fit-content;
        }

        input {
            max-width: fit-content;
            padding: .2rem .4rem;
        }
    </style>
    <p>Escribe lo que quieras que se pase por protocolo web sockets</p>

    <form id="_form">
        <input id="wss" type="text" name="wss" placeholder="Mensaje">
        <button type="submit">Enviar</button>
    </form>


    <script type="module">
        const id = new Date().getMilliseconds();
        import {
            io
        } from "https://cdn.socket.io/4.7.5/socket.io.esm.min.js";

        const socket = io('ws://localhost:3001/');


        const _form = document.querySelector("#_form")

        _form.addEventListener("submit", e => {
            e.preventDefault()
            const input = _form.querySelector("#wss")

            socket.emit("message", {
                msg: `${id}: ${input.value}`
            })
        })

        socket.on("messageback", data => {
            console.log(data)
        })
    </script>
</div>