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
            <div>
                <label class="inputs_txt" id="username_txt">Nombre de usuario</label>
                <input class="inputs" type="text" name="username" placeholder="Username">
            </div>
            <div>
                <label class="inputs_txt">Correo electronico</label>
                <input class="inputs" type="text" name="email" placeholder="Email">
            </div>
            <div>
                <label class="inputs_txt">Contraseña</label>
                <input class="inputs" type="password" name="password" placeholder="Password">
            </div>
            <div>
                <label class="inputs_txt" id="repeat-password_txt">Repetir contraseña</label>
                <input class="inputs" type="password" name="re_password" placeholder="Repetir Password">
            </div>
                <input id="boton" type="submit" value="Cambiar datos">
            </form>

        </div>
    </div>
    <?php implementComp("error_toast.php") ?>
</div>