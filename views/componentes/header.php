<header>
    <a href="/" class="logo">
        <img src="/build/src/images/LOGO2.png" alt="Logo Iparraguirre Motors">
    </a>

    <?php $url = $_SERVER["REQUEST_URI"]; ?>
    <div class="hello-world <?php if ($url === '/auth/login') echo "oculto"; ?>">

        <?php include __DIR__ . "/navegacion.php"; ?>

        <div class="brgMenu brgMenuHandler">
            <img src="/build/src/images/brgMenu.svg" alt="Hamburger Menu">
        </div>

        <div class="mobile-menu menu-disabled">
            <section class="mobile-menu-header">
                <div class="quit-menu-img brgMenuHandler">
                    <img src="/build/src/images/arrowLeft.svg" alt="quit menu left arrow">
                </div>
                <div class="card__toggle">
                    <input id="themeSwitcher" class="ThemeToggle" type="checkbox" checked>
                </div>
            </section>
            <section class="mobile-menu-content">
                <?php include __DIR__ . "/navegacion.php"; ?>
            </section>
        </div>
    </div>
</header>