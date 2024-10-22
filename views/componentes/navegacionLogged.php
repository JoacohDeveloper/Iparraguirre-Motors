<?php $url = $_SERVER["REQUEST_URI"]; ?>


<nav class="navegacion">
    <ul>
        <li><a href="/" class="nav-links <?php echo $url === '/' ? 'actual-index' : '' ?>">Inicio</a></li>
        <li><a href="/catalogo" class="nav-links <?php echo (strpos($url, '/catalogo') === 0) ? 'actual' : '' ?>">Catalogo</a></li>
        <li><a href="/faq" class="nav-links <?php echo $url === '/faq' ? 'actual' : '' ?>">Ayuda</a></li>
        <li class="dropdown">
            <a class="nav-links <?php echo $url === '/cuenta' ? 'actual' : '' ?>">Cuenta</a>
            <ul class="dropdown-content">
                <?php include __DIR__ . "/themeSwitcher.php"; ?>
                <li><a href="/settings?u=<?php echo isset($_SESSION["usuario"]) ? $_SESSION["usuario"]->getUUID() : "" ?>" class="<?php echo $url === '/Ajustes' ? 'actual' : '' ?>">Ajustes</a></li>
                <li><a href="/settings?u=<?php echo isset($_SESSION["usuario"]) ? $_SESSION["usuario"]->getUUID() : "" ?>#cart" class="<?php echo $url === '/carrito' ? 'actual' : '' ?>">Carrito</a></li>
                <li><a href="/settings?u=<?php echo isset($_SESSION["usuario"]) ? $_SESSION["usuario"]->getUUID() : "" ?>#wishlist" class="<?php echo $url === '/Lista de Deseos' ? 'actual' : '' ?>">Lista de Deseos</a></li>
                <li><a href="/logout" id="logout" class="<?php echo $url === '/Cerrar Sesion' ? 'actual' : '' ?>">Cerrar Sesión</a></li>
            </ul>
        </li>
        <li id="settings"><a class="nav-links" href="/settings?u=<?php echo isset($_SESSION["usuario"]) ? $_SESSION["usuario"]->getUUID() : ""; ?>">Cuenta</a></li>
        <li id="settingsLog"><a class="nav-links" href="/logout" class="<?php echo $url === '/Cerrar Sesion' ? 'actual' : '' ?>">Cerrar Sesión</a></li>
    </ul>
</nav>