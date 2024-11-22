<div class="container">

    <div class="dashboard-content">
        <div class="dashboard-fit">
            <div class="dashboard-title">
                <h3>Bienvenido al dashboard de IparraguirreMotors</h3>
            </div>

            <div class="dashboard-info">
                <p>Actualmente los datos de tu cuenta son inseguros<br>
                Completa las siguientes casillas con la nueva informacion de tu cuenta</p>
            </div>

            <form id="newInfo">
                <h5>Mis datos</h5>
                <div class="form-group">
                    <label class="inputs_txt" id="username_txt">Nombre de usuario</label>
                    <input class="inputs" type="text" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <label class="inputs_txt">Correo electrónico</label>
                    <input class="inputs" type="text" name="email" placeholder="Email">
                </div>
                <div class="form-group password-group">
                    <label class="inputs_txt">Contraseña</label>
                    <input class="inputs" type="password" name="password" placeholder="Password">
                    <button type="button" class="show-password" onclick="togglePassword(this)">
                        <img src="/build/src/images/closedEye.svg" alt="Mostrar contraseña">
                    </button>
                </div>
                <div class="form-group password-group">
                    <label class="inputs_txt" id="repeat-password_txt">Repetir contraseña</label>
                    <input class="inputs" type="password" name="re_password" placeholder="Repetir Password">
                    <button type="button" class="show-password" onclick="togglePassword(this)">
                        <img src="/build/src/images/closedEye.svg" alt="Mostrar contraseña">
                    </button>
                </div>
                <input id="boton" type="submit" value="Cambiar datos">
            </form>

        </div>
    </div>
    <?php implementComp("error_toast.php") ?>
</div>