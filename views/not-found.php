<div class="contenedor not_found">
    <div>
        <p>no se encontró una página con esa dirección <span style="color: red;"> <?php echo $_SERVER["PATH_INFO"] ?? "/" ?> </span></p>
        <h2>NOT FOUND</h2>
    </div>
    <div>
        <a href="#" id="goback">volver atras</a>
        <div class="img-container">
            <img src="/build/src/images/LOGO.png" alt="Iparraguirre Logo">
        </div>
    </div>
    <script>
        document.querySelector("#goback").addEventListener("click", () => history.back())
    </script>
</div>