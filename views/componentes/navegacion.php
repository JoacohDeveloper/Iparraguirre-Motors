<?php $url = $_SERVER["REQUEST_URI"]; ?>

<nav class="navegacion">
    <ul>
        <li><a href="/" class="<?php echo $url === '/' ? 'actual-index' : '' ?>">Home</a></li>
        <li><a href="/tienda" class="<?php echo $url === '/tienda' ? 'actual' : '' ?>">Tienda</a></li>
        <li><a href="/trade" class="<?php echo $url === '/trade' ? 'actual' : '' ?>">Trade</a></li>
        <li><a href="/portfolio" class="<?php echo $url === '/portfolio' ? 'actual' : '' ?>">Portfolio</a></li>
        <li><a href="/faq" class="<?php echo $url === '/cuenta' ? 'actual' : '' ?>">cuenta</a></li>
    </ul>
</nav>