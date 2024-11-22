<div class="loader">
</div>
<div class="container">


    <section class="login-section">
        <h1>Inicio de<br>sesion</h1>
        <form method="POST" action="/dashboard/login" id="loginForm">
            <div class="errores"></div>
            <div>
                <label for="email" class="inputs_txt">Correo o nombre de usuario</label>
                <input class="inputs" id="email" type="text" name="email" placeholder="Usuario o Email">
            </div>
            <div>
                <label for="password" class="inputs_txt">Contraseña</label>
                <div class="password-container">
                    <input type="password" name="password" class="inputs" inputmode="text", placeholder="Contraseña">
                    <button type="button" class="show-password" onclick="togglePassword(this)">
                        <img src="/build/src/images/closedEye.svg" alt="Mostrar contraseña">
                    </button>
                </div>
            </div>
            <div class="remember">
                <input id="remember" type="checkbox">
                <label for="remember" id="remember_txt">Mantener sesion</label>
            </div>
            <input id="boton" type="submit" value="Ingresar">
        </form>
    </section>
    <?php implementComp("error_toast.php") ?>
</div>