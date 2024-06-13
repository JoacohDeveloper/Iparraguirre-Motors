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
                        <p>Settings</p>
                    </a></li>
                <li title="Theme Changer">

                    <?php include str_replace("dashboard", "", __DIR__) . "themeSwitcher.php" ?>

                </li>
                <li class="border-top">
                    <a href="#">
                        <img src="/build/src/images/exit.svg" alt="Logout">
                        <p>Log Out</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="notifications" title="Notifications"><img src="/build/src/images/notifications.svg" alt="Notifications">
            <ul class="sub-dropdown notifications-dropdown">
                <li class="notifications-header">
                    <p>Notifications</p>
                    <label>Mark all as read</label>
                </li>
                <li class="border-top">
                    <p>You have no notifications</p>
                </li>
            </ul>
        </li>
        <li class="account" title="Your Profile"><a href="#" title="profile image" class="card profile-img rounded">
                <img src="<?php echo isset($usuario) ? $usuario->getImagen() : "" ?>" alt="<?php echo isset($usuario) ? $usuario->getNombreImagen() : "" ?>">
            </a>
            <p>Welcome, <?php echo $username ? $username . "." : "..."; ?></p>

            <ul class="sub-dropdown account-dropdown">
                <li><a href="/dashboard/user-settings?u=<?php echo isset($usuario) ? $usuario->getUUID() : "" ?>">
                        <img src="/build/src/images/settings.svg" alt="Settings">
                        <p>Settings</p>
                    </a></li>
                <li title="Theme Changer">

                    <?php include str_replace("dashboard", "", __DIR__) . "themeSwitcher.php" ?>

                </li>
                <li class="border-top">
                    <a href="/logout">
                        <img src="/build/src/images/exit.svg" alt="Logout">
                        <p>Log Out</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>