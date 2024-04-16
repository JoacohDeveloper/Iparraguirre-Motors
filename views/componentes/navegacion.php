<?php $url = $_SERVER["REQUEST_URI"]; ?>
<nav class="navegacion">
    <ul>
        <li><a href="#" class="<?php echo $url === '/' ? 'actual-index' : '' ?>">Home</a></li>
        <li><a href="/tienda">Tienda</a></li>
        <li><a href="#">Trade</a></li>
        <li><a href="#">Portfolio</a></li>
        <li><a href="#">FAQ</a></li>
    </ul>
</nav>