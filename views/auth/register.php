<div class="container" style="justify-content: center; align-items: center; flex-direction: column;">

<section>
    <h1>Register</h1>
    <form method="POST" action="">
        <?php if (isset($errores)) {
                foreach ($errores as $key => $value) {
                    echo "<div class='error'>$value</div>";
                }
            } ?>
        <div>
            <p class="inputs_txt" id="fullname_txt">Fullname</p>
            <input class="inputs" type="text" name="fullname" placeholder="Nombre Completo" value="<?php echo $campos["fullname"] ?>">
            <div id="primera_linea"></div>
        </div>
        <div>
            <p class="inputs_txt" id="username_txt">Username</p>
            <input class="inputs" type="text" name="username" placeholder="Username" value="<?php echo $campos["username"] ?>">
            <div id="segunda_linea"></div>
        </div>
        <div>
            <p class="inputs_txt">Email</p>
            <input class="inputs" type="text" name="email" placeholder="Email" value="<?php echo $campos["email"] ?>">
            <div id="tercera_linea"></div>
        </div>
        <div>
            <p class="inputs_txt">Password</p>
            <input class="inputs" type="password" name="password" placeholder="Password">
            <div id="cuarta_linea"></div>
        </div>
        <div>
            <p class="inputs_txt" id="repeat-password_txt">Repeat password</p>
            <input class="inputs" type="password" name="re_password" placeholder="Repetir Password">
            <div id="quinta_linea"></div>
        </div>
        <div class="terms">
            <input type="checkbox">
            <p id="terms_txt">Acepto los terminos y condiciones</p>
        </div>
        <input id="boton" type="submit" value="Registrar">
        <p id="login_txt">Log In</p>
    </form>
</section>

</div>