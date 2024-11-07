<?php $url = $_SERVER["REQUEST_URI"]; ?>


<nav class="navegacion">
    <ul>
        <li><a href="/" class="nav-links <?php echo $url === '/' ? 'actual-index' : '' ?>">Inicio</a></li>
        <li><a href="/catalogo" class="nav-links <?php echo (strpos($url, '/catalogo') === 0) ? 'actual' : '' ?>">Catalogo</a></li>
        <li><a href="/faq" class="nav-links <?php echo $url === '/faq' ? 'actual' : '' ?>">Ayuda</a></li>
        <li><a class="nav-links" href="/settings?u=<?php echo isset($_SESSION["usuario"]) ? $_SESSION["usuario"]->getUUID() : ""; ?>">Cuenta</a></li>
        <li class="basket empty">
            <a href="/checkout/cart" class="nav-links <?php echo $url === '/checkout/cart' ? 'actual' : '' ?>">
                <span id="qty">0</span><img src="/build/src/images/cart.svg" alt=""> Carrito
            </a>

            <ul id="basket-products-container">
            </ul>
        </li>
    </ul>
</nav>