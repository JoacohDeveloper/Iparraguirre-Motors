<div class="container" style="justify-content: center; align-items: center;">

<section>
    <h1>LOGIN</h1>
    <form method="POST" action="">
        <?php if (isset($errores)) {
                foreach ($errores as $key => $value) {
                    echo "<div class='error'>$value</div>";
                }
            } ?>
        <div>
            <p class="inputs_txt">Email</p>
            <input class="inputs" type="text" name="email" placeholder="Usuario o Email">
            <div id="primera_linea"></div>
        </div>
        <div>
            <p class="inputs_txt">Password</p>
            <input class="inputs" type="password" name="password" placeholder="Password">
            <div id="segunda_linea"></div>
        </div>
        <div class="remember">
            <input type="checkbox">
            <p id="remember_txt">Remember me</p>
        </div>
        <input id="boton" type="submit" value="Ingresar">
        <p id="regist_txt">Sign Up</p>
    </form>
</section>

</div>