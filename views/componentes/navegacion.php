<?php $url = $_SERVER["REQUEST_URI"]; ?>


<nav class="navegacion">
    <ul>
        <li><a href="/" class="<?php echo $url === '/' ? 'actual-index' : '' ?>">Inicio</a></li>
        <li><a href="/catalogo" class="<?php echo $url === '/catalogo' ? 'actual' : '' ?>">Catalogo</a></li>
        <li><a href="/tienda" class="<?php echo (strpos($url, '/tienda') === 0) ? 'actual' : '' ?>">Tienda</a></li>
        <li>
        <a href="/cuenta" class="<?php echo $url === '/cuenta' ? 'actual' : '' ?>">Cuenta</a>
            <ul class="dropdown-content">
                <li><a href="/carrito" class="<?php echo $url === '/carrito' ? 'actual' : '' ?>">Carrito</a></li>
                <li><a href="/Lista de Deseos" class="<?php echo $url === '/Lista de Deseos' ? 'actual' : '' ?>">Lista de Deseos</a></li>
                <li><a href="/Ajustes" class="<?php echo $url === '/Ajustes' ? 'actual' : '' ?>">Ajustes</a></li>
                <li><a href="/logout" class="<?php echo $url === '/Cerrar Sesion' ? 'actual' : '' ?>">Cerrar Sesión</a></li>
            </ul>
        </li>
        <li><a href="/faq" class="<?php echo $url === '/faq' ? 'actual' : '' ?>">Ayuda</a></li>
    </ul>
</nav>