<?php $url = $_SERVER["REQUEST_URI"]; ?>


<nav class="navegacion">
    <ul>
        <li><a href="/" class="nav-links <?php echo $url === '/' ? 'actual-index' : '' ?>">Inicio</a></li>
        <li><a href="/tienda" class="nav-links <?php echo (strpos($url, '/tienda') === 0) ? 'actual' : '' ?>">Tienda</a></li>
        <li><a href="/faq" class="nav-links <?php echo $url === '/faq' ? 'actual' : '' ?>">Ayuda</a></li>
        <li class="dropdown">
            <a class="nav-links <?php echo $url === '/cuenta' ? 'actual' : '' ?>">Cuenta</a>
            <ul class="dropdown-content">
                <?php include __DIR__ . "/themeSwitcher.php"; ?>
                <li><a href="/settings" class="<?php echo $url === '/Ajustes' ? 'actual' : '' ?>">Ajustes</a></li>
                <li><a href="/carrito" class="<?php echo $url === '/carrito' ? 'actual' : '' ?>">Carrito</a></li>
                <li><a href="/Lista de Deseos" class="<?php echo $url === '/Lista de Deseos' ? 'actual' : '' ?>">Lista de Deseos</a></li>
                <li><a href="/logout" id="logout" class="<?php echo $url === '/Cerrar Sesion' ? 'actual' : '' ?>">Cerrar Sesión</a></li>
            </ul>
        </li>
    </ul>
</nav>