<aside class="aside">
    <div class="aside-top">
        <div title="Show" class="more-information aside-element rounded">
            <img src="/build/src/images/tripleDot.svg" alt="mostrar más">
            <p>Close</p>
        </div>
        <a title="Dashboard" class="aside-element rounded" href="/dashboard">
            <img src="/build/src/images/home.svg" alt="Dashboard">
            <p>Dashboard</p>
        </a>

        <ul aria-label="ddl_1" class="dropDown-list">
            <li>
                <a title="Product Managment" class="aside-element rounded" href="#">
                    <div class="dropDown-spacer">
                        <img src="/build/src/images/archive.svg" alt="Product Managment">
                        <p>Product Managment</p>
                    </div>
                    <img src="/build/src/images/miniDownArrow.svg" alt="more elements">
                </a>
            </li>
            <li>
                <ul class="dropDown-links dropDownNotDeployed">
                    <li><a href="/dashboard/products/vehicle">Administrar vehiculos</a></li>
                    <li><a href="/dashboard/products/repuestos">Administrar repuestos</a></li>
                </ul>
            </li>
        </ul>
        <ul aria-label="ddl_2" class="dropDown-list">
            <li>
                <a title="Discounts" class="aside-element rounded" href="#">
                    <div class="dropDown-spacer">
                        <img src="/build/src/images/discount.svg" alt="Discounts">
                        <p>Discounts</p>
                    </div>
                    <img src="/build/src/images/miniDownArrow.svg" alt="more elements">
                </a>
            </li>
            <li>
                <ul class="dropDown-links dropDownNotDeployed">
                    <li><a href="/dashboard/discounts/vehicle">Descuentos de vehiculos</a></li>
                    <li><a href="/dashboard/discounts/refractions">Descuentos de repuestos</a></li>
                </ul>
            </li>
        </ul>
        <a title="Orders" class="aside-element rounded" href="/dashboard/orders">
            <img src="/build/src/images/rocket.svg" alt="Orders">
            <p>Orders</p>
        </a>
        <a title="Feedback" class="aside-element rounded" href="/dashboard/feedback">
            <img src="/build/src/images/pencil.svg" alt="Feedback">
            <p>Feedback</p>
        </a>
        <ul aria-label="ddl_3" class="dropDown-list">
            <li>
                <a title="Analytics" class="aside-element rounded" href="#">
                    <div class="dropDown-spacer">
                        <img src="/build/src/images/analytics.svg" alt="Analytics">
                        <p>Analytics</p>
                    </div>
                    <img src="/build/src/images/miniDownArrow.svg" alt="more elements">
                </a>
            </li>
            <li>
                <ul class="dropDown-links dropDownNotDeployed">
                    <li><a href="/dashboard/analytics/client">Analiticas Clientes</a></li>
                    <li><a href="/dashboard/analytics/sells">Analiticas Ventas</a></li>
                    <li><a href="/dashboard/analytics/products">Analiticas Productos</a></li>
                </ul>
            </li>
        </ul>
        <?php
            $usuario = $_SESSION["usuario"] ?? null;
            if (isset($usuario)) {
                $isEncargado = $usuario->isEncargado();
            }

            if ($isEncargado == true) {
                echo '<ul aria-label="ddl_4" class="dropDown-list">
            <li>
                <a title="Account Managment" class="aside-element rounded" href="#">
                    <div class="dropDown-spacer">
                        <img src="/build/src/images/user.svg" alt="Account Managment">
                        <p>Account Managment</p>
                    </div>
                    <img src="/build/src/images/miniDownArrow.svg" alt="more elements">
                </a>
            </li>
            <li>
                <ul class="dropDown-links dropDownNotDeployed">
                    <li><a href="/dashboard/manageClient">Administrar Clientes</a></li>
                    <li><a href="/dashboard/manageEmployee">Administrar Empleados</a></li>
                </ul>
            </li>
        </ul>';
            }
        ?>

    </div>
    <a title="Settings" class="aside-element rounded" href="/dashboard/user-settings?u=<?php echo isset($_SESSION["usuario"]) ? $_SESSION["usuario"]->getUUID() : "" ?>">
        <img src="/build/src/images/settings.svg" alt="Settings">
        <p>Settings</p>
    </a>


</aside>