<div class="loader"></div>
<div class="container">
    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>Have an account?</h3>
                    <p>Presiona el boton de abajo para ingresar</p>
                    <button id="btn__iniciar-sesion">Log In</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>Do not have an account?</h3>
                    <p>Presiona el boton de abajo para registrarte</p>
                    <button id="btn__registrarse">Sign Up</button>
                </div>
            </div>
            <div class="contenedor__login-register">
                <form method="POST" action="/auth/login" id="loginForm">
                    <h2>Log In</h2>
                    <input type="text" name="email" placeholder="User o Email">
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
                    <h2>Sign Up</h2>
                    <input type="text" name="full_name" placeholder="Full Name">
                    <input type="text" name="username" placeholder="User">
                    <input type="text" name="email" placeholder="Email">
                    <input type="text" name="phone" placeholder="Phone">
                    <div class="password-container">
                        <input type="password" name="password" placeholder="Password" inputmode="text">
                        <button type="button" class="show-password" onclick="togglePassword(this)">
                            <img src="/build/src/images/eye.svg" alt="Mostrar contraseña">
                        </button>
                    </div>
                    <div class="password-container">
                        <input type="password" name="re_password" placeholder="Repeat Password" inputmode="text">
                        <button type="button" class="show-password" onclick="togglePassword(this)">
                            <img src="/build/src/images/eye.svg" alt="Mostrar contraseña">
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
