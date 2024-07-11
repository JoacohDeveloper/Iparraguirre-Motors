<?php $url = $_SERVER["REQUEST_URI"]; ?>

<nav class="navegacion">
    <ul>

        <li><a href="/tienda/wishlist" class="<?php echo $url === '/tienda/wishlist' ? 'actual' : '' ?>"><img src="/build/src/images/bookmark.svg" alt="wishlist icon"> Wishlist</a></li>

        <li><a href="/tienda/cart" class="<?php echo $url === '/tienda/cart' ? 'actual' : '' ?>">
                <div>
                    <img src="/build/src/images/cart.svg" alt="cart icon">
                    <p id="cart-items">0</p>
                </div>
                Cart
            </a></li>

        <li><a href="/client/account" class="<?php echo $url === '/client/account"' ? 'actual' : '' ?>">
                <img src="/build/src/images/account.svg" alt="account icon">
                Account</a></li>
    </ul>
</nav>