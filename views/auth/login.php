<div class="container" style="justify-content: center; align-items: center;">

    <?php
    if (isset($errores)) {
        foreach ($errores as $key => $value) {
            echo "<div class='error'>$value</div>";
        }
    }
    ?>

    <form action="/auth/login" method="POST" id="f_login">
        <input type="text" name="email" placeholder="Correo electronico" value="<?php echo $campos["email"] ?>">
        <input type="password" name="password" placeholder="Contraseña">
        <input type="submit" value="Ingresar">
    </form>
</div>