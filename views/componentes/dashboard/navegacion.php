<nav class="navegacion-dashboard isDashboard">
    <?php
    $usuario = $_SESSION["usuario"] ?? null;
    $username = "";
    if (isset($usuario)) {
        $username = $usuario->getUsername();
    }

    ?>
    <ul>
        <li title="Announces"><img src="/build/src/images/announce.svg" alt="Announces">
            <ul class="sub-dropdown">
                <li><a href="/dashboard/user-settings">
                        <img src="/build/src/images/settings.svg" alt="Settings">
                        <p>Configuracion</p>
                    </a></li>
                <li title="Theme Changer">

                    <?php include str_replace("dashboard", "", __DIR__) . "themeSwitcher.php" ?>

                </li>
                <li class="border-top">
                    <a href="#">
                        <img src="/build/src/images/exit.svg" alt="Logout">
                        <p>Cerrar sesion</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="notifications" title="Notifications"><img src="/build/src/images/notifications.svg" alt="Notifications">
            <ul class="sub-dropdown notifications-dropdown">
                <li class="notifications-header">
                    <p>Notificaciones</p>
                    <label>Marcar como visto</label>
                </li>
                <li class="border-top">
                    <p>No tienes notificaciones</p>
                </li>
            </ul>
        </li>
        <li class="account" title="Your Profile">
            <a href="#" title="profile image" class="card profile-img rounded">
                <img id="nav_profileImg__id" src="<?php echo isset($usuario) ? $usuario->getImagen() : "" ?>" alt="<?php echo isset($usuario) ? $usuario->getNombreImagen() : "" ?>">
            </a>
            <p id="nav_profileUsername__id">Bienvenido, <?php echo $username ? $username . "." : "..."; ?></p>

            <ul class="sub-dropdown account-dropdown">

                <li><a href="/dashboard/user-settings?u=<?php echo isset($_SESSION["usuario"]) ? $_SESSION["usuario"]->getUUID() : "" ?>">
                        <img src="/build/src/images/settings.svg" alt="Settings">
                        <p>Configuracion</p>
                    </a></li>
                <li title="Theme Changer">

                    <?php include str_replace("dashboard", "", __DIR__) . "themeSwitcher.php" ?>

                </li>
                <li class="border-top">
                    <a href="/dashboard/logout">
                        <img src="/build/src/images/exit.svg" alt="Logout">
                        <p>Cerrar sesion</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>