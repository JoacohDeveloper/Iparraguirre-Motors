<div class="container" style="justify-content: center; align-items: center; flex-direction: column;">
    <h2>Hello world from register</h2>
    <div class="errores">
        <?php
        if (isset($errores)) {
            foreach ($errores as $key => $value) {
                echo "<div class='error'>$value</div>";
            }
        } ?>
    </div>

    <form action="/auth/register" method="post" id="f_register">

        <input type="text" name="fullname" placeholder="Nombre Completo" value="<?php echo $campos["fullname"] ?>">

        <input type="text" name="username" placeholder="Username" value="<?php echo $campos["username"] ?>">

        <input type="text" name="email" placeholder="Email" value="<?php echo $campos["email"] ?>">

        <input type="password" name="password" placeholder="Password">

        <input type="password" name="re_password" placeholder="Repetir Password">

        <input type="submit" value="enviar">

    </form>
</div>