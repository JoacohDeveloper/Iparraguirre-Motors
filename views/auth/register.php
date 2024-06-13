<div class="loader">
</div>
<div class="container">

    <section class="form-section">
        <h1>Register</h1>
        <form method="POST" action="" id="regForm">
            <div>
                <label class="inputs_txt" id="fullname_txt">Fullname</label>
                <input class="inputs" type="text" name="fullname" placeholder="Nombre Completo" value="<?php echo $campos["fullname"] ?? "" ?>">
                <div class="input-underline"></div>
            </div>
            <div>
                <label class="inputs_txt" id="username_txt">Username</label>
                <input class="inputs" type="text" name="username" placeholder="Username" value="<?php echo $campos["username"] ?? "" ?>">
                <div class="input-underline"></div>
            </div>
            <div>
                <label class="inputs_txt">Email</label>
                <input class="inputs" type="text" name="email" placeholder="Email" value="<?php echo $campos["email"] ?? "" ?>">
                <div class="input-underline"></div>
            </div>
            <div>
                <label class="inputs_txt">Password</label>
                <input class="inputs" type="password" name="password" placeholder="Password">
                <div class="input-underline"></div>
            </div>
            <div>
                <label class="inputs_txt" id="repeat-password_txt">Repeat password</label>
                <input class="inputs" type="password" name="re_password" placeholder="Repetir Password">
                <div class="input-underline"></div>
            </div>
            <div class="terms">
                <input type="checkbox">
                <label id="terms_txt">Aceptar los terminos y condiciones</label>
            </div>
            <input id="boton" type="submit" value="Registrar">
            <a class="opposite" href="/auth/login">Log In</a>
        </form>
    </section>
    <?php implementComp("error_toast.php") ?>
</div>