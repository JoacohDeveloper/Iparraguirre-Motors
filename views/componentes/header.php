<header>
    <a href="/" class="logo">
        <img src="/build/src/images/LOGO2.png" alt="Logo Iparraguirre Motors">
    </a>

    <?php $url = $_SERVER["REQUEST_URI"]; ?>
    <?php include __DIR__ . "/dashboard/navegacion.php"; ?>
    <div class="hello-world">

        <?php include __DIR__ . "/navegacion.php"; ?>


        <div class="brgMenu brgMenuHandler">
            <img src="/build/src/images/brgMenu.svg" alt="Hamburger Menu">
        </div>

        <div class="mobile-menu menu-disabled">
            <section class="mobile-menu-header">
                <div class="quit-menu-img brgMenuHandler">
                    <img src="/build/src/images/arrowLeft.svg" alt="quit menu left arrow">
                </div>
                <?php include __DIR__ . "/themeSwitcher.php"; ?>

            </section>
            <section class="mobile-menu-content">
                <?php include __DIR__ . "/navegacion.php"; ?>
            </section>
        </div>
    </div>
</header>