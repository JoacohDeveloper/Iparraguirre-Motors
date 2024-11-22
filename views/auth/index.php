<div class="loader"></div>
<div class="container">
    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>Tienes una cuenta?</h3>
                    <p>Presiona el boton de abajo para ingresar</p>
                    <button id="btn__iniciar-sesion">Log In</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>No tienes una cuenta?</h3>
                    <p>Presiona el boton de abajo para registrarte</p>
                    <button id="btn__registrarse">Sign Up</button>
                </div>
            </div>
            <div class="contenedor__login-register">
                <form method="POST" action="/auth/login" id="loginForm">
                    <h2>Inicio de sesion</h2>
                    <input type="text" name="email" placeholder="Correo o usuario">
                    <div class="password-container">
                        <input type="password" name="password" placeholder="Password">
                        <button type="button" class="show-password" onclick="togglePassword(this)">
                            <img src="/build/src/images/closedEye.svg" alt="Mostrar contraseña">
                        </button>
                    </div>
                    <input class="boton" type="submit" value="Ingresar">
                    <p id="p_signUp">¿No tienes una cuenta? Registrate</p>
                </form>
                <form method="POST" action="/auth/register" id="regForm">
                    <h2>Registro</h2>
                    <input type="text" name="full_name" placeholder="Nombre completo">
                    <input type="text" name="username" placeholder="Nombre de usuario">
                    <input type="text" name="email" placeholder="Correo electronico">
                    <input type="text" name="phone" placeholder="Numero de telefono">
                    <div class="password-container">
                        <input type="password" name="password" placeholder="Contraseña" inputmode="text">
                        <button type="button" class="show-password" onclick="togglePassword(this)">
                            <img src="/build/src/images/closedEye.svg" alt="Mostrar contraseña">
                        </button>
                    </div>
                    <div class="password-container">
                        <input type="password" name="re_password" placeholder="Repetir contraseña" inputmode="text">
                        <button type="button" class="show-password" onclick="togglePassword(this)">
                            <img src="/build/src/images/closedEye.svg" alt="Mostrar contraseña">
                        </button>
                    </div>
                    <input class="boton" type="submit" value="Registrar">
                    <p id="p_logIn">¿Ya tienes una cuenta? Inicia sesion</p>
                </form>
            </div>
        </div>
    </main>
    <?php implementComp("error_toast.php") ?>
</div>
