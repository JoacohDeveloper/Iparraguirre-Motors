<ul class="dashboard-brgMenu-ul">
    <li>
        <a href="/dashboard">Home</a>
    </li>
    <li>
        <a class="toggle-dropdown">Product Management</a>
        <ul class="productmanagment-dropdown">
            <li><a href="/dashboard/products/vehicle">Vehicles</a></li>
            <li><a href="/dashboard/products/refraction">Refractions</a></li>
        </ul>
    </li>
    <li>
        <a class="toggle-dropdown">Discounts</a>
        <ul class="discounts-dropdown">
            <li><a href="/dashboard/products/vehicle">Vehicles</a></li>
            <li><a href="/dashboard/products/refraction">Refractions</a></li>
        </ul>
    </li>
    <li>
        <a href="/dashboard/orders">Orders</a>
    </li>
    <li>
        <a href="/dashboard/feedback">Feedback</a>
    </li>
    <li>
        <a class="toggle-dropdown">Analytics</a>
        <ul class="analytics-dropdown">
            <li><a href="/dashboard/analytics/client">Client</a></li>
            <li><a href="/dashboard/analytics/sells">Sells</a></li>
            <li><a href="/dashboard/analytics/products">Products</a></li>
        </ul>
    </li>
    <?php
        $usuario = $_SESSION["usuario"] ?? null;
        if (isset($usuario)) {
            $isEncargado = $usuario->isEncargado();
        }

        if ($isEncargado == true) {
            echo '<li>
                    <a href="/dashboard/registAdmin">Admin regist</a>
                  </li>';
        }
    ?>
    <li>
        <a href="/dashboard/user-settings?u=<?php echo isset($_SESSION["usuario"]) ? $_SESSION["usuario"]->getUUID() : "" ?>">Settings</a>
    </li>
    <li>
        <a href="/dashboard/logout">Log out</a>
    </li>
</ul>
