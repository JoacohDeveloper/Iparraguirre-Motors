<ul class="dashboard-brgMenu-ul">
    <li>
        <a href="/dashboard">Inicio</a>
    </li>
    <li>
        <a class="toggle-dropdown">Gestion de productos</a>
        <ul class="productmanagment-dropdown">
            <li><a href="/dashboard/products/vehicle">Vehiculos</a></li>
            <li><a href="/dashboard/products/refraction">Repuestos</a></li>
        </ul>
    </li>
    <li>
        <a class="toggle-dropdown">Gestion de descuentos</a>
        <ul class="discounts-dropdown">
            <li><a href="/dashboard/discounts/vehicle">Vehiculos</a></li>
            <li><a href="/dashboard/discounts/refractions">Repuestos</a></li>
        </ul>
    </li>
    <li>
        <a href="/dashboard/orders">Ordenes</a>
    </li>
    <li>
        <a href="/dashboard/feedback">Reseñas</a>
    </li>
    <li>
        <a class="toggle-dropdown">Graficas</a>
        <ul class="analytics-dropdown">
            <li><a href="/dashboard/analytics/client">Clientes</a></li>
            <li><a href="/dashboard/analytics/sells">Ventas</a></li>
            <li><a href="/dashboard/analytics/products">Productos</a></li>
        </ul>
    </li>
    <?php
        $usuario = $_SESSION["usuario"] ?? null;
        if (isset($usuario)) {
            $isEncargado = $usuario->isEncargado();
        }

        if ($isEncargado == true) {
            echo '<li>
                    <a href="/dashboard/manageClient">Gestionar clientes</a>
                  </li>
                  <li>
                    <a href="/dashboard/manageEmployee">Gestionar empleados</a>
                  </li>';
        }
    ?>
    <li>
        <a href="/dashboard/user-settings?u=<?php echo isset($_SESSION["usuario"]) ? $_SESSION["usuario"]->getUUID() : "" ?>">Configuracion</a>
    </li>
    <li>
        <a href="/dashboard/logout">Cerrar sesion</a>
    </li>
</ul>
