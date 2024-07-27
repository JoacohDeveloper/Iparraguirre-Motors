<div class="loader">
</div>
<div class="container">


    <section class="login-section">
        <h1>LOGIN</h1>
        <form method="POST" action="/dashboard/login" id="loginForm">
            <div class="errores"></div>
            <div>
                <label for="email" class="inputs_txt">Email</label>
                <input class="inputs" id="email" type="text" name="email" placeholder="Usuario o Email">
                <div class="input-underline"></div>
            </div>
            <div>
                <label for="password" class="inputs_txt">Password</label>
                <input class="inputs" id="password" type="password" name="password" placeholder="Password">
                <div class="input-underline"></div>
            </div>
            <div class="remember">
                <input id="remember" type="checkbox">
                <label for="remember" id="remember_txt">Remember me</label>
            </div>
            <input id="boton" type="submit" value="Ingresar">
            <a class="opposite" href="/dashboard/register">Sign Up</a>
        </form>
    </section>
    <?php implementComp("error_toast.php") ?>

</div>