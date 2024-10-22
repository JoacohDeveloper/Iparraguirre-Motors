<?php $url = $_SERVER["REQUEST_URI"]; ?>


<nav class="navegacion">
    <ul>
        <li><a href="/" class="nav-links <?php echo $url === '/' ? 'actual-index' : '' ?>">Inicio</a></li>
        <li><a href="/catalogo" class="nav-links <?php echo (strpos($url, '/catalogo') === 0) ? 'actual' : '' ?>">Catalogo</a></li>
        <li><a href="/faq" class="nav-links <?php echo $url === '/faq' ? 'actual' : '' ?>">Ayuda</a></li>
        <li><a href="/auth" class="nav-links <?php echo $url === '/auth' ? 'actual' : '' ?>">Iniciar sesion</a></li>
    </ul>
</nav>