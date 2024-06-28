<?php $url = $_SERVER["REQUEST_URI"]; ?>

<nav class="navegacion">
    <ul>
        <li><a href="/" class="<?php echo $url === '/' ? 'actual-index' : '' ?>">Home</a></li>
        <li><a href="/tienda" class="<?php echo $url === '/tienda' ? 'actual' : '' ?>">Tienda</a></li>
        <li><a href="/trade" class="<?php echo $url === '/trade' ? 'actual' : '' ?>">Trade</a></li>
        <li><a href="/dashboard" class="<?php echo $url === '/dashboard' ? 'actual' : '' ?>">Portfolio</a></li>
        <li><a href="/auth/register" class="<?php echo $url === '/auth/register' ? 'actual' : '' ?>">cuenta</a></li>
    </ul>
</nav>