<?php $url = $_SERVER["REQUEST_URI"]; ?>


<nav class="navegacion">
    <ul>
        <li><a href="/" class="<?php echo $url === '/' ? 'actual-index' : '' ?>">Inicio</a></li>
        <li><a href="/catalogo" class="<?php echo $url === '/catalogo' ? 'actual' : '' ?>">Catalogo</a></li>
        <li><a href="/tienda" class="<?php echo (strpos($url, '/tienda') === 0) ? 'actual' : '' ?>">Tienda</a></li>
        <li><a href="/faq" class="<?php echo $url === '/faq' ? 'actual' : '' ?>">Ayuda</a></li>
        <li><a href="/auth" class="<?php echo $url === '/auth' ? 'actual' : '' ?>">Iniciar sesion</a></li>
    </ul>
</nav>