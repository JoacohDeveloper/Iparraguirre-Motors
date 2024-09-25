<?php $url = $_SERVER["REQUEST_URI"]; ?>


<nav class="navegacion">
    <ul>
        <li><a href="/" class="nav-links <?php echo $url === '/' ? 'actual-index' : '' ?>">Inicio</a></li>
        <li><a href="/catalogo/vehiculos" class="nav-links <?php echo (strpos($url, '/catalogo/vehiculos') === 0) ? 'actual' : '' ?>">Tienda</a></li>
        <li><a href="/faq" class="nav-links <?php echo $url === '/faq' ? 'actual' : '' ?>">Ayuda</a></li>
        <li><a href="/auth" class="nav-links <?php echo $url === '/auth' ? 'actual' : '' ?>">Iniciar sesion</a></li>
    </ul>
</nav>